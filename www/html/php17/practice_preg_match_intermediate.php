<?php
$mail_address = "";
$mail_address_pattern = '/^[\w!#$%&]+[\w.!#$%&]*@[\w.!#$%&]*[\w!#$%&]+$/';
$password = "";
$password_pattern = '/^[\w!#$%&()=~|{}`*+<>?_]{6,18}$/';
$errors = array();

if ((isset($_POST['mail_address']) === TRUE) && (isset($_POST['password']) === TRUE)) {
    $mail_address = $_POST['mail_address'];
    $password = $_POST['password'];

    if ($mail_address === '') {
        $errors[] = 'メールアドレスが入力されていません。';
    }

    if ($password === '') {
        $errors[] = 'パスワードが入力されていません。';
    }

    if (($mail_address !== '') && (preg_match($mail_address_pattern, $mail_address) === 0)) {
        $errors[] = 'メールアドレスの形式が正しくありません。';
    }

    if (($password !== '') && (preg_match($password_pattern, $password) === 0)) {
        $errors[] = 'パスワードは半角英数記号6文字以上18文字以下で入力してください。';
    }
}

?>
<html lang="ha">

<head>
    <meta charset="UTF-8">
    <title>17-5 課題</title>
</head>

<body>
    <?php if ((count($_POST) === 2) && (count($errors) === 0)) : ?>
        登録完了
    <?php endif; ?>

    <?php if ((count($_POST) === 0) || (count($errors) !== 0)) : ?>
        <form method="post">
            メールアドレス
            <input type="text" name="mail_address">
            パスワード
            <input type="password" name="password">
            <input type="submit" value="登録">
        </form>
    <?php endif; ?>

    <?php if (count($errors) !== 0) : ?>
        <ul>
            <?php foreach ($errors as $value) : ?>
                <li><?php print $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>