<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>課題9-11</title>
</head>

<body>
    <h1>課題</h1>
    <table border="1">
        <tr>
            <th>郵便番号</th>
            <th>都道府県</th>
            <th>市区町村</th>
            <th>町域</th>
        </tr>

        <?php
        //$filename = "./ken_all_utf8.csv"; // 全データ、これを使うと、グロい
        $filename = "./test.csv";
        $data = [];
        if (($data = file($filename)) !== FALSE) {
            foreach ($data as $key => $value) {
                $array = [];
                $array = explode(',', $value);

                $post_number = $array[2];
                $prefecter = $array[6];
                $town = $array[7];
                $note = $array[8];
        ?>
                <tr>
                    <td><?php print $post_number ?></td>
                    <td><?php print $prefecter ?></td>
                    <td><?php print $town ?></td>
                    <td><?php print $note ?></td>
                </tr>
        <?php
            }
        } else {
            print "ファイルを開けませんでした \n";
        }
        ?>
    </table>
</body>

</html>