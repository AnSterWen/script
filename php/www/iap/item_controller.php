<?php 
define('C01_CALLBACK_URL', 'http://116.228.240.108/m-payservice/mpay');
define('MMC_C01_CALLBACK_URL', 'http://10.1.1.9/m-payservice/mpay');
//define('MMC_C01_CALLBACK_URL', 'http://10.1.1.101:8966/mark');

class  itemController 
{ 
    protected $http = NULL ;
    
	private $pid = NULL;
  	public function  __construct($m)
	{		
		$this->http = Http::get_instance() ;	
		$this->pid = itemModel::$ProductList[$m];
	}

	function getItemJsonAction()
	{
        $page_index    = $this->http->has('page')       ? $this->http->get('page') : 1;
        $page_size     = 15;
        $category      = $this->http->has('category')   ? $this->http->get('category') : 0;
        $version      = $this->http->has('version')   ? $this->http->get('version') : 1;

        $data = array(
            'cmd'          =>    $this->pid.'05',
            'category'     =>    $category,
            'page_index'   =>    $page_index,
            'page_size'    =>    $page_size,
            'version'    =>    $version,
        );
		//echo (json_encode($data));

		$result = itemModel::send($data);
		print_r (json_encode($result['data']));
	}

    /**
     * 通过支付宝支付时生成订单及其签名
     */
    public function tradeAction()
    {
	    $subject = $this->http->has('product_id') ? $this->http->get('product_id') : NULL;
	    $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $subject, 1, $userid, $exdata, 'ALIPAY');
	    
		$content = '';
		$signData = '';

