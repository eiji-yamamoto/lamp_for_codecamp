<?php
if (isset($_GET['my_name']) === TRUE && $_GET['my_name'] !== '') {
    // print 'ここに入力した名前を表示: ' . htmlspecialchars($_GET['my_name'], ENT_QUOTES, 'UTF-8');
    print 'ようこそ ' . $_GET['my_name'] . 'さん'; // htmlspecialcharsの確認、

} else {
    print '名前を入力してください。';
}
