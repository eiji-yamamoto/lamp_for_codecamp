<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>自動販売機 結果</title>
</head>

<body>
    <h1>自動販売機 結果</h1>
    <?php if (count($err_msg) > 0) : ?>
        <ul>
            <?php foreach ($err_msg as  $value) : ?>
                <li><?php print $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (count($correct_commit_message) > 0) : ?>
        <img src="<?php print $drink_array['image_path'] ?>">
        <ul>
            <?php foreach ($correct_commit_message as  $value) : ?>
                <li><?php print $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="./index.php">自動販売機へ戻る</a>
</body>

</html>