<?php
$host = 'mysql';
$username = 'db_user';
$passwd = 'db_user';
$dbname = 'default_db';
$link = mysqli_connect($host, $username, $passwd, $dbname);

$post_number = '';
$pref = '';
$town = '';

$query = '';
$data = array();
$errors = [];
$pattern = '/^[0-9]{7}$/';

if (isset($_GET['post_number']) === TRUE) {
    $post_number = trim($_GET['post_number']);
    if ($post_number === '') {
        $errors[] = '郵便番号を入力してください。';
    }

    if (preg_match($pattern, $post_number) === 0) {
        $errors[] = '郵便番号は7桁の数字を入力してください。';
    }

    $query = "SELECT `COL 3`, `COL 7`, `COL 8`, `COL 9` FROM post_number_table WHERE `COL 3` = '$post_number' ORDER BY `COL 3`ASC";
}

if ((isset($_GET['pref']) === TRUE) && (isset($_GET['town']) === TRUE)) {
    $pref = trim($_GET['pref']);
    $town = trim($_GET['town']);

    if ($pref === '') {
        $errors[] = '都道府県を入力してください。';
    }

    if ($town === '') {
        $errors[] = '市区町村を入力して下さい。';
    }

    $query = "SELECT `COL 3`, `COL 7`, `COL 8`, `COL 9` FROM post_number_table WHERE `COL 7` = '$pref' AND `COL 8` = '$town' ORDER BY `COL 3`ASC";
}

if ($link && $_GET) {
    mysqli_set_charset($link, 'utf8');
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
        $data[] = $row;
    }

    mysqli_free_result($result);
    mysqli_close($link);
}

?>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>郵便番号検索</title>
</head>

<body>
    <h1>郵便番号検索</h1>

    <h3>郵便番号から検索</h3>
    <form method="get">
        <input type="text" name="post_number">
        <input type="hidden" name="page" value="1">
        <input type="submit" value="検索">
    </form>

    <h3>地名から検索</h3>
    <form method="get">
        都道府県 <input type="text" name="pref">
        市区町村 <input type="text" name="town">
        <input type="hidden" name="page" value="1">
        <input type="submit" value="検索">
    </form>

    <hr>

    <?php if (count($data) === 0) : ?>
        ここに検索結果が表示されます。
    <?php endif; ?>

    <?php if (count($errors) >= 1) : ?>
        <ul>
            <?php foreach ($errors as $value) : ?>
                <li><?php print $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (count($data) >= 1) : ?>
        検索結果 <?php print count($data); ?>件
        <br><br>
        郵便番号検索結果

        <table border="1">
            <tr>
                <th>郵便番号</th>
                <th>都道府県</th>
                <th>市区町村</th>
                <th>町域</th>
            </tr>

            <?php foreach ($data as $column) : ?>
                <tr>
                    <?php foreach ($column as $value) : ?>
                        <td><?php print $value; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php endif; ?>
</body>

</html>