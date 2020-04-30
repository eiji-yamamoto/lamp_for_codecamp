<pre>
<?php
$comment = '';
$filename = './challenge_log.txt';
$date = date('Y/m/d H:i:s');
if (isset($_POST['comment']) === TRUE && $_POST['comment'] !== '') {
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
}
// var_dump($comment);
// var_dump($date);

// FILE_APPENDを使うと、追記モード(a)でfile_put_contentsを使える
// file_put_contents : fopne, fwrite, floseをしてくれるすごいやつ
// https://www.php.net/manual/ja/function.file-put-contents.php
if (file_put_contents($filename, ($date . "\t" . $comment . "\n"), FILE_APPEND) === FALSE) {
    print "ファイルの書き込みに失敗しました。\n";
}

if (($file_content = file_get_contents($filename)) === FALSE) {
    print "ファイルの読み込みに失敗しました。\n";
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>9-10 課題</title>
</head>

<body>
    <h1>課題</h1>
    <form action="#" method="post">
        発言 :
        <input type="text" name="comment">
        <input type="submit" value="送信">
    </form>

    <h3>発言一覧</h3>
    <?php if ($file_content) {
        print $file_content;
    } ?>
</body>

</html>
</pre>