<?php
/**
 * taomee 公共函数库
 *
 * @category  Taomee
 * @package   Common
 * @author    Rooney<Rooney@taomee.com>
 */

/**
 * 自定义错误处理
 *
 * @access public
 *
 * @param int $errno 错误类型
 * @param string $errstr 错误信息
 * @param string $errfile 错误文件
 * @param int $errline 错误行数
 *
 * @return void
 */
function taomee_error($errno, $errstr, $errfile, $errline)
{
    switch($errno)
    {
        case E_ERROR:
        case E_USER_ERROR:
            $e_str = "ERROR: [$errno] $errstr " . basename($errfile) . " 第  $errline 行.\r\n";
            Log::write($e_str, 0);
            exit();
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $e_str = "WARNING: [$errno] $errstr " . basename($errfile) . " 第  $errline 行.\r\n";
            break;
        case E_STRICT:
        case E_NOTICE:
        case E_USER_NOTICE:
        default:
            if(!defined('VERSION') || VERSION != 'release') {
                $e_str = "NOTICE: [$errno] $errstr " . basename($errfile) . " 第  $errline 行.\r\n";
            }
            else {
                $e_str = '' ;
            }
            //Log::record($errorStr);
            break;
    }

    if($e_str) {
        Log::write($e_str, 0);
    }
}

function get_client_ip()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return ($ip);
}

function send_by_post($url, $data, $timeout=30)
{
	Log::write($url);
	$ch = curl_init(); // Create curl resource          
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, 0);						//过滤HTTP头
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	$ret = curl_exec($ch);
	$err = curl_error($ch);
	curl_close($ch);
	if ($err) {
		Log::write($url.':'.$err);
	}
	return $err == false ? $ret : false;
}

function send_by_get($url, $timeout=30)
{
	Log::write($url);
	$ch = curl_init(); // Create curl resource          
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, 0);						//过滤HTTP头

	$ret = curl_exec($ch);
	$err = curl_error($ch);
	curl_close($ch);
	if ($err) {
		Log::write($url.':'.$err);
	}
	return $err == false ? $ret : false;
}

function array_to_kvstr($data, $isUrlEncode = true)
{
	ksort($data, SORT_STRING);
	reset($data);
	$o = '';
	foreach ($data as $key => $val) {
		if ($isUrlEncode)
			$o.="$key=".urlencode($val)."&";
		else
			$o.="$key=".$val."&";
	}
	return substr($o,0,-1);
}

function HmacMd5($data,$key, $code = 'UTF-8')
{
	# RFC 2104 HMAC implementation for php.
	# Creates an md5 HMAC.                 
	# Eliminates the need to install mhash to compute a HMAC
	# Hacked by Lance Rushing(NOTE: Hacked means written)

	#需要配置环境支持iconv，否则中文参数不能正常处理

	if ($code != 'UTF-8') {
		$key = iconv($code, "UTF-8", $key);
		$data = iconv($code, "UTF-8", $data);
	}

	$b = 64; # byte length for md5         
	if (strlen($key) > $b) {
	$key = pack("H*",md5($key));
	}
	$key = str_pad($key, $b, chr(0x00));
	$ipad = str_pad('', $b, chr(0x36));
	$opad = str_pad('', $b, chr(0x5c));
	$k_ipad = $key ^ $ipad ;
	$k_opad = $key ^ $opad;

	return md5($k_opad . pack("H*",md5($k_ipad . $data)));
}

function make_md5_sign($params, $pri_key)
{
    /* 过滤掉参数sign和sign_type */
    $arg = array();

    foreach ($params as $key => $val) {

        if ($key == 'sign' || trim($val) == "") {
            continue;
        }    

        $arg[$key] = $val;
    }    

    /* 参数按ASCII排序 */
    ksort($arg);

    $str = '';

    /* 将参数用&连起来 */
    foreach ($arg as $key => $val) {
        //$key = iconv(mb_detect_encoding($key), "UTF-8", $key);
        //$val = iconv(mb_detect_encoding($val), "UTF-8", $val);
        //$key = mb_convert_encoding($key, "UTF-8");
        //$val = mb_convert_encoding($val, "UTF-8");
        $str .= $key . '=' . $val . '&'; 
    }
    /* 最后加上key参数 */
    $str = substr($str, 0, -1) . $pri_key;
	//Log::write($str);

    return md5($str);
}

function make_c01_md5_sign($params, $pri_key)
{
    /* 过滤掉参数sign和sign_type */
    $arg = array();

    foreach ($params as $key => $val) {
        if ($key == 'sign' || $key == 'key') {
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
    $str .= "key=" . $pri_key;
	Log::write($str);

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
        }
        elseif('json' == $data_type)
        {
            return json_decode($output, true);
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


?>
