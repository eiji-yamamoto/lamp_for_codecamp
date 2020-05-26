<?php

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

/**
 * username のpost があるかどうか
 *
 * @return int エラーコード
 */
function check_post_username_error()
{
    return check_post_name_error();
}

/**
 * username の文法チェック
 *
 * @return int エラーコード
 */
function check_username_grammer_error()
{
    $pattern = '/^[0-9a-zA-Z]{6,}$/';
    if (preg_match($pattern, $_POST['name']) !== 1) {
        return 16;
    }
    return 0;
}


/**
 * パスワードがポストされているかどうか
 *
 * @return int エラーコード
 */
function check_post_password_error()
{
    if (!is_post_data_exist('password')) {
        return 14;
    }
    return 0;
}

/**
 * パスワードの文法を確認
 *
 * @return int エラーコード
 */
function check_password_grammer_error()
{
    $pattern = '/^[0-9a-zA-Z]{6,}$/';
    if (preg_match($pattern, $_POST['password']) !== 1) {
        return 18;
    }
    return 0;
}
/**
 * post されたamount があっているかどうか確認
 *
 * @return int エラーコード
 */
function check_post_amount_error()
{
    if (!is_post_data_exist('amount')) {
        return 19;
    } else if (ctype_digit($_POST['amount']) === FALSE || $_POST['amount'] === '0') {
        return 20;
    }
    return 0;
}
