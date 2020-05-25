<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ユーザ登録ページ</title>
</head>

<body>
    <h1>ユーザ登録ページ</h1>
    <?php if (check_err_msg($err_msg)) : ?>
        <ul>
            <?php foreach ($err_msg as  $value) : ?>
                <?php if ($value !== 0) : ?>
                    <li><?php print ERR_MSGS[$value]; ?></li>
                <?php endif; ?>
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

    <form method="post">
        ユーザ名<input type="text" name="name"><br>
        パスワード<input type="password" name="password"><br>
        <input type="submit" value="ユーザ登録">
    </form>

    <a href="./login_controller.php">ログインページ</a>
</body>

</html>