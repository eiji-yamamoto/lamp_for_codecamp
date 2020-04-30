<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ひとこと掲示板</title>
</head>

<body>
    <h1>ひとこと掲示板</h1>
    <form action="#" method="post">
        名前 : <input type="text" name="name">
        ひとこと: <input type="text" name="comment">
        <input type="submit">
    </form>
</body>

</html>

<?php
$filename = "bbs_log.txt";
$valid_flag = TRUE;

if ((isset($_POST['name']) === TRUE) && (isset($_POST['comment']) === TRUE)) {
    // 名前とコメントのエラー処理
    if ($_POST['name'] === '') {
        print '名前を入力してください。<br>';
        $valid_flag = FALSE;
    }

    if ($_POST['comment'] === '') {
        print 'ひとことを入力してください。<br>';
        $valid_flag = FALSE;
    }

    if (mb_strlen($_POST['name']) > 20) {
        print '名前は20文字以内で入力してください。<br>';
        $valid_flag = FALSE;
    }

    if (mb_strlen($_POST['comment']) > 100) {
        print 'ひとことは100文字以内で入力してください。<br>';
        $valid_flag = FALSE;
    }

    // 名前とコメントの登録処理
    if ($valid_flag) {
        $data = $_POST['name'] . ': ' .  $_POST['comment'] . ' -' . date('Y/m/d H:i:s') . "\n";
        file_put_contents($filename, $data, FILE_APPEND);
    }
}

// レイアウト調整
print '<hr>';

// ファイル表示処理
if (($file_data_array = file($filename)) !== FALSE) {
    // 最新のコメントが上に来るようにひっくり返す
    foreach (array_reverse($file_data_array) as $value) {
        print htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '<br>';
    }
} else {
    print 'ファイルが読み込めませんでした。';
}
?>