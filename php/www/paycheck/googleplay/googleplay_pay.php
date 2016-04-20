<?php
require_once (dirname(dirname(__FILE__)) . "/config/googleplay.config.php");
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once (dirname(dirname(__FILE__)) . "/lib/statlogger.php");
require_once (dirname(dirname(__FILE__)) . "/model/third.platform.db.model.php");
require_once (dirname(dirname(__FILE__)) . "/model/pay.proxy.model.php");

// code=-1:订单验证失败
// code=0:订单正常受理成功
// code=1:订单已提交过，后端充值还未完成
// code=2:订单已提交且后端充值已完成

$fail_string = json_encode( array('code' => -1) );
$succ_string = json_encode( array('code' => 0) );
$repeted_string = json_encode( array('code' => 2) );


global $logger;
$logger = new Log("googleplay/google_play_pay_", LOG_DIR);
session_start();

$client_ip = getClientIp();
write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction start]");
write_log("info", __FILE__, __FUNCTION__, __LINE__, "REQUEST_URI:" . urldecode($_SERVER['REQUEST_URI']));
write_log("info", __FILE__, __FUNCTION__, __LINE__, "_REQUEST: " . print_r($_REQUEST, true));
write_log("info", __FILE__, __FUNCTION__, __LINE__, "CLIENT_IP:" . $client_ip);

// 判断请求IP是否在白名单中
global $g_white_list;
if ( !empty($g_white_list) && !in_array($client_ip, $g_white_list) ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "IP({$client_ip}) forbidden");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
	die($fail_string);
}

$chkres = googleplay_check_sign();
if ($chkres == false) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "googleplay_check_sign() failed");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
	die($fail_string);
}

$signed_data = $_REQUEST['signed_data'];
$notify_data = json_decode($_REQUEST['signed_data'], true);
$extra_array = json_decode($notify_data['developerPayload'], true);
$order_id = $extra_array['orderId'];
$third_order_id = $notify_data['orderId'];
$third_product_id = $notify_data['productId'];

//订单的购买状态。可能的值为0（已购买），1（取消购买），2（退款），或3（已过期，只用于购买订阅）
$purchase_state = $notify_data['purchaseState'];
if ($purchase_state != 0) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "order({$order_id}) wrong purchaseState: {$purchase_state}");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
	die($succ_string);
}

//获取内部订单信息
$order_info = array();
$product_info = array();
$result = get_inner_order_info($order_id, $order_info, $product_info);
if ( false === $result ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "get_inner_order_info({$order_id}) failed.");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
	die($fail_string);
}

if ( $third_product_id != $order_info['third_product_id'] ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__,
        "order({$order_id}) third_product_id({$third_product_id}) not match DB product_id({$order_info['third_product_id']})");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    die($fail_string);
}


/////////////////////////////////////////订单处理逻辑部分///////////////////////////////////////
global $g_db_config;
$result = db_init($g_db_config);
if ( false === $result ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "order({$order_id}) connect db{$db_config['db_name']} failed.");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
	die($fail_string);
}

//insert or update googleplay bill info
if ( false === db_googleplay_insert_update_bill($notify_data) ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_googleplay_insert_update_bill({$order_id}) failed");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    die($fail_string);
}

global $g_pay_channel;
global $g_googleplay_exchange_rate;
global $g_googleplay_package_config;

$pay_channel_id = $g_pay_channel['googleplay'];
$bill_stat = db_check_third_bill_state($pay_channel_id, $third_order_id);
if (BILL_HAS_HANDLED == $bill_stat) {//已经处理过的订单直接返回成功
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "order({$third_order_id}) has been dealed before, status({$bill_stat})");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
    //die($repeted_string);
    die($succ_string);
}


