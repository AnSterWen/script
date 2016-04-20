<?php
$logger = false;
require_once (dirname(__FILE__) . "/statlogger.php");



function check_string($string)
{
    return (isset($string) && strlen($string) > 0);
}


function ip2netlong($m_ip)
{
    $i_ip = is_string($m_ip) ? ip2long($m_ip) : $m_ip ;
    $a_ip = unpack('Nip', pack('L', $i_ip)) ;
    return $a_ip['ip'] ;
}

/* 获取格林尼治时间戳 */
function gmtime()
{
    $default_timezone = date_default_timezone_get();
    date_default_timezone_set('Europe/London');
    $time = time();
    date_default_timezone_set($default_timezone);

    return $time;
}

/**
 * 记录日志
 * @author Henry <henry@taomee.com>
 * @param int $type
 * @param array $data_array
 */
function msglog($log_file, $type, $data_array)
{
    $timestamp = time();

    @touch($log_file);

    if(count($data_array) <= 0)
    {
        return false;
    }
    $len = 24;
    $hlen = 24;
    $flag0 = 0;
    $flag = 0;
    $saddr = 0;
    $seqno = 0;

    $packed_body = "";
    foreach($data_array as $data_row)
    {
        $packed_body .= pack("L",$data_row);
        $len += 4;
    }

    $packed_header = pack("SCCL5",$len,$hlen,$flag0,$flag,$saddr,$seqno,$type,$timestamp);
    $packed_data = $packed_header . $packed_body;

    //write to stat log file
    umask(0000);
    $log_file_fd = fopen($log_file,"ab");
    if(!$log_file_fd)
    {
        return false;
    }
    //chmod($log_file, 0777);
    if(!fwrite($log_file_fd,$packed_data))
    {
        return false;
    }

    fclose($log_file_fd);

    return true;
}

/**
 *检查邮箱是否正确
 *
 */
function checkEmail($s_email)
{
    $i_match = !preg_match("/^[a-z0-9][a-z0-9\._-]{2,}@([a-z0-9]+([a-z0-9-]*[a-z0-9])*\.)+[a-z]+$/", $s_email);
    if($i_match)
    {
        return array("result" => -1 ,'msg'=>'Email格式不正确');
    }
    else
    {
        return array("result"=>0);
    }
}

function write_log($type, $file, $line, $func, $info)
{
    global $logger;

    if (!$logger instanceof Log) {
        return false;
    }

    $file = basename($file);
    $msg = "[$file][$func][$line] $info";

    switch ($type) {
    case "error":
        $logger->error($msg);
        break;
    case "debug":
        $logger->debug($msg);
        break;
    case "info":
        $logger->info($msg);
        break;
    case "warn":
        $logger->warn($msg);
        break;

    default:
        $logger->trace($msg);
        break;
    }

    return true;
}

function check_sign()
{
    $sign_type = $_REQUEST['sign_type'];
    $sign = $_REQUEST['sign'];

    switch ($sign_type) {
    case 'MD5':
        $my_sign = make_md5_sign($_REQUEST);
        break;
    default:
        return false;
    }

    if ($my_sign != $sign) {
        return false;
    } else {
        return true;
    }
}

function getClientIp ( $is_long = FALSE )
{
    if (isset($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]))
    {
        $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]))
    {
        $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
    }
    elseif (isset($HTTP_SERVER_VARS["REMOTE_ADDR"]))
    {
        $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
    }
    elseif (getenv("HTTP_X_FORWARDED_FOR"))
    {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    }
    elseif (getenv("HTTP_CLIENT_IP"))
    {
        $ip = getenv("HTTP_CLIENT_IP");
    }
    elseif (getenv("REMOTE_ADDR"))
    {
        $ip = getenv("REMOTE_ADDR");
    }
    else
    {
        $ip = "Unknown";
    }

    if( $is_long )
    {
        $ip = ip2netlong($ip);
    }

    return $ip;
}

function get_channel_key($channel)
{
    global $allow_channels;

    if (!isset($allow_channels[$channel])) {
        return '';
    } else {
        return $allow_channels[$channel];
    }
}

function get_internal_verifyid($channel)
{
    global $internal_channels;

    if (!isset($internal_channels[$channel])) {
        return '';
    } else {
        return $internal_channels[$channel]['verifyid'];
    }
}

function get_internal_key($channel)
{
    global $internal_channels;

    if (!isset($internal_channels[$channel])) {
        return '';
    } else {
        return $internal_channels[$channel]['key'];
    }
}


