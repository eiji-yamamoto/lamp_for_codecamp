<pre>
<?php
// $s = date("s"); // dateのやり方
$s = idate("s"); // idate : intで数字を受け取る
// var_dump($s);

if ($s === 0) {
    print "ジャストタイム!!\n";
} else if ($s % 11 === 0) {
    print "ゾロ目!\n";
} else {
    print "ハズレ\n";
}
print "アクセスした瞬間の秒は $s でした。\n";
?>
</pre>