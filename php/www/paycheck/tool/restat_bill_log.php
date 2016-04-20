#!/usr/bin/php5
<?php
require_once(dirname(dirname(__FILE__)).'/config/common.config.php');
require_once(dirname(dirname(__FILE__)).'/lib/Log.class.php');
require_once(dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once(dirname(dirname(__FILE__)) . "/lib/statlogger.php");
require_once(dirname(dirname(__FILE__)) . "/model/common.db.model.php");


if ( $argc != 4 ) {
    echo "Usage: {$argv[0]} channelId   start_time  end_time\n";
    return;
}

$channel_id = $argv[1];
$start_time = $argv[2];
$end_time = $argv[3];
if ($channel_id < 0) {
    echo "Usage: {$argv[0]} channelId   start_time  end_time\n";
    echo "ERROR: channel_id({$channel_id}) must bigger than zero\n";
    return;
}
if ($start_time >= $end_time) {
    echo "Usage: {$argv[0]} channelId   start_time  end_time\n";
    echo "ERROR: start_time({$start_time}) >= end_time({$end_time})\n";
    return;
}


$logger = new Log("restat_bill_log_", "./log/");
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
    " item_id, item_count, amount, real_amount, currency, gift_id, gift_count,".
    " consume_time, consume_ip, consume_type, create_time FROM t_bill_detail".
    " WHERE channel_id = {$channel_id} AND create_time >= '{$start_time}' AND create_time < '{$end_time}'";

global $g_db_conn;
$a_rows = $g_db_conn->selectAll($sql);
write_log("info", __FILE__, __FUNCTION__, __LINE__, $sql);
//print_r($a_rows);

$index = 0;
foreach ( $a_rows as $a_row)
{
    $index++;
    $log = "row[{$index}]: " . print_r($a_row, true);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, $log);

    $pay_amount = $a_row['amount'];
    $stat_game_id = $a_row['game_id'];
    $channel_user = $a_row['platform_id'] . "_" . $a_row['user_id'];
    $login_channel_id = $a_row['platform_id'];
    $server_id = $a_row['server_id'];

    $is_vip = 0;
    $currency = 1;
    $zone_id = -1; 
    $pay_reason = "_buyitem_";
    $product_id = $a_row['product_id'];
    $product_count = 1;
    $pay_channel = "GOOGLE_PLAY";
    $pay_time = strtotime($a_row['create_time']);
    stat_pay($stat_game_id, $login_channel_id, $zone_id, $server_id, $channel_user,
        $is_vip, $pay_amount, $currency, $pay_reason, $product_id, $product_count, $pay_channel, $pay_time);
}

$now = date("Y-m-d H:i:s");
$log = "end time: {$now}";
write_log("info", __FILE__, __FUNCTION__, __LINE__, $log);

?>
