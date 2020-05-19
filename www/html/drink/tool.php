<?php
define('MAX_FILE_SIZE', 30000);

$name = '';
$price = 0;
$quantity = 0;
$image_path = '';
$public_status = '';

$host = 'mysql';
$username = 'db_user';
$passwd = 'db_user';
$dbname = 'default_db';
$link = mysqli_connect($host, $username, $passwd, $dbname);

$errors = [];
$result_msg = [];

///////////////////////////////////////
// 新規商品追加
///////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['change_status'] === 'create') {
    // エラー処理
    if (trim($_POST['name']) === "") {
        $errors[] = '名前を入力してください。';
    }
    if ($_POST['price'] === "") {
        $errors[] = '値段を入力してください。';

        // ctype_digit : stringがすべて数字なら、小数点もマイナスもないので、必然的に整数
    } elseif (ctype_digit($_POST['price']) === FALSE) {
        $errors[] = '値段は0以上の整数を入力してください。';
    }

    if ($_POST['stock'] === "") {
        $errors[] = '個数を入力してください。';
    } elseif (ctype_digit($_POST['stock']) === FALSE) {
        $errors[] = '個数は0以上の整数を入力してください。';
    }

    // error = 0 のみ成功
    // https://www.php.net/manual/ja/features.file-upload.errors.php
    if ($_FILES['image']['error'] !== 0) {
        $errors[] = '商品画像を選択してください。';
    } elseif ($_FILES['image']['type'] !== 'image/jpeg' && $_FILES['image']['type'] !== 'image/png') {
        $errors[] = '商品画像のファイル形式は、JPEGかPNG にしてください。';
    }

    if (isset($_POST['public_status']) === "") {
        $errors[] = '公開/非公開を設定してください。';
    } elseif ($_POST['public_status'] !== '0' && $_POST['public_status'] !== '1') {
        $errors[] = '公開ステータスは、公開/非公開のどちらかを指定してください。';
    }

    if (count($errors) === 0) {
        // 画像はimg/に移し、pathを保存
        //ファイル名は、元のファイル名_created にする
        // TODO ： ファイル名を、自動で割り振る!
        $image_name_array = explode('.', basename($_FILES['image']['name']));
        $image_file_offset = date('Y-m-d_H-i-s');
        $image_name = $image_name_array[0] . '_' . $image_file_offset . '.' . $image_name_array[1];
        $uploaddir = './img/';
        $uploadfile = $uploaddir . $image_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
            $image_path = $uploadfile;
        } else {
            $errors[] = '画像のコピーに失敗しました。';
        }
    }

    // 画像のコピーも含めて、エラーしてないかチェック
    // drink tableと、drink stock tableのinsert
    if (count($errors) === 0) {
        // 各種値の更新
        $name = trim($_POST['name']);
        $price = (int) $_POST['price'];
        $stock = (int) $_POST['stock'];
        $public_status = (int) $_POST["public_status"];
        $created = date('Y-m-d H:i:s');
        $updated = date('Y-m-d H:i:s');

        if ($link) {
            mysqli_set_charset($link, 'utf8');

            // transaction 開始
            mysqli_autocommit($link, FALSE);

            // drink table の更新
            $sql = "INSERT INTO drink_table(drink_name, drink_price, created, updated, public_status, image_path) VALUES ('"
                . $name . "'," . $price . ", '" . $created . "', '" . $updated . "', " . $public_status . ", '" . $image_path . "')";
            $result = mysqli_query($link, $sql);

            // drink stock table の更新
            if ($result === TRUE) {
                $id = mysqli_insert_id($link);
                $sql = "INSERT INTO drink_stock_table(drink_id, drink_stock, created, updated) VALUES ("
                    . $id . ", " .  $stock . ", '" . $created . "', '" . $updated . "')";
                $result = mysqli_query($link, $sql);

                if ($result === FALSE) {
                    $errors[] = 'drink_stock_table : INSERT エラー : ' . $sql;
                }
            } else {
                $errors[] = 'drink_table : INSERT エラー : ' . $sql;
            }

            // transaction 処理に失敗しているかどうか
            if (count($errors) === 0) {
                mysqli_commit($link);
                $result_msg[] = '商品の追加に成功しました。';
            } else {
                mysqli_rollback($link);
            }
        } else {
            $errors[] = 'error' . mysqli_connect_error();
        }
    }
}

