<?php
require_once('../../include/conf/const.php');
require_once('../../include/model/ec_model.php');
session_start();

$link = get_db_link();
$err_msg = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $err_msg[] = check_post_username_error();
    $err_msg[] = check_post_password_error();

    if (!check_err_msg($err_msg)) {
        if ($id = is_account_valid($link, $_POST['name'], $_POST['password'])) {
            $_SESSION['id'] = $id;
            if ($_POST['name'] === 'admin') {
                header("Location: " . $_SERVER['PHP_SELF'] . '/../goods_management_controller.php');
                exit();
            } else {
                header("Location: " . $_SERVER['PHP_SELF'] . '/../goods_list_controller.php');
                exit();
            }
        } else {
            $err_msg[] = 15;
        }
    }
}

close_db_link($link);
include_once('../../include/view/ec_login_view.php');
