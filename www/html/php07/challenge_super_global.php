<pre>
<?php
// 変数初期化
$gender = '';
$my_name = '';
$mail = '';

if (isset($_POST['gender']) === TRUE) {
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
}

if (isset($_POST['my_name']) === TRUE) {
    $my_name = htmlspecialchars($_POST['my_name'], ENT_QUOTES, 'UTF-8');
}

if (isset($_POST['mail']) === TRUE) {
    $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');
}
// var_dump($gender);
// var_dump($my_name);
// var_dump($mail);

print "name: $my_name \n";
print "gender : $gender \n";
print "mail : $mail \n";

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>7-7課題</title>
</head>

<body>
    <h2>7-7課題</h2>
    <form method="post">

        <input id="my_name" type="text" name="my_name" value="">
        <input type="radio" name="gender" value="man">男
        <input type="radio" name="gender" value="woman">女
        <input type="checkbox" name="mail" value="OK">お知らせメールを受け取る
        <input type="submit" value="送信">

    </form>
</body>


</html>
</pre>


</body>
</html>