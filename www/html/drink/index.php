<?php

$host = 'mysql';
$username = 'db_user';
$passwd = 'db_user';
$dbname = 'default_db';
$err_msg = [];
$link = mysqli_connect($host, $username, $passwd, $dbname);

if ($link) {
    mysqli_set_charset($link, 'utf8');
    $sql = 'SELECT drink_table.drink_id, drink_name, drink_price, image_path, drink_stock
            FROM drink_table JOIN drink_stock_table ON drink_table.drink_id = drink_stock_table.drink_id
            WHERE public_status = 1';

    $result = mysqli_query($link, $sql);
    $data = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = $row;
    }

    mysqli_free_result($result);
    mysqli_close($link);
} else {
    $err_msg[] = 'error' . mysqli_connect_error();
}
?>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>自動販売機</title>

    <style>
        #flex {
            width: 600px;
        }

        #flex .drink {
            /*border: solid 1px;*/
            width: 120px;
            height: 210px;
            text-align: center;
            margin: 10px;
            float: left;
        }

        #flex span {
            display: block;
            margin: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #submit {
            clear: both;
        }
    </style>
</head>

<body>
    <h1>自動販売機</h1>

    <?php if (count($err_msg) >= 0) : ?>
        <ul>
            <?php foreach ($err_msg as  $value) : ?>
                <li><?php print $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="./result.php" method="post">
        金額 <input type="number" min="0" name="money">

        <div id="flex">
            <?php foreach ($data as $value) : ?>
                <div class="drink">
                    <span><img src="<?php print $value['image_path'] ?>"></span>
                    <span><?php print $value['drink_name']; ?></span>
                    <span><?php print $value['drink_price']; ?>円</span>
                    <?php if ($value['drink_stock'] == '0') : ?>
                        <?php print '売り切れ'; ?>
                    <?php else : ?>
                        <span><input type="radio" name="drink_id" value="<?php print $value['drink_id']; ?>"></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="submit">
            <input type="submit" value="購入">
        </div>
    </form>
</body>

</html>