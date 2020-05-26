<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ユーザ管理ページ</title>
</head>

<body>
    <h1>ユーザ管理ページ</h1>
    <a href="./goods_management_controller.php">商品管理ページ</a>
    <a href="./logout_controller.php">ログアウト</a>

    <hr>

    <h3>ユーザ一覧</h3>

    <table border="1">
        <tr>
            <th>ユーザ名</th>
            <th>登録日</th>
        </tr>

        <?php foreach ($data as $value) : ?>
            <tr>
                <td><?php print h($value['name']); ?></td>
                <td><?php print h($value['created_date']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>