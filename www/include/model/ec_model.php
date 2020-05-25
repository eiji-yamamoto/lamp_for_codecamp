<?php
//////////////////
// http 系
/////////////////

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
    return (isset($_POST[$key]) === TRUE && trim($_POST[$key]) !== '');
}


//////////////////
// error 系
/////////////////
/**
 * エラー配列の中に、エラーがあるか確認
 *
 * @param array $err_msg
 * @return boolean
 */
function check_err_msg($err_msg)
{
    foreach ($err_msg as $value) {
        if ($value !== 0) {
            return TRUE;
        }
    }
    return FALSE;
}

/**
 * postデータのname にエラーがあるか確認
 *
 * @return int エラーコード
 */
function check_post_name_error()
{
    if (!is_post_data_exist('name')) {
        return 1;
    }
    return 0;
}

/**
 * post デーののprice にエラーがあるか確認
 *
 * @return int エラーコード
 */
function check_post_price_error()
{
    if (!is_post_data_exist('price')) {
        return 2;
    } else if (ctype_digit($_POST['price']) === FALSE) {
        return 3;
    }
    return 0;
}

/**
 * post データの stock にエラーがあるか確認
 *
 * @return int エラーコード
 */
function check_post_stock_error()
{
    if (!is_post_data_exist('stock')) {
        return 4;
    } else if (ctype_digit($_POST['stock']) === FALSE) {
        return 5;
    }
    return 0;
}

/**
 * post データの image に、エラーがあるか確認
 *
 * @return int エラーコード
 */
function check_post_image_error()
{
    if (isset($_FILES['image']) === FALSE || $_FILES['image']['error'] !== 0) {
        return 6;
    } else if ($_FILES['image']['type'] !== 'image/jpeg' && $_FILES['image']['type'] !== 'image/png') {
        return 7;
    }
    return 0;
}


/**
 * post デーのの公開/非公開の値が制約条件を満たしているかを確認
 *
 * @return int ERR_MSGSのエラーコードを返却
 */
function check_post_status_error()
{
    if (!is_post_data_exist('status')) {
        return 8;
    } elseif ($_POST['status'] !== '0' && $_POST['status'] !== '1') {
        return 9;
    }
    return 0;
}

/**
 * move_upload_file が上手くいくかどうかチェック
 *
 * @param string $old_path
 * @param string $new_path
 * @return int エラーコード
 */
function check_moving_upload_file_error($old_path, $new_path)
{
    if (move_uploaded_file($old_path, $new_path)) {
        return 0;
    } else {
        return 10;
    }
}

//////////////////
// その他
/////////////////
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


//////////////////
// db 操作
/////////////////
/**
 * DBハンドルを取得
 * @return obj $link DBハンドル
 */
function get_db_link()
{
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
    mysqli_set_charset($link, DB_CHARACTER_SET);
    return $link;
}

/**
 * DBとのコネクション切断
 * @param obj $link DBハンドル
 */
function close_db_link($link)
{
    mysqli_close($link);
}


/**
 * insertを実行する
 *
 * @param obj $link DBハンドル
 * @param str SQL文
 * @return bool
 */
function insert_db($link, $sql)
{
    return mysqli_query($link, $sql);
}

/**
 * update文を実行
 *
 * @param obj $link
 * @param str $sql
 * @return bool
 */
function update_db($link, $sql)
{
    return mysqli_query($link, $sql);
}

/**
 * delete文を実行
 *
 * @param obj $link
 * @param str $sql
 * @return bool
 */
function delete_db($link, $sql)
{
    return mysqli_query($link, $sql);
}



/**
 * クエリを実行しその結果を配列で取得する
 *
 * @param obj  $link DBハンドル
 * @param str  $sql SQL文
 * @param str  $result_type mysqli_fetch_arrayにおけるresult_type, 連想配列かどうか
 * @return array 結果配列データ
 */
function select_db($link, $sql, $result_type = MYSQLI_ASSOC)
{
    $data = array();
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, $result_type)) {
                $data[] = $row;
            }
        }
        mysqli_free_result($result);
    }
    return $data;
}
