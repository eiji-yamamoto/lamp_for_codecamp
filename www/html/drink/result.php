<?php

$host = 'mysql';
$username = 'db_user';
$passwd = 'db_user';
$dbname = 'default_db';
$err_msg = [];
$correct_commit_message = [];
$link = mysqli_connect($host, $username, $passwd, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['money'] === '') {
        $err_msg[] = '投入金額を入力してください。';
    } elseif (ctype_digit($_POST['money']) === FALSE) {
        $err_msg[] = '投入金額には、0以上の整数を入力してください。';
    }

    if (isset($_POST['drink_id']) === FALSE) {
        $err_msg[] = '購入するドリンクを指定してください。';
    }

    // transaction開始
    // price, publis state, stock, 画像、商品名、を取得
    // 各値でエラー処理
    // 全部通れば、購入処理
    // つまり、在庫数を減らして、購入履歴を挿入
    // どちらもとおれば、画像、商品名、おつりの情報を表示する

    if (count($err_msg) === 0) {
        if ($link) {
            $money = $_POST['money'];
            $drink_id = $_POST['drink_id'];

            // transaction開始
            mysqli_set_charset($link, 'utf8');
            mysqli_autocommit($link, FALSE);

            // price, publis state, stock, 画像、商品名、を取得
            $sql = "SELECT drink_price, drink_name, drink_stock, image_path, public_status
                FROM drink_table JOIN drink_stock_table ON drink_table.drink_id = drink_stock_table.drink_id
                WHERE drink_table.drink_id =" .  $drink_id;
            $result = mysqli_query($link, $sql);
            $drink_array = mysqli_fetch_array($result, MYSQLI_ASSOC);

            // 各値でエラー処理
            if ($money < $drink_array['drink_price']) {
                $err_msg[] = 'ドリンクの値段より大きい金額を投入してください。';
            }

            if ($drink_array['drink_stock'] === '0') {
                $err_msg[] = 'ドリンクの在庫がないため、購入できません。';
            }

            if ($drink_array['public_status'] === '0') {
                $err_msg[] = 'ドリンクのステータスが非公開のため、購入できません。';
            }

            // 全部通れば、購入処理
            // つまり、在庫数を減らして、購入履歴を挿入
            if (count($err_msg) === 0) {
                $updated = date('Y-m-d H:i:s');
                $sql = "UPDATE  drink_stock_table SET drink_stock = " . ($drink_array['drink_stock'] - 1) . ", updated = '" .  $updated . "' WHERE drink_id = " . $drink_id;

                $result = mysqli_query($link, $sql);
                if ($result === TRUE) {
                    $sql = "INSERT  drink_order_table (drink_id, order_datetime) VALUES ( " . $drink_id . ", '" . $updated . "')";

                    $result = mysqli_query($link, $sql);
                    if ($result === FALSE) {
                        $err_msg[] = 'drink_order_table: insertエラー: ' . $sql;
                    }
                } else {
                    $err_msg[] = 'drink_stock_table: updateエラー: ' . $sql;
                }

                // どちらもとおれば、画像、商品名、おつりの情報を表示する
                // transaction の終了処理
                if (count($err_msg) === 0) {
                    mysqli_commit($link);
                    $left_money = $money - $drink_array['drink_price'];
                    $correct_commit_message[] = $drink_array['drink_name'] . 'を購入しました!';
                    $correct_commit_message[] = 'おつりは、' . $left_money . '円です。';
                } else {
                    mysqli_rollback($link);
                }
            }

            mysqli_close($link);
        } else {
            $err_msg[] = 'error : ' . mysqli_connect_error();
        }
    }
}

?>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>自動販売機 結果</title>
</head>

<body>
    <h1>自動販売機 結果</h1>
    <?php if (count($err_msg) > 0) : ?>
        <ul>
            <?php foreach ($err_msg as  $value) : ?>
                <li><?php print $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (count($correct_commit_message) > 0) : ?>
        <img src="<?php print $drink_array['image_path'] ?>">
        <ul>
            <?php foreach ($correct_commit_message as  $value) : ?>
                <li><?php print $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="./index.php">自動販売機へ戻る</a>
</body>

</html>