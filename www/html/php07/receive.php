<?php
if (isset($_GET['my_name']) === TRUE && $_GET['my_name'] !== '') {
    // print 'ここに入力した名前を表示: ' . htmlspecialchars($_GET['my_name'], ENT_QUOTES, 'UTF-8');
    print 'ここに入力した名前を表示: ' . $_GET['my_name']; // htmlspecialcharsの確認、
    print '名前が未入力です。';
}
