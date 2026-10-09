<?php
// Core functions used by the application

function redirect_to($location) {
    if (!headers_sent()) {
        header("Location: " . $location, true, 302);
        exit;
    }
    // Fallback when output has already started
    echo "<script type=\"text/javascript\">window.location=" . json_encode($location) . ";</script>";
    exit;
}

function confirm_query($result_set) {
    global $connection;
    if (!$result_set) {
        die("Database query failed.");
    }
}

function get_user_id($email) {
    global $connection;
    $stmt = mysqli_prepare($connection, "SELECT * FROM newmember_tbl WHERE email = ? ORDER BY id ASC LIMIT 1");
    if (!$stmt) {
        die("Database query failed.");
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function get_all_user() {
    global $connection;
    $query = "SELECT * FROM newmember_tbl ORDER BY id ASC";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

function check_required_fields($required_array) {
    $field_errors = array();
    foreach ($required_array as $fieldname) {
        if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
            $field_errors[] = $fieldname;
        }
    }
    return $field_errors;
}

function display_errors($error_array) {
    echo "<p class=\"errors\">";
    echo "Please review the following fields:<br />";
    foreach ($error_array as $error) {
        echo " - " . htmlspecialchars($error) . "<br />";
    }
    echo "</p>";
}
?>
