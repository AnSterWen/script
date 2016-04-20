<?php
require_once(dirname(dirname(__FILE__)) . "/lib/Mysql.class.php");

$g_db_conn = false;

////////////////////////////////////公用部分////////////////////////////////////
function db_init($db_config)
{
    global $g_db_conn;
    $g_db_conn = new Mysql();
    $conn_result = $g_db_conn->connect($db_config['db_host'] . ":" . $db_config['db_port'], 
        $db_config['db_user'], $db_config['db_pass'], $db_config['db_name']);
    if ($conn_result === false) {
        return false;
    }

    return true;
}

function db_finish()
{
    global $g_db_conn;
    if ($g_db_conn !== false) {
        $g_db_conn->close();
    }

    return true;
}

function get_hash_key($key)
{
    $hash_key = 0;
    $len = strlen($key);
    for ($i = 0; $i < $len; $i++) {
        $hash_key += 31 * $hash_key + ord($key[$i]);
        $hash_key = $hash_key & 0xFFFFFFFF;
    }

    return $hash_key;
}

////////////////////////////////////账号注册部分////////////////////////////////////
function generate_salt_passwd($salt, $password, $md5_count = 1)
{
    $salt_hex_str = sprintf("%010x", $salt);

    // 第1次MD5加密,原始密码已经md5一次
    $md5_1 = $password;
    // 第2次MD5加密
    $md5_2 = strtolower( md5($md5_1) );

    // 第2次MD5后追加salt
    $salt1_str = $md5_2 . $salt_hex_str;

    // 第3次MD5加密
    $md5_3 = strtolower( md5($salt1_str) );

    // 第三次MD5结果后再追加salt
    $salt2_str = $md5_3 . $salt_hex_str;

    // 反转
    $reverse_string = strrev($salt2_str);

    //16位MD5码
    $dest_passwd = md5($reverse_string, true);

    return $dest_passwd;
}


function db_get_a_userid($channel_id)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return false;
    }

    $sql = "SELECT start_uid, end_uid FROM db_userid.t_generate_userid_transaction".
        " WHERE channel_id = {$channel_id} AND dealed_status = 1";
    $rows = $g_db_conn->selectAll($sql);
    foreach ($rows as $row) {
        $start_uid = $row['start_uid'];
        $end_uid = $row['end_uid'];
        $sql = "SELECT MIN(userid) AS min_uid FROM db_userid.t_register_userid".
            " WHERE use_flag = 0 AND id BETWEEN {$start_uid} AND {$end_uid}";
        $uid_row = $g_db_conn->selectOne($sql);
        if ( $uid_row !== false && !empty($uid_row['min_uid']) ) {
            return intval($uid_row['min_uid']);
        }
    }

    return false;
}

function db_insert_userid_key($key, $key_type, $channel_id, $user_id)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return false;
    }

    $hash_key = get_hash_key($key);

    $table_name = sprintf("db_userid_key_map.t_key_userid_%02d", $hash_key % 100);
    $insert_fields = array(
        'userkey' => $key,
        'type' => $key_type,
        'channel' => $channel_id,
        'userid' => $user_id,
    );
    $result = $g_db_conn->insert($table_name, $insert_fields);
    if ($result === false) {
        return false;
    }

    $table_name = sprintf("db_userid_key_map.t_userid_key_%02d", $hash_key % 100);
    $insert_fields = array(
        'userid' => $user_id,
        'type' => $key_type,
        'channel' => $channel_id,
        'userkey' => $key,
    );
    $result = $g_db_conn->insert($table_name, $insert_fields);
    if ($result === false) {
        return false;
    }

    return true;
}


function db_get_key_userid($key, $key_type, $channel_id)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return false;
    }

    $hash_key = get_hash_key($key);

    $table_name = sprintf("db_userid_key_map.t_key_userid_%02d", $hash_key % 100);
    $sql = "SELECT userkey, type, channel, userid FROM {$table_name}".
        " WHERE userkey = '{$key}' AND type = {$key_type} AND channel = {$channel_id}";
    $row = $g_db_conn->selectOne($sql);
    if ($row === false) {
        write_log("warn", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
        return false;
    }

    return $row['userid'];
}


