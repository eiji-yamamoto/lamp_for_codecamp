<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>商品管理ページ</title>
</head>

<body>
    <h1>商品管理ページ</h1>
    <a href="./user_management_controller.php">ユーザ管理ページ</a>
    <a href="./logout_controller.php">ログアウト</a>

    <?php if (check_err_msg($errors)) : ?>
        <ul>
            <?php foreach ($errors as $value) : ?>
                <?php if ($value !== 0) : ?>
                    <li><?php print h(ERR_MSGS[$value]); ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (count($result_msg) >= 0) : ?>
        <ul>
            <?php foreach ($result_msg as $value) : ?>
                <li><?php print h($value); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>

    <h3>新規商品追加</h3>
    <form enctype="multipart/form-data" method="post">
        <input type="hidden" name="change_method" value="create">
        名前: <input type="text" name="name"><br>
        値段 : <input type="number" min="0" name="price"><br>
        個数 : <input type="number" min="0" name="stock"><br>
        <input type="hidden" name="MAX_FILE_SIZE" value=<?php print MAX_FILE_SIZE; ?>>
        <input type="file" name="image"><br>
        <select name="status">
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
            <th>操作</th>
        </tr>

        <?php foreach ($data as $value) : ?>
            <tr>
                <td><img src="<?php print $value['img'] ?>" height="100"></td>
                <td><?php print h($value['name']); ?></td>
                <td><?php print h($value['price']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="change_method" value="update_stock">
                        <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                        <input type="number" min="0" name="stock" value="<?php print h($value['stock']); ?>">
                        <input type="submit" value="更新">
                    </form>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="change_method" value="update_status">
                        <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                        <select name="status">
                            <option <?php if ($value['status'] === '0') {
                                        print 'selected';
                                    } ?> value="0">非公開</option>
                            <option <?php if ($value['status'] === '1') {
                                        print 'selected';
                                    } ?> value="1"> 公開</option>
                        </select>
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

</body>

</html>