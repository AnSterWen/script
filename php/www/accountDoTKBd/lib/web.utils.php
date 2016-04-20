<?php
/**
 * =======================================================================
 * @file 		web.utils.php
 * @brief 		provide some utility functions for web request processing
 *
 * @author 		landry	yuzy1985@gmail.com
 * @version 	2009/08/21
 * @copyright 	TaoMee, Inc. Shanghai China. All rights reserved.
 * =======================================================================
 */

/**
 * Output content to web client in specified format
 *
 * @param mixed $response , the output content
 * @param int   $result_format , the output format type
 */
function process_response($response, $result_format)
{
	$output = "";
    switch ($result_format)
    {
    case "array":
		$output = var_export($response,TRUE);
        break;
    case "json":
        $output = json_encode($response);
        break;
    default:
		$output ="Unsupported \$result_format value: ".$result_format;
        break;
    }

	echo $output;
}

/**
 *
 * @return bool TRUE if client's ip is allowed, FALSE if not
 */
function check_ip($allowed_ips, $checked_ip)
{
	foreach($allowed_ips as $ip)
	{
		if ($checked_ip == $ip)
		{
			return TRUE;
		}
	}

	return FALSE;
}

/**
 * Enter description here...
 *
 * @param string $game    mole,seer,...
 * @param int    $result  0:success, -1:failure, 1:verify sign failure,
 * @param int    $mb_usage
 * @param int    $user_id
 * @param int    $channel_id
 * @param int    $mb_num  $mb_usage为1时充值米币数,单位分
 */
function redirect_to($result, $mb_usage, $user_id, $channel_id, $mb_num=0)
{
	$url = "";

	//todo:select url according to $mb_usage value
	if($result == 0)
	{
		//success
	    $url = MOLE_PAY_SUCCESS_URL ;
	}
	else
	{
	    $url = MOLE_PAY_FAILURE_URL ;
	}

	$pay_type = get_pay_type($channel_id);
	if (!$pay_type)
	{
		$pay_type = "";
	}

	$url .= "&userid=$user_id&mb_num=$mb_num&mb_usage=$mb_usage&status_code=0&pay_type=$pay_type";

	$str_msg = "<script language=javascript>\n";
	$str_msg.= "window.location.href='$url';\n";
	$str_msg.= "</script>";

	echo($str_msg);
}

/**
 * http GET 获取数据
 * $url 指定URL完整路径地址
 * @param $input_charset 编码格式。默认值：空值
 * @param $time_out 超时时间。默认值：60
 * return 远程输出的数据
 */
function get_http_response($url, $input_charset = '', $time_out = "60")
{
	$urlarr     = parse_url($url);
	$errno      = "";
	$errstr     = "";
	$transports = "";
	$responseText = "";
	if($urlarr["scheme"] == "https")
    {
		$transports = "ssl://";
        if (empty($urlarr['port']))
        {
		    $urlarr["port"] = "443";
        }
	}
    else
    {
		$transports = "tcp://";
        if (empty($urlarr['port']))
        {
		    $urlarr["port"] = "80";
        }
	}

    if (empty($urlarr['path']))
    {
        $urlarr['path'] = '/';
    }

	$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
	if(!$fp)
    {
        return false;
	}
    else
    {
        $content = '';
        if (empty($urlarr['query'])) {
            $content .= "GET {$urlarr['path']} HTTP/1.1\r\n";
        } else {
            $content .= "GET {$urlarr['path']}?{$urlarr['query']} HTTP/1.1\r\n";
        }
        $content .= "Host: {$urlarr['host']}\r\n";
        $content .= "Content-type: application/x-www-form-urlencoded\r\n";
        $content .= "Content-length: 0\r\n";
        $content .= "Connection: close\r\n";
        $content .= "\r\n\r\n";

        fputs($fp, $content);

		while(!feof($fp))
        {
			$responseText .= @fgets($fp, 1024);
		}
		fclose($fp);
		$responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");

		return $responseText;
	}
}

?>
