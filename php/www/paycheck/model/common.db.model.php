<?php
require_once(dirname(dirname(__FILE__)) . "/lib/Mysql.class.php");

$g_db_conn = false;

define("BILL_NOT_EXIST", -1);
define("BILL_EXIST_BUT_NOT_HANDLE", 0);
define("BILL_HAS_HANDLED", 1);

/////////////////////////////////////common mysql part/////////////////////////////////////
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
    if (false !== $g_db_conn) {
        $g_db_conn->close();
    }
    $g_db_conn = false;

    return true;
}

function db_begin()
{
    global $g_db_conn;
    if (false !== $g_db_conn) {
        $g_db_conn->begin();
    }
}

function db_commit()
{
    global $g_db_conn;
    if (false !== $g_db_conn) {
        $g_db_conn->commit();
    }
}

function db_rollback()
{
    global $g_db_conn;
    if (false !== $g_db_conn) {
        $g_db_conn->rollback();
    }
}


/////////////////////////////////////common action part/////////////////////////////////////
function db_check_bill_state($channel_id, $order_id)
{
    global $g_db_conn;

    $sql = "SELECT bill_state, finish_time FROM t_bill_detail".
        " WHERE channel_id = {$channel_id} AND order_id = '{$order_id}'";
    $row = $g_db_conn->selectOne($sql);
    if (false === $row) {
        return BILL_NOT_EXIST;
    }
    $bill_state = $row['bill_state'];
    $finish_time = strtotime($row['finish_time']);
    if ( ($bill_state != 1) || ($finish_time > 0) ) {
        return BILL_HAS_HANDLED;
    }

    return BILL_EXIST_BUT_NOT_HANDLE;
}

function db_check_third_bill_state($channel_id, $third_order_id)
{
    global $g_db_conn;

    $sql = "SELECT bill_state, finish_time FROM t_bill_detail".
        " WHERE channel_id = {$channel_id} AND third_order_id = '{$third_order_id}'";
    $row = $g_db_conn->selectOne($sql);
    if (false === $row) {
        return BILL_NOT_EXIST;
    }
    $bill_state = $row['bill_state'];
    $finish_time = strtotime($row['finish_time']);
    if ( ($bill_state != 1) || ($finish_time > 0) ) {
        return BILL_HAS_HANDLED;
    }

    return BILL_EXIST_BUT_NOT_HANDLE;
}


function db_get_bill_detail($channel_id, $order_id)
{
    global $g_db_conn;

    $sql = "SELECT game_id, channel_id, platform_id, server_id, user_id, role_create_time AS user_time,".
        " order_id, product_id, charge_count AS user_charge_count,".
        " third_user_id, third_order_id, third_product_id, item_id, item_count, amount, real_amount,".
        " currency AS currency_kind, gift_id, gift_count, item_list, consume_time, ".
        " consume_ip, consume_type, extra_data AS ext_data,".
        " product_add_times, product_attr_int, product_attr_string".
        " FROM t_bill_detail".
        " WHERE channel_id = {$channel_id} AND order_id = '{$order_id}'";
    $row = $g_db_conn->selectOne($sql);
    $bill_info = false;
    if (false !== $row) {
        $bill_info = array();
        $bill_info = $row;
        $bill_info['item_list'] = json_decode($row['item_list'], true);
    }

    return $bill_info;
}

function db_get_third_bill_detail($channel_id, $third_order_id)
{
    global $g_db_conn;

    $sql = "SELECT game_id, channel_id, platform_id, server_id, user_id, role_create_time AS user_time,".
        " order_id, product_id, charge_count AS user_charge_count,".
        " third_user_id, third_order_id, third_product_id, item_id, item_count, amount, real_amount,".
        " currency AS currency_kind, gift_id, gift_count, item_list, consume_time, ".
        " consume_ip, consume_type, extra_data AS ext_data,".
        " product_add_times, product_attr_int, product_attr_string".
        " FROM t_bill_detail".
        " WHERE channel_id = {$channel_id} AND third_order_id = '{$third_order_id}'";
    $row = $g_db_conn->selectOne($sql);
    $bill_info = false;
    if (false !== $row) {
        $bill_info = array();
        $bill_info = $row;
        $bill_info['item_list'] = json_decode($row['item_list'], true);
    }

    return $bill_info;
}

