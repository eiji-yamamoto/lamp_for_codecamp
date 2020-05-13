<?php
$errors = [];

$host = 'mysql';
$username = 'db_user';
$passwd = 'db_user';
$dbname = 'default_db';
$link = mysqli_connect($host, $username, $passwd, $dbname);

if ((isset($_POST['name']) === TRUE) && (isset($_POST['comment']) === TRUE)) {
    // 名前とコメントのエラー処理
    if (ctype_space($_POST['name'])) {
        $errors[] = '名前が空白文字のみで構成されているため、発言できません。';
    }

    if (ctype_space($_POST['comment'])) {
        $errors[] = 'コメントが空白文字のみで構成されているため、発言できません。';
    }

    if ($_POST['name'] === '') {
        $errors[] = '名前を入力してください。';
    }

    if ($_POST['comment'] === '') {
        $errors[] = 'ひとことを入力してください。';
    }

    if (mb_strlen($_POST['name']) > 20) {
        $errors[] = '名前は20文字以内で入力してください。';
    }

    if (mb_strlen($_POST['comment']) > 100) {
        $errors[] = 'ひとことは100文字以内で入力してください。';
    }

    // 名前とコメントの登録処理
    if ((count($errors) === 0) && $link) {
        mysqli_set_charset($link, 'utf8');
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $datetime = date('Y-m-d H:i:s');
        $insert_query = "INSERT INTO bbs_log (name, comment, datetime) VALUES ('$name', '$comment', '$datetime')";
        $insert_result = mysqli_query($link, $insert_query);
    }
}

// DB読み込み処理
if ($link) {
    $select_query = "SELECT name, comment, datetime FROM bbs_log";
    $select_result = mysqli_query($link, $select_query);
    $data = array();
    while ($row = mysqli_fetch_array($select_result, MYSQLI_ASSOC)) {
        $data[] = $row;
    }
    $data = array_reverse($data);
    mysqli_free_result($select_result);
}

?>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ひとこと掲示板</title>
</head>

<body>
    <h1>ひとこと掲示板</h1>
    <form method="post">
        名前 : <input type="text" name="name">
        ひとこと: <input type="text" name="comment">
        <input type="submit">
    </form>

    <?php if (count($errors) !== 0) : ?>
        <ul>
            <?php foreach ($errors as $value) : ?>
                <li>
                    <?php print $value; ?>
                </li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>

    <hr>

    <?php if ($data) : ?>
        <?php foreach ($data as $column) : ?>
            <?php $value = $column['name'] . ' : ' . $column['comment'] . ' - ' . $column['datetime']; ?>
            <?php print  htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>
            <br>
        <?php endforeach ?>
    <?php endif ?>
</body>

</html>