function make_md5_sign($params, $pri_key = '')
{
    /* 过滤掉参数sign和sign_type */
    $arg = array();

    foreach ($params as $key => $val) {

        if ($key == 'sign' || $key == 'sign_type' || $key == 'PHPSESSID' || $key == '__utma' || $key == '__utmz') {
            continue;
        }

        $arg[$key] = $val;
    }

    /* 参数按ASCII排序 */
    ksort($arg);

    $str = '';

    /* 将参数用&连起来 */
    foreach ($arg as $key => $val) {
        $str .= $key . '=' . $val . '&';
    }

    /* 最后加上key参数 */
    if ( empty($pri_key) ) {
        $channel = intval($params['channel']);
        $key = get_channel_key($channel);
    }
    else {
        $key = $pri_key;
    }
    $str .= "key=$key";

    return md5($str);
}

if(!function_exists('get_url_contents')) {
    function get_url_contents($url, $data, $method="get", $data_type='var_export', $timeout=60)
    {
        /* 配置完整URL */
        $url = (false === strpos($url, 'http://') && false === strpos($url, 'https://'))
            ?  'http://' . $url : $url;

        $ch = curl_init();

        //https处理
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        if('get' == strtolower($method))
        {
            $url = is_array($data) ? $url.'?'.http_build_query($data) : $url . '?' .$data ;
            curl_setopt($ch, CURLOPT_URL, $url);
        }
        else
        {
            if (is_array($data)) {
                $data = http_build_query($data);
            } else {
                $data = $data;
                $header[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            }

            // $data = is_array($data) ? http_build_query($data) : $data ;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string
        $output = curl_exec($ch);
        curl_close($ch);

        switch ( strtolower($data_type) ) {
        case 'var_export':
            $result = '' ;
            @eval("\$result=$output;");
            return $result ;
        case 'json':
            return json_decode($output, true) ;
        case 'xml':
            return simplexml_load_string($output) ;
        default:
            return $output ;
        }
    }
}

function uid_change_to_int($channel_id, $key)
{
    $data = array(
        'channel_id' => $channel_id,
        'key' => $key,
        'opt_type' => 'query'
    );
    ksort($data);
    $sign = UID_CHANGE_SIGN;
    $signature = md5(http_build_query($data) . "&sign=" . $sign);

    $data['sign'] = $signature;
    $s_url = UID_CHANGE_URL;
    $a_result = get_url_contents($s_url, $data, 'get', 'json');

    return ($a_result['result'] == '0') ? intval($a_result['value']) : -1;
}


// 落支付数据统计项
function platform_stat_pay_log($order_detail, $excharge_rate = 1.0)
{
    $user_id = intval($order_detail['user_id']);
    global $g_exclude_users;
    if (in_array($user_id, $g_exclude_users)) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "Need not stat: user({$user_id}) in g_exclude_users");
        return true;
    }
    $pay_amount = $order_detail['amount'] * $excharge_rate;
    $stat_game_id = $order_detail['game_id'];
    $login_channel_id = $order_detail['platform_id'];
    if (isset($order_detail['user_id_prefix']) && $order_detail['user_id_prefix']) {
        $channel_user = $order_detail['user_id_prefix'] . '_' . $order_detail['user_id'];
    } else {
        $channel_user = $login_channel_id . '_' . $order_detail['user_id'];
    }
    $server_id = $order_detail['server_id'];

    $is_vip = 0;
    $currency = 1;
    $zone_id = -1;
    $pay_reason = "_buyitem_";
    if ( empty($order_detail['product_id']) ) {
        $product_id = $order_detail['item_id'];
        $product_count = $order_detail['item_count'];
    }
    else {
        $product_id = $order_detail['product_id'];
        $product_count = 1;
    }
    $pay_channel = $order_detail['pay_channel'];
    stat_pay($stat_game_id, $login_channel_id, $zone_id, $server_id, $channel_user,
        $is_vip, $pay_amount, $currency, $pay_reason, $product_id, $product_count, $pay_channel);
}