function db_register_userid($channel_id, $user_name, $password, $email, $client_ip)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return false;
    }

    $user_id = db_get_a_userid($channel_id);
    if ($user_id === false || $user_id <= 0) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "db_get_a_userid({$channel_id}) failed");
        return false;
    }

    //$salt = rand() * time() * $user_id;
    $salt = rand();
    $salt_pwd = generate_salt_passwd($salt, $password);

    $g_db_conn->begin();
    $is_succ = false;
    do {
        //设置userid为使用过状态
        $sql = "UPDATE db_userid.t_register_userid set use_flag = 1 WHERE userid = {$user_id}";
        $result = $g_db_conn->query($sql);
        if ($result === false) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "EXECUTE SQL FAILED: {$sql}");
            break;
        }

        //插入用户注册信息到基础库
        $table_name = sprintf("db_user_info.t_user_info_%02d", $user_id % 100);
        $insert_fields = array(
            'userid' => $user_id,
            'username' => $user_name,
            'passwd' => $salt_pwd,
            'email' => $email,
            'status' => 1,//注册则激活
            'register_channel' => $channel_id,
            'register_ip' => ip2long($client_ip),
            'salt' => $salt,
        );
        $result = $g_db_conn->insert($table_name, $insert_fields);
        if ($result === false) {
            break;
        }
        if (strlen(trim($email)) > 0) {
            //插入email <---> userid映射表
            $result = db_insert_userid_key($email, ACCOUNT_KEY_TYPE_EMAIL, $channel_id, $user_id);
            if ($result === false) {
                break;
            }
        }
        if (strlen(trim($user_name)) > 0) {
            //插入name <---> userid映射表
            $result = db_insert_userid_key($user_name, ACCOUNT_KEY_TYPE_NAME, $channel_id, $user_id);
            if ($result === false) {
                break;
            }
        }
        $is_succ = true;
    } while (false);

    if (!$is_succ) {
        $g_db_conn->rollback();
        return false;
    }
    $g_db_conn->commit();

    return $user_id;
}


////////////////////////////////////账号验证部分////////////////////////////////////
function db_check_user_passwd($channel_id, $user_id, $user_name, $password, $client_ip)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return ACCOUNT_ERR_SYS_BUSY;
    }

    $table_name = sprintf("db_user_info.t_user_info_%02d", $user_id % 100);
    $sql = "SELECT username, passwd, status, salt FROM {$table_name}".
        " WHERE userid = {$user_id}";
    $row = $g_db_conn->selectOne($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
        return ACCOUNT_ERR_SYS_ERR;
    }
    if ($user_name != $row['username']) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}): db username({$row['username']}) but recv name({$user_name})");
        return ACCOUNT_ERR_SYS_ERR;
    }
    $salt = $row['salt'];
    $salt_pwd = generate_salt_passwd($salt, $password);
    if ($salt_pwd != $row['passwd']) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}): db passwd({$row['passwd']}) but recv passwd({$password})");
        return ACCOUNT_ERR_WRONG_PASSWD;
    }
    $user_status = $row['status'];
    if ($user_status != 1) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}) status({$user_status}) != 1");
        return ACCOUNT_ERR_USER_FROZEN;
    }

    return ACCOUNT_ERR_OK;
}


function db_check_user_email($channel_id, $user_id, $user_name, $user_email, $client_ip)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return ACCOUNT_ERR_SYS_BUSY;
    }

    $table_name = sprintf("db_user_info.t_user_info_%02d", $user_id % 100);
    $sql = "SELECT username, email, status, salt FROM {$table_name}".
        " WHERE userid = {$user_id}";
    $row = $g_db_conn->selectOne($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
        return ACCOUNT_ERR_SYS_ERR;
    }
    if ($user_name != $row['username']) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}): db username({$row['username']}) but recv name({$user_name})");
        return ACCOUNT_ERR_SYS_ERR;
    }
    $user_status = $row['status'];
    if ($user_status != 1) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}) status({$user_status}) != 1");
        return ACCOUNT_ERR_USER_FROZEN;
    }

    if ($user_email != $row['email']) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}): db email({$row['email']}) but recv email({$user_email})");
        return ACCOUNT_ERR_NAME_EMAIL;
    }

    return ACCOUNT_ERR_OK;
}

