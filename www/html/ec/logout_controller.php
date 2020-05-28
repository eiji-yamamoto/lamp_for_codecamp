<?php
require_once('../../include/conf/ec_const.php');

session_start();
$session_name = session_name();
$_SESSION = [];

if (isset($_COOKIE[$session_name])) {
    $params = session_get_cookie_params();
    setcookie(
        $session_name,
        '',
        time() - 60,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();
header("Location: " . $_SERVER['PHP_SELF'] . '/../login_controller.php');
