<?php
require_once (dirname(dirname(__FILE__)) . "/config/apple.config.php");
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once (dirname(dirname(__FILE__)) . "/model/third.platform.db.model.php");
require_once (dirname(dirname(__FILE__)) . "/model/pay.proxy.model.php");
require_once (dirname(dirname(__FILE__)) . "/apple/AppleReceipt.class.php");

$logger = new Log("apple/appstore_check_", LOG_DIR);
$client_ip = getClientIp();
write_log("info", __file__, __function__, __line__, "[transaction start]");
write_log("info", __file__, __function__, __line__, "REQUEST_URI:" . urldecode($_SERVER['REQUEST_URI']));
write_log("info", __file__, __function__, __line__, "_REQUEST: " . print_r($_REQUEST, true));
write_log("info", __file__, __function__, __line__, "client_ip:" . $client_ip);

global $g_appstore_exchange_rate;

//返回值
$now = time();
$return_array = array('result' => ERR_OK, 'handle_time' => $now, 'sign' => "");
$return_array['sign'] = calculate_sign($return_array);
$succ_string = json_encode($return_array);

$return_array['result'] = ERR_SYS_ERR;
$return_array['sign'] = calculate_sign($return_array);
$syserr_string = json_encode($return_array);

// 参数检查
$notify_data = $_REQUEST;
$check_result = check_params($notify_data);
if ($check_result === false) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    $return_array['result'] = ERR_INVALID_PARAMS;
    $return_array['sign'] = calculate_sign($return_array);
    die( json_encode($return_array) );
}

// 签名验证
$check_result = ios_check_sign($notify_data);
if ($check_result === false) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    $return_array['result'] = ERR_WRONG_SIGN;
    $return_array['sign'] = calculate_sign($return_array);
    die( json_encode($return_array) );
}
$user_id = $notify_data['user_id'];

// 验证小票并获取小票中订单信息
$bill_info = array();
$rInstance = new CAppleReceipt();
$result = $rInstance->verifyReceipt($notify_data, $bill_info);



write_log("info", __FILE__, __FUNCTION__, __LINE__, "user({$user_id}) verifyReceipt: result({$result})");
if ($result != ERR_OK) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    $return_array['result'] = $result;
    $return_array['sign'] = calculate_sign($return_array);


    if (1) {
        $my_redis = new Redis();
        $my_redis->pconnect('10.163.190.1', 6379);
        $my_redis->hSet("hBillFaild", $notify_data['udid'], json_encode($_REQUEST));
    }


    die( json_encode($return_array) );
}

// 获取苹果中商品ID对应的游戏内部商品详情
$db_suffix = $bill_info['db_suffix'];
$third_name = $bill_info['product_id'];
$product_info = get_product_detail_by_third_name($db_suffix, $third_name);
if (false === $product_info) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: get_product_detail_by_third_name({$third_name}) failed.");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    die( $syserr_string );
}
$bill_info['self_product_id'] = $product_info['product_id'];
$bill_info['self_product_price'] = $product_info['product_price'];
$bill_info['client_ip'] = $client_ip;



/////////////////////////////////////////订单处理逻辑部分///////////////////////////////////////
$order_id = $bill_info['trans_id'];
global $g_db_config;
$result = db_init($g_db_config);
if ( false === $result ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "order({$order_id}) connect db{$db_config['db_name']} failed.");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    die( $syserr_string );
}

//insert or update apple bill info
if ( false === db_apple_insert_update_bill($bill_info) ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_apple_insert_update_bill({$order_id}) failed");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    die( $syserr_string );
}

global $g_pay_channel;
$pay_channel_id = $g_pay_channel['apple'];
$bill_stat = db_check_bill_state($pay_channel_id, $order_id);
if (BILL_HAS_HANDLED == $bill_stat) {//已经处理过的订单直接返回成功
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "order({$order_id}) has been dealed before");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    die( $succ_string );
}

