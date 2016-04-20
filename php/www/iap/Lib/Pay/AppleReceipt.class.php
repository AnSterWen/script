<?php
require_once("wdb_pdo.class.php");
require_once("stat_log.php");

class CAppleReceipt {
	static $bidMap = array(
		'com.qidong.iapmodule'		=> '00',
		'com.taomee.molekartevo'	=> '01',
		'com.taomee.MoleWorld'		=> '02',
		'com.taomee.iskate'			=> '03',
		'com.taomee.seer'			=> '04',	
        'com.taomee.iseer2'         => '05',
	);

	static $priceMap = array(
		'com.taomee.MoleWorld' => array(
			"com.taomee.MoleWorld.sale0" => 99,
			"com.taomee.MoleWorld.sale1" => 499,
			"com.taomee.MoleWorld.sale2" => 999,
			"com.taomee.MoleWorld.sale3" => 1499,
			"com.taomee.MoleWorld.sale4" => 2499,
			"com.taomee.MoleWorld.sale5" => 4999,
			"com.taomee.MoleWorld.sale6" => 9999,
		),
		'com.taomee.seer' => array(
			"com.taomee.iseer.vipgold1" => 99,
			"com.taomee.iseer.vipgold2" => 199,
			"com.taomee.iseer.vipgold3" => 499,
			"com.taomee.iseer.vipgold4" => 999,
			"com.taomee.iseer.vipgold5" => 1999,
			"com.taomee.iseer.vipgold6" => 4999,
		),
		'com.taomee.molekartevo' => array(
			"com.taomee.molekartevo.consumable.coin1" => 199,
			"com.taomee.molekartevo.consumable.coin2" => 499,
			"com.taomee.molekartevo.consumable.coin3" => 999,
			"com.taomee.molekartevo.consumable.coin4" => 1999,
			"com.taomee.molekartevo.consumable.star1" => 199,
			"com.taomee.molekartevo.consumable.star2" => 499,
			"com.taomee.molekartevo.consumable.star3" => 999,
			"com.taomee.molekartevo.consumable.star4" => 1999,
			"com.taomee.molekartevo.consumable.coin5" => 99,
			"com.taomee.molekartevo.consumable.coin6" => 199,
			"com.taomee.molekartevo.consumable.coin7" => 499,
			"com.taomee.molekartevo.consumable.coin8" => 999,
			"com.taomee.molekartevo.consumable.coin9" => 1999,
			"com.taomee.molekartevo.consumable.star5" => 99,
			"com.taomee.molekartevo.consumable.star6" => 199,
			"com.taomee.molekartevo.consumable.star7" => 499,
			"com.taomee.molekartevo.consumable.star8" => 999,
			"com.taomee.molekartevo.consumable.star9" => 1999,
		),
		'com.taomee.iseer2' => array(
			"com.taomee.iseer2.vipgold1" => 99,
			"com.taomee.iseer2.vipgold2" => 199,
			"com.taomee.iseer2.vipgold3" => 499,
			"com.taomee.iseer2.vipgold4" => 999,
			"com.taomee.iseer2.vipgold5" => 1999,
			"com.taomee.iseer2.vipgold6" => 4999,
			"com.taomee.iseer2.vipgold7" => 9999,
		),
	);

