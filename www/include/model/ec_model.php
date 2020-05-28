<?php

/**
 * リクエストメソッドを取得
 * @return str GET/POST/PUTなど
 */
function get_request_method()
{
    return $_SERVER['REQUEST_METHOD'];
}

/**
 * post data が存在するかどうか判断
 *
 * @param str $key
 * @return boolean
 */
function is_post_data_exist($key)
{
    return (isset($_POST[$key]) === true && trim($_POST[$key]) !== '');
}

/**
 * アカウントが、DBにあるかどうか確認
 *
 * @param object $link
 * @param string $name
 * @param string $password
 * @return mixed DBにあれば、該当のuser id 、なければ、FALSE
 */
function is_account_valid($link, $name, $password)
{
    $sql = "SELECT id FROM ec_user_table WHERE name = '" . $name . "' AND password = '" . $password . "'";
    $data = select_db($link, $sql);
    if (isset($data[0]['id'])) {
        return $data[0]['id'];
    } else {
        return false;
    }
}

/**
 * ログインしているかどうか確認
 *
 * @return void
 */
function is_logined()
{
    if (!isset($_SESSION['id'])) {
        header("Location: " . $_SERVER['PHP_SELF'] . '/../login_controller.php');
        exit();
    }
}

/**
 * 特殊文字をHTMLエンティティに変換する
 * @param str  $str 変換前文字
 * @return str 変換後文字
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

/**
 * upload されたファイルのパスを作る
 *
 * @param string $filename
 * @param string $uploaddir
 * @return string パス
 */
function create_upload_file_path($filename, $uploaddir = './img/')
{
    $image_name_array = explode('.', $filename);
    $image_file_offset = date('Y-m-d_H-i-s');
    $image_name = $image_name_array[0] . '_' . $image_file_offset . '.' . $image_name_array[1];
    return $uploaddir . $image_name;
}

/**
 * 商品の二次元配列から、合計金額を計算
 *
 * @param array $data
 * @return int 合計金額
 */
function calc_sum($data)
{
    $sum = 0;
    foreach ($data as $value) {
        $sum = $sum + $value['price'] * $value['amount'];
    }
    return $sum;
}