// 获取订单详情
$order_detail = array();
if (BILL_NOT_EXIST == $bill_stat) {
    $order_detail['game_id'] = $bill_info['game_id'];
    $order_detail['channel_id'] = $pay_channel_id;//支付渠道编码
    $order_detail['platform_id'] = $bill_info['channel_id'];//登录平台编码
    $order_detail['server_id'] = $bill_info['server_id'];
    $order_detail['user_id'] = $bill_info['user_id'];
    $order_detail['user_time'] = $bill_info['role_create_time'];
    $order_detail['order_id'] = $order_id;
    $order_detail['product_id'] = $product_info['product_id'];
    $order_detail['user_charge_count'] = 0;//交给db_insert_bill函数来获取

    $order_detail['third_user_id'] = 0;
    $order_detail['third_order_id'] = $order_id;
    $order_detail['third_product_id'] = $bill_info['product_id'];
    $order_detail['pay_channel'] = "APPSTORE";

    $order_detail['item_id'] = $product_info['item_id'];
    $order_detail['item_count'] = $product_info['item_count'];
    $order_detail['amount'] = $product_info['product_third_price'];
    $order_detail['real_amount'] = $product_info['product_third_price'];
    $order_detail['currency_kind'] = 'TWD';
    $order_detail['gift_id'] = $product_info['gift_id'];
    $order_detail['gift_count'] = $product_info['gift_count'];
    $order_detail['item_list'] = $product_info['item_list'];//赠送的道具列表
    $order_detail['consume_time'] = time();
    $order_detail['consume_ip'] = ip2long($client_ip);
    $order_detail['consume_type'] = 1;
    $order_detail['ext_data'] = "";

    $order_detail['product_add_times'] = $product_info['product_add_times'];
    $order_detail['product_attr_int'] = $product_info['product_attr_int'];
    $order_detail['product_attr_string'] = $product_info['product_attr_string'];

    //insert common bill info
    if ( false == db_insert_bill($order_detail) ) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_record_bill_operation({$order_id}) failed");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
        die( $syserr_string );
    } else if ($bill_info['is_sandbox'] == 0) {//非沙盒则落统计项
        platform_stat_pay_log($order_detail, $g_appstore_exchange_rate);
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "end of platform_stat_pay_log({$order_id})");
    }
}
else {//订单已存在，则依据数据库记录(客户端补单情况)
    $order_detail = db_get_bill_detail($pay_channel_id, $order_id);
    if ( false == $order_detail ) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_get_bill_detail({$order_id}) failed");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
        die( $syserr_string );
    }
}

write_log("info", __FILE__, __FUNCTION__, __LINE__, var_export($order_detail,true));
$result = send_to_pay_proxy($order_detail);
db_record_bill_operation($pay_channel_id, $order_id, "charge", $result);

if ($result != 0) {
    $result = ERR_ADD_ITEM_FAILED;
} else {
    $result = ERR_OK;
}


$return_array['result'] = $result;
$return_array['sign'] = calculate_sign($return_array);
$return_string = json_encode($return_array);
echo $return_string;
write_log("info", __FILE__, __FUNCTION__, __LINE__, "return_string: {$return_string}");
write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");

exit;










///////////////////////////////////////////////common function part///////////////////////////////////////////////

function check_params($recv_data)
{
    $req_params = array(
        'sign' => array('is_string',),
        'receipt' => array('is_string',),
        'app_name' => array('is_string',),
        'channel_id' => array('is_numeric',),
        'server_id' => array('is_numeric',),
        'user_id' => array('is_numeric',),
        'regtime' => array('is_numeric',),
        'level' => array('is_numeric',),
        //'amount' => array('is_numeric',),
        'udid' => array('is_string',),
        'jailbreak' => array('is_numeric',),
        );
    foreach ($req_params as $key => $methods) {
        if (!isset($recv_data[$key])) {
            $log = "lack of param({$key}) in request array:" . print_r($recv_data, true);
            write_log("error", __FILE__, __FUNCTION__, __LINE__, $log);
            return false;
        }
        $param = $recv_data[$key];
        foreach ($methods as $check_method) {
            if ( !$check_method($param) ) {
                $log = "wrong param({$key}) in request array:" . print_r($recv_data, true);
                write_log("error", __FILE__, __FUNCTION__, __LINE__, $log);
                return false;
            }
        }
    }

    return true;
}

function calculate_sign($cal_array)
{
    unset($cal_array['sign']);
    unset($cal_array['PHPSESSID']);
    ksort($cal_array);
    $md5_string = "";
    foreach ($cal_array as $key => $value) {
        $md5_string .= $value;
    }
    $md5_string .= IOS_RECEIPT_MD5_TAIL;
    //write_log("info", __FILE__, __FUNCTION__, __LINE__, "md5_string: {$md5_string}");

    return md5($md5_string);
}

function hash_calculate_sign($cal_array)
{
    $ctx = hash_init('md5');
    unset($cal_array['sign']);
    ksort($cal_array);
    foreach ($cal_array as $key => $value) {
        hash_update($ctx, $value);
    }
    hash_update($ctx, IOS_RECEIPT_MD5_TAIL);

    return hash_final($ctx);
}

function ios_check_sign($recv_data)
{
    $rcv_sign = $recv_data['sign'];
    $cal_sign = calculate_sign($recv_data);

    if ($cal_sign != $rcv_sign) {
        $log = "sign check fail: cal_sign({$cal_sign}) != rcv_sign({$rcv_sign})";
        write_log("error", __FILE__, __FUNCTION__, __LINE__, $log);
        return false;
    }

    return true;
}

