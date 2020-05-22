<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['access_history_delete_flag'] === 'true') {
    setcookie('access_datetime', '', time() - 1);
    setcookie('access_num', '', time() - 1);
    header("Location: " . $_SERVER['PHP_SELF']); // 消したときは、その時点で、自分に再度飛ばし直す
} else {
    if (isset($_COOKIE['access_datetime'])) {
        $access_datetime = $_COOKIE['access_datetime'];
    }
    setcookie('access_datetime', date('Y-m-d H:i:s'), time() + 60 * 60 * 24 * 365);

    if (isset($_COOKIE['access_num'])) {
        $access_num = $_COOKIE['access_num'];
    } else {
        $access_num = 1;
    }
    setcookie('access_num', $access_num + 1, time() + 60 * 60 * 24 * 365);
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>課題 24-8 cookie</title>
</head>

<body>
    合計<?php print $access_num ?>回目のアクセスです。

    現在日時 :
    <?php print date('Y-m-d H:i:s'); ?>

    <?php if ($access_num > 1) : ?>
        前回のアクセス日時:
        <?php print $access_datetime; ?>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="access_history_delete_flag" value="true">
        <input type="submit" value="履歴削除">
    </form>

</body>

</html>