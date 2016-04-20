<?php
include_once ( dirname(dirname(__FILE__)) . "/config/common.config.php" );
include_once ( dirname(dirname(__FILE__)) . "/lib/functions.php" );
include_once ( dirname(dirname(__FILE__)) . "/proto/pb4php/message/pb_message.php" );
//include_once ( dirname(dirname(__FILE__)) . "/proto/pb_proto_iplatform.overseas.pay.php" );
include_once ( dirname(dirname(__FILE__)) . "/proto/pb_proto_iplatform.pay.php" );

function send_to_pay_proxy($order_info)
{
    global $g_proxy_conf;
    $ip = $g_proxy_conf['ip'];
    $port = $g_proxy_conf['port'];
    $private_key = $g_proxy_conf['pri_key'];

    // socket create，指定socket为tcp连接
    $socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
    // 设置超时
    socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 3, "usec" => 0));
    socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array("sec" => 1, "usec" => 0));

    if (!$socket) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "create socket failed");
        return CREATE_SOCKET_ERROR;
    }

    // socket connect 建立三次握手
    if (!socket_connect($socket,$ip,$port)) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "connect to pay proxy failed");
        return SOCKET_CONNECT_ERROR;
    }


    //包头
    $game_id = $order_info['game_id'];
    $channel_id = $order_info['channel_id'];//支付渠道
    $pack_header = new pay_msg_head_t();
    $pack_header->set_msg_type_name("IPlatformPayProto.overseas_boss_pay_msg_in_t");
    $pack_header->set_game_id($game_id);
    // 这里是指支付渠道
    $pack_header->set_channel_id($channel_id);
    $pack_header->set_ret(0);
    $pack_header->set_seq(0);
    $pack_header->set_server_id( $order_info['server_id'] );
    $sign = "game_id=".$game_id."&channel_id=".$channel_id."&pri_key=".$private_key;
    if (!isset($order_info['real_amount'])) {
        $order_info['real_amount'] = $order_info['amount'];
    }
    if (!isset($order_info['platform_id'])) {
        $order_info['platform_id'] = $order_info['channel_id'];//登录渠道号
    }
    if (!isset($order_info['user_charge_count'])) {
        $order_info['user_charge_count'] = 0;//默认为首次购买
    }

    //包体
    $pack_body = new overseas_boss_pay_msg_in_t();
    $pack_body->set_server_id( $order_info['server_id'] );
    $pack_body->set_user_id( $order_info['user_id'] );
    $pack_body->set_user_time( $order_info['user_time'] );//role create time
    $pack_body->set_third_user_id( $order_info['third_user_id'] );
    $pack_body->set_order_id( $order_info['order_id'] );
    $pack_body->set_item_id( $order_info['item_id'] );
    $pack_body->set_item_count( $order_info['item_count'] );
    $pack_body->set_amount( $order_info['amount'] );
    $pack_body->set_real_amount( $order_info['real_amount'] );
    $pack_body->set_currency_kind( $order_info['currency_kind'] );
    $pack_body->set_gift_id( $order_info['gift_id'] );
    $pack_body->set_gift_count( $order_info['gift_count'] );
    $pack_body->set_consume_time( $order_info['consume_time'] );
    $pack_body->set_consume_ip( $order_info['consume_ip'] );
    $pack_body->set_consume_type( $order_info['consume_type'] );

    $ext_data = $order_info['platform_id'] . ";" . $order_info['user_charge_count'] . ";" .  $order_info['ext_data'];
    $pack_body->set_ext_data( $ext_data );

    //newly add 2014-09-04
    // 商品添加倍数,单位: %
    if ( isset($order_info['product_add_times']) ) {
        $product_add_times = intval($order_info['product_add_times']);
        $product_add_times = ($product_add_times < 100) ? 100 : $product_add_times;
        $pack_body->set_product_add_times( $product_add_times );
    }
    // 商品属性整数值: 含义需要跟策划沟通
    if ( isset($order_info['product_attr_int']) ) {
        $pack_body->set_product_attr_int( $order_info['product_attr_int'] );
    }
    // 商品属性字符串表达式: 含义需要跟策划沟通
    if ( isset($order_info['product_attr_string']) ) {
        $pack_body->set_product_attr_string( $order_info['product_attr_string'] );
    }
    // 赠送道具列表
    if ( isset($order_info['item_list']) ) {
        foreach ($order_info['item_list'] as $item_id => $item_count) {
            $gift_info_handler = $pack_body->add_gift_info();
            $gift_info_handler->set_gift_id($item_id);
            $gift_info_handler->set_gift_count($item_count);
        }
    }

    $pack_body_string = $pack_body->SerializeToString();

    $sign .= "&data=".$pack_body_string;
    $sign_md5 = md5($sign);
    $pack_header->set_sign($sign_md5);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "send head: " . $pack_header->toJson());
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "send body: " . $pack_body->toJson());

    $pack_header_string = $pack_header->SerializeToString();

    $pack_data = $pack_header_string . $pack_body_string;
    $pack_data = pack("N", (strlen($pack_data)+8)) . pack("N", (strlen($pack_header_string)+4)) . $pack_data;
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "pack head len: " . strlen($pack_header_string));
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "pack data len: " . strlen($pack_data));

    $result = socket_write($socket, $pack_data, strlen($pack_data));
    if ($result === false) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "send data to pay proxy failed");
        return SEND_DATA_ERROR;
    }

    if ($result != strlen($pack_data)) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "unable to send all data");
        return SEND_DATA_LENGTH_ERROR;
    }


    //recv from server
    $recved_string = socket_read($socket, 4096, PHP_BINARY_READ);

    if ($recved_string == false || strlen($recved_string) <= 0) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "received data from pay proxy server failed");
        return RECV_DATA_ERROR;
    }

    $length = strlen($recved_string) - 8;

    $pack_extend = unpack("Nmsg_len/Nhead_len/a{$length}head_body", $recved_string);
    $msg_body_len = $pack_extend['msg_len'] - $pack_extend['head_len'] - 4;
    $msg_head_len = $pack_extend['head_len'] - 4;

    //echo "pkg_len: {$length}\n";
    //echo "msg_body_len: {$msg_body_len}\n";
    //echo "msg_head_len: {$msg_head_len}\n";
    //echo "head_body_len: ". strlen($pack_extend['head_body']) . "\n";
    $pack_head_body = unpack("a{$msg_head_len}pack_head/a{$msg_body_len}pack_body", $pack_extend['head_body']);

    $pack_header = new pay_msg_head_t();

    $pack_header->ParseFromString($pack_head_body['pack_head']);

    if ($pack_header->msg_type_name() == 'IPlatformPayProto.overseas_boss_pay_msg_out_t') {
        $pack_body = new overseas_boss_pay_msg_out_t();
    } else {
        $pack_body = new ack_errcode_t();
    }

    $pack_body->ParseFromString($pack_head_body['pack_body']);

    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv]msg_head_len:".$msg_head_len);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv]msg_body_len:".$msg_body_len);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv]head json: " . $pack_header->toJson());
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv]body json: " . $pack_body->toJson());
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv]ret: " . $pack_header->ret());

    // MD5验证
    $sign = "game_id=".$pack_header->game_id()."&channel_id=".$pack_header->channel_id()."&pri_key=".$private_key;

    $sign .= "&data=".$pack_head_body['pack_body'];
    // 打印包体的十六进制
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv][sign]" . bin2hex($pack_head_body['pack_body']));
    $sign_md5 = md5($sign);
    if ($pack_header->sign() != $sign_md5) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv]md5 is not equal[" .
            $pack_header->sign()."!=".$sign_md5."]");
        // 返回自己定义的值
        return MD5_UNEQUAL_ERROR;
    }


    if($pack_header->ret() == 0) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv_success]" . $pack_header->ret());
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv] body json: " . $pack_body->toJson());
        $a_ret_order = array();
        $a_ret_order['user_id'] = $pack_body->user_id();
        $a_ret_order['order_id'] = $pack_body->order_id();

        $send_user = $order_info['user_id'];
        $recv_user = $pack_body->user_id();
        if ($send_user != $recv_user) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__,
                "[recv]user({$recv_user}) is not equal send user({$send_user})");
            return WRONG_RECV_MSG;
        }
        if ( $a_ret_order['order_id'] != $order_info['order_id'] ) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__,
                " [ERROR]: [recv]order_id({$a_ret_order['order_id']}) but [send] order_id({$order_info['order_id']})");
            return WRONG_RECV_MSG;
        }

        return 0;
    } else {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv_failed]" . $pack_header->ret());
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[recv] body json: " . $pack_body->toJson());
        return $pack_header->ret();
    }
}

?>
