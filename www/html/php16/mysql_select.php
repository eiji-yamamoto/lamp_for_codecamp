<pre>
<?php
$host = 'mysql';
$username = 'db_user';
$passwd = 'db_user';
$dbname = 'default_db';
$link = mysqli_connect($host, $username, $passwd, $dbname);

if ($link) {
    mysqli_set_charset($link, 'utf8');
    $query = 'SELECT goods_id, goods_name, price FROM goods_table';
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        print $row['goods_id'];
        print $row['goods_name'];
        print $row['price'];
        print "\n";
    }
    mysqli_free_result($result);
    mysqli_close($link);
} else {
    print 'DB接続失敗';
}

?>
</pre>