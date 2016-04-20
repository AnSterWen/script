<?php
require_once(dirname(__FILE__) . "/common.db.model.php");
require_once(dirname(dirname(__FILE__)) . "/lib/Mysql.class.php");

function db_kakao_insert_update_bill($a_bill)
{
//    global $g_db_config;
//    $g_db_conn = db_init($g_db_config);
    global $g_db_conn;

    $table_name = "t_kakao_bill";
    $insert_fields = array(
        'transactionId' => $a_bill['transactionId'],
        'order_id'  => $a_bill['order_id'],
        'game_id'   => $a_bill['game_id'],
        'channel_id'    => $a_bill['channel_id'],
        'user_id'   => $a_bill['user_id'],
        'applicationId'            => $a_bill['applicationId'],
        'productName'          => $a_bill['productName'],
        'productId'            => $a_bill['productId'],
        'itemId'            => $a_bill['itemId'],
        'amount'         => $a_bill['amount'],
        'currencyUnit'             => $a_bill['currencyUnit'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}


function db_igg_insert_update_bill($a_bill)
{
    global $g_db_conn;

    $table_name = "t_igg_bill";
    $insert_fields = array(
        'sn'                => $a_bill['sn'],

        'game_id'           => $a_bill['game_id'],
        'channel_id'        => $a_bill['channel_id'],
        'user_id'           => $a_bill['user_id'],
        'role_create_time'  => $a_bill['c_id'],
        'server_id'         => $a_bill['s_id'],

        'igg_id'            => $a_bill['iggid'],
        'currency'          => $a_bill['currency'],
        'amount'            => $a_bill['amount'],
        'amountUSD'         => $a_bill['amountUSD'],
        'pc_id'             => $a_bill['pc_id'],
        'pm_id'             => $a_bill['pm_id'],
        'coin_type'         => $a_bill['coin_type'],
        'coin_num'          => $a_bill['coin_num'],
        'iBuyPoints'        => $a_bill['iBuyPoints'],
        'consume_time'      => date("Y-m-d H:i:s", $a_bill['datetime']),
        'consume_ip'        => $a_bill['ip'],
        'pm_type'           => $a_bill['pm_type'],
        'item_id'           => $a_bill['item_id'],
        'item_count'        => $a_bill['item_count'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}


function db_get_igg_product_detail($pamas)
{
    global $g_db_conn;

    $game_id = intval($pamas['game_id']);
    $channel_id = $pamas['channel_id'];
    $user_id = $pamas['user_id'];
    $role_create_time = $pamas['reg_time'];

    $sql = "SELECT third_product_id AS id, COUNT(bill_id) AS count".
        " FROM t_bill_detail".
        " WHERE game_id = {$game_id} AND channel_id = {$channel_id}".
	" AND user_id = {$user_id} AND role_create_time = {$role_create_time}".
	" GROUP BY third_product_id";

    $rows = $g_db_conn->selectAll($sql);
    if (false === $rows) {
        $log = "no record of SQL: {$sql}";
        write_log("error", __FILE__, __FUNCTION__, __LINE__, $log);
        return false;
    }

    return $rows;
}




function db_mycard_insert_update_bill($a_bill)
{
    global $g_db_conn;

    $table_name = "t_mycard_bill";
    $insert_fields = array(
        'mycard_order_id' => $a_bill['MG_TxID'],
        'cp_order_id'   => $a_bill['CP_TxID'],
        'account'       => $a_bill['Account'],
        'amount'        => $a_bill['Amount'],
        'server_id'     => $a_bill['Realm_ID'],
        'character_id'  => $a_bill['Character_ID'],
        'mycard_pno'    => $a_bill['MyCardProjectNo'],
        'mycard_type'   => $a_bill['iggid'],
        'trade_time'    => date("Y-m-d H:i:s", $a_bill['Tx_Time']),
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

function db_googleplay_insert_update_bill($a_bill)
{
    global $g_db_conn;

    //$table_name = "t_googleplay_bill";
    $table_name = "t_tx_bill";
    $insert_fields = array(
        'order_id' => $a_bill['orderId'],
        'notification_id'   => $a_bill['notificationId'],
        'package_name'       => $a_bill['packageName'],
        'product_id'        => $a_bill['productId'],
        'purchase_time'     => $a_bill['purchaseTime'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

function db_gameone_insert_update_bill($a_bill)
{
    global $g_db_conn;

    $table_name = "t_gameone_pay_bill";
    $insert_fields = array(
        'billno'  => $a_bill['billno'],
        'nick_name' => $a_bill['nickname'],
        'globalid'  => $a_bill['globalid'],
        'gopoint'   => $a_bill['gopoint'],
        'gamegold'  => $a_bill['gamegold'],
        'amount'    => $a_bill['amount'],
        'extra_data'=> $a_bill['ext'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

function db_gameone_add_item_bill($a_bill)
{
    global $g_db_conn;

    $table_name = "t_gameone_add_item_bill";
    $insert_fields = array(
        'billno'  => $a_bill['billno'],
        'globalid'   => $a_bill['globalid'],
        'nick_name' => $a_bill['nickname'],
        'item_id'   => $a_bill['itemid'],
        'item_count'=> $a_bill['quantity'],
        'extra_data'=> $a_bill['ext'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

function db_mface_insert_update_bill($a_bill)
{
    global $g_db_conn;

    $table_name = "t_mface_bill";
    $insert_fields = array(
        'mface_order_id'=> $a_bill['MerchantRef'],
        'cp_order_id'   => $a_bill['Extraparam1'],
        'amount'        => $a_bill['Amount'],
        'role_id'       => $a_bill['RoleID'],
        'zone_id'       => $a_bill['ZoneID'],
        'gold'          => $a_bill['Gold'],
        'pay_type'      => $a_bill['pay_Type'],
        'trade_time'    => date("Y-m-d H:i:s", $a_bill['Time']),
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

function db_gash_insert_update_bill($a_bill)
{
    global $g_db_conn;

    $table_name = "t_gash_bill";
    $insert_fields = array(
        'out_trade_no'  => $a_bill['out_trade_no'],
        'global_id'     => $a_bill['uid'],
        'server_id'     => $a_bill['server_id'],
        'num'           => $a_bill['num'],
        'coin'          => $a_bill['coin'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

function db_apple_insert_update_bill($a_bill)
{
    global $g_db_conn;

    $table_name = "t_apple_bill";
    $insert_fields = array(
        'trans_id'          => $a_bill['trans_id'],
        'original_trans_id' => $a_bill['original_trans_id'],
        'product_id'        => $a_bill['product_id'],
        'item_id'           => $a_bill['item_id'],
        'quantity'          => $a_bill['quantity'],
        'purchase_date'          => $a_bill['purchase_date'],
        'original_purchase_date' => $a_bill['original_purchase_date'],
        'uuid'              => $a_bill['uuid'],
        'device'            => $a_bill['device'],
        'app_version'       => $a_bill['app_version'],
        'bundle_id'         => $a_bill['bundle_id'],
        'client_ip'         => $a_bill['client_ip'],
        'is_jailbreak'      => $a_bill['is_jailbreak'],
        'is_sandbox'        => $a_bill['is_sandbox'],

        //游戏相关
        'game_id'           => $a_bill['game_id'],
        'channel_id'        => $a_bill['channel_id'],
        'user_id'           => $a_bill['user_id'],
        'role_create_time'  => $a_bill['role_create_time'],
        'server_id'         => $a_bill['server_id'],
        'self_product_id'   => $a_bill['self_product_id'],
        'self_product_price'=> $a_bill['self_product_price'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

function db_goodgame_insert_update_bill($bill_info)
{
    global $g_db_conn;

    $table_name = "t_goodgame_bill_v1";
    $insert_fields = array(
        'transaction_id'    => $bill_info['transactionID'],
        'app_id'            => $bill_info['app_id'],
        'coin_balance'      => $bill_info['coin_balance'],
        'reference_id'      => $bill_info['reference_id'],
        'resp_code'         => $bill_info['resp_code'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

function db_goodgame_insert_update_bill_v2($bill_info)
{
    global $g_db_conn;

    $table_name = "t_goodgame_bill_v2";
    $insert_fields = array(
        'transaction_id'    => $bill_info['transaction_id'],
        'app_id'            => $bill_info['app_id'],
        'payment_code'      => $bill_info['payment_code'],
        'price'             => $bill_info['price'],
        'currency'          => $bill_info['currency'],
        'reference_id'      => $bill_info['reference_id'],
        'resp_code'         => $bill_info['resp_code'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

function db_netmarble_insert_update_bill($bill_info)
{
    global $g_db_conn;

    $table_name = "t_netmarble_bill";
    $insert_fields = array(
        'transactionId' => $bill_info['transactionId'],
        'order_id'      => $bill_info['order_id'],
        'game_id'       => $bill_info['game_id'],
        'channel_id'    => $bill_info['channel_id'],
        'user_id'       => $bill_info['user_id'],
        'applicationId' => $bill_info['applicationId'],
        'product_id'   => $bill_info['product_id'],
        'itemId'        => $bill_info['itemId'],
        'amount'        => $bill_info['amount'],
        'currencyUnit'  => $bill_info['currencyUnit'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

//netmarble根据transID获取id
function db_netmarble_get_transId_to_oid($trans_id)
{
    global $g_db_conn;
    $sql = "SELECT order_id FROM t_netmarble_bill".
        " WHERE transactionId = '{$trans_id}'";

    $row = $g_db_conn->selectOne($sql);
    if ( false === $row ) {
        return false;
    }

    return $row['order_id'];
}

function db_thailandtdp_insert_update_bill($a_bill)
{
    global $g_db_conn;

    $table_name = "t_thailandtdp_bill";
    $insert_fields = array(
        'game_id'          => $a_bill['game_id'],
        'channel_id'       => $a_bill['channel_id'],
        'user_id'          => $a_bill['UserID'],
        'role_create_time' => $a_bill['RoleCreateTime'],
        'server_id'        => $a_bill['ServerID'],
        'uid'              => $a_bill['UID'],
        'order_id'         => $a_bill['OrderID'],
        'amount'           => $a_bill['Amount'],
        'ip'               => $a_bill['IP'],
        'count'            => $a_bill['Count']
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}

/**
 * 猎豹充值成功后回调记录
 *
 * @param  array $record
 * @return int|false
 */
function db_cheetah_insert_update_bill($record)
{
    global $g_db_conn;

    $table = 't_cheetah_bill';
    $fields = array(
        'bid' => $record['bid'],
        'client_id' => $record['client_id'],
        'product_id' => $record['product_id'],
        'purchase_date_ms' => $record['purchase_date_ms'],
        'purchase_date' => $record['purchase_date'],
        'purchase_date_pst' => $record['purchase_date_pst'],
        'transaction_id' => $record['transaction_id'],
        'money' => $record['money'],
        'currency' => $record['currency'],
        'quantity' => $record['quantity'],
        'uid' => $record['uid'],
        'payload' => $record['payload'] // 内部订单号
    );
    $sql = 'recv_count = recv_count + 1, last_recv_time = NOW()';

    return $g_db_conn->insert_sentence_update($table, $fields, $sql);
}

/**
 * 线下充值记录
 *
 * @param  array     $record
 *
 * @return int|false
 */
function db_offline_insert_update_bill($record)
{
    global $g_db_conn;

    $table = 't_offline_bill';
    $fields = array(
        'role_name' => $record['role_name'],
        'server_id' => $record['server_id'],
        'pay_channel' => $record['pay_channel'],
        'order_id' => $record['order_id'],
        'item_id' => $record['item_id'],
        'item_count' => $record['item_count'],
        'amount' => $record['amount'],
        'currency' => $record['currency'],
        'ip' => $record['ip']
    );
    $sql = 'recv_count = recv_count + 1, last_recv_time = NOW()';

    return $g_db_conn->insert_sentence_update($table, $fields, $sql);
}
