<?php
require_once('../../include/conf/ec_const.php');

session_start();
is_logined();
$link = get_db_link();
$err_msg = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['change_method'] === 'update_amount') {
    $err_msg[] = check_post_amount_error();
    if (!check_err_msg($err_msg)) {
        $sql = 'UPDATE ec_cart_table SET updated_date = NOW(), amount = ' . $_POST['amount'] . " WHERE goods_id = " . $_POST['id'];
        if (update_db($link, $sql)) {
            $result_msg = '数量を更新しました。';
        } else {
            $err_msg[] = 12;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['change_method'] === 'delete') {
    $sql = "DELETE FROM ec_cart_table WHERE goods_id = " . $_POST['id'];
    if (delete_db($link, $sql)) {
        $result_msg = '商品を削除しました。';
    } else {
        $err_msg[] = 13;
    }
}

$sql = "SELECT g.id, g.name, g.price, g.img, s.stock, c.amount
        FROM ec_goods_table AS g JOIN ec_stock_table AS s ON g.id = s.goods_id JOIN ec_cart_table AS c ON g.id = c.goods_id
        WHERE c.user_id =" . $_SESSION['id'];
$data = select_db($link, $sql);
$sum = calc_sum($data);

close_db_link($link);
include_once('../../include/view/ec_cart_view.php');
