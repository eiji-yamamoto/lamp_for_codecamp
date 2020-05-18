<?php

/**
 * 必要テーブル
 *
 * point_gift_table: ポイントで購入可能な景品
 * point_customer_table: ユーザーのポイント保有情報
 * point_history_table:  ポイントでの購入履歴
 */
// MySQL接続情報
$host   = 'mysql'; // データベースのホスト名又はIPアドレス
$user   = 'db_user';  // MySQLのユーザ名
$passwd = 'db_user';    // MySQLのパスワード
$dbname = 'default_db';    // データベース名
$customer_id = 1;      // 顧客は1に固定
$message     = '';     // 購入処理完了時の表示メッセージ
$point       = 0;      // 保有ポイント情報
$err_msg     = [];     // エラーメッセージ
$point_gift_list = []; // ポイントで購入できる景品
// コネクション取得
if ($link = mysqli_connect($host, $user, $passwd, $dbname)) {

    // 文字コードセット
    mysqli_set_charset($link, 'UTF8');
    /**
     * 保有ポイント情報を取得
     */
    // 現在のポイント保有情報を取得するためのSQL
    $sql = 'SELECT point FROM point_customer_table WHERE customer_id = ' . $customer_id;
    // クエリ実行
    if ($result = mysqli_query($link, $sql)) {
        // １件取得
        $row = mysqli_fetch_assoc($result);
        // 変数に格納
        if (isset($row['point']) === TRUE) {
            $point = $row['point'];
        }
    } else {
        $err_msg[] = 'SQL失敗:' . $sql;
    }
    mysqli_free_result($result);
    // POSTの場合はポイントでの景品購入処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /*
        * ここに購入時の処理を記載してください
        * 既存のソースを変更したい場合、変更が必要な理由を講師に説明し、許可をとってください。
        */

        // point history table へ、購入履歴を insert
        if (isset($_POST['point_gift_id']) === TRUE) {
            $point_gift_id = $_POST['point_gift_id'];
            mysqli_autocommit($link, FALSE);

            $date = date('Y-n-d H:i:s');
            $sql = "INSERT INTO point_history_table (customer_id, point_gift_id, created_at) VALUES ($customer_id, $point_gift_id, '$date')";
            $result = mysqli_query($link, $sql);

            // point customer table の顧客保有ポイントをupdate
            // 購入商品数は、1で固定
            if ($result === TRUE) {
                // point_gift_idを使って、point_gift_tableから、金額を取得
                $sql = "SELECT point, name FROM point_gift_table WHERE point_gift_id = $point_gift_id";
                $result = mysqli_query($link, $sql);
                $price = 0;
                $name = '';
                if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $price = $row['point'];
                    $name = $row['name'];
                }

                // その金額を使って、point_customer_tableを更新
                $after_point = $point - $price;
                $sql = "UPDATE point_customer_table SET point = $after_point WHERE customer_id=$customer_id";

                $result = mysqli_query($link, $sql);
                if ($result === TRUE) {
                    mysqli_commit($link);
                    $message = $name . 'を購入しました!';
                    $point = $after_point;
                } else {
                    mysqli_rollback($link);
                }
            }
        }


        // ここまで
    }
    /**
     * 景品情報を取得
     */
    // SQL
    $sql = 'SELECT point_gift_id, name, point FROM point_gift_table';
    // クエリ実行
    if ($result = mysqli_query($link, $sql)) {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $point_gift_list[$i]['point_gift_id'] = htmlspecialchars($row['point_gift_id'], ENT_QUOTES, 'UTF-8');
            $point_gift_list[$i]['name']       = htmlspecialchars($row['name'],       ENT_QUOTES, 'UTF-8');
            $point_gift_list[$i]['point']      = htmlspecialchars($row['point'],      ENT_QUOTES, 'UTF-8');
            $i++;
        }
    } else {
        $err_msg[] = 'SQL失敗:' . $sql;
    }
    mysqli_free_result($result);
    mysqli_close($link);
} else {
    $err_msg[] = 'error: ' . mysqli_connect_error();
}
//var_dump($err_msg); // エラーの確認が必要ならばコメントを外す
?>
<!DOCTYPE HTML>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>トランザクション課題</title>
</head>

<body>
    <?php if (empty($message) !== TRUE) { ?>
        <p><?php print $message; ?></p>
    <?php } ?>
    <section>
        <h1>保有ポイント</h1>
        <p><?php print number_format($point); ?>ポイント</p>
    </section>
    <section>
        <h1>ポイント商品購入</h1>
        <form method="post">
            <ul>
                <?php foreach ($point_gift_list as $point_gift) { ?>
                    <li>
                        <span><?php print $point_gift['name']; ?></span>
                        <span><?php print number_format($point_gift['point']); ?>ポイント</span>
                        <?php if ($point_gift['point'] <= $point) { ?>
                            <button type="submit" name="point_gift_id" value="<?php print $point_gift['point_gift_id']; ?>">購入する</button>
                        <?php        } else { ?>
                            <button type="button" disabled="disabled">購入不可</button>
                        <?php        } ?>
                    </li>
                <?php    } ?>
            </ul>
        </form>
        <p>※サンプルのためポイント購入は1景品 & 1個に固定</p>
    </section>
</body>

</html>