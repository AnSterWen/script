<?php
/**
 * 获取请求参数
 * @param string $_name
 * @param string $_type auto, get, post
 * @return object
 */
function req_get_param($_name, $_type = 'auto')
{
    switch ($_type)
    {
    	case 'get':
            return isset($_GET[$_name]) ? $_GET[$_name] : NULL;
            break;
    	case 'post':
            return isset($_POST[$_name]) ? $_POST[$_name] : NULL;
            break;
    	default:
            return isset($_REQUEST[$_name]) ? $_REQUEST[$_name] : NULL;
    }
}

/**
 * 验证访问者IP是否有效
 * @global VALID_IP
 * @return boolean
 */
function is_valid_client_ip() 
{
    if(!defined('VALID_IP') || VALID_IP == '')
    {
        return true;
    }
    else
    {    
        $ip = get_client_ip();
		$ip = str_ireplace('::ffff:','',$ip);
        if(preg_match('/^' . VALID_IP . '$/', $ip))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

/**
 * 获取客户端IP地址
 * @return string $ip
 */
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

/**
 * 验证请求签名是否有效
 * @return boolean
 */
function is_valid_request()
{
	if (!defined('DIGITAL_SIGNATURE')
	    || !defined('TOKEN_NAME')
	    || !defined('TOKEN_VALUE'))
	{
		return true;
	}
	else
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET')
		{
            $query_string = $_SERVER['QUERY_STRING'];
		}
		else
		{
			$query_string = file_get_contents("http://input");
		}
	    if (preg_match('/^([^# ]+)&' . DIGITAL_SIGNATURE . '=([\w]+)$/', 
            $query_string, $rs))
        {
            $data = $rs[1];
            $sign = $rs[2];
            if (md5($data . '&' . TOKEN_NAME . '=' . TOKEN_VALUE) == $sign)
            {
                return true;
            }
            else
            {
                 return false;
            }
        }
        else
        {
            return false;
        }
	}
}

/**
 * 创建目录
 * @param string $dir
 * @param int $mode
 * @return bool
 */
if (! function_exists('mk_dir')) {

    function mk_dir($dir, $mode = 0755)
    {
        if (is_dir($dir) || @mkdir($dir, $mode))
            return true;
        if (! mk_dir(dirname($dir), $mode))
            return false;
        return @mkdir($dir, $mode);
    }
}
/**
 * 写日志函数
 * @access public
 * @param string $_msg
 */
function log_write($_msg)
{
    LOG::write($_msg);
}