/////////////////////////////////////////商品系统接口/////////////////////////////////////////
// 获取订单详细信息
function get_inner_order_info($order_id, &$order_info, &$product_info)
{
    global $g_get_order_params;
    $pri_key = $g_get_order_params['pri_key'];
    $url = $g_get_order_params['get_url'];
    $cmd = substr($order_id, 0, 2);
    $sign = md5("cmd={$cmd}16&order_id={$order_id}&key={$pri_key}");
    $full_url = "{$url}cmd={$cmd}16&order_id={$order_id}&sign={$sign}";
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "get_order_info_url: {$full_url}");

    // 从公共平台组拉取用户的信息
    $get_order_info = file_get_contents($full_url);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "get_order_info: {$get_order_info}");
    $get_order_info_data = json_decode($get_order_info, true);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, var_export($get_order_info_data, TRUE));

    // 假设拉取的数据有问题
    if (!isset($get_order_info_data['result']) || $get_order_info_data['result'] != 0) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "get order({$order_id}) info result: {$get_order_info_data['result']}");
        return false;
    }

    $order_info_origin = json_decode($get_order_info_data['data']['extra_data'], true);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, var_export($get_order_info_data['data']['extra_data'], TRUE));
    write_log("info", __FILE__, __FUNCTION__, __LINE__, var_export($order_info_origin, TRUE));


    global $g_extend_field;
    $order_info = array();
    foreach ($g_extend_field as $detail_name => $abb_name) {
        if (isset($order_info_origin[$abb_name])) {
            $order_info[$detail_name] = $order_info_origin[$abb_name];
        } else {
            $order_info[$detail_name] = 0;
        }
    }
    $order_info['third_product_id'] = $get_order_info_data['data']['product_third_name'];
    $add_times = intval($get_order_info_data['data']['product_add_times']);

    $order_info['product_add_times'] = ($add_times >= 100) ? $add_times : 100;
    $order_info['product_attr_int'] = $get_order_info_data['data']['product_attr_int'];
    $order_info['product_attr_string'] = $get_order_info_data['data']['product_attr_string'];


    $product_info_origin = json_decode($get_order_info_data['data']['product_items'], true);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, var_export($product_info_origin, TRUE));
    $product_info = array();
    $product_info['product_id'] = $get_order_info_data['data']['product_id'];
    foreach ($product_info_origin as $item_id => $item_info) {
        $item_id = ($item_id == 1) ? 416002 : $item_id;//将1映射成砖石ID
        $product_info['item_id'] = $item_id;
        $product_info['item_count'] = empty($item_info['base']) ? 0 : $item_info['base'];
        $product_info['gift_id'] = $item_id;
        $product_info['gift_count'] = empty($item_info['gift']) ? 0 : $item_info['gift'];
        $product_info['item_list'] = $item_info['item_list'];//'id -> count' list
        break;
    }

    return true;
}

// 通过第三方商品名称获取商品详情
function get_product_detail_by_third_name($db_suffix, $third_name)
{
    global $g_get_order_params;
    $pri_key = $g_get_order_params['pri_key'];
    $url = $g_get_order_params['get_url'];

    $sign = md5("cmd={$db_suffix}19&third_name={$third_name}&key={$pri_key}");
    $data = array(
        'cmd' => $db_suffix . "19",
        'third_name' => $third_name,
        'sign' => $sign,
        );
    $return_array = get_url_contents($url, $data, 'post', 'json');
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "return_array: " . print_r($return_array, true));

    // 假设拉取的数据有问题
    if ($return_array['result'] != 0) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__,
            "ERROR: get third_name({$third_name}) info result: {$return_array['result']}");
        return false;
    }
    //返回data包含的字段如下:
    //$data['product_id']
    //$data['product_name']
    //$data['product_price']
    //$data['product_third_price']
    //$data['product_items']
    //$data['product_add_times']
    //$data['product_attr_int']
    //$data['product_attr_string']

    $product_info = array();
    $item_array = json_decode($return_array['data']['product_items'], true);
    foreach ($item_array as $item_id => $item_info) {
        $item_id = ($item_id == 1) ? 416002 : $item_id;//将1映射成砖石ID
        $product_info['item_id'] = $item_id;
        $product_info['item_count'] = empty($item_info['base']) ? 0 : $item_info['base'];
        $product_info['gift_id'] = $item_id;
        $product_info['gift_count'] = empty($item_info['gift']) ? 0 : $item_info['gift'];
        $product_info['item_list'] = $item_info['item_list'];
        break;
    }

    $product_info['product_id'] = $return_array['data']['product_id'];
    $product_info['product_name'] = $return_array['data']['product_name'];
    $product_info['product_price'] = $return_array['data']['product_price'];
    $product_info['product_third_price'] = $return_array['data']['product_third_price'];

    $product_info['product_add_times'] = $return_array['data']['product_add_times'];
    $product_info['product_attr_int'] = $return_array['data']['product_attr_int'];
    $product_info['product_attr_string'] = $return_array['data']['product_attr_string'];

    return $product_info;
}

function ajax($response)
{
    echo json_encode($response);
    exit;
}
?>
