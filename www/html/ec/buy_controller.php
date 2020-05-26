<?php
require_once('../../include/conf/ec_const.php');

session_start();
is_logined();
$link = get_db_link();
$err_msg = [];
$result_msg = '購入失敗';

$sql = "SELECT g.id, g.name, g.price, g.img, s.stock, c.amount
        FROM ec_goods_table AS g JOIN ec_stock_table AS s ON g.id = s.goods_id JOIN ec_cart_table AS c ON g.id = c.goods_id
        WHERE c.user_id =" . $_SESSION['id'];
$data = select_db($link, $sql);
$sum = calc_sum($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    mysqli_autocommit($link, FALSE);

    $sql = "UPDATE ec_stock_table AS s , ec_cart_table AS c SET s.stock = s.stock - c.amount, s.updated_date = NOW()
            WHERE s.goods_id = c.goods_id AND c.user_id = " . $_SESSION['id'];

    if (update_db($link, $sql)) {
        $sql = "DELETE FROM ec_cart_table WHERE user_id = " . $_SESSION['id'];
        if (!delete_db($link, $sql)) {
            $err_msg[] = 13;
        }
    } else {
        $err_msg[] = 12;
    }

    if (!check_err_msg($err_msg)) {
        mysqli_commit($link);
        $result_msg = '購入完了';
    } else {
        mysqli_rollback($link);
    }
}

close_db_link($link);
include_once('../../include/view/ec_buy_view.php');
