<?php
require_once '../../include/conf/const.php';
require_once '../../include/model/model_bbs.php';

$errors = [];
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
include_once '../../include/view/view_bbs.php';
