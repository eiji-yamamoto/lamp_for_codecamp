<?php
$value = 55.5555;

// 切り捨て
$value_floor = floor($value);

// 切り上げ
$value_ceil = ceil($value);

// 四捨五入
$value_round = round($value);

// 少数第2位で四捨五入
$value_round2 = round($value, 2)

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>課題</title>
</head>

<body>
    <p>元の値: :<?php print $value ?>　</p>
    <p>小数切り捨て:<?php print $value_floor ?> </p>
    <p>小数切り上げ::<?php print $value_ceil ?> </p>
    <p>小数四捨五入: :<?php print $value_round ?></p>
    <p>小数第二位で四捨五入: :<?php print $value_round2 ?></p>
</body>

</html>