function db_insert_achievement($achievement_db_info){
    global $g_db_conn;

    $table_name = "t_achievement_info";
    $insert_fields = array(
        'user_id'           => $achievement_db_info['user_id'],
        'level'        => $achievement_db_info['level'],
        'achievementCode'       => $achievement_db_info['achievementCode'],
        'add_time'         => $achievement_db_info['add_time'],
    );

    write_log("info", __FILE__, __FUNCTION__, __LINE__, "insert_fields: " . print_r($insert_fields, true));

    return $g_db_conn->insert($table_name, $insert_fields);
}

function db_get_user_achievement($user_id,$level)
{
    global $g_db_conn;

    $sql = "SELECT user_id FROM t_achievement_info WHERE user_id = ".$user_id." AND level = ".$level;
    write_log("info", __FILE__, __FUNCTION__, __LINE__, $sql);

    $rows = $g_db_conn->selectAll($sql);

    if (empty($rows)) {
        return true;
    }else{
        return false;
    }
}

function db_insert_reward($mail_info){
    global $g_db_conn;

    $table_name = "t_reward_detail";
    $insert_fields = array(
        'bill_state'           => $mail_info['bill_state'],
        'user_id'        => $mail_info['user_id'],
        'role_create_time'       => $mail_info['role_create_time'],
        'server_id'         => $mail_info['server_id'],
        'title'           => $mail_info['title'],
        'content'  => $mail_info['content'],
        'mail_from'          => $mail_info['mail_from'],
        'item_id'           => $mail_info['item_id'],
        'item_num'        => $mail_info['item_num'],
        'trans_id'            => $mail_info['trans_id'],

    );

    write_log("info", __FILE__, __FUNCTION__, __LINE__, "insert_fields: " . print_r($insert_fields, true));

    return $g_db_conn->insert($table_name, $insert_fields);
}

