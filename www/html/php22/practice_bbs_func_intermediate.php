<?php
$errors = [];

define('DB_HOST', 'mysql');
define('DB_USER_NAME', 'db_user');
define('DB_PASSWD', 'db_user');
define('DB_NAME', 'default_db');

function connect_db()
{
    $link = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWD, DB_NAME);
    mysqli_set_charset($link, 'utf8');
    return $link;
}

function insert_db($link, $sql)
{
    return mysqli_query($link, $sql);
}

function select_db($link, $sql)
{
    $data = array();
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = $row;
    }
    mysqli_free_result($result);
    return $data;
}

function close_db($link)
{
    mysqli_close($link);
}

function has_name_error($name)
{
    if (ctype_space($name)) {
        return '名前が空白文字のみで構成されているため、発言できません。';
    } elseif ($name === '') {
        return '名前を入力してください。';
    } elseif (mb_strlen($name) > 20) {
        return  '名前は20文字以内で入力してください。';
    }
    return FALSE;
}

function has_comment_error($comment)
{
    if (ctype_space($comment)) {
        return 'コメントが空白文字のみで構成されているため、発言できません。';
    } elseif ($comment === '') {
        return 'ひとことを入力してください。';
    } elseif (mb_strlen($comment) > 100) {
        return 'ひとことは100文字以内で入力してください。';
    }
    return FALSE;
}

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


///////////////////////
// main
///////////////////////
$link = connect_db();
if ((isset($_POST['name']) === TRUE) && (isset($_POST['comment']) === TRUE)) {
    // 名前とコメントのエラー処理
    if (has_name_error($_POST['name'])) {
        $errors[] = has_comment_error($_POST['name']);
    }

    if (has_comment_error($_POST['comment'])) {
        $errors[] = has_comment_error($_POST['comment']);
    }

    // 名前とコメントの登録処理
    if ((count($errors) === 0) && $link) {
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $sql = "INSERT INTO bbs_log (name, comment, datetime) VALUES ('$name', '$comment', NOW())";
        insert_db($link, $sql);
    }
}

// DB読み込み処理
if ($link) {
    $sql = "SELECT name, comment, datetime FROM bbs_log";
    $data = select_db($link, $sql);
    $data = array_reverse($data);
}

close_db($link);
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
            <?php print h($value); ?>
            <br>
        <?php endforeach ?>
    <?php endif ?>
</body>

</html>