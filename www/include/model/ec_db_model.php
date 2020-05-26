<?php

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