// 获取订单详情
$order_detail = array();
if (BILL_NOT_EXIST == $bill_stat) {
    $order_detail['game_id'] = $order_info['game_id'];
    $order_detail['channel_id'] = $pay_channel_id;//支付渠道编码
    $order_detail['platform_id'] = $order_info['channel_id'];//登录平台编码
    $order_detail['server_id'] = $order_info['server_id'];
    $order_detail['user_id'] = $order_info['user_id'];
    $order_detail['user_time'] = $order_info['role_create_time'];
    $order_detail['order_id'] = $order_id;
    $order_detail['product_id'] = $order_info['product_id'];
    $order_detail['user_charge_count'] = 0;//交给db_insert_bill函数来获取

    $order_detail['third_user_id'] = 0;
    $order_detail['third_order_id'] = $third_order_id;
    $order_detail['third_product_id'] = $third_product_id;
    // 检查签名时已经确认package名称正确，这里不再检查
    $order_detail['pay_channel'] = $g_googleplay_package_config[$notify_data['packageName']]['pay_channel'];

    $order_detail['item_id'] = $product_info['item_id'];
    $order_detail['item_count'] = $product_info['item_count'];
    $order_detail['amount'] = $order_info['price'];
    $order_detail['real_amount'] = $order_info['price'];
    $order_detail['currency_kind'] = "TWD";
    $order_detail['gift_id'] = $product_info['gift_id'];
    $order_detail['gift_count'] = $product_info['gift_count'];
    $order_detail['item_list'] = $product_info['item_list'];
    $order_detail['consume_time'] = time();
    $order_detail['consume_ip'] = ip2long($client_ip);
    $order_detail['consume_type'] = 1;
    $order_detail['ext_data'] = "";

    $order_detail['product_add_times'] = $order_info['product_add_times'];
    $order_detail['product_attr_int'] = $order_info['product_attr_int'];
    $order_detail['product_attr_string'] = $order_info['product_attr_string'];

    write_log("info", __FILE__, __FUNCTION__, __LINE__, var_export($order_detail,true));

    //insert common bill info
    //首次充值处理逻辑放到db_insert_bill函数中
    if ( false == db_insert_bill($order_detail) ) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_record_bill_operation({$order_id}) failed");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
        die($fail_string);
    }
    else {
        platform_stat_pay_log($order_detail, $g_googleplay_exchange_rate);
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "end of platform_stat_pay_log({$order_id})");
    }
}
else {//订单已存在，则依据数据库记录(客户端补单情况)
    $order_detail = db_get_third_bill_detail($pay_channel_id, $third_order_id);
    if ( false == $order_detail ) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_get_third_bill_detail({$third_order_id}) failed");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
        die( $fail_string );
    }
}

$handle_result = send_to_pay_proxy($order_detail);
db_record_bill_operation($pay_channel_id, $order_id, "charge", $handle_result);

echo $succ_string;

write_log("info", __FILE__, __FUNCTION__, __LINE__, "[transaction end]");
exit;





///////////////////////////////////////////common part///////////////////////////////////////////
function googleplay_check_sign()
{
    //$signture_data = '{"nonce":2923936465474897294,"orders":[{"notificationId":"android.test.purchased","orderId":"transactionId.android.test.purchased","packageName":"com.kunlun.fysg.test","productId":"android.test.purchased","purchaseTime":1346916115611,"purchaseState":0}]}';
    //signed_data => {"orderId":"12999763169054705758.1359978163011414","packageName":"com.taomee.amole_tt","productId":"100001","purchaseTime":1406619829965,"purchaseState":0,"developerPayload":"{\"server_id\":\"1\",\"cha_id\":\"2\"}","purchaseToken":"bcfmfejogkhdploffgiccifl.AO-J1OzQyL9NvKtUhOSAEPJUw_ebvLR2NKJQa4EbHu2mfBExWPu8bocHYaU0y-Fja6zvw9etX3NZOptGRGjnscvwCg9CDqkOi_un5-_UvoGzQy77LRVAkEk"}
    $game_id = $_REQUEST['gameid'];
    $signed_data = $_REQUEST['signed_data'];
    $signature = $_REQUEST['signature'];
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "game_id: {$game_id}");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "signed_data:\n{$signed_data}");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "signature:\n{$signature}");

    // 根据package名称区分公钥
    global $g_googleplay_package_config;
    $data = json_decode($signed_data, true);
    if (!is_array($data) || !isset($data['packageName']) || !isset($g_googleplay_package_config[$data['packageName']])) {
        write_log('info', __FILE__, __FUNCTION__, __LINE__, 'no configuration for ' . print_r($data, true));
        return false;
    }
    $public_key_base64 = $g_googleplay_package_config[$data['packageName']]['public_key'];

    $public_key =  "-----BEGIN PUBLIC KEY-----\n".
        chunk_split($public_key_base64, 64,"\n").
        '-----END PUBLIC KEY-----';   
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "public_key:\n{$public_key}");
    //using PHP to create an RSA key handler
    $publickey_handler = openssl_get_publickey($public_key);
    //$signature should be in binary format, but it comes as BASE64. 
    $signature = base64_decode($signature);   
    //using PHP's native support to verify the signature
    $result = openssl_verify($signed_data, $signature, $publickey_handler, OPENSSL_ALGO_SHA1);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "openssl_verify return: {$result}");

    return (1 === $result);
}


?>
