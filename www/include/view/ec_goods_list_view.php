<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>商品一覧ページ</title>
    <style>
        #flex {
            width: 600px;
        }

        #flex .goods {
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
    <h1>商品一覧ページ</h1>

    <a href="./logout_controller.php">ログアウト</a><br>
    <a href="./cart_controller.php">カートへ</a><br>

    <?php if (check_err_msg($err_msg)) : ?>
        <ul>
            <?php foreach ($err_msg as $value) : ?>
                <?php if ($value !== 0) : ?>
                    <li><?php print h(ERR_MSGS[$value]); ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (isset($result_msg)) : ?>
        <?php print h($result_msg); ?>
    <?php endif; ?>
    <hr>

    <div id="flex">
        <?php foreach ($data as $value) : ?>
            <div class="goods">
                <span><img src="<?php print $value['img'] ?>" height="100"></span>
                <span><?php print h($value['name']); ?></span>
                <span><?php print h($value['price']); ?>円</span>
                <?php if ($value['stock'] == '0') : ?>
                    <?php print '売り切れ'; ?>
                <?php else : ?>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                        <span><input type="submit" value="カートに入れる"></span>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>


</body>

</html>