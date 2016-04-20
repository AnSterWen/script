<?php
require_once(dirname(__FILE__) . "/common.db.model.php");

function db_igg_insert_update_bill($a_bill)
{
    global $g_db_conn;

    $table_name = "t_igg_bill";
    $insert_fields = array(
        'sn'                => $a_bill['sn'],

        'game_id'           => $a_bill['game_id'],
        'channel_id'        => $a_bill['channel_id'],
        'user_id'           => $a_bill['iggid'],
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
        'item_id'           => $a_bill['item_id'],
        'item_count'        => $a_bill['item_count'],
    );

    $update_sql = "recv_count = recv_count + 1, last_recv_time = NOW()";

    return $g_db_conn->insert_sentence_update($table_name, $insert_fields, $update_sql);
}



?>
