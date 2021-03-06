<?php
require_once('../../include/conf/ec_const.php');

session_start();
is_logined();
$link = get_db_link();
$err_msg = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_post_data_exist('id')) {
    $id = $_POST['id'];
    mysqli_autocommit($link, false);

    $sql = "SELECT id FROM ec_cart_table WHERE goods_id = " . $id . " AND user_id = " . $_SESSION['id'] . " FOR UPDATE";
    $data = select_db($link, $sql);
    if (isset($data[0]['id'])) {
        $sql = "UPDATE ec_cart_table SET amount = amount + 1, updated_date = NOW() WHERE goods_id = " . $id . " AND user_id = " . $_SESSION['id'];
        if (!update_db($link, $sql)) {
            $err_msg[] = 12;
        }
    } else {
        $sql = "INSERT INTO ec_cart_table (user_id, goods_id, amount, created_date, updated_date)
                VALUES (" . $_SESSION['id'] . ", " . $id . ", 1, NOW(), NOW())";
        if (!insert_db($link, $sql)) {
            $err_msg[] = 11;
        }
    }

    if (!check_err_msg($err_msg)) {
        mysqli_commit($link);
        $result_msg = '商品をカートに追加しました。';
    } else {
        mysqli_rollback($link);
    }
}

$sql = "SELECT g.id, g.name, g.price, g.img, s.stock
        FROM ec_goods_table AS g JOIN ec_stock_table AS s ON g.id = s.goods_id
        WHERE status='1'";

$data = select_db($link, $sql);

close_db_link($link);
include_once('../../include/view/ec_goods_list_view.php');