	    if ($data)
	    {
			$body = 'body';
			//组装待签名数据
			$content = "partner=\"".ALI_PARTNER."\"&";
			$content .= "seller=\"".ALI_SELLER."\"&";
			$content .= "out_trade_no=\"{$data['out_trade_no']}\"&";
			$content .= "subject=\"".$data['product_name']."\"&";
			$content .= "body=\"$body\"&";
			$content .= "total_fee=\"".$data['total_fee']."\"&";
			$content .= "notify_url=\"".urlencode(ALI_NOTIFY)."\"";
			$signData = urlencode(sign($content));
		}
	    //返回参数格式
		echo $content."&sign=\"".$signData."\"&sign_type=\"RSA\"";
    }

    /**
     * 通过支付宝支付时生成订单及其签名
     */
    public function alitradeAction()
    {
	    $subject = $this->http->has('product_id') ? $this->http->get('product_id') : NULL;
	    $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $subject, 1, $userid, $exdata, 'ALIPAY');
	    
		$content = '';
		$signData = '';

        $notify_url = C01_CALLBACK_URL . "/alipay_pay.php";
	    if ($data)
	    {
			$body = 'body';
			//组装待签名数据
			$content = "partner=\"".ALI_PARTNER."\"&";
			$content .= "seller=\"".ALI_SELLER."\"&";
			$content .= "out_trade_no=\"{$data['out_trade_no']}\"&";
			$content .= "subject=\"".$data['product_name']."\"&";
			$content .= "body=\"$body\"&";
			$content .= "total_fee=\"".$data['total_fee']."\"&";
			$content .= "notify_url=\"".urlencode($notify_url)."\"";
			$signData = urlencode(sign($content));
		}
	    //返回参数格式
		echo $content."&sign=\"".$signData."\"&sign_type=\"RSA\"";
    }

	/**
	 * * 生成易宝支付签名信息
	 * */
	public function yeepayAction()
	{
		$subject = $this->http->has('product_id') ? $this->http->get('product_id') : NULL;
		$userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $subject, 1, $userid, $exdata, 'YEEPAY');
	    
		$response = array('result' => 'fail');
		if ($data) {
			$response = Yeepay::appSign($data['out_trade_no'], $data['total_fee'], $data['product_name']);
		} else {
			$response = array('result' => 'fail');
		}
		echo json_encode($response);
	}

	public function yeewapAction()
	{
		if (!$this->http->has('product_id') || !$this->http->has('cardinfo')) {
			exit(json_encode(array('result' => 1000)));
		}

		$cardinfo = $this->http->get('cardinfo');
		$cardinfo = str_replace("\\", '', $cardinfo);
		$cardinfo = json_decode($cardinfo, true);
		if (!is_array($cardinfo)) {
			exit(json_encode(array('result' => 1000)));
		}

		$product_id = $this->http->get('product_id');
		$userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'YEEPAY');

		$response = Yeepay::wapSign($data['out_trade_no'], $data['total_fee'], $data['product_name'], $cardinfo);
		echo json_encode(array('result' => 0, 'response' => $response));
	}

	public function cardpayAction()
	{
		$userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$card_id = $this->http->get('card_id');
		$card_passwd = $this->http->get('card_password');
		$product_id = $this->http->get('product_id');

		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'MMCARD');

		$cliret = array('result' => 1105);
		Log::write($data);
		if ($data) {
			$orderId = $data['out_trade_no'];
			$cliret['out_trade_no'] = $data['out_trade_no'];
			$hid = intval(substr($data['out_trade_no'], 0, 8), 16);
			$lid = intval(substr($data['out_trade_no'], -8, 8), 16);
			$fee = intval($data['total_fee'] * 100);
			$body = pack("cLLLa32L",99,$lid, $hid, $card_id,$card_passwd,$fee);
			$code = md5("channelId=11&securityCode=34987137&data=$body");
			$proto = new Cicomm_card_proto(CARD_SERVER_IP, CARD_SERVER_PORT);
			$ret = $proto->card_pay_with_card($userid, 11, $code, 99, $lid, $hid, $card_id, $card_passwd, $fee);
			Log::write($ret);
			switch ($ret['result']) {
			case 0:			// 操作成功
				$cliret['result'] = 0;
				itemModel::commitTrade($orderId, $fee/100.0, 'MMCARD', $ret['out']->consume_id, $card_id);
				break;
			case 1003:		// 卡号错误
			case 1006:		// 卡密码错误
				$cliret['result'] = 1101;
				break;
			case 1007:		// 余额不足
				$cliret['result'] = 1102;
				break;
			case 1011:		// 交易重复
				$cliret['result'] = 1103;
				break;
			default:
				$cliret['result'] = 1104;
				break;
			}
		}

		echo json_encode($cliret);
	}

    public function cliverifyAction()
    {
        $out_trade_no = $this->http->get('out_trade_no');
        $result = itemModel::checkOrderFinish($out_trade_no);
        echo json_encode($result);
    }

    public function aliwapPayAction()
    {
        $subject = $this->http->has('product_id') ? $this->http->get('product_id') : NULL;
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $subject, 1, $userid, $exdata, 'ALIPAY');

		if ($data) {
			//构造请求函数
			$alipay = new AlipayService();
			//调用alipay_wap_trade_create_direct接口，并返回token返回参数
			$token = $alipay->alipay_wap_trade_create_direct($data['product_name'], $data['out_trade_no'], $data['total_fee'], $userid); 

			//调用alipay_Wap_Auth_AuthAndExecute接口方法，并重定向页面
			$alipay->alipay_Wap_Auth_AuthAndExecute($token, $result['data']['total_fee']);
		} else {
			echo "支付系统发生错误，请稍后再试";
		}
    }


	function mycardPayAction()
	{
		$product_id = $this->http->get('product_id');
		$userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'MYCARD');

		if ($data) {
			$mycard = new MycardIngame();
			$auth = $mycard->getAuth($data['out_trade_no']);
			if ($auth && $auth['ReturnMsgNo'] == 1) {
				if ($auth['TradeType'] == 2) {
					$auth['url'] = $mycard->userAuth($auth['AuthCode'], $userid);
				}
			}

			echo json_encode($auth);
		} else {
			header("Location: http://wlad.61.com/iap/mycard/ingame_callback.php?ErrMsg=MyCard支付失败：系统错误");
		}
	}

	function xmpayAction()
	{
		$product_id = $this->http->get('product_id');
		$userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'XMPAY');
		if ($data) {
			$ret = array(
				'result' => 0,
				'tradeNo' => $data['out_trade_no'],
				'fee' => $data['total_fee'],
			);
			echo json_encode($ret);
		} else {
			echo json_encode(array('result' => 1000));
		}
	}

	function gfanpayAction()
	{
		$product_id = $this->http->get('product_id');
		$userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'GFANPAY');
		if ($data) {
			$ret = array(
				'result' => 0,
				'tradeNo' => $data['out_trade_no'],
				'fee' => $data['total_fee'],
			);
			echo json_encode($ret);
		} else {
			echo json_encode(array('result' => 1000));
		}
	}

	function qihoopayAction()
	{
		$product_id = $this->http->get('product_id');
		$userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'QIHOOPAY');
		if ($data) {
			$ret = array(
				'result' => 0,
				'tradeNo' => $data['out_trade_no'],
				'fee' => $data['total_fee'],
				'notify' => 'http://wlad.61.com/iap_test/qihoo_callback.php',
			);
			echo json_encode($ret);
		} else {
			echo json_encode(array('result' => 1000));
		}
	}

	function ucpayAction()
	{
		$product_id = $this->http->get('product_id');
		$userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'UCPAY');
		if ($data) {
			$ret = array(
				'result' => 0,
				'tradeNo' => $data['out_trade_no'],
				'fee' => $data['total_fee'],
			);
			echo json_encode($ret);
		} else {
			echo json_encode(array('result' => 1000));
		}
	}

	function dangleAction()
	{
		$product_id = $this->http->get('product_id');
		$userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
		$exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
		$uif = $this->http->has('uif') ? $this->http->get('uif') : '';

		$cmd = $this->pid;
		if (!isset(itemModel::$PidList[$cmd]['danglemid'])) {
			echo json_encode(array('result' => 1000));
			return;
		}
		$data = itemModel::initTrade($cmd, $product_id, 1, $userid, $exdata, 'DANGLE');
		if ($data) {
			$mid = itemModel::$PidList[$cmd]['danglemid'];
			$gid = itemModel::$PidList[$cmd]['danglegid'];
			$sid = itemModel::$PidList[$cmd]['danglesid'];
			$eif = $data['out_trade_no'];
			$tms = date('YmdHis');
			$key = itemModel::$PidList[$cmd]['danglekey'];
			$bakurl = "http://wlad.61.com/iap/dangle.html";
			$vstr = md5("mid=$mid&gid=$gid&sid=$sid&uif=$uif&utp=0&eif=$eif&bakurl=$bakurl&timestamp=$tms&merchantkey=$key");
			$payInfo = "mid=$mid&gid=$gid&sid=$sid&uif=$uif&utp=0&eif=$eif&bakurl=$bakurl&timestamp=$tms&verstring=$vstr";
			$ret = array(
				'result' => 0,
				'payInfo' => $payInfo,
			);
			echo json_encode($ret);
		} else {
			echo json_encode(array('result' => 1000));
		}

	}
    
    function dangleV2Action()
    {
        $product_id = $this->http->get("product_id");
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'DANGLEV2');
        if ($data)
        {
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'fee'        => $data['total_fee'],
            );
            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }
    
    function tongbuAction()
    {
        $product_id = $this->http->get("product_id");
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'TONGBU');
        if ($data)
        {
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'fee'        => $data['total_fee'],
            );
            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }

    function qihu360Action()
    {
        $product_id = $this->http->get("product_id");
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, 'QIHU360');
        if ($data)
        {
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'    	 => $data['product_name'],
                'fee'        => $data['total_fee'],
            );
			Log::write("360action: {$product_id} --> {$ret['name']}");
            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }

    function generalAction()
    {
        $product_id = $this->http->get("product_id");
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
        $channel = $this->http->has('channel') ? $this->http->get('channel') : 'UNKNOWN';
       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, $channel);

        if ($data)
        {
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'    	 => $data['product_name'],
                'fee'        => $data['total_fee'],
                'third_price' => $data['third_price'],
                'third_name' => $data['product_third_name'],
            );
            $url_prefix = "http://116.228.58.59/paycheck/mpay/";
            if ( strcasecmp($channel, "lenovo") == 0 ) {
                $ret['url'] = urlencode($url_prefix . "lenovo_pay.php");
            }
            else if ( strcasecmp($channel, "oppo") == 0 ) {
                $ret['url'] = urlencode($url_prefix . "oppo_pay.php");
            }
			Log::write("generalAction: {$product_id} --> {$ret['name']}");
            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }

    function msgagentAction()
    {
        $product_id = $this->http->get("product_id");
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
        $agent = $this->http->has('channel') ? $this->http->get('channel') : 'UNKNOWN';
		$channel = "UNKNOWN";
        $url = C01_CALLBACK_URL;
		switch($agent)
		{
		case "mm"://移动MM基地
			$channel = "MOBILE_MM";
            $url .= "/mmarket_pay.php";
			break;
		case "mgame"://移动游戏基地
			$channel = "MOBILE_GAME";
            $url .= "/mmarket_pay.php";
			break;
		case "uwoshop"://联通沃商店
            $ip = get_client_ip();
            if (strcasecmp($ip, "unknow") == 0)
            {
                $ip = str_pad("0", 12, "0", STR_PAD_LEFT);
            }
            else
            {
                $a_ip = explode(".", $ip);
                $ip = "";
                foreach ($a_ip as $key => $val)
                {
                    $ip .= str_pad(trim($val), 3, "0", STR_PAD_LEFT);
                }
            }

            $macaddress = $this->http->has('macaddress') ? $this->http->get('macaddress') : '';
            $imei = $this->http->has('imei') ? $this->http->get('imei') : '';
            $appversion = $this->http->has('appversion') ? $this->http->get('appversion') : '';
            $unichannel = $this->http->has('unichannel') ? $this->http->get('unichannel') : '';

            $a_extra = json_decode(urldecode($exdata), true);
            $a_extra['ip'] = $ip;
            $a_extra['mac'] = str_replace(":", "", $macaddress);
            $a_extra['imei'] = $imei;
            $a_extra['appv'] = $appversion;
            $a_extra['unicd'] = $unichannel;
            $exdata = json_encode($a_extra);
			Log::write("uwoshop exdata: {$exdata}");

            $url .= "/unipay_pay.php";
			$channel = "UNICOM_WOSHOP";
			break;
		case "tgame"://电信爱游戏
            $url .= "/dianxinlovegame_pay.php";
			$channel = "TELCOM_GAME";
			break;
		case "tesurf"://电信天翼空间
            $url .= "/dianxintianyi_pay.php";
			$channel = "TELCOM_ESURFING";
			break;
		default:
            json_encode(array('result' => 1000));
			return;
		}
       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, $channel);
        if ($data)
        {
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'    	 => $data['product_name'],
                'fee'        => $data['total_fee'],
                'macode'     => "",
                'url'     => urlencode($url),
            );
			switch($agent)
			{
			case "mm"://移动MM基地
				$ret['macode'] = $data['mobile_mm'];
				break;
			case "mgame"://移动游戏基地
				$ret['macode'] = $data['mobile_game'];
				break;
			case "uwoshop"://联通沃商店
				$ret['macode'] = $data['unicom_woshop'];
				$ret['tradeNo'] = str_pad('Z'.$data['out_trade_no'], 24, '0', STR_PAD_LEFT);
				break;
			case "tgame"://电信爱游戏
				$ret['macode'] = $data['telcom_game'];
				break;
			case "tesurf"://电信天翼空间
				$ret['macode'] = $data['telcom_esurfing'];
				break;
			default:
				Log::write("[msgagentAction] Wrong agent: {$agent}");
				break;
			}
			Log::write("msgagentAction: {$product_id} --> {$ret['name']}");
            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }

    function mo9payAction()
    {
        $product_id = $this->http->get("product_id");
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $user_time = $this->http->has('user_time') ? $this->http->get('user_time') : 0;
        $game_id = $this->http->has('game_id') ? $this->http->get('game_id') : 0;
        $channel_id = $this->http->has('channel_id') ? $this->http->get('channel_id') : 0;
        $server_id = $this->http->has('server_id') ? $this->http->get('server_id') : 0;
        $game_name = $_GET['m'];
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
        $extra_data = $this->http->has('extra_data') ? $this->http->get('extra_data') : '';
        $debug = $this->http->has('debug') ? intval($this->http->get('debug')) : 0;

        $mo9_app_id = "";
        switch ($game_name)
        {
        case "demo"://demo
            $mo9_app_id = "98000";
            break;
        case "imole_android"://Amole
        case "amole"://Amole
            $mo9_app_id = "1";
            break;
        case "aseer"://Aseer
            $mo9_app_id = "98002";
            break;
        case "ahero"://Ahero
            $mo9_app_id = "98003";
            break;
        case "ago"://Ago
            $mo9_app_id = "98004";
            break;
        default:
		    Log::write("cannot support game: {$game_name}");
            echo json_encode(array('result' => 1001, 'desc' => "wrong m"));
            return;
        }

       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, "MO9PAY");
        if ($data)
        {
            $extra_param = array();
            $extra_param["gd"] = $game_id;//Game ID
            $extra_param["cd"] = $channel_id;//Channel ID
            $extra_param["sd"] = $server_id;//Server ID
            $extra_param["pd"] = $product_id;//Product ID
            $extra_param["od"] = $data['out_trade_no'];//Order ID
            $extra_param["m"] = $data['total_fee'] * 100;//Price
            $extra_param["cu"] = 0;//Currency, 0-CNY, 1-USD
            $extra_param["ud"] = $userid;//User ID
            $extra_param["ut"] = $user_time;//Role Create Time
            $extra_param["ed"] = $extra_data;//json中的extra_data
            $extra_param["dg"] = $debug;

            $params = array();
            $params['pay_to_email'] = "seven@taomee.com";
            $params['version'] = "2.1";
            $params['return_url'] = "";
            //mo9交易成功以后通知商家做交易处理的异步通知
            $params['notify_url'] = C01_CALLBACK_URL . "/mo9_pay.php?";
            $params['invoice'] = $data['out_trade_no'];//一般商家都把订单号做为此字段

            $params['extra_param'] = json_encode($extra_param);

            $params['payer_id'] = $userid;
            $params['lc'] = "CN";
            $params['amount'] = $data['total_fee'];
            $params['currency'] = "CNY";
            $params['item_name'] = $data['product_name'];
            $params['app_id'] = $mo9_app_id;

            $pri_key = "4360dced665441fd833a1282e412d026";
            $sign = make_md5_sign($params, $pri_key);
            $params['sign'] = $sign;

            $url = "https://sandbox.mo9.com.cn/gateway/mobile.shtml?m=mobile";
            foreach ($params as $key => $val) {
                if (trim($val) == "") {
                    continue;
                }
                $url .= "&{$key}={$val}";
            }    
            Log::write($url);
            $url = urlencode($url);

            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'    	 => $data['product_name'],
                'fee'        => $data['total_fee'],
                'url'        => $url,
            );

            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }

    public function mmcardpayAction()
    {
        $product_id = $this->http->get("product_id");
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $user_time = $this->http->has('user_time') ? $this->http->get('user_time') : 0;
        $game_id = $this->http->has('game_id') ? $this->http->get('game_id') : 0;
        $channel_id = $this->http->has('channel_id') ? $this->http->get('channel_id') : 0;
        $server_id = $this->http->has('server_id') ? $this->http->get('server_id') : 0;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
        $extra_data = $this->http->has('extra_data') ? $this->http->get('extra_data') : '';//json中的extra_data
        $card_id = $this->http->get('card_id');
        $card_passwd = $this->http->get('card_pwd');
        $debug = $this->http->has('debug') ? intval($this->http->get('debug')) : 0;

        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, "MMCARD");
        if ($data)
        {
            $extra_param = array();
            $extra_param["gd"] = $game_id;//Game ID
            $extra_param["cd"] = $channel_id;//Channel ID
            $extra_param["sd"] = $server_id;//Server ID
            $extra_param["pd"] = $product_id;//Product ID
            $extra_param["od"] = $data['out_trade_no'];//Order ID
            $extra_param["m"] = $data['total_fee'] * 100;//Price
            $extra_param["cu"] = 0;//Currency, 0-CNY, 1-USD
            $extra_param["ud"] = $userid;//User ID
            $extra_param["ut"] = $user_time;//Role Create Time
            $extra_param["ed"] = $extra_data;//json中的extra_data
            $extra_param["dg"] = $debug;

            //card_id=500036369&password=e2ef732578386117782f5067427e2c27&user_id=50024&mb_num=1000&extend={"pd":"100","od":"10007","sd":1,"gd":999,"ud":10000,"ut":99999,"m":1,"cu":0,"cd":1}&sign=1e95976ef866e438750be27ca46a9be2
            $params = array();
            $params['card_id'] = $card_id;
            $params['password'] = $card_passwd;
            $params['user_id'] = $userid;
            $params['mb_num'] = $data['total_fee'] * 100;
            $params['extend'] = json_encode($extra_param);

            $pri_key = "4360dced665441fd833a1282e412d026";
            $sign = make_c01_md5_sign($params, $pri_key);
            $params['sign'] = $sign;

            $url = MMC_C01_CALLBACK_URL . "/mmcard_pay.php";
            //foreach ($params as $key => $val) {
            //    $url .= "&{$key}={$val}";
            //}
            //$url = urlencode($url);
            $params['url'] = urlencode($url);
            //$params['url'] = $url;

            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'       => $data['product_name'],
                'fee'        => $data['total_fee'],
                'data'        => $params,
            );

            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }
    }

    function oppoAction()
    {
        $product_id = $this->http->get("product_id");
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, "OPPO");
        if ($data)
        {
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'    	 => $data['product_name'],
                'fee'        => $data['total_fee'],
                'url'        => urlencode("http://116.228.58.59/paycheck/mpay/oppo_pay.php"),
            );
			Log::write("oppoAction: {$product_id} --> {$ret['name']}");
            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }

    function lenovoAction()
    {
        $product_id = intval($this->http->get("product_id"));
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
        Log::write("lenovo ---> exdata: {$exdata}");

        $pid_map = array(
            //ahero
            '08' => array(
                80001 => 1,
                80002 => 2,
                80003 => 3,
                80004 => 4,
                80005 => 5,
                80006 => 6,
                80007 => 7,
                81001 => 8,
            ),
        );
       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, "LENOVO");
        if ($data)
        {
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'    	 => $data['product_name'],
                'fee'        => $data['total_fee'],
                'url'        => urlencode("http://116.228.58.59/paycheck/mpay/lenovo_pay.php"),
                'lenovoid'  => $pid_map[$this->pid][$product_id],
            );
			Log::write("lenovoAction: {$product_id} --> {$ret['name']}");
            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }

    function appchinaAction()
    {
        $product_id = intval($this->http->get("product_id"));
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
        Log::write("lenovo ---> exdata: {$exdata}");

        $pid_map = array(
            //ahero
            '08' => array(
                80001 => 1,
                80002 => 2,
                80003 => 3,
                80004 => 4,
                80005 => 5,
                80006 => 6,
                80007 => 7,
            ),
        );
       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, "APPCHINA");
        if ($data)
        {
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'    	 => $data['product_name'],
                'fee'        => $data['total_fee'],
                'url'        => urlencode("http://116.228.58.59/paycheck/mpay/appchina_pay.php"),
                'pid'  => $pid_map[$this->pid][$product_id],
            );
			Log::write("appchinaAction: {$product_id} --> {$ret['name']}");
            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }

    function oupengAction()
    {
        $product_id = intval($this->http->get("product_id"));
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
        Log::write("oupeng ---> exdata: {$exdata}");

        $pid_map = array(
            //ahero
            '08' => array(
                80001 => 1,
                80002 => 2,
                80003 => 3,
                80004 => 4,
                80005 => 5,
                80006 => 6,
                80007 => 7,
            ),
        );
       
        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, "OUPENG");
        if ($data)
        {
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'    	 => $data['product_name'],
                'fee'        => $data['total_fee'],
                'url'        => urlencode("http://116.228.58.59/paycheck/mpay/oupeng_pay.php"),
                'pid'  => $pid_map[$this->pid][$product_id],
            );
			Log::write("oupengAction: {$product_id} --> {$ret['name']}");
            echo json_encode($ret);
        }
        else
        {
            json_encode(array('result' => 1000));
        }        
    }

    //比较特殊，需要访问第三方获取订单信息和签名
    function vivoAction()
    {
        $wrong_string = json_encode(array('result' => 1000));

        $product_id = intval($this->http->get("product_id"));
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
        Log::write("vivo ---> exdata: {$exdata}");


        $game_name = $this->http->has('m') ? $this->http->get('m') : '';

        $game_param = array(
            'ahero' => 
            array(
                'storeId' => '20140314115905031935',
                'appId' => '1090',
                'priKey' => '12863755F2D5FF3673D15C74663C77EA',
            ),
        );

        if (!isset($game_param[$game_name]))
        {
            Log::write("VIVO ERROR: game({$game_name}) parameter not exist");
            die($wrong_string);
        }


        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, "VIVO");
        if ($data)
        {
            $orderId = $data['out_trade_no'];
            $orderAmount = sprintf("%.2f", $data['total_fee']);
            $orderTitle = $data['product_name'];

            $storeId = $game_param[$game_name]['storeId'];
            $appId = $game_param[$game_name]['appId'];
            $priKey = $game_param[$game_name]['priKey'];
            $notifyUrl = "http://116.228.58.59/paycheck/mpay/bbg_vivo_pay.php";
            $orderTime = date("YmdHis");

            $a_data = array(
                'version' => '1.0.0',
                'signMethod' => 'MD5',
                'signature' => "",
                'storeId' => $storeId,
                'appId' => $appId,
                'storeOrder' => $orderId,
                'notifyUrl' => $notifyUrl,
                'orderTime' => $orderTime,
                'orderAmount' => $orderAmount,
                'orderTitle' => $orderTitle,
                'orderDesc' => $orderTitle,
            );
            $sign_arr = $a_data;
            ksort($sign_arr);
            $sign_str = ''; 
            /* 将参数用&连起来 */
            foreach ($sign_arr as $key => $val) {
                if ( empty($val) ||
                    strcasecmp($key, "signMethod") == 0 ||
                    strcasecmp($key, "signature") == 0 )
                    continue;
                $sign_str .= $key . '=' . $val . '&';
            }
            $sign_str .= strtolower( md5($priKey) );
			Log::write("vivo sign sting: {$sign_str}");
            $signature = strtolower( md5($sign_str) );
            $a_data['signMethod'] = "MD5";
            $a_data['signature'] = $signature;

            $s_data = "";
            foreach ($a_data as $key => $val) {
                $s_data .= $key . '=' . utf8_encode( urlencode($val) ) . '&';
            }
            $s_data = substr($s_data, 0, -1);

            $vivoUrl = "https://pay.vivo.com.cn/vivoPay/getVivoOrderNum";
            $a_return = get_url_contents($vivoUrl, $s_data, 'post', 'json');
            $return_string = json_encode($a_return);
			Log::write("vivo request array: " . var_export($a_data, true));
			Log::write("vivo return array: " . var_export($a_return, true));
			Log::write("vivo return string: {$return_string}");

            if (!isset($a_return['respCode']) || $a_return['respCode'] != 200) {
                die($wrong_string);
            }

            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'    	 => $data['product_name'],
                'fee'        => $data['total_fee'],
                'vivoSignature'   => $a_return['vivoSignature'],
                'vivoOrder'   => $a_return['vivoOrder'],
            );

            echo json_encode($ret);
        }
        else
        {
            die($wrong_string);
        }        
    }

    function mfaceAction()
    {
        $product_id = $this->http->get("product_id");
        $userid = $this->http->has('userid') ? $this->http->get('userid') : 50000;
        $exdata = $this->http->has('exdata') ? $this->http->get('exdata') : '';
        $channel = "MFACE";


        $data = itemModel::initTrade($this->pid, $product_id, 1, $userid, $exdata, $channel);
        $wrong_string = json_encode(array('result' => 1000));
        if ($data)
        {
            $game_currency = intval($data['total_fee'] * 10);
            $ret = array(
                'result'     => 0,
                'tradeNo'    => $data['out_trade_no'],
                'name'       => $data['product_name'],
                'fee'        => $data['total_fee'],
                //"com.gv.jfyzz." . $game_currency
                'mfaceId'    => $game_currency,
            );
            Log::write("mfaceAction: {$product_id} --> {$ret['name']}");

            echo json_encode($ret);
        }
        else
        {
            die($wrong_string);
        }
    }

}