function db_reset_user_passwd($channel_id, $user_id, $user_name, $user_email, $new_pasword, $client_ip)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return ACCOUNT_ERR_SYS_BUSY;
    }

    $table_name = sprintf("db_user_info.t_user_info_%02d", $user_id % 100);
    $sql = "SELECT username, email, status, salt FROM {$table_name}".
        " WHERE userid = {$user_id}";
    $row = $g_db_conn->selectOne($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
        return ACCOUNT_ERR_SYS_ERR;
    }
    if ($user_name != $row['username']) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}): db username({$row['username']}) but recv name({$user_name})");
        return ACCOUNT_ERR_SYS_ERR;
    }
    $user_status = $row['status'];
    if ($user_status != 1) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}) status({$user_status}) != 1");
        return ACCOUNT_ERR_USER_FROZEN;
    }

    if ($user_email != $row['email']) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}): db email({$row['email']}) but recv email({$user_email})");
        return ACCOUNT_ERR_NAME_EMAIL;
    }
    $salt = $row['salt'];
    $salt_pwd = generate_salt_passwd($salt, $new_pasword);

    $sql = sprintf(
        "UPDATE %s SET passwd = '%s' WHERE userid = %s",
        $table_name,
        mysql_real_escape_string($salt_pwd),
        $user_id
    );
    $row = $g_db_conn->query($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "exec sql failed: {$sql}");
        return ACCOUNT_ERR_SYS_ERR;
    }

    return ACCOUNT_ERR_OK;
}

function db_modify_user_passwd_by_old($channel_id, $user_id, $user_name, $old_passwd, $new_passwd, $client_ip)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return ACCOUNT_ERR_SYS_BUSY;
    }

    $table_name = sprintf("db_user_info.t_user_info_%02d", $user_id % 100);
    $sql = "SELECT username, passwd, status, salt FROM {$table_name}".
        " WHERE userid = {$user_id}";
    $row = $g_db_conn->selectOne($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
        return ACCOUNT_ERR_SYS_ERR;
    }
    if ($user_name !== $row['username']) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}): db username({$row['username']}) but recv name({$user_name})");
        return ACCOUNT_ERR_SYS_ERR;
    }
    $user_status = $row['status'];
    if ((int)$user_status !== 1) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}) status({$user_status}) != 1");
        return ACCOUNT_ERR_USER_FROZEN;
    }
    $salt = $row['salt'];
    $old_salt_pwd = generate_salt_passwd($salt, $old_passwd);
    if ($old_salt_pwd !== $row['passwd']) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}): db passwd({$row['passwd']}) but recv passwd({$old_passwd})");
        return ACCOUNT_ERR_WRONG_PASSWD;
    }

    $new_salt_pwd = generate_salt_passwd($salt, $new_passwd);
    $sql = sprintf(
        "UPDATE %s SET passwd = '%s' WHERE userid = %s",
        $table_name,
        mysql_real_escape_string($new_salt_pwd),
        $user_id
    );
    $row = $g_db_conn->query($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "exec sql failed: {$sql}");
        return ACCOUNT_ERR_SYS_ERR;
    }

    return ACCOUNT_ERR_OK;
}

function db_generate_session($user_id, $session, $client_ip)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return false;
    }
    $user_ip = ip2long($client_ip);
    $now = time();
    $dead_time = date("Y-m-d H:i:s", $now + ACCOUNT_SESSION_VALID_TIME);

    $table_name = sprintf("db_user_info.t_user_session_%02d", $user_id % 100);
    $insert_fields = array(
        'userid' => $user_id,
        'session' => $session,
        'dead_time' => $dead_time,
        'user_ip' => $user_ip,
    );
    $result = $g_db_conn->insert($table_name, $insert_fields);
        write_log("warn", __FILE__, __FUNCTION__, __LINE__,
            "FAILED: table_name({$table_name}) insert_fields:".print_r($insert_fields, true));
    if ($result === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__,
            "FAILED: table_name({$table_name}) insert_fields:".print_r($insert_fields, true));
        return false;
    }

    return true;
}


