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


function write_log($type, $file, $line, $func, $info)
{
    global $g_logger;

    if (!$g_logger instanceof Log) {
        return false;
    }

    $file = basename($file);
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


function get_client_ip ( $is_long = FALSE )
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

    $len = strlen($ip);
    $i = 0;
    for(; $i < $len; $i++) {
        if ($ip[$i] >= '1' && $ip[$i] <= '9') {
            break;
        }
    }
    if ($i > 0 && $i < $len) {
        $ip = substr($ip, $i);
    }

    if( $is_long )
    {
        $ip = ip2netlong($ip);
    }

    return $ip;
}

function get_channel_key($channel)
{
    global $g_allow_channels;

    if (!isset($g_allow_channels[$channel])) {
        return ACCOUNT_DEFAULT_KEY;
    } else {
        return $g_allow_channels[$channel];
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


function make_md5_sign($params)
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
    $channel = intval($params['channel']);
    $key = get_channel_key($channel);
    $str .= "key=$key";

    write_log("info", __FILE__, __FUNCTION__, __LINE__, "md5 string: {$str}");
    return md5($str);
}

if(!function_exists('get_url_contents')) {
    function get_url_contents($url, $data, $method="get", $data_type='var_export', $timeout=60)
    {
        /* 配置完整URL */
        $url = (false === strpos($url, 'http://') && false === strpos($url, 'https://'))
            ?  'http://' . $url : $url;

        $ch = curl_init();
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

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string
        $output = curl_exec($ch);
        curl_close($ch);

        if($data_type == 'var_export') {
            $result = '' ;
            @eval("\$result=$output;");
            return $result ;
        } elseif('json' == $data_type) {
            return json_decode($output, true) ;
        } else {
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
    $data['opt_type'] = 'query';
    $s_url = UID_CHANGE_URL;
    $a_result = get_url_contents($s_url, $data, 'get', 'json');

    return ($a_result['result'] == '0') ? intval($a_result['value']) : -1;
}

//////////////////////////////////参数检查部分//////////////////////////////////
function check_email($email)
{
    $i_match = preg_match("/^[a-z0-9][a-z0-9\._-]{2,}@([a-z0-9]+([a-z0-9-]*[a-z0-9])*\.)+[a-z]+$/", $email);
    return ($i_match == 0) ? false : true;
}

function check_user_name($user_name)
{
    $i_match = preg_match("/^\w+$/", $user_name);
    return ($i_match == 0) ? false : true;
}

function check_sign()
{
    $sign_type = $_REQUEST['sign_type'];
    $rcv_sign = $_REQUEST['sign'];

    switch ($sign_type) {
    case 'MD5':
        $cal_sign = make_md5_sign($_REQUEST);
        break;
    default:
        return false;
    }

    write_log("info", __FILE__, __FUNCTION__, __LINE__, "cal_sign({$cal_sign}) rcv_sign($rcv_sign)");
    return ($cal_sign == $rcv_sign);
}

?>
