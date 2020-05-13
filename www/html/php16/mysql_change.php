<pre>
    <?php

    $host = 'mysql';
    $username = 'db_user';
    $passwd = 'db_user';
    $dbname = 'default_db';
    $link = mysqli_connect($host, $username, $passwd, $dbname);
    if ($link) {
        mysqli_set_charset($link, 'utf8');
        // $query = 'INSERT INTO goods_table(goods_name, price) VALUES (\'ボールペン\', 80)';
        // $query = 'UPDATE goods_table SET price = 60 WHERE goods_name = \'ボールペン\'';
        $query = 'DELETE FROM goods_table WHERE goods_name = \'ボールペン\'';
        $result = mysqli_query($link, $query);
        if ($result) {
            print '成功';
        } else {
            print '失敗';
        }

        mysqli_close($link);
    } else {
        print 'DB接続失敗';
    }

    ?>
</pre>