function db_insert_bill(&$bill_info)
{
    global $g_db_conn;
    $channel_id = $bill_info['channel_id'];

    //获取用户充值次数
    global $g_pay_count_type;
    global $g_fp_allow_channel;
    $charge_count = 1;
    if ( in_array($channel_id, $g_fp_allow_channel) ) {
        switch ($g_pay_count_type) {
        case PAY_COUNT_TO_USER:
            $charge_count = db_get_user_charge_count($bill_info['platform_id'], $bill_info['user_id'], $bill_info['user_time']);
            break;
        case PAY_COUNT_TO_PRODUCT:
            $charge_count = db_get_user_product_charge_count($bill_info['platform_id'],
                             $bill_info['user_id'], $bill_info['user_time'], $bill_info['product_id']);
            break;
        }
        $bill_info['user_charge_count'] = $charge_count;
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "user_charge_count: {$charge_count}");

        //首次充值
        $product_add_times = intval($bill_info['product_add_times']);
        if ($charge_count == 0 && $product_add_times > 100) {
            if (PAY_FIRST_INCLUDE_GIFT) {// gift也按倍数赠送
                $bill_info['gift_id'] = $bill_info['item_id'];
                $bill_info['gift_count'] += ($bill_info['item_count'] + $bill_info['gift_count']) * ($product_add_times - 100) / 100;
            }
            else {
                $bill_info['gift_id'] = $bill_info['item_id'];
                $bill_info['gift_count'] = $bill_info['item_count'] * ($product_add_times - 100) / 100;
            }
        }
    }
    $bill_info['product_add_times'] = 100;

    // 是否计入用户购买历史记录：0-计入，1-不计入
    $reset_flag = 0;
    if (PAY_MONTH_CARD == $bill_info['product_attr_int']) {
        $bill_info['product_attr_int'] = 10001;
        $bill_info['product_attr_string'] = $bill_info['product_id'];
        $reset_flag = 1;
    }

    $table_name = "t_bill_detail";
    $insert_fields = array(
        'game_id'           => $bill_info['game_id'],
        'channel_id'        => $bill_info['channel_id'],
        'platform_id'       => $bill_info['platform_id'],
        'server_id'         => $bill_info['server_id'],
        'user_id'           => $bill_info['user_id'],
        'role_create_time'  => $bill_info['user_time'],

        'order_id'          => $bill_info['order_id'],
        'product_id'        => $bill_info['product_id'],
        'item_id'           => $bill_info['item_id'],
        'item_count'        => $bill_info['item_count'],
        'amount'            => $bill_info['amount'],
        'real_amount'       => isset($bill_info['real_amount']) ? $bill_info['real_amount'] : $bill_info['amount'],
        'currency'          => $bill_info['currency_kind'],
        'gift_id'           => $bill_info['gift_id'],
        'gift_count'        => $bill_info['gift_count'],
        'item_list'      => is_string($bill_info['item_list']) ? $bill_info['item_list'] : json_encode($bill_info['item_list']),
        'charge_count'      => $bill_info['user_charge_count'],
        'consume_time'      => date("Y-m-d H:i:s", $bill_info['consume_time']),
        'consume_ip'        => $bill_info['consume_ip'],
        'consume_type'      => is_numeric($bill_info['consume_type']) ? $bill_info['consume_type'] : 1,//1-paid,2-free,3-offer

        'product_add_times'     => $bill_info['product_add_times'],
        'product_attr_int'      => $bill_info['product_attr_int'],

        'reset_flag' => $reset_flag,
    );

    // 如果空字符串则忽略
    $empty_keys = array(// array key ---> DB key
        'third_order_id'    => 'third_order_id',
        'third_user_id'     => 'third_user_id',
        'third_product_id'  => 'third_product_id',
        'pay_channel'       => 'pay_channel',
        'ext_data'          => 'extra_data',
        'product_attr_string' => 'product_attr_string',
        );
    foreach ($empty_keys as $arr_key => $db_key) {
        if ( !empty($bill_info[$arr_key]) ) {
            $insert_fields[$db_key] = $bill_info[$arr_key];
        }
    }
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "insert_fields: " . print_r($insert_fields, true));

    return $g_db_conn->insert($table_name, $insert_fields);
}

function db_record_bill_operation($channel_id, $order_id, $s_opt_type, $err_code, $err_desc = "")
{
    global $g_db_conn;

    $a_operations = array(
        'charge'    => 1,
        'recharge'  => 2,
        );

    if ( !isset($a_operations[$s_opt_type]) ) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "cannot support opt_type({$s_opt_type})");
        return false;
    }
    $i_opt_type = $a_operations[$s_opt_type];

    $sql = "SELECT bill_id FROM t_bill_detail WHERE channel_id = {$channel_id} AND order_id = '{$order_id}'";
    $row = $g_db_conn->selectOne($sql);
    if ( false === $row ) {
        return false;
    }
    $bill_id = $row['bill_id'];

    $table_name = "t_operation_log";
    $fields = array(
        'bill_id'       => $bill_id,
        'opt_type'      => $i_opt_type,
        'error_code'    => $err_code,
        'error_desc'    => $err_desc,
        );

    return $g_db_conn->insert($table_name, $fields);
}


// 获取用户充值次数
function db_get_user_charge_count($login_channel_id, $user_id, $role_create_time, $create_time = false)
{
    global $g_db_conn;

    if ( $create_time === false ) {//缺省则表示当前时间
        $sql = "SELECT COUNT(bill_id) AS charge_count FROM t_bill_detail".
            " WHERE platform_id = {$login_channel_id} AND user_id = {$user_id}".
            " AND role_create_time = {$role_create_time} AND create_time < NOW()".
            " AND reset_flag = 0";
    }
    else {
        $sql = "SELECT COUNT(bill_id) AS charge_count FROM t_bill_detail".
            " WHERE platform_id = {$login_channel_id} AND user_id = {$user_id}".
            " AND role_create_time = {$role_create_time} AND create_time < '{$create_time}'".
            " AND reset_flag = 0";
    }
    $row = $g_db_conn->selectOne($sql);
    if ( false === $row ) {
        return false;
    }

    return intval($row['charge_count']);
}

