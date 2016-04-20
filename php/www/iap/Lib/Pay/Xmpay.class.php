<?php
class Xmpay {
	private static function hmacsha1($data, $key)
	{
      $blocksize=64;
      $hashfunc='sha1';
      if (strlen($key)>$blocksize)
          $key=pack('H*', $hashfunc($key));
      $key=str_pad($key,$blocksize,chr(0x00));
      $ipad=str_repeat(chr(0x36),$blocksize);
      $opad=str_repeat(chr(0x5c),$blocksize);
      $hmac = pack('H*',$hashfunc(($key^$opad).pack('H*',$hashfunc(($key^$ipad).$data))));
      return bin2hex($hmac);
	}

	public static function check($appid, $appkey, $data)
	{
		$sign = $data['signature'];
		unset($data['signature']);

		$hmac = array_to_kvstr($data, false);
		$hmac = self::hmacsha1($hmac, $appkey);

		return  $sign == $hmac;
	}

	public static function checkRemote($appId, $orderId, $uid, $appkey)
	{
		$url = "http://mis.migc.xiaomi.com/api/biz/service/queryOrder.do";
		$data = "appId=$appId&cpOrderId=$orderId&uid=$uid";
		$sign = self::hmacsha1($data, $appkey);
		$data .= "&signature=$sign";
		$data = send_by_post($url, $data);
		return json_decode($data, true);
	}
}
