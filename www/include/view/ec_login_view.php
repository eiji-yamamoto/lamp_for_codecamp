<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログインページ</title>
</head>

<body>
    <h1>ログインページ</h1>

    <a href="./user_register_controller.php">ユーザの新規作成</a>

    <?php if (check_err_msg($err_msg)) : ?>
        <ul>
            <?php foreach ($err_msg as $value) : ?>
                <?php if ($value !== 0) : ?>
                    <li><?php print h(ERR_MSGS[$value]); ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>

    <form method="post">
        ユーザ名<input type="text" name="name"><br>
        パスワード<input type="password" name="password"><br>
        <input type="submit" value="ログイン">
    </form>

</body>

</html>