// 获取用户商品充值次数
function db_get_user_product_charge_count($login_channel_id, $user_id, $role_create_time, $product_id, $create_time = false)
{
    global $g_db_conn;

    if ( $create_time === false ) {//缺省则表示当前时间
        $sql = "SELECT COUNT(bill_id) AS charge_count FROM t_bill_detail".
            " WHERE platform_id = {$login_channel_id} AND user_id = {$user_id}".
            " AND role_create_time = {$role_create_time} AND product_id = {$product_id} AND create_time < NOW()".
            " AND reset_flag = 0";
    }
    else {
        $sql = "SELECT COUNT(bill_id) AS charge_count FROM t_bill_detail".
            " WHERE platform_id = {$login_channel_id} AND user_id = {$user_id}".
            " AND role_create_time = {$role_create_time} AND product_id = {$product_id} AND create_time < '{$create_time}'".
            " AND reset_flag = 0";
    }
    write_log("info", __FILE__, __FUNCTION__, __LINE__, $sql);
    $row = $g_db_conn->selectOne($sql);
    if ( false === $row ) {
        return false;
    }

    return intval($row['charge_count']);
}

// 获取用户充值记录
function db_get_user_product_detail($game_id, $login_channel_id, $user_id, $role_create_time, $server_id, $start_time = 0, $end_time = 0)
{
    global $g_db_conn;

    $time_condition = "";
    if (!empty($start_time)) {//限制开始时间
        $time_condition .= " AND create_time >= '{$start_time}'";
    }
    if (!empty($end_time)) {//限制结束时间
        $time_condition .= " AND create_time < '{$end_time}'";
    }

    $sql = "SELECT product_id as id, COUNT(bill_id) AS `count` FROM t_bill_detail".
        " WHERE game_id = {$game_id} AND platform_id = {$login_channel_id} AND user_id = {$user_id}".
        " AND role_create_time = {$role_create_time} AND reset_flag = 0".
        " {$time_condition} GROUP BY product_id";
    write_log("info", __FILE__, __FUNCTION__, __LINE__, $sql);

    $rows = $g_db_conn->selectAll($sql);
    if ( false === $rows ) {
        $log = "no record of SQL: {$sql}";
        write_log("error", __FILE__, __FUNCTION__, __LINE__, $log);
        return false;
    }

    return $rows;
}

//get_user_cost_money
function db_get_user_cost_money($user_info,$start_time,$end_time)
{
    global $g_db_conn;

    $start_time = date('Y-m-d H:i:s',$start_time);
    $end_time = date('Y-m-d H:i:s',$end_time);
    $sql = "SELECT SUM(real_amount/100) AS charge from t_bill_detail WHERE user_id = ".$user_info['user_id']." AND role_create_time = '".$user_info['reg_tm']."' AND create_time >= '".$start_time."' AND create_time <= '".$end_time."'";
    $row = $g_db_conn->selectOne($sql);

    if ( false === $row ) {
        return false;
    }
    return $row['charge'];
}

function db_check_user_award($uid,$achieve_id)
{
    global $g_db_conn;

    $sql = "SELECT id FROM t_user_appdriver_award WHERE user_id = ".$uid." AND achieve_id = '".$achieve_id."'";
    $row = $g_db_conn->selectOne($sql);
    if (false === $row) {
        return false;
    }else{
        return true;
    }
}

function db_insert_user_award($uid,$achieve_id,$accepted_time,$point)
{
    global $g_db_conn;

    $table_name = "t_user_appdriver_award";
    $insert_fields = array(
        'user_id' => $uid,
        'achieve_id' => $achieve_id,
        'accepted_time' => $accepted_time,
        'point' => $point,
    );
    return $g_db_conn->insert($table_name, $insert_fields);
}

?>
