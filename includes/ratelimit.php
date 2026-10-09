<?php
// Database-backed login rate limiting with escalating lockouts.
// Ladder: 5 failures -> 15 min block; trying again during the block
// escalates to 1 hour, then 6 hours (max).

define("RL_MAX_ATTEMPTS", 5);
define("RL_WINDOW_SECONDS", 900); // count failures over 15 minutes

// Lock durations per level (seconds)
define("RL_L1_SECONDS", 900);    // 15 minutes
define("RL_L2_SECONDS", 3600);   // 1 hour
define("RL_L3_SECONDS", 21600);  // 6 hours
define("RL_MAX_LEVEL", 3);

function rl_client_ip() {
    return isset($_SERVER['REMOTE_ADDR']) ? substr($_SERVER['REMOTE_ADDR'], 0, 45) : 'unknown';
}

function rl_level_seconds($level) {
    switch ((int)$level) {
        case 1:  return RL_L1_SECONDS;
        case 2:  return RL_L2_SECONDS;
        default: return RL_L3_SECONDS;
    }
}

function rl_lock_message($seconds) {
    if ($seconds >= 3600) {
        $hours = (int)ceil($seconds / 3600);
        $txt = $hours . " hour" . ($hours > 1 ? "s" : "");
    } else {
        $minutes = (int)ceil($seconds / 60);
        $txt = $minutes . " minute" . ($minutes > 1 ? "s" : "");
    }
    return "Too many failed attempts. Please try again in " . $txt . ".";
}

// Remaining block seconds for this identity or this IP (0 = not blocked)
function rl_block_remaining($connection, $identity) {
    $ip = rl_client_ip();
    $sql = "SELECT MAX(UNIX_TIMESTAMP(locked_until)) FROM login_lockouts
            WHERE locked_until > NOW() AND (identity = ? OR ip_address = ?)";
    $stmt = mysqli_prepare($connection, $sql);
    if (!$stmt) {
        return 0;
    }
    mysqli_stmt_bind_param($stmt, "ss", $identity, $ip);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $expires);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($expires && $expires > time()) {
        return max(1, $expires - time());
    }
    return 0;
}

// Called when a login is submitted while a block is active.
// Escalates the lock one level (15 min -> 1 hr -> 6 hr) and returns new remaining seconds.
function rl_escalate_lock($connection, $identity) {
    $ip = rl_client_ip();
    $current = rl_block_remaining($connection, $identity);
    if ($current <= 0) {
        return 0;
    }

    // Highest active level matching this identity or IP
    $level = 1;
    $stmt = mysqli_prepare(
        $connection,
        "SELECT MAX(lock_level) FROM login_lockouts
         WHERE locked_until > NOW() AND (identity = ? OR ip_address = ?)"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $identity, $ip);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $max_level);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if ($max_level) {
            $level = (int)$max_level;
        }
    }

    $new_level = min($level + 1, RL_MAX_LEVEL);
    $new_until = date("Y-m-d H:i:s", time() + rl_level_seconds($new_level));

    $stmt = mysqli_prepare(
        $connection,
        "UPDATE login_lockouts SET lock_level = ?, locked_until = ?, updated_at = NOW()
         WHERE locked_until > NOW() AND (identity = ? OR ip_address = ?)"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $new_level, $new_until, $identity, $ip);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    return rl_level_seconds($new_level);
}

// Record a failed attempt. If the threshold is hit, create the next-level lock.
// Returns remaining block seconds (0 = not blocked).
function rl_record_failure($connection, $identity) {
    $ip = rl_client_ip();

    // Opportunistic cleanup of old rows
    mysqli_query($connection, "DELETE FROM login_attempts WHERE attempted_at < (NOW() - INTERVAL 1 DAY)");
    mysqli_query($connection, "DELETE FROM login_lockouts WHERE locked_until < (NOW() - INTERVAL 1 DAY)");

    $stmt = mysqli_prepare($connection, "INSERT INTO login_attempts (ip_address, username, attempted_at) VALUES (?, ?, NOW())");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $ip, $identity);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Count recent failures for this identity or IP
    $count = 0;
    $stmt = mysqli_prepare(
        $connection,
        "SELECT COUNT(*) FROM login_attempts
         WHERE attempted_at > (NOW() - INTERVAL " . RL_WINDOW_SECONDS . " SECOND)
           AND (ip_address = ? OR username = ?)"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $ip, $identity);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    if ($count < RL_MAX_ATTEMPTS) {
        return 0;
    }

    // Escalate: new lock level = previous highest level (identity or IP, even expired) + 1
    $prev = 0;
    $stmt = mysqli_prepare(
        $connection,
        "SELECT MAX(lock_level) FROM login_lockouts WHERE identity = ? OR ip_address = ?"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $identity, $ip);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $prev_level);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if ($prev_level) {
            $prev = (int)$prev_level;
        }
    }

    $level = min($prev + 1, RL_MAX_LEVEL);
    $until = date("Y-m-d H:i:s", time() + rl_level_seconds($level));

    // One lock row per identity + IP pair
    $stmt = mysqli_prepare(
        $connection,
        "INSERT INTO login_lockouts (identity, ip_address, lock_level, locked_until, updated_at)
         VALUES (?, ?, ?, ?, NOW())
         ON DUPLICATE KEY UPDATE lock_level = VALUES(lock_level), locked_until = VALUES(locked_until), updated_at = NOW()"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssis", $identity, $ip, $level, $until);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Lock is in place: clear the failure counter so the next window restarts clean
    mysqli_query($connection, "DELETE FROM login_attempts WHERE ip_address = '" . mysqli_real_escape_string($connection, $ip) . "' OR username = '" . mysqli_real_escape_string($connection, $identity) . "'");

    return rl_level_seconds($level);
}

// Successful login: clear failures and any lock for this identity
function rl_clear_failures($connection, $identity) {
    $stmt = mysqli_prepare($connection, "DELETE FROM login_attempts WHERE ip_address = ? OR username = ?");
    if ($stmt) {
        $ip = rl_client_ip();
        mysqli_stmt_bind_param($stmt, "ss", $ip, $identity);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    $stmt = mysqli_prepare($connection, "DELETE FROM login_lockouts WHERE identity = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $identity);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
