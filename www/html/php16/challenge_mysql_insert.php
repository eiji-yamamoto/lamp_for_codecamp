<?php

$host = 'mysql';
$username = 'db_user';
$passwd = 'db_user';
$dbname = 'default_db';
$link = mysqli_connect($host, $username, $passwd, $dbname);

if ($link) {
    mysqli_set_charset($link, 'utf8');

    $goods_name = '';
    $price = 0;
    if (isset($_POST)) {
        $goods_name = $_POST['goods_name'];
        $price = $_POST['price'];
        $insert_query = "INSERT INTO goods_table (goods_name, price) VALUES ('$goods_name', $price)";
        $insert_result = mysqli_query($link, $insert_query);
    }

    $select_query = 'SELECT goods_name, price FROM goods_table';
    $select_result = mysqli_query($link, $select_query);
    $data = array();
    while ($row = mysqli_fetch_array($select_result, MYSQLI_ASSOC)) {
        $data[] = $row;
    }
    mysqli_free_result($select_result);

    mysqli_close($link);
} else {
    print 'DB接続失敗';
}

?>

<html lang="ja">

<head>
    <meta charset="UTF-8">

    <title>Document</title>
</head>

<body>
    <form method="post">
        商品名: <input type="text" name="goods_name">
        価格: <input type="text" name="price">
        <input type="submit" value="追加">
    </form>

    商品一覧
    <table border="1">
        <tr>
            <th>商品名</th>
            <th>価格</th>
        </tr>

        <?php foreach ($data as $column) : ?>
            <tr>
                <?php foreach ($column as $value) : ?>
                    <td><?php print $value; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>