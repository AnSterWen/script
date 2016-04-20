<?php
$g_logger = false;

//function hex2bin($hex_str)
//{
//    $len = strlen($hex_str);
//
//    if ($len % 2 != 0) {
//        return '';
//    }
//
//    $bin_str = '';
//
//    for ($i = 0; $i + 1 < $len; $i += 2) {
//        $high = hexdec($hex_str[$i]);
//        $low = hexdec($hex_str[$i + 1]);
//
//        $bin_str .= pack('C', $high * 16 + $low);
//    }
//
//    return $bin_str;
//}

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
    global $g_logger;

    if (!$g_logger instanceof Logger) {
        return false;
    }

    $msg = "[$file][$func][$line] $info";

    switch ($type) {
        case "error":
            $g_logger->error($msg);
            break;

        case "debug":
            $g_logger->debug($msg);
            break;

        case "info":
            $g_logger->info($msg);
            break;

        case "warn":
            $g_logger->warn($msg);
            break;

        default:
            $g_logger->trace($msg);
            break;
    }

    return true;
}

function get_game_key($game)
{
    global $g_allow_channels;

    if (!isset($g_allow_channels[$game])) {
        return ACCOUNT_DEFAULT_KEY;
    } else {
        return $g_allow_channels[$channel];
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
        $game = $params['game'];
        $key = get_game_key($game);
    }
    else {
        $key = $pri_key;
    }

    $str .= "key=$key";
    return md5($str);
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
            break;
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



if(!function_exists('get_url_contents')) {
    function get_url_contents($url, $data, $method="get", $data_type='var_export', $timeout=60)
    {
        write_log("debug", __FILE__, __FUNCTION__, __LINE__,"get_url_contents");
        /* 配置完整URL */
        $url = (false === strpos($url, 'http://') && false === strpos($url, 'https://'))
            ?  'http://' . $url : $url;


        write_log("debug", __FILE__, __FUNCTION__, __LINE__,"0000");
        $ch = curl_init();
        write_log("debug", __FILE__, __FUNCTION__, __LINE__,"1111");
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
            $data = is_array($data) ? http_build_query($data) : $data ;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        write_log("debug", __FILE__, __FUNCTION__, __LINE__,"3get_url_contents");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string

        write_log("debug", __FILE__, __FUNCTION__, __LINE__,json_encode($ch));
        $output = curl_exec($ch);
        write_log("debug", __FILE__, __FUNCTION__, __LINE__,json_encode($output));
        curl_close($ch);

        if($data_type == 'var_export') {
            $result = '' ;
            @eval("\$result=$output;");
            return $result ;
        }
        elseif('json' == $data_type)
        {
            return json_decode($output, true) ;
        }
        elseif('single_quote_json' == $data_type)
        {
            $output = str_replace("'", "\"", $output);
            return json_decode($output, true) ;
        }
        else {
            return $output ;
        }
    }
}

function uid_change_to_int($channel_id, $key)
{
    $data = array(
        'channel_id' => $channel_id,
        'key' => $key,
    );
    ksort($data);
    $sign = UID_CHANGE_SIGN;
    $signature = md5(http_build_query($data) . "&sign=" . $sign);

    $data['sign'] = $signature;
    $s_url = UID_CHANGE_URL;
    $a_result = get_url_contents($s_url, $data, 'get', 'json');

    return ($a_result['result'] == '0') ? intval($a_result['value']) : -1;
}

function safe_uid_change_to_int($channel_id, $key)
{
    $data = array(
        'proto_id' => 10001,
        'channel_id' => $channel_id,
        'user_key' => $key,
        'current_time' => time()
    );

    ksort($data);
    $data['sign'] = md5(http_build_query($data) . "&key=" . UID_CHANGE_SIGN);

    // 加密
    require_once dirname(__FILE__) . '/security.class.php';
    $encrypted = array();
    foreach ($data as $k => $v) {
        $encrypted[$k] = Security::encrypt($v, UID_CHANGE_KEY);
    }

    $res_str = get_url_contents(UID_CHANGE_URL, $encrypted, 'get', 'text');
    $res_arr = json_decode(Security::decrypt($res_str, UID_CHANGE_KEY), true);
    if (is_array($res_arr) && isset($res_arr['result']) && $res_arr['result'] === 0
            && isset($res_arr['user_id']) && $res_arr['user_id']) {
        return (int)$res_arr['user_id'];
    } else {
        return -1;
    }
}

function igg_game_log($data)
{
    ksort($data);
    $sign_string = http_build_query($data) . "&sign=" . IGG_GAMELOG_KEY;
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "sign_string: {$sign_string}");
    $signature = md5($sign_string);

    $data['sign'] = $signature;
    $s_url = IGG_GAMELOG_URL;
    $result = get_url_contents($s_url, $data, 'get', 'string');

    return ( 0 == strcasecmp($result, 'SUCCESS') );
}

function inner_check_sign($check_array, $pri_key)
{
    $rcv_sign = $check_array['sign'];
    unset($check_array['sign']);
    ksort($check_array);
    $sign_string = "";
    foreach ($check_array as $key => $val) {
        $sign_string .= "{$key}={$val}&";
    }
    $sign_string .= "key={$pri_key}";
    $cal_sign = md5($sign_string);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "sign_string: {$sign_string}");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "rcv_sign({$rcv_sign}) cal_sign({$cal_sign})");

    return ($rcv_sign == $cal_sign);
}
