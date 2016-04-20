#!/usr/bin/php5
<?php
require_once(dirname(dirname(__FILE__)).'/config/common.config.php');
require_once(dirname(dirname(__FILE__)).'/lib/Log.class.php');
require_once(dirname(dirname(__FILE__)) . "/model/pay.proxy.model.php");
require_once(dirname(dirname(__FILE__)) . "/model/common.db.model.php");


$logger = new Log("bill-repair/bill_repair_", LOG_DIR);
global $g_db_config;
if (!db_init($g_db_config)) {
    $log = "db_init failed!";
    write_log("error", __FILE__, __FUNCTION__, __LINE__, $log);
    return;
}
$now = date("Y-m-d H:i:s");
$log = "\n\nstart time: {$now}";
write_log("info", __FILE__, __FUNCTION__, __LINE__, $log);

$limit_time = date('Y-m-d H:i:s', strtotime("now") - 10);//5分钟前的订单
$sql = "SELECT game_id, channel_id, platform_id, server_id, user_id, role_create_time, ".
    "order_id, product_id, third_user_id, third_order_id, third_product_id,".
    " item_id, item_count, amount, real_amount, currency, gift_id, gift_count, item_list,".
    " consume_time, consume_ip, consume_type, extra_data, create_time, charge_count," .
    " product_add_times, product_attr_int, product_attr_string FROM t_bill_detail".
    " WHERE create_time < '{$limit_time}' AND finish_time = 0 AND bill_state = 1 AND recv_count < 1000";

global $g_db_conn;
$rows = $g_db_conn->selectAll($sql);
write_log("info", __FILE__, __FUNCTION__, __LINE__, $sql);
//print_r($rows);

$count = 0;
foreach ( $rows as $row)
{
    $count++;

    $pay_channel_id = $row['channel_id'];
    $order_id = $row['order_id'];
    $login_channel_id = $row['platform_id'];
    $user_id = $row['user_id'];
    $role_create_time = $row['role_create_time'];
    $create_time = $row['create_time'];
    ////////
    $a_send_order = array(
        'game_id'       => $row['game_id'],
        'channel_id'    => $row["channel_id"],
        'platform_id'   => $row["platform_id"],
        'server_id'     => $row['server_id'],
        'user_id'       => $row['user_id'],
        'user_time'     => $row['role_create_time'],
        'order_id'      => $row['order_id'],
        'product_id'    => $row['product_id'],
        'user_charge_count' => $row['charge_count'],

        'third_user_id' => $row['third_user_id'],
        'third_order_id' => $row['third_order_id'],
        'third_product_id' => $row['third_product_id'],

        'item_id'       => $row['item_id'],
        'item_count'    => $row['item_count'],
        'amount'        => $row['amount'],
        'real_amount'   => $row['real_amount'],
        'currency_kind' => $row['currency'],
        'gift_id'       => $row['gift_id'],
        'gift_count'    => $row['gift_count'],
        'item_list'     => json_decode($row['item_list'], true),
        'consume_time'  => strtotime($row['consume_time']),
        'consume_ip'    => $row['consume_ip'],
        'consume_type'  => $row['consume_type'],
        'ext_data'      => $row['extra_data'],

        'product_add_times'   => $row['product_add_times'],
        'product_attr_int'    => $row['product_attr_int'],
        'product_attr_string' => $row['product_attr_string'],
    );
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "order[{$count}] info:".print_r($a_send_order, true));


    $i_send_result = send_to_pay_proxy($a_send_order);
    if ( false === db_record_bill_operation($pay_channel_id, $order_id, 'recharge', $i_send_result) ) {
        $log = "db record bill({$order_id}) operation(recharge) failed";
        write_log("error", __FILE__, __FUNCTION__, __LINE__, $log);
    }

    if ( 0 != $i_send_result ) {
        $log = "send_to_pay_proxy failed({$i_send_result}): " . print_r($a_send_order, true);
        write_log("error", __FILE__, __FUNCTION__, __LINE__, $log);
    }
    else {
        $log = "repair order_id({$order_id}) succ";
        write_log("info", __FILE__, __FUNCTION__, __LINE__, $log);
    }
}

$now = date("Y-m-d H:i:s");
$log = "end time: {$now}";
write_log("info", __FILE__, __FUNCTION__, __LINE__, $log);

?>
