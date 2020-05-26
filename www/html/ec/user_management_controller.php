<?php
require_once('../../include/conf/ec_const.php');


session_start();
is_logined();
$link = get_db_link();

$sql = "SELECT name, created_date FROM ec_user_table";
$data = select_db($link, $sql);

close_db_link($link);
include_once('../../include/view/ec_user_management_view.php');
