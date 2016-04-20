<?php
class Yeepay {
	const number = '10011855770';
	const md5key = 'Z302eEvj20f6S7j1g277h44kQ11K28F9A9793fA622c5b1796SD5kepS16fy';

	public static function appSign($orderId, $amount, $pname)
	{
		$response = array();
		$response['result'] = 'succ';
		$response['customer_no'] = self::number;
		$response['out_trade_no'] = $orderId;
		$response['amount'] = sprintf("%.2f", $amount);
		$response['product_name'] = $pname;
		$response['time'] = time() * 1000;
		$response['product_desc'] = '';
		$data = self::number.'$'.$orderId.'$'.$response['amount'].'$'.$pname.'$'.($response['time']);
		$response['hmac'] = HmacMd5($data, self::md5key);
		return $response;
	}

	public static function appCheck($data)
	{
		if ($data['p1_MerId'] != self::number)
			return false;

		#进行校验码检查 取得加密前的字符串
		$sbOld = $data['p1_MerId'];			// 商户编号
		$sbOld .= $data['r0_Cmd'];			// 业务类型，固定值"Buy"
		$sbOld .= $data['r1_Code'];			// 支付结果，1表示成功
		$sbOld .= $data['r2_TrxId'];			// 易宝交易流水号	
		$sbOld .= $data['r3_Amt'];			// 支付金额	
		$sbOld .= $data['r4_Cur'];			// 交易币种	
		$sbOld .= $data['r5_Pid'];			// 商品名称	
		$sbOld .= $data['r6_Order'];			// 商户订单号	
		$sbOld .= $data['r7_Uid'];			// 易宝支付会员ID	
		$sbOld .= $data['r8_MP'];				// 商户扩展信息ID	
		$sbOld .= $data['r9_BType'];			// 交易结果返回类型ID	
		//$sbOld .= $data['rb_BankId'];			// 支付通道编码，不计算hmac	
		//$sbOld .= $data['ro_BankOrderId'];		// 银行订单号，不计算hmac	
		//$sbOld .= $data['rp_PayDate'];			// 支付成功时间，不计算hmac	
		//$sbOld .= $data['rq_CardNo'];			// 神州行充值卡序列号,不计算hmac
		//$sbOld .= $data['ru_Trxtime'];			// 交易结果通知时间,不计算hmac
		return  $data['hmac'] == HmacMd5($sbOld, self::md5key, 'GBK');
	}


    public static function wapSign($orderId, $amount, $pname, $card)
    {
        $data = array(
            'p0_Cmd'            => 'ChargeCardDirect',  // 非银行卡专业版支付请求固定值
            'p1_MerId'          => self::number,        // 易宝商户编号
            'p2_Order'          => $orderId,            // 商户订单号
            'p3_Amt'            => $amount,             // 支付金额，单位：元，精确到分
            'p4_verifyAmt'      => 'true',              // 只支付指定金额，保留余额
            'p5_Pid'            => $pname,              // 产品名称
            'p6_Pcat'           => '', 		            // 产品类型
            'p7_Pdesc'          => '',                  // 产品描述
            'p8_Url'            => 'http://'.$_SERVER['HTTP_HOST'].'/'.basename(APP_PATH).'/yeepay_callback.php',
            'pa_MP'             => '',                  // 商户扩展信息
            'pa7_cardAmt'       => $card['Amt'],        // 卡面额组
            'pa8_cardNo'        => $card['No'],         // 卡号组
            'pa9_cardPwd'       => $card['Pwd'],        // 卡密组
            'pd_FrpId'          => $card['FrpId'],      // 支付渠道编码
            'pr_NeedResponse'   => '1',
            'pz_userId'         => '',                  // 用户ID
            'pz1_userRegTime'   => '',                  // 用户注册时间
            );
        $dstr = '';
        foreach ($data as $v) {
            $dstr .= $v;
        }
        $hmac = HmacMd5($dstr, self::md5key);
        $data['hmac'] = $hmac;

        return $data;
    }

	public static function wapCheck($data)
	{
		if ($data['p1_MerId'] != self::number)
			return false;

		#进行校验码检查 取得加密前的字符串
		$sbOld = '';
		$sbOld .= $data['r0_Cmd'];			// 业务类型，固定值"Buy"
		$sbOld .= $data['r1_Code'];			// 支付结果，1表示成功
		$sbOld .= $data['p1_MerId'];		// 商户编号
		$sbOld .= $data['p2_Order'];		// 商户订单号	
		$sbOld .= $data['p3_Amt'];			// 支付金额	
		$sbOld .= $data['p4_FrpId'];		// 支付方式	
		$sbOld .= $data['p5_CardNo'];		// 卡序列号组	
		$sbOld .= $data['p6_confirmAmount'];// 确认金额组	
		$sbOld .= $data['p7_realAmount'];	// 实际金额组	
		$sbOld .= $data['p8_cardStatus'];	// 卡状态组	
		$sbOld .= $data['p9_MP'];			// 商户扩展信息ID	
		$sbOld .= $data['pb_BalanceAmt'];	// 支付余额
		$sbOld .= $data['pc_BalanceAct'];			// 余额卡号
		Log::write(HmacMd5($sbOld, self::md5key, 'GBK'));
		return  $data['hmac'] == HmacMd5($sbOld, self::md5key, 'GBK');
	}
}
