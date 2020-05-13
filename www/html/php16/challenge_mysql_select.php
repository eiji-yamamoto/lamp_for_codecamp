<?php
$job = '';
if (isset($_POST['job'])) {
    $job = $_POST['job'];
}

$host = 'mysql';
$username = 'db_user';
$passwd = 'db_user';
$dbname = 'default_db';
$link = mysqli_connect($host, $username, $passwd, $dbname);
$data = array();

if ($link) {
    mysqli_set_charset($link, 'utf8');
    $query = "SELECT * FROM emp_table";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = $row;
    }
    mysqli_free_result($result);
    mysqli_close($link);
} else {
}
?>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>16-9 課題</title>
</head>

<body>
    表示する職種を選択してください。

    <form method="post">
        <select name="job">
            <option value="all" <?php if ($job === "all") { ?> selected <?php } ?>>全員</option>
            <option value="manager" <?php if ($job === "manager") { ?> selected <?php } ?>>マネージャー</option>
            <option value="analyst" <?php if ($job === "analyst") { ?> selected <?php } ?>>アナリスト</option>
            <option value="clerk" <?php if ($job === "clerk") { ?> selected <?php } ?>>一般職</option>
        </select>
        <input type="submit" value="表示">
    </form>

    社員一覧
    <table border="1">
        <tr>
            <th>社員番号</th>
            <th>名前</th>
            <th>職種</th>
            <th>年齢</th>
        </tr>

        <?php foreach ($data as $column) : ?>
            <tr>
                <?php if (($job === $column['job']) || ($job === 'all')) : ?>
                    <?php foreach ($column as $value) : ?>
                        <td><?php print $value; ?></td>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>

    </table>
</body>

</html>