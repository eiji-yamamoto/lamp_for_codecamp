<?php
$filename = "bbs_log.txt";
$errors = [];

if ((isset($_POST['name']) === TRUE) && (isset($_POST['comment']) === TRUE)) {
    // 名前とコメントのエラー処理
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
    if (count($errors) === 0) {
        $data = $_POST['name'] . ': ' .  $_POST['comment'] . ' -' . date('Y/m/d H:i:s') . "\n";
        file_put_contents($filename, $data, FILE_APPEND);
    }
}

// ファイル読み込み処理
$file_data_array = [];
if (($file_data_array = file($filename)) !== FALSE) {
    // 最新のコメントが上に来るようにひっくり返す
    $file_data_array = array_reverse($file_data_array);
} else {
    print 'ファイルが読み込めませんでした。';
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

    <?php if ($file_data_array) : ?>
        <?php foreach ($file_data_array as $value) : ?>
            <?php print  htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>
            <br>
        <?php endforeach ?>
    <?php endif ?>
</body>

</html>