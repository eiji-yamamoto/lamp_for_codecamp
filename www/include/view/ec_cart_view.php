<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ショッピングカート</title>
</head>

<body>
    <h1>ショッピングカート</h1>
    <a href="./goods_list_controller.php">商品一覧ページ</a><br>
    <a href="./logout_controller.php">ログアウト</a><br>


    <?php if (check_err_msg($err_msg)) : ?>
        <ul>
            <?php foreach ($err_msg as $value) : ?>
                <?php if ($value !== 0) : ?>
                    <li><?php print h(ERR_MSGS[$value]); ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (isset($result_msg)) : ?>
        <?php print h($result_msg); ?>
    <?php endif; ?>

    <hr>
    <h3>商品一覧</h3>

    <table border="1">
        <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>数量</th>
            <th>操作</th>
        </tr>

        <?php foreach ($data as $value) : ?>
            <tr>
                <td><img src="<?php print $value['img'] ?>"></td>
                <td><?php print h($value['name']); ?></td>
                <td><?php print h($value['price']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="change_method" value="update_amount">
                        <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                        <input type="number" min="1" name="amount" value="<?php print h($value['amount']); ?>">
                        <input type="submit" value="更新">
                    </form>
                </td>

                <td>
                    <form method="post">
                        <input type="hidden" name="change_method" value="delete">
                        <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                        <input type="submit" value="削除">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
    <h2>合計金額 </h2>
    <h3><?php print $sum; ?>円</h3>

    <form action="./buy_controller.php" method="post">
        <input type="submit" value="商品を購入">
    </form>
</body>

</html>