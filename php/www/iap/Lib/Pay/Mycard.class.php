<?php

if(defined('VERSION') && VERSION == 'release') {
	define ('MYCARD_B2B', 'https://b2b.mycard520.com.tw/');
	define ('MYCARD_WEB', 'https://mycard520.com.tw/');
	define ('MYCARD_MEMBER', 'https://member.mycard520.com.tw/');
	define ('MYCARD_INGAME', 'https://redeem.mycard520.com/');
} else {
	define ('MYCARD_B2B', 'http://test.b2b.mycard520.com.tw/');
	define ('MYCARD_WEB', 'http://test.mycard520.com.tw/');
	define ('MYCARD_MEMBER', 'http://test.member.mycard520.com.tw/');
	define ('MYCARD_INGAME', 'http://test.mycard520.com.tw/MyCardIngame/');
}

define ('MYCARD_BILL_AUTH_URL', MYCARD_B2B.'MyCardBillingRESTSrv/MyCardBillingRESTSrv.svc/Auth/');
define ('MYCARD_BILL_BILL_URL', MYCARD_WEB.'MyCardBilling/');
define ('MYCARD_BILL_VERIFY_URL', MYCARD_B2B.'MyCardBillingRESTSrv/MyCardBillingRESTSrv.svc/TradeQuery?AuthCode=');
define ('MYCARD_BILL_COMMIT_URL', MYCARD_B2B.'MyCardBillingRESTSrv/MyCardBillingRESTSrv.svc/PaymentConfirm?');
define ('MYCARD_FACTORY_ID', 'MFD0000242');
define ('MYCARD_BILL_ITEM_URL', MYCARD_B2B.'MyCardBillingRESTSrv/MyCardBillingRESTSrv.svc/ProductsQuery/'.MYCARD_FACTORY_ID);

class MyCardBilling {
	public function getAuth($serviceId, $amount, $tradeSeq)
	{
		$result = array('result'=> 1200);
		$url = MYCARD_B2B.$this->auth_url."$serviceId/$tradeSeq/$amount";
		$in = send_by_get($url);
		if ($in) {
			$in = (string)simplexml_load_string($in);
			$result['auth'] = split("\|", $in);
			$result['result'] = 0;
		}

		return $result;
	}

	public function bill($authCode)
	{
		$url = MYCARD_BILL_BILL_URL."?AuthCode=$authCode";
		Header("Location: $url");
	}

	public function verify($authCode)
	{
		$url = MYCARD_BILL_VERIFY_URL.$authCode;
		$in = send_by_get($url);
		if ($in == false)
			return -1;

		$in = (string)simplexml_load_string($in);
		$in = split("\|", $in);
		return $in[0] == 1 ? 0 : 1;
	}

	public function commit($authCode, $userid)
	{
		$result = 1200;
		$url = MYCARD_BILL_COMMIT_URL."CPCustId=$userid&AuthCode=$authCode";
		$in = send_by_get($url);
		if ($in != false) {
			$in = (string)simplexml_load_string($in);
			$in = split("\|", $in);
			$result = ($in == 1) ? 0 : 1201;
		}
		return $result;
	}

	public function getItemlist()
	{

	}
}

class MyCardPoint {
	private $auth_url = '/MyCardPointPaymentServices/MyCardPpServices.asmx/MyCardMemberServiceAuth';
	private $user_url = '/MemberLoginService/';
	private $cost_url = '/MyCardPointPaymentServices/MyCardPpServices.asmx/MemberCostListRender';
	private $addpt_url = '/MyCardPointPaymentServices/MyCardPpServices.asmx/MemberAddListRender';
	private $factoryId = 'MFD0000242';
	private $factoryServiceId = 'MFSD000496';
	private $authCode = null;
	public function getAuth($tradeSeq, $point)
	{
		$returl = 'http://wlad.61.com/iap_test/b.php';
		$url = MYCARD_B2B.$this->auth_url.'?FactoryId='.$this->factoryId.'&FactoryServiceId='.$this->factoryServiceId;
		$url = $url.'&FactorySeq='.$tradeSeq.'&PointPayment='.$point.'&BonusPayment=0&FactoryReturnUrl='.urlencode($returl);
		$in = send_by_get($url);
		$xml = simplexml_load_string($in);
		$in = array();
		foreach ($xml->children() as $k => $v) {
			$in[$k] = (string)$v;
		}
		$this->authCode = $in['ReturnAuthCode'];
		return $in;
	}

	public function userAuth()
	{
		$url = MYCARD_MEMBER.$this->user_url.'?AuthCode='.$this->authCode;
		Header("Location: $url");
	}

	public function userCost($authCode, $otp)
	{
		$url = MYCARD_B2B.$this->cost_url."?AuthCode=$authCode&OneTimePassword=$otp";
		$in = send_by_get($url);
		$xml = simplexml_load_string($in);
		$retcode = 0;
		foreach ($xml->children() as $k => $v) {
			if ($k == 'ReturnMsgNo') {
				$retcode = (string)$v;
			}
		}
		return $retcode;
	}
}

define ('MYCARD_SHAKEY1', 'mycardtaomee');
define ('MYCARD_SHAKEY2', 'd1CA811d65');
define ('MYCARD_FACID', 'GFD00841');
define ('MYCARD_INGAME_AUTH_URL', MYCARD_B2B.'MyCardIngameService/Auth');
define ('MYCARD_INGAME_BILL_URL', MYCARD_B2B.'MyCardIngameService/Confirm');

// 使用Mycard进行充值
class MycardInGame {
	public function getAuth($facTradeSeq)
	{
		$sign = hash('sha256', MYCARD_SHAKEY1.MYCARD_FACID.$facTradeSeq.MYCARD_SHAKEY2);
		$url = MYCARD_INGAME_AUTH_URL."?facId=".MYCARD_FACID."&facTradeSeq=$facTradeSeq&hash=$sign";
		$in = send_by_get($url);
		if ($in) {
			return json_decode($in, true);
		}

		return array('ReturnMsgNo' => 0, 'ReturnMsg' => '网络异常');
	}

	public function confirm($cardId, $cardPwd, $authCode, $facMemId)
	{
		$sign = hash('sha256', MYCARD_SHAKEY1.MYCARD_FACID.$authCode.$facMemId.$cardId.$cardPwd.MYCARD_SHAKEY2);
		$url = MYCARD_INGAME_BILL_URL."?facId=".MYCARD_FACID."&authCode=$authCode&facMemId=$facMemId&cardId=$cardId&cardPwd=$cardPwd&hash=$sign";
		$in = send_by_get($url);
		if ($in) {
			$in = json_decode($in, true);
		} else {
			$in = array('ReturnMsgNo' => 0, 'ReturnMsg' => '网络异常');
		}
		return $in;
	}

	public function userAuth($authCode, $facMemId)
	{
		$sign = hash('sha256', MYCARD_SHAKEY1.$authCode.MYCARD_FACID.$facMemId.MYCARD_SHAKEY2);
		$url = MYCARD_INGAME."?authCode=$authCode&facId=".MYCARD_FACID."&facMemId=$facMemId&hash=$sign";
		return $url;
		Header("Location: $url");
	}

	public function checkHash($data, $sign)
	{
		$hashstr = MYCARD_SHAKEY1;
		foreach ($data as $v) {
			$hashstr .= $v;
		}
		$hashstr .= MYCARD_SHAKEY2;
		return $sign == hash('sha256', $hashstr);
	}
}

