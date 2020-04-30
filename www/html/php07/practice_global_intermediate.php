<pre>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>7-9課題</title>
</head>

<body>
    <h2>じゃんけん勝負</h2>
    <form method="post">

        <input type="radio" name="my_hand" value="グー">グー
        <input type="radio" name="my_hand" value="チョキ">チョキ
        <input type="radio" name="my_hand" value="パー">パー
        <input type="submit" value="送信">

    </form>
</body>


</html>

<?php
$my_hand = '';
$hands = ['グー', 'チョキ', 'パー'];

// 例外処理
// この処理の前にhtmをを表示したいから、htmlを上にもってきたが、html の箇所をphp の if で囲んだほうがよかったかも
if (isset($_POST['my_hand']) === FALSE || $_POST['my_hand'] === '') {
    print "Your hand is no value! \n Please input your hands!";
    exit;
}

// 上でexitすればこの条件は必要ない
if (isset($_POST['my_hand']) === TRUE && $_POST['my_hand'] !== '') {
    $my_hand = htmlspecialchars($_POST['my_hand'], ENT_QUOTES, 'UTF-8');
    $my_hand_number = array_search($my_hand, $hands);
}
//var_dump($hand);
print "my hand is $my_hand \n";


$opponent_hand = $hands[mt_rand(0, 2)];
$opponent_hand_number = array_search($opponent_hand, $hands);
print "opponetn hand is $opponent_hand \n";

if ($my_hand_number === $opponent_hand_number) {
    print "Draw \n";
} elseif (($my_hand_number + 1) % 3 === $opponent_hand_number) { // 勝ったとき
    print "You Win! \n";
} else {
    print " You Lose ... \n";
}

?>

</pre>