////////////////////////////////////userid生成部分////////////////////////////////////
function db_get_channel_userid_remain_count($channel_id)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return false;
    }

    $sql = "SELECT id, name".
        " FROM db_userid.t_channel_info".
        " WHERE id = {$channel_id} AND use_flag = 1";
    $row = $g_db_conn->selectOne($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
        return false;
    }
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "start to generate channel id({$row['id']}) name({$row['name']})");

    $sql = "SELECT start_uid, end_uid".
        " FROM db_userid.t_generate_userid_transaction".
        " WHERE channel_id = {$channel_id} AND dealed_status = 1";
    $rows = $g_db_conn->selectAll($sql);
    $userid_remain = 0;
    foreach ($rows as $row) {
        $start_uid = $row['start_uid'];
        $end_uid = $row['end_uid'];
        $sql = "SELECT COUNT(id) AS idcnt FROM db_userid.t_register_userid".
            " WHERE userid BETWEEN {$start_uid} AND {$end_uid} AND use_flag = 0";
        $cnt_row = $g_db_conn->selectOne($sql);
        if ($cnt_row === false) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
            return false;
        }
        $userid_remain += $cnt_row['idcnt'];
    }
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "channel({$channel_id}) remain userid count({$userid_remain})");
    return $userid_remain;
}

function db_get_max_userid()
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return false;
    }

    $sql = "SELECT max(userid) AS max_uid FROM db_userid.t_register_userid";
    $row = $g_db_conn->selectOne($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
        return false;
    }

    return empty($row['max_uid']) ? 0 : $row['max_uid'];
}

function db_generate_userid($channel_id, $gen_count)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return false;
    }

    $max_uid = db_get_max_userid();
    if ($max_uid === false) {
        return false;
    }
    $user_count = db_get_channel_userid_remain_count($channel_id);
    if ($user_count === false) {
        return false;
    }
    if ($user_count >= $gen_count) {
        return true;
    }
    $real_gen_count = $gen_count - $user_count;

    $is_succ = true;
    $g_db_conn->begin();
    for ($i = 1; $i <= $real_gen_count; $i++) {
        $user_id = $max_uid + $i;

        //插入userid
        $table_name = "db_userid.t_register_userid";
        $insert_fields = array(
            'userid' => $user_id,
            'use_flag' => 0,
        );
        $result = $g_db_conn->insert($table_name, $insert_fields);
        if ($result === false) {
            $is_succ = false;
            break;
        }
    }
    $start_uid = $max_uid + 1;
    $end_uid = $max_uid + $real_gen_count;

    //插入transaction
    $table_name = "db_userid.t_generate_userid_transaction";
    $insert_fields = array(
        'channel_id' => $channel_id,
        'start_uid' => $start_uid,
        'end_uid' => $end_uid,
    );
    $result = $g_db_conn->insert($table_name, $insert_fields);
    if ($result === false) {
        $is_succ = false;
    }

    if ($is_succ) {
        $g_db_conn->commit();
    } else {
        $g_db_conn->rollback();
    }

    $retrun_array = array(
        'result' => $is_succ ? 0 : 1,
        'start_uid' => $start_uid,
        'end_uid' => $end_uid,
    );

    return $retrun_array;
}


////////////////////////////////////session验证部分////////////////////////////////////
function db_check_user_session($user_id, $session)
{
    global $g_db_conn;
    if ($g_db_conn === false) {
        return ACCOUNT_ERR_SYS_ERR;
    }

    //检查账号是否有效
    $table_name = sprintf("db_user_info.t_user_info_%02d", $user_id % 100);
    $sql = "SELECT status FROM {$table_name} WHERE userid = '{$user_id}'";
    $row = $g_db_conn->selectOne($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
        return ACCOUNT_ERR_USERID_NOTEXIST;
    }
    $status = intval($row['status']);
    if ($status != 1) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "userid({$user_id}) wrong status({$row['status']})");
        return ACCOUNT_ERR_USER_FROZEN;
    }

    //检查session是否有效
    $table_name = sprintf("db_user_info.t_user_session_%02d", $user_id % 100);
    $sql = "SELECT userid, dead_time FROM {$table_name} WHERE session = '{$session}'";
    $row = $g_db_conn->selectOne($sql);
    if ($row === false) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "no record of sql: {$sql}");
        return ACCOUNT_ERR_SESSION_NOTEXIST;
    }
    $now = time();
    $dead_time = strtotime($row['dead_time']);
    if ($now > $dead_time) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "session({$session}) expired at {$row['dead_time']}");
        return ACCOUNT_ERR_SESSION_EXPIRE;
    }
    $save_user_id = $row['userid'];
    if ($user_id != $save_user_id) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__,
            "session({$session}) rcv_user_id({$user_id}) != db_user_id({$save_user_id})");
        return ACCOUNT_ERR_SESSION_WRONG_USER;
    }

    return ACCOUNT_ERR_OK;
}


?>
