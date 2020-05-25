<?php
require_once('../../include/conf/const.php');
require_once('../../include/model/ec_model.php');

$link = get_db_link();
$err_msg = [];
$result_msg = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $err_msg[] = check_post_username_error();
    $err_msg[] = check_username_grammer_error();
    $err_msg[] = check_post_password_error();
    $err_msg[] = check_password_grammer_error();

    if (!check_err_msg($err_msg)) {
        $name = $_POST['name'];
        $password = $_POST['password'];

        mysqli_autocommit($link, FALSE);
        $sql = "SELECT id FROM ec_user_table WHERE name = '" . $name . "'";
        $data =  select_db($link, $sql);
        if (!isset($data[0]['id'])) {
            $sql = "INSERT INTO ec_user_table(name, password, created_date, update_date)
            VALUES ('" . $name . "', '" . $password . "', NOW(), NOW())";

            if (!insert_db($link, $sql)) {
                $err_msg[] = 11;
            }
        } else {
            $err_msg[] = 17;
        }

        if (!check_err_msg($err_msg)) {
            mysqli_commit($link);
            $result_msg[] = 'ユーザを登録しました。';
        } else {
            mysqli_rollback($link);
        }
    }
}

close_db_link($link);
include_once('../../include/view/ec_user_register_view.php');