///////////////////////////////////////
// stock の更新
///////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['change_status'] === 'update' && (isset($_POST['update_stock']) === TRUE)) {
    // エラー処理
    if ($_POST['update_stock'] === "") {
        $errors[] = '個数を入力してください。';
    } elseif (ctype_digit($_POST['update_stock']) === FALSE) {
        $errors[] = '個数は0以上の整数を入力してください。';
    }

    if (count($errors) === 0) {
        $stock = (int) $_POST['update_stock'];
        $drink_id = (int) $_POST['drink_id'];

        if ($link) {
            mysqli_set_charset($link, 'utf8');

            $updated = date('Y-m-d H:i:s');
            $sql = "UPDATE drink_stock_table SET drink_stock = "
                . $stock . ", updated = '" . $updated . "' WHERE drink_id = " . $drink_id;
            $result = mysqli_query($link, $sql);

            if ($result === TRUE) {
                $result_msg[] = '在庫の更新に成功しました。';
            } else {
                $errors[] = 'drink_stock_table : UPDATE エラー : ' . $sql;
            }
        } else {
            $errors[] = 'error' . mysqli_connect_error();
        }
    }
}

///////////////////////////////////////
// public_status の更新
///////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['change_status'] === 'update' && (isset($_POST['update_public_status']) === TRUE)) {
    // エラー処理
    if (isset($_POST['update_public_status']) === "") {
        $errors[] = '公開/非公開を設定してください。';
    } elseif ($_POST['update_public_status'] !== '0' && $_POST['update_public_status'] !== '1') {
        $errors[] = '公開ステータスは、公開/非公開のどちらかを指定してください。';
    }

    if (count($errors) === 0) {
        $public_status = (int) $_POST["update_public_status"];
        $drink_id = (int) $_POST['drink_id'];

        if ($link) {
            mysqli_set_charset($link, 'utf8');

            $updated = date('Y-m-d H:i:s');
            $sql = "UPDATE drink_table SET updated = '"
                . $updated . "', public_status = " . $public_status . " WHERE drink_id =" . $drink_id;
            $result = mysqli_query($link, $sql);

            if ($result === TRUE) {
                $result_msg[] = '公開/非公開の更新に成功しました。';
            } else {
                $errors[] = 'drink_table : UPDATE エラー : ' . $sql;
            }
        } else {
            $errors[] = 'error' . mysqli_connect_error();
        }
    }
}

///////////////////////////////////////
// 商品一覧取得
//////////////////////////////////////
if ($link) {
    mysqli_set_charset($link, 'utf8');
    $sql = 'SELECT drink_table.drink_id, drink_name, drink_price, drink_stock, public_status, image_path
            FROM drink_table JOIN drink_stock_table
            ON drink_table.drink_id = drink_stock_table.drink_id';
    $result = mysqli_query($link, $sql);

    $data = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = $row;
    }
    mysqli_free_result($result);
} else {
    $errors[] = 'error' . mysqli_connect_error();
}

mysqli_close($link);
?>



<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>自動販売機管理ツール</title>
</head>

<body>
    <h1>自動販売機管理ツール</h1>

    <?php if (count($errors) >= 0) : ?>
        <ul>
            <?php foreach ($errors as  $value) : ?>
                <li><?php print $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (count($result_msg) >= 0) : ?>
        <ul>
            <?php foreach ($result_msg as  $value) : ?>
                <li><?php print $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>

    <h3>新規商品追加</h3>
    <form enctype="multipart/form-data" method="post">
        <input type="hidden" name="change_status" value="create">
        名前: <input type="text" name="name"><br>
        値段 : <input type="number" min="0" name="price"><br>
        個数 : <input type="number" min="0" name="stock"><br>
        <input type="hidden" name="MAX_FILE_SIZE" value=<?php print MAX_FILE_SIZE; ?>>
        <input type="file" name="image"><br>
        <select name="public_status">
            <option value="0">非公開</option>
            <option value="1"> 公開</option>
        </select><br>
        <input type="submit" value="商品追加">
    </form>

    <hr>

    <h3>商品情報変更</h3>

    商品一覧
    <table border="1">
        <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>公開ステータス</th>
        </tr>

        <?php foreach ($data as $value) : ?>
            <tr>
                <td><img src="<?php print $value['image_path'] ?>"></td>
                <td><?php print $value['drink_name']; ?></td>
                <td><?php print $value['drink_price']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="change_status" value="update">
                        <input type="hidden" name="drink_id" value="<?php print $value['drink_id']; ?>">
                        <input type="number" min="0" name="update_stock" value="<?php print $value['drink_stock']; ?>">
                        <input type="submit" value="更新">
                    </form>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="change_status" value="update">
                        <input type="hidden" name="drink_id" value="<?php print $value['drink_id']; ?>">
                        <select name="update_public_status">
                            <option <?php if ($value['public_status'] === '0') {
                                        print 'selected';
                                    } ?> value="0">非公開</option>
                            <option <?php if ($value['public_status'] === '1') {
                                        print 'selected';
                                    } ?> value="1"> 公開</option>
                        </select>
                        <input type="submit" value="更新">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>

</body>

</html>