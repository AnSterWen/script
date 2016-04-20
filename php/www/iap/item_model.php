<?php
/**
 * @package  mode
 * @author   Ian@taomee.com
 * @version  $ID
 *
 */
class itemModel
{
	static $ProductList = array(
		'demo'				=> '00',			// 测试
		'ahero'			=> '08',			// android hero
	);

	static $PidList = array(
		'00' => array(
			),	
		'08' => array(//ahero,待补全
		),	
	);

	static function send($data, $method = "get")
	{
		$str = '';
		foreach ($data as $key => $val) {
			$str .= $key.'='.(is_numeric($val) ? $val : urlencode($val)).'&';
		}		

	    $str = $str."sign=".md5( $str.'key=taomee' ) ;

		$result = $method == 'get' ? send_by_get(SERVICE_URL."?$str") : send_by_post(SERVICE_URL, $str) ;
		return json_decode($result, true);
	}

	static function yeepayCcid($ccname)
	{
		switch ($ccname) {
		case 'UNICOM-NET':
		case 'UNICOM':
			return 1;
		case 'JUNNET-NET':
		case 'JUNNET':
			return 2;
		case 'SZX-NET':
		case 'SZX':
			return 3;
		case '1000000-NET':
			return 4;
		case 'TELECOM-NET':
			return 5;
		case 'SNDACARD-NET':
		case 'SNDACARD':
			return 6;
		case 'QQCARD-NET':
		case 'QQCARD':
			return 7;
		case 'ZHENGTU-NET':
		case 'ZHENGTU':
			return 8;	
		default:
			$ccid = time();
			Log::write("Tmp Ccid $ccname = $ccid");
			return $ccid;
		}
	}

    /*
     * $OrderId 存取的某个游戏的数据库标识，命名成gameid或者dbid岂不是更好？
     *     参考 iap.wladmin.taomee.com/service/config/config.php
     *     '00' => 'demo',
     *     '01' => 'icar',
     *     '02' => 'imole',
     *     '03' => 'iskate',
     *     '04' => 'iseer',
     *     '05' => 'imole_android',
     *     '06' => 'douzhuan',
     *
     *  $fee 费用，单位：
     *
     *  $channel 渠道名称
     *
     *  $cseq 订单号？
     *
     *  $cuserid 用户id
     *
     *  $ccname 子渠道名称？
     *
     *  $extdata 额外数据
     */

	static function commitTrade($OrderId, $fee, $channel, $cseq, $cuserid, $ccname = '', $exdata = '')
	{
		if(isset($ccname) && !empty($ccname))
			self::httpNotify($OrderId, $fee, "$channel-$ccname");
		else
			self::httpNotify($OrderId, $fee, $channel);
		$cmd = substr($OrderId, 0, 2).'10';
		$cid = null;
		switch ($channel) {
		case 'ALIPAY':
			$cid = 0;
			break;
		case 'MMCARD':
			$cid = 0x10000;
			break;
		case 'MYCARD':
			$cid = 0x30000;
			break;
		case 'YEEPAY':
			$cid = 0x20000 + self::yeepayCcid($ccname);
			break;
		case 'XMPAY':
			$cid = 0x40000;
			break;
		case 'QIHOOPAY':
			$cid = 0x50000;
			break;
		case 'UCPAY':
			$cid = 0x60000;
			break;
		case 'GFANPAY':
			$cid = 0x70000;
			break;
		case 'DANGLE':
			$cid = 0x80000;
			break;
        case 'DANGLEV2':
            $cid = 0x80001;
            break;
		case 'TONGBU':
			$cid = 0x90000;
			break;
		}
		$data = array (
			'cmd' => $cmd,
			'out_trade_no'	=> $OrderId,
			'total_fee'		=> $fee,
			'channel'		=> $cid,
			'cseq'			=> $cseq,
			'cuserid'		=> $cuserid,
			'exdata'		=> $exdata,
			);
		return self::send($data);
	}

