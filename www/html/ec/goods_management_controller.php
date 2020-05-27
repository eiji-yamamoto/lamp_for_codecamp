<?php
require_once('../../include/conf/ec_const.php');

$name = '';
$price = 0;
$status = '';
$errors = [];
$result_msg = [];

session_start();
is_logined();
$link = get_db_link();

///////////////////////////////////////
// 新規商品追加
///////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['change_method'] === 'create') {
    $errors[] = check_post_name_error();
    $errors[] = check_post_price_error();
    $errors[] = check_post_stock_error();
    $errors[] = check_post_image_error();
    $errors[] = check_post_status_error();

    // upload されたファイルのコピー
    if (!check_err_msg($errors)) {
        $img = create_upload_file_path(basename($_FILES['image']['name']));
        $errors[] = check_moving_upload_file_error($_FILES['image']['tmp_name'], $img);
    }

    // drink tableと、drink stock tableのinsert
    if (!check_err_msg($errors)) {
        $name = trim($_POST['name']);
        $price = (int) $_POST['price'];
        $stock = (int) $_POST['stock'];
        $status = (int) $_POST["status"];
        $created_date = date('Y-m-d H:i:s');
        $updated_date = $created_date;

        // transaction 開始
        mysqli_autocommit($link, false);
        $sql = "INSERT INTO ec_goods_table(name, price, img, status, created_date, updated_date) VALUES ('"
            . $name . "'," . $price . ", '" . $img . "', '" . $status . "', '" . $created_date . "', '" . $updated_date . "')";

        if (insert_db($link, $sql)) {
            $goods_id = mysqli_insert_id($link);
            $sql = "INSERT INTO ec_stock_table(goods_id, stock, created_date, updated_date) VALUES ("
                . $goods_id . ", " .  $stock . ", '" . $created_date . "', '" . $updated_date . "')";

            if (!insert_db($link, $sql)) {
                $errors[] = 11;
            }
        } else {
            $errors[] = 11;
        }

        // transaction 処理に失敗しているかどうか
        if (!check_err_msg($errors)) {
            mysqli_commit($link);
            $result_msg[] = '商品の追加に成功しました。';
        } else {
            mysqli_rollback($link);
        }
    }
}

///////////////////////////////////////
// stock の更新
///////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['change_method'] === 'update_stock') {
    // エラー処理
    $errors[] = check_post_stock_error();

    if (!check_err_msg($errors)) {
        $stock = (int) $_POST['stock'];
        $goods_id = (int) $_POST['id'];
        $sql = "UPDATE ec_stock_table SET stock = " . $stock . ", updated_date = NOW() WHERE goods_id = " . $goods_id;

        if (update_db($link, $sql)) {
            $result_msg[] = '在庫の更新に成功しました。';
        } else {
            $errors[] = 12;
        }
    }
}

///////////////////////////////////////
// status の更新
///////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['change_method'] === 'update_status') {
    $errors[] = check_post_status_error();

    if (!check_err_msg($errors)) {
        $status = (int) $_POST["status"];
        $id = (int) $_POST['id'];
        $sql = "UPDATE ec_goods_table SET updated_date = NOW() , status = " . $status . " WHERE id =" . $id;

        if (update_db($link, $sql)) {
            $result_msg[] = '公開/非公開の更新に成功しました。';
        } else {
            $errors[] = 12;
        }
    }
}


///////////////////////////////////////
// 商品の削除
///////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['change_method'] === 'delete') {
    $id = (int) $_POST['id'];
    mysqli_autocommit($link, false);
    $sql = "DELETE FROM ec_stock_table WHERE goods_id = " . $id;

    if (delete_db($link, $sql)) {
        print 'bb';
        $sql = "DELETE FROM ec_goods_table WHERE id = " . $id;
        if (!delete_db($link, $sql)) {
            $errors[] = 13;
        }
    } else {
        $errors[] = 13;
    }

    if (!check_err_msg($errors)) {
        mysqli_commit($link);
        $result_msg[] = '商品を削除しました。';
    } else {
        mysqli_rollback($link);
    }
}


///////////////////////////////////////
// 商品一覧取得
//////////////////////////////////////
$sql = 'SELECT g.id, g.name, g.price, s.stock, g.status, g.img
        FROM ec_goods_table AS g JOIN ec_stock_table AS s
        ON g.id = s.goods_id';
$data = select_db($link, $sql);

close_db_link($link);
include_once('../../include/view/ec_goods_management_view.php');
