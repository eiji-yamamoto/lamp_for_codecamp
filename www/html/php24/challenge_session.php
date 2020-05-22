<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['access_history_delete_flag'] === 'true') {
    session_start();
    $_SESSION = [];
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']); // 消したときは、その時点で、自分に再度飛ばし直す
} else {
    session_start();
    if (isset($_SESSION['access_datetime'])) {
        $access_datetime = $_SESSION['access_datetime'];
    } else {
        $access_datetime = date('Y-m-d H:i:s');
    }
    $_SESSION['access_datetime'] = date('Y-m-d H:i:s');

    if (isset($_SESSION['access_num'])) {
        $access_num = $_SESSION['access_num'];
    } else {
        $access_num = 1;
    }
    $_SESSION['access_num'] = $access_num + 1;
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>課題 24-8 session</title>
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