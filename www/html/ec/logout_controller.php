<?php
require_once('../../include/conf/const.php');
require_once('../../include/model/ec_model.php');
session_start();

$_SESSION = [];
session_destroy();
header("Location: " . $_SERVER['PHP_SELF'] . '/../login_controller.php');