	private static function post_data($url, $data, $timeout=6, $retry = 3)
	{
		$ch = curl_init(); // Create curl resource          
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout) ;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:13.0) Gecko/20100101 Firefox/13.0.1');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		$ret = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		return $ret;
	}

	private static function stat_log($log_param)
	{
		$vallist = array('null', );
		$vallist[] = uniqid('A', true).uniqid('B', true).'AB';  // sessionid
		$vallist[] = $log_param['receipt_udid'];    //2     小票传过来的udid
		//$vallist[] = $log_param['user_id'];		    //3
		$vallist[] = $log_param['udid'];		    //3     server传过来的udid
		$vallist[] = $log_param['device_type'];	    //4
		$vallist[] = $log_param['game_name'];       //5
		$vallist[] = $log_param['game_version'];    //6
		$vallist[] = 'PayInfo';		                //7
        //OrderId(0500C351000633F9),ProductName(38个超级贝壳),Price(161),Count(1),Pay(ALIPAY),user_id(18670),
		$vallist[] = 'OrderId';	                    //8
		$vallist[] = $log_param['order_id'];        //9
		$vallist[] = 'ProductName';		            //10
		$vallist[] = $log_param['product_name'];    //11
		$vallist[] = 'Price';	                    //12
		$vallist[] = $log_param['price'];	        //13
		$vallist[] = 'Count';           		    //14
		$vallist[] = $log_param['count'];           //15
		$vallist[] = 'Pay';			                //16
		$vallist[] = "Apple-{$log_param['server_id']}";//17
		$vallist[] = $log_param['jailbreak'];       //18
		$vallist[] = "app_store";                   //19
		$vallist[] = "user_id";                     //20
		$vallist[] = $log_param['user_id'];		    //21

		$data = pack('S', count($vallist));
		foreach ($vallist as $v) {
			$vlen = strlen($v);
			$data = $data.pack('Sa'.$vlen, $vlen, $v);
		}

        // 如果你猜不出下面N多的Magic Number是什么个东西的话，请向C01部门索取《无线事业部统计客户端及服务端开发需求文档》
		$data = $data.pack('S', 1);     // session数量
        //1、Ssession_index
        //2、Sudid_index
        //3、Suser_id_index ---> 调整为server传过来的udid
        //4、Sdevice_type_index
        //5、Scarrier_name_index
        //6、Sgame_name_index
        //7、Sgame_version_index
        //8、Schannel_name_index
        //9、Sfirmware_version_index
        //10、Cage
        //11、Cgender
        //12、Slanguage_name_index
        //13、Sregion_name_index
        //14、Cjailbroken
        //15、Soperation_system
        //16、Sresolution
		$data = $data.pack('SSSSSSSSSCCSSCSS', 1, 2, 3, 4, 0, 5, 6, 19, 0, 0, 0, 0, 0, 18, 0, 0);

        //1、Llen(byte)
        //2、Ssession_index ---> 上面session数组下标
        //3、Stype
        //4、Ltimestamp
        //5、Smsg_name_index
        //6、Sparam_count//OrderId(0500C351000633F9),ProductName(38个超级贝壳),Price(161),Count(1),Pay(ALIPAY), 
        //      <Sparam_name_index, Sparam_val_index>
        //      <...>
		$timestamp = $log_param['timestamp'];
		//$data = $data.pack('LSSLSSSSSSSSSSSS', 36, 0, 0, $timestamp, 7, 5, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17);
        $data = $data.pack('LSSLSSSSSSSSSSSSSS', 40, 0, 0, $timestamp, 7, 6,
                         8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 20, 21);
		$pkglen = strlen($data) + 32;
		$pkg_hash = md5($data.'#t9(~>eT;/', true);
		// pack header
		$send_data = pack('LLLLa16', $pkglen, 0, $timestamp, 0, $pkg_hash).$data;
		self::post_data('http://wlstat.61.com/t/index.php', $send_data);
	}

	public $isSandbox = false;
	public $isValid = false;
	public $receipt = array();
	public $receiptStr = '';
	public $cmd = '';
	public $price = 0;

	private static function malJsonDecode($str)
	{
		$arr = array();
		$str = trim($str, " \t\n\"{};");
		$str = str_replace('"', '', $str);
		$slist = split(';', $str);
		foreach ($slist as $ss) {
			$kv = split('=', $ss);
			$arr[trim($kv[0])] = trim($kv[1]);
		}
		return $arr;
	}	

	private static function get_client_ip()
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

	function __construct($rstr, $bid = null)
	{
		if (!$bid || array_key_exists($bid, self::$bidMap)) {
			$data = base64_decode($rstr);	
			$this->isSandbox = strpos($data, 'Sandbox');
			$data = self::malJsonDecode($data);
			if (isset($data['purchase-info'])) {
				$purchase = base64_decode($data['purchase-info']);
				$purchase = str_replace('-', '_', $purchase);
				$this->receipt = self::malJsonDecode($purchase);
			}

			if (($bid && $bid == $this->receipt['bid'])
				|| (isset($this->receipt['bid']) && array_key_exists($this->receipt['bid'], self::$bidMap))) {
				$this->isValid = true;
				$this->receiptStr = $rstr;
				$this->cmd = self::$bidMap[$this->receipt['bid']];
				$this->price = (int)self::$priceMap[$this->receipt['bid']][$this->receipt['product_id']];
			}
		}
        if (!$this->isValid) {
            Log::write($bid);
            Log::write($data);
            Log::write($this->receipt);
        }
	}

	function verifyReceipt($userid, $udid, $device, $jailbreak, $server_id)
	{
		if (!$this->isValid) {
			return 1001;
		}

		$dsn = WDB_PDO::build_dsn('IAP_'.$this->cmd, '192.168.21.134', 3306);
		$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');
		$trans_id = mysql_escape_string($this->receipt['transaction_id']);
		$sql = "select product_id, item_id, date, status from t_ios_receipt_succ where trans_id=\"$trans_id\";";
		$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ROW);
		if ($data === false) {				// 第一次进行小票校验
			if ($this->isSandbox) {
				$endpoint = 'https://sandbox.itunes.apple.com/verifyReceipt';
			} else {
				$endpoint = 'https://buy.itunes.apple.com/verifyReceipt';
			}

			$postData = json_encode(
				array('receipt-data' => $this->receiptStr)
			);

			$ch = curl_init($endpoint);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

			$response = curl_exec($ch);
			$errno    = curl_errno($ch);
			curl_close($ch);

			if ($errno) {
				return 1002;
			} else {
				$response = json_decode($response);
				if ($response->status == 21005) {
					return 1002;
				} else if ($response->status) {
					return 1004;
				} else {
					$orig_trans_id = mysql_escape_string($this->receipt['original_transaction_id']);
					$product_id = mysql_escape_string($this->receipt['product_id']);
					$item_id = intval($this->receipt['item_id']);
					$quantity = intval($this->receipt['quantity']);
					$orig_date = intval($this->receipt['original_purchase_date_ms']/1000);
					$date = intval($this->receipt['purchase_date_ms']/1000);
                    //if (!$udid) {
                        $receipt_udid = $this->receipt['unique_identifier'];
                    //}
                    $udid2 = mysql_escape_string($receipt_udid);
					$cliver = mysql_escape_string($this->receipt['bvrs']);
					$cli_ip = self::get_client_ip();
					$sql = "insert into t_ios_receipt_succ(trans_id, userid, original_trans_id, product_id, item_id, quantity, original_date, date, money, uuid, device, bvr, cli_ip, jailbreak) values (\"$trans_id\", $userid, \"$orig_trans_id\", \"$product_id\", $item_id, $quantity, $orig_date, $date, {$this->price}, \"$udid2\", \"$device\", \"$cliver\", \"$cli_ip\", $jailbreak);";
					$result = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC, array());
					if ($result) {
						if (!$this->isSandbox)
                        {
                            $log_param = array();
                            $log_param['order_id'] = trim($this->receipt['transaction_id']);
                            $log_param['udid'] = $udid;//server传过来的udid
                            $log_param['receipt_udid'] = $receipt_udid;//小票传过来的udid
                            $log_param['user_id'] = $userid;
                            $log_param['device_type'] = $device;
                            $log_param['game_name'] = trim($this->receipt['bid']);
                            $log_param['game_version'] = $cliver;
                            $log_param['timestamp'] = $date;
                            $log_param['product_name'] = $product_id;
                            $log_param['price'] = trim($this->price);
                            $log_param['count'] = trim($this->receipt['quantity']);
                            $log_param['server_id'] = $server_id;
                            $log_param['jailbreak'] = $jailbreak;
							//self::stat_log($udid, $userid, $device, $this->receipt['bid'], $cliver, $date, $this->price, $product_id, $server_id, $jailbreak);
							self::stat_log($log_param);
							new_stat_log($log_param);

                        }
						return 0;
					} else {
						return 1002;
					}
				}
			}
		} else {							// 已经有对应交易号的小票信息
			if ($data['status'] != 0
				|| $data['product_id'] != $this->receipt['product_id']
				|| $data['item_id'] != $this->receipt['item_id']
				|| $data['date'] = $this->receipt['purchase-date-ms']/1000) {
				return 1004;
			} else {
				$sql = "update t_ios_receipt_succ set status=1 where trans_id=\"$trans_id\";";
				$db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC, array());
				return 0;
			}
		}
	}
};
