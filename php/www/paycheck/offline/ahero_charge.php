<?php
/**
 * AHERO按角色名充值
 * 用于线下充值
 */
require_once (dirname(dirname(__FILE__)) . "/config/offline.config.php");
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once (dirname(dirname(__FILE__)) . "/lib/statlogger.php");
require_once (dirname(dirname(__FILE__)) . "/model/third.platform.db.model.php");
require_once (dirname(dirname(__FILE__)) . "/model/pay.proxy.model.php");
require_once (dirname(dirname(__FILE__)) . "/model/web.db.model.php");

global $logger;
$logger = new Log("offline/ahero_charge_", LOG_DIR);

$client_ip = getClientIp();
write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge start]");
write_log("info", __FILE__, __FUNCTION__, __LINE__, "REQUEST_URI:" . urldecode($_SERVER['REQUEST_URI']));
write_log("info", __FILE__, __FUNCTION__, __LINE__, "_REQUEST: " . var_export($_REQUEST, true));
write_log("info", __FILE__, __FUNCTION__, __LINE__, "CLIENT_IP:" . $client_ip);

// 判断请求IP是否在白名单中
global $g_white_list;
if ( !empty($g_white_list) && !in_array($client_ip, $g_white_list) ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "IP({$client_ip}) forbidden");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
    json_resp(RESULT_ERR_INVALID_IP);
}

// 获取参数
$request = array();
foreach (array(
            'role_name',
            'server_id',
            'pay_channel',
            'order_id',
            'product_id',
            'item_id',
            'item_count',
            'amount',
            'currency',
            'ip',
            'sign'
        ) as $key) {
    if (!isset($_REQUEST[$key])) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: lack of parameter {$key}");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
        json_resp(RESULT_ERR_INVALID_PARAMETER);
    }
    $request[$key] = $_REQUEST[$key];
}

// 验证签名
if ( !check_md5_sign($request) ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: check md5 sign failed");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
    json_resp(RESULT_ERR_INVALID_SIGN);
}

// 检查游戏服务器
global $g_server_list;
$request['server_id'] = (int)$request['server_id'];
if (!isset($g_server_list[$request['server_id']])) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: invalid server id {$request['server_id']}");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
    json_resp(RESULT_ERR_INVALID_PARAMETER);
}
$server = $g_server_list[$request['server_id']];

// 验证角色名
$model = new dbModel();
$model->ip = $server['ip'];
$model->port = $server['port'];
$role = $model->get_user_by_nickname($request['role_name'], $request['server_id']);
write_log("info", __FILE__, __FUNCTION__, __LINE__, "ROLE: " . var_export($role, true));
if (!isset($role['result']) || $role['result'] !== 0
        || !isset($role['data']['userid'])) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: check role name failed");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
    json_resp(RESULT_ERR_INVALID_ROLE_NAME);
}
$role = $role['data'];

$game_id = 616;
$platform_id = ($role['userid'] >> 32) & 0xFFFFFFFF;
$user_id = $role['userid'] & 0xFFFFFFFF;
$role_create_time = $role['reg_tm'];

$order_id = $request['order_id'];
global $g_pay_channel;
global $g_offline_exchange_rate;
$pay_channel = strtolower($request['pay_channel']);
if (!isset($g_pay_channel[$pay_channel])) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: Unknown pay channel {$pay_channel}");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
    json_resp(RESULT_ERR_INVALID_PARAMETER);
}
$channel_id = $g_pay_channel[$pay_channel];


// =======================================订单处理逻辑部分=======================================
global $g_db_config;
$result = db_init($g_db_config);
if ( false === $result ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "order({$order_id}) connect db{$db_config['db_name']} failed.");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
    json_resp(RESULT_ERR_INTERNAL_ERROR);
}
// 插入线下充值记录
if (false === db_offline_insert_update_bill($request)) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_offline_insert_update_bill({$order_id}) failed");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
    json_resp(RESULT_ERR_INTERNAL_ERROR);
}
// 检查订单状态
$bill_stat = db_check_bill_state($channel_id, $order_id);
if (BILL_HAS_HANDLED == $bill_stat) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "order({$order_id}) has been dealed before");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
    json_resp(RESULT_OK);
}
// 获取订单详情
$order_detail = array();
if (BILL_NOT_EXIST === $bill_stat) {
    $order_detail['game_id'] = $game_id;
    $order_detail['platform_id'] = $platform_id;
    $order_detail['channel_id'] = $channel_id;
    $order_detail['server_id'] = $request['server_id'];
    $order_detail['user_id'] = $user_id;
    $order_detail['user_time'] = $role_create_time;
    $order_detail['order_id'] = $order_id;
    $order_detail['product_id'] = $request['product_id'];
    $order_detail['user_charge_count'] = 0; // 由db_insert_bill获取

    $order_detail['third_user_id'] = '';
    $order_detail['third_order_id'] = $order_id;
    $order_detail['third_product_id'] = '';
    $order_detail['pay_channel'] = "OFFLINE_{$request['pay_channel']}";

    $order_detail['item_id'] = 416002; // 所有商品都是砖石
    $order_detail['item_count'] = (int)$request['item_count'];
    $order_detail['amount'] = (int)($request['amount'] * 100);
    $order_detail['real_amount'] = (int)($request['amount'] * 100);
    $order_detail['currency_kind'] = $request['currency'];
    $order_detail['gift_id'] = 0;
    $order_detail['gift_count'] = 0;
    $order_detail['consume_time'] = time();
    $order_detail['consume_ip'] = ip2long($request['ip']);
    $order_detail['consume_type'] = 1; // 默认paid
    $order_detail['ext_data'] = '';

    $order_detail['product_add_times'] = 200; // 首充翻倍
    $order_detail['product_attr_int'] = 1;
    $order_detail['product_attr_string'] = '';

    // 月卡
    global $g_month_card_products;
    if (in_array($order_detail['product_id'], $g_month_card_products)) {
        $order_detail['product_add_times'] = 100;
        $order_detail['product_attr_int'] = PAY_MONTH_CARD;
    }

    write_log("info", __FILE__, __FUNCTION__, __LINE__, var_export($order_detail, true));

    if (false == db_insert_bill($order_detail)) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_record_bill_operation({$order_id}) failed");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
        json_resp(RESULT_ERR_INTERNAL_ERROR);
    } else {
        platform_stat_pay_log($order_detail, $g_offline_exchange_rate);
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "end of platform_stat_pay_log({$order_id})");
    }
} else { // 订单已存在，则依据数据库记录(客户端补单情况)
    $order_detail = db_get_bill_detail($channel_id, $order_id);
    if ( false === $order_detail ) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_get_bill_detail({$order_id}) failed");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
        json_resp(RESULT_ERR_INTERNAL_ERROR);
    }
}

$handle_result = send_to_pay_proxy($order_detail);
db_record_bill_operation($channel_id, $order_id, "charge", $handle_result);

write_log("info", __FILE__, __FUNCTION__, __LINE__, "OK");
write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero charge end]");
json_resp(RESULT_OK);