	static function send_notify($url, $data, $key)
	{
		if (is_array($data)) {
			$data = json_encode($data);
		}
		$sign = hash('sha256',  $data.$key);
		$ch = curl_init(); // Create curl resource	
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60) ;
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "notify_data=$data&sign=$sign");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string

		Log::write("$url : notify_data=$data&sign=$sign");

        curl_exec($ch);
        curl_close($ch);
	}

	static function httpNotify($OrderId, $amount, $channel)
	{
		$cmd = substr($OrderId, 0, 2);

		if (!isset(self::$PidList[$cmd]))
			return;

		$redis = new RedisServer("10.1.23.241", 6379);
		$tmpdata = $redis->get('IAP:EXDATA:'.$OrderId);
		if ($tmpdata === false) {
			$redis_bak = new RedisServer("10.1.23.241", 6380);
			$tmpdata = $redis_bak->get('IAP:EXDATA:'.$OrderId);
		}
		if ($tmpdata === false) {
			Log::write("Lost data: $OrderId");
		}
		$tmpdata = json_decode($tmpdata, true);
		$exdata = $tmpdata['exdata'];
		$uid = $tmpdata['userid'];
		$pname = $tmpdata['pname'];

		self::stat_log($uid, $OrderId, $amount, $channel, $pname);

		if (isset(self::$PidList[$cmd]['url'])) {
			$conf = self::$PidList[$cmd];

			$data = array();
			$data['uid'] = $uid;
			$data['amount'] = (string)$amount;
			$data['gameCode'] = $conf['name'];
			$data['result'] = 1;
			$data['tm_trade_no'] = $OrderId;
			$data['exdata'] = $exdata;
			$data['channel'] = $channel;
			self::send_notify($conf['url'], $data, $conf['shakey']);
		}
	}

	static function initTrade($pid, $productId, $count, $userid, $exdata, $channel)
	{
		Log::write("InitTrade:$pid:$productId:$count:$userid:$exdata:$channel");
		// 每个IP每小时最多进行1000次支付
		$redis = new RedisServer("10.1.23.241", 6379);
		$redis_bak = new RedisServer("10.1.23.241", 6380);

		// 将支付次数+1
		$key = get_client_ip().':'.date('YmdH');
		$count = $redis->hGet("IAP:TRADE:COUNT", $key);
		if ($count === false) {
			$count = $redis_bak->hGet("IAP:TRADE:COUNT", $key);
		}
		Log::write("IAP:TRADE:COUNT:$key:$count");
		if ($count >= 1000) {
			return false;
		}
		$redis->hIncrBy("IAP:TRADE:COUNT", $key, 1);
		$redis_bak->hIncrBy("IAP:TRADE:COUNT", $key, 1);

	    $data = array('cmd'=>$pid.'13', 'subject'=>$productId, 'userid'=>$userid, 'exdata' => $exdata);
		// 获取商品的信息 
		$result = itemModel::send($data);
        //echo json_encode($result);
		if (isset($result['result']) && $result['result'] == 0) {
			$OrderId = $result['data']['out_trade_no'];
			$data = array(
				'userid' => $userid,	
				'amount' => $result['data']['total_fee'],
				'exdata' => $exdata,
				'pname' => $result['data']['product_name'],
				);
			$data = json_encode($data);
			$redis->set("IAP:EXDATA:$OrderId", $data);
			$redis->Expire("IAP:EXDATA:$OrderId", 7*86400);
			$redis_bak->set("IAP:EXDATA:$OrderId", $data);
			$redis_bak->Expire("IAP:EXDATA:$OrderId", 7*86400);
            Log::write("succ " . json_encode($result));
			return $result['data'];
		} else {
            Log::write("failed initializing trade " . serialize($result));
			return false;
		}
	}

    public static function stat_log($userid, $orderid, $price, $channel, $productname)
    {
		$cmd = substr($orderid, 0, 2);
		Log::write("STAT LOG:$userid:$orderid:$price:$channel");
	}

}
?>
