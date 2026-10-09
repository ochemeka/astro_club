<?php
require_once(__DIR__ . "/constant.php");
session_start();

// Session timeout: 30 minutes of inactivity
$timeout = 1800; // 30 minutes in seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    $was_admin = isset($_SESSION['adm_id']);
    session_unset();
    session_destroy();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    // Redirect based on who was logged in
    if ($was_admin) {
        header("Location: " . SITE_PATH . "manager/index.php?timeout=1");
    } else {
        header("Location: " . SITE_PATH . "user/login.php?timeout=1");
    }
    exit;
}
$_SESSION['last_activity'] = time();

function admin_login() {
    return isset($_SESSION['adm_id']);
}

function admin_logged_in() {
    if (!admin_login()) {
        redirect_to(SITE_PATH."manager/index.php");
        exit();
    }
}

function logged_in() {
    return isset($_SESSION['user_id']);
}

function confirm_logged_in() {
    if (!logged_in()) {
        redirect_to(SITE_PATH."user/login.php");
        exit();
    }
}

function set_flash($type, $message) {
    $_SESSION['flash'] = array('type' => $type, 'message' => $message);
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
?>
