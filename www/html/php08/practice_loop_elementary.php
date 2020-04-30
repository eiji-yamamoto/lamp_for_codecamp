<pre>
<?php
$coin_number = 0;
$up_result = 0;
$down_result = 0;
// var_dump($_POST["coin_number"]);

if (isset($_POST["coin_number"]) === TRUE) {
    $coin_number = $_POST['coin_number'];
}

for ($i = 1; $i < $coin_number + 1; $i++) {
    if (mt_rand(0, 1) === 0) {
        $up_result++;
    } else {
        $down_result++;
    }
}
print "表 : $up_result 回 \n";
print "裏 : $down_result 回 \n";

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>8-18 課題</title>
</head>

<body>
    <form action="#" method="post">
        <select name="coin_number">
            <option>10</option>
            <option>100</option>
            <option>1000</option>
        </select>回
        <button type="submit">コイントス</button>
    </form>
</body>

</html>
</pre>