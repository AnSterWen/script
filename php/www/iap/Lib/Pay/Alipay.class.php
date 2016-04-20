<?php
define('ALI_PUB_KEY', '/home/tony/www/iap/Key/alikey/alipay_public_key.pem');
define('RSA_PRI_KEY', '/home/tony/www/iap/Key/alikey/rsa_private_key.pem');
define('ALI_SELLER', 2088801213839164);
define('ALI_PARTNER', 2088801213839164);
define('ALI_SELLER_EMAIL', 'zhifubaowuxian@taomee.com');
define('ALI_SERVICE_1', 'alipay.wap.trade.create.direct');
define('ALI_SERVICE_2', 'alipay.wap.auth.authAndExecute');
define('ALI_SEC_ID', '0001');
define('ALI_VERSION', '2.0');
define('ALI_NOTIFY', 'http://'.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '127.0.0.1').'/'.basename(APP_PATH).'/aliwap_callback.php');
define('ALI_CALLBACK', 'http://'.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '127.0.0.1').'/'.basename(APP_PATH).'/aliwap_callback.php');



/*
 * * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 */
function create_linkstring($array) {
    $arg  = "";
    while (list ($key, $val) = each ($array)) {
        $arg.=$key."=".$val."&";
    }
    return substr($arg,0,-1);
}

/*
 * *通过节点路径返回字符串的某个节点值
 */
function getDataForXML($res_data,$node)
{
	$xml = simplexml_load_string($res_data);
	$result = $xml->xpath($node);

	while(list( , $node) = each($result)) 
	{
		return $node;
	}
}

/*
 * *对数组排序
 */
function arg_sort($array) {
    ksort($array);
    reset($array);
    return $array;
}

/*
 * *除去数组中的空值和签名参数
 */
function para_filter($parameter) {
    $para = array();
    while (list ($key, $val) = each ($parameter)) {
		if($key != "sign" && $key != "sign_type" && $val != "")
        	$para[$key] = $parameter[$key];
    }
    return $para;
}

/*
 * 解密用商户私钥
 * 解密前，需要用base64将内容还原成二进制
 * 将需要解密的内容，按128位拆开解密
 */
function decrypt($content) {

    $priKey = file_get_contents(RSA_PRI_KEY);
	$res = openssl_get_privatekey($priKey);
    $content = base64_decode($content);

    $result  = '';

    for($i = 0; $i < strlen($content)/128; $i++  ) {
        $data = substr($content, $i * 128, 128);
        openssl_private_decrypt($data, $decrypt, $res);
        $result .= $decrypt;
    }

    openssl_free_key($res);

	//返回明文
    return $result;
}

/*
 * 签名用商户私钥，必须是没有经过pkcs8转换的私钥
 * 最后的签名，需要用base64编码
 */
function sign($data) {
	$priKey = file_get_contents(RSA_PRI_KEY);
	$res = openssl_get_privatekey($priKey);
	openssl_sign($data, $sign, $res);
	openssl_free_key($res);
	$sign = base64_encode($sign);
	return $sign;
}

class Alipay {
	private $notify_data = null;
	/*
	 * RSA验签，使用支付宝公钥
	 */
	protected function verify($data, $sign)
	{
		$pubKey = file_get_contents(ALI_PUB_KEY);
		$res = openssl_get_publickey($pubKey);
		$result = (bool)openssl_verify($data, base64_decode($sign), $res);
		openssl_free_key($res);
		return $result;
	}

	private function parse_notify_data($data)
	{
		$xml = simplexml_load_string($data);
		foreach ($xml->children() as $k => $v) {
			$this->notify_data[$k] = (string)$v;
		}
		$this->notify_data['cmd'] = substr($this->notify_data['out_trade_no'], 0, 2).'14';
	}

	public function verify_wap_callback($get)
	{
		$data = para_filter($get);			// 去空
		$data = arg_sort($data);			// 排序
		$data = create_linkstring($data);	// 按"k=v"的形式用'&'连接
		return $this->verify($data, $get['sign']);
	}

	public function verify_wap_notify($post)
	{
		$notify_data = decrypt($post['notify_data']);
		$data = array(
			"service"		=> $post['service'],
			"v"				=> $post['v'],
			"sec_id"		=> $post['sec_id'],
			"notify_data"	=> $notify_data,
		);
		$data = create_linkstring($data);
		$verify = $this->verify($data, $post['sign']);
		if ($verify) {
			$this->parse_notify_data($notify_data);		
		}
		return $verify;
	}

	public function verify_app_notify($post)
	{
		$notify_data = $post['notify_data'];
		$verify = $this->verify('notify_data='.$notify_data, $post['sign']);
		if ($verify) {
			$this->parse_notify_data($notify_data);		
		}
		return $verify;
	}

	public function get_commit_data()
	{
		if ($this->notify_data && $this->notify_data['trade_status'] == 'TRADE_FINISHED')
			return $this->notify_data;
		return null;
	}
}

class AlipayService {
	var $parameter;			//需要签名的参数数组
	var $gateway_order = "http://wappaygw.alipay.com/service/rest.htm?";

	/*
	 * RSA验签，使用支付宝公钥
	 */
	protected function verify($data, $sign)
	{
		$pubKey = file_get_contents(ALI_PUB_KEY);
		$res = openssl_get_publickey($pubKey);
		$result = (bool)openssl_verify($data, base64_decode($sign), $res);
		openssl_free_key($res);
		return $result;
	}
	/*
	/**生成签名结果
	 */
	protected function build_mysign($sort_array) {
		$prestr = create_linkstring($sort_array);
		return sign($prestr);
	}

	function alipay_wap_trade_create_direct($product_name, $out_trade_no, $total_fee, $userid) {
        //构造要请求的参数数组，无需改动
        $param = array (
            "req_data"      => '<direct_trade_create_req><subject>'.$product_name.'</subject><out_trade_no>'.$out_trade_no.'</out_trade_no><total_fee>'.$total_fee."</total_fee><seller_account_name>".ALI_SELLER_EMAIL."</seller_account_name><notify_url>".ALI_NOTIFY."</notify_url><out_user>".$userid ."</out_user><merchant_url></merchant_url><cashier_code></cashier_code><call_back_url>".ALI_CALLBACK."</call_back_url></direct_trade_create_req>",
            "service"       => ALI_SERVICE_1,
            "sec_id"        => ALI_SEC_ID,
            "partner"       => ALI_PARTNER,
            "req_id"        => date("Ymdhms"),
            "format"        => 'xml',
            "v"             => ALI_VERSION 
        );

		
		//生成签名
		$sort_array = arg_sort($param);
		$mysign = $this->build_mysign($sort_array);

		//配置post请求数据，注意sign签名需要urlencode
		$req_data = create_linkstring($param) . '&sign=' . urlencode($mysign);
		$result = send_by_post($this->gateway_order, $req_data);

		//调用GetToken方法，并返回token
		return $this->getToken($result);
	}

	/**
	 * 调用alipay_Wap_Auth_AuthAndExecute接口
	 */
	function alipay_Wap_Auth_AuthAndExecute($token, $out_trade_no) {
		//构造要请求的参数数组，无需改动
        $param = array (
            "req_data"      => "<auth_and_execute_req><request_token>".$token."</request_token><out_trade_no>".$out_trade_no."</out_trade_no></auth_and_execute_req>",
            "service"       => ALI_SERVICE_2,
            "sec_id"        => ALI_SEC_ID,
            "partner"       => ALI_PARTNER,
            "call_back_url" => ALI_CALLBACK,
            "format"        => 'xml',
            "v"             => ALI_VERSION 
        );

		//排好序的参数数组
		$sort_array	= arg_sort($param);
		
		//生成签名
		$mysign = $this->build_mysign($sort_array);
		
		//生成跳转链接
		$RedirectUrl = $this->gateway_order . create_linkstring($param) . '&sign=' . urlencode($mysign);

		//跳转至该地址
		Header("Location: $RedirectUrl");
	}

	/**
	 * 返回token参数
	 * 参数 result 需要先urldecode
	 */
	function getToken($result)
	{
		$result	= urldecode($result);				
		$result = explode('&', $result);				
		
		$temp = array();
		$myArray = array();

		//循环构造key、value数组
		for ($i = 0; $i < count($result); $i++) {
			$temp = explode( '=' , $result[$i] , 2 );
			$myArray[$temp[0]] = $temp[1];
		}
		
		//需要先解密res_data
		$myArray['res_data'] = decrypt($myArray['res_data']);
		
		//获取返回的RSA签名
		$sign = $myArray['sign'];
		$myArray = para_filter($myArray);	
		$sort_array = arg_sort($myArray);	
		$prestr = create_linkstring($sort_array);	
		
		//判断签名是否正确
		if($this->verify($prestr, $sign)) {
			return getDataForXML($myArray['res_data'],'/direct_trade_create_res/request_token');	
		} else {
			return '签名不正确';
		}
	}
}
