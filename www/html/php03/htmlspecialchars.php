<?
$str = '<h2>hogehoge"sgs"</h2>';
print $str;
print htmlspecialchars($str, ENT_QUOTES);
