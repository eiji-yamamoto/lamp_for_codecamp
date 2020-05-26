<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>購入完了ページ</title>
</head>

<body>
    <h1>
        <?php print $result_msg; ?>
    </h1>

    <a href="./goods_list_controller.php">商品一覧ページ</a><br>
    <a href="./logout_controller.php">ログアウト</a><br>

    <?php if (check_err_msg($err_msg)) : ?>
        <ul>
            <?php foreach ($err_msg as  $value) : ?>
                <?php if ($value !== 0) : ?>
                    <li><?php print h(ERR_MSGS[$value]); ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>
    <h3>商品一覧</h3>

    <table border="1">
        <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>数量</th>
        </tr>

        <?php foreach ($data as $value) : ?>
            <tr>
                <td><img src="<?php print $value['img'] ?>"></td>
                <td><?php print h($value['name']); ?></td>
                <td><?php print h($value['price']); ?></td>
                <td><?php print h($value['amount']); ?>
            </tr>
        <?php endforeach; ?>

    </table>
    <h2>合計金額 </h2>
    <h3><?php print $sum; ?>円</h3>

</body>

</html>