<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>課題8-18</title>
</head>

<body>

    <table border="1">

        <?php
        for ($i = 1; $i <= 9; $i++) {
        ?>
            <tr>

                <?php
                for ($j = 1; $j <= 9; $j++) {
                ?>

                    <td><?php print "$i * $j = " . $i * $j; ?></td>

                <?php
                }
                ?>
            </tr>

        <?php
        }
        ?>

    </table>
</body>

</html>