<pre>
<?php
$a = 10;
$b = 10;
$c = 10;
$d = 10;
define('DEF', 10);

print 'fuga_before: a = ' . $a . "\n";
print 'fuga_before: b = ' . $b . "\n";
print 'fuga_before: c = ' . $c . "\n";
print 'fuga_before: d = ' . $d . "\n";
print 'fuga_before: DEF = ' . DEF  . "\n";

fuga($c);

print 'fuga_after: a = ' . $a . "\n"; // beforeと同じ
print 'fuga_after: b = ' . $b . "\n"; // beforeと同じ
print 'fuga_after: c = ' . $c . "\n"; // 更新されている
print 'fuga_after: d = ' . $d . "\n"; // 更新されている
print 'fuga_after: DEF = ' . DEF  . "\n"; // かわらず

function fuga($c)
{

    global $d;

    $a++;
    print 'fuga: a = ' . $a . "\n"; // 参照できない

    $b = 100;
    $b++;
    print 'fuga: b = ' . $b . "\n"; // 100でうわがきされる

    $c++;
    print 'fuga: c = ' . $c . "\n"; // 引数でもらったcを使う

    $d++;
    print 'fuga: d = ' . $d . "\n"; // global宣言してるので、例外的に外部のdを参照

    define('DEF', 100);
    print 'fuga: DEF = ' . DEF . "\n"; // 問題なく使用
}
?>
</pre>