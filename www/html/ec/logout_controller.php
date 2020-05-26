<?php
require_once('../../include/conf/ec_const.php');

session_start();

$_SESSION = [];
session_destroy();
header("Location: " . $_SERVER['PHP_SELF'] . '/../login_controller.php');
