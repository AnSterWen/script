<?php
require_once (dirname(dirname(__FILE__)) . "/lib/Mysql.class.php");
require_once ( dirname(dirname(__FILE__)) . "/config/apple.config.php" );

//receipt字段信息
//{
//    "original-purchase-date-pst" = "2014-04-02 09:25:24 America/Los_Angeles";
//    "purchase-date-ms" = "1396455924802";
//    "unique-identifier" = "f25f04c3855e1a5fbd0ca98966a1a2dbb52396de";
//    "original-transaction-id" = "450000070220675";
//    "bvrs" = "1.6.0";
//    "transaction-id" = "450000070220675";
//    "quantity" = "1";
//    "original-purchase-date-ms" = "1396455924802";
//    "unique-vendor-identifier" = "85AAC022-82B0-4B7B-80E8-2B05D6737955";
//    "item-id" = "663640376";
//    "version-external-identifier" = "88612634";
//    "product-id" = "com.taomee.iseer2.vipgold5";
//    "purchase-date" = "2014-04-02 16:25:24 Etc/GMT";
//    "original-purchase-date" = "2014-04-02 16:25:24 Etc/GMT";
//    "bid" = "com.taomee.iseer2";
//    "purchase-date-pst" = "2014-04-02 09:25:24 America/Los_Angeles";
//}
class CAppleReceipt {
    public $_isSandbox = false;
    public $_isValid = false;
    public $_receiptArr = array();
    public $_receiptStr = '';
    public $_db_suffix = '';
    public $_self_product_id = 0;
    public $_apple_price = 0;

    function __construct()
    {
        $this->_isSandbox = false;
        $this->_isValid = false;
        $this->_receiptStr = "";
        $this->_receiptArr = array();
        $this->_db_suffix = "";
        $this->_self_product_id = 0;
        $this->_apple_price = 0;
    }

    private static function getGameID($bundle_id)
    {
        global $g_game_info_map;
        if ( !array_key_exists($bundle_id, $g_game_info_map) ) {
            return false;
        }
        if ( !array_key_exists('game_id', $g_game_info_map[$bundle_id]) ) {
            return false;
        }

        return $g_game_info_map[$bundle_id]['game_id'];
    }


    private static function getSelfProductId($bundle_id, $apple_product_id)
    {
        global $g_game_info_map;
        if ( !array_key_exists($bundle_id, $g_game_info_map) ) {
            return false;
        }
        if ( !array_key_exists('pid_map', $g_game_info_map[$bundle_id]) ) {
            return false;
        }
        if ( !array_key_exists($apple_product_id, $g_game_info_map[$bundle_id]['pid_map']) ) {
            return false;
        }

        return $g_game_info_map[$bundle_id]['pid_map'][$apple_product_id];
    }

    private static function getDBPostfix($bundle_id)
    {
        global $g_game_info_map;
        if ( !array_key_exists($bundle_id, $g_game_info_map) ) {
            return false;
        }
        if ( !array_key_exists('db_postfix', $g_game_info_map[$bundle_id]) ) {
            return false;
        }

        return $g_game_info_map[$bundle_id]['db_postfix'];
    }

    private static function getAppleProductPrice($bundle_id, $product_id)
    {
        global $g_game_info_map;
        if ( !array_key_exists($bundle_id, $g_game_info_map) ) {
            return false;
        }
        if ( !array_key_exists('price_map', $g_game_info_map[$bundle_id]) ) {
            return false;
        }
        if ( !array_key_exists($product_id, $g_game_info_map[$bundle_id]['price_map']) ) {
            return false;
        }

        return $g_game_info_map[$bundle_id]['price_map'][$product_id];
    }

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
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $ret = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return $ret;
    }


    private function malJsonDecode($str)
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


    function parseReceiptString($receiptStr, $bundle_id)
    {
        if (strpos($receiptStr, '{') !== false) {
            $this->_receiptStr = base64_encode($receiptStr);
            $data = $receiptStr;	
        } else {
            $this->_receiptStr = $receiptStr;
            $data = base64_decode($receiptStr);	
        }   
        $this->_isSandbox = (false === strpos($data, 'Sandbox')) ? false : true;
        $data = $this->malJsonDecode($data);
        if ( isset($data['purchase-info']) ) {
            $purchase = base64_decode($data['purchase-info']);
            $purchase = str_replace('-', '_', $purchase);
            $this->_receiptArr = $this->malJsonDecode($purchase);
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "_receiptArr:" . print_r($this->_receiptArr, true));
        }

        $db_postfix = self::getDBPostfix($bundle_id);
        if ( false === $db_postfix ) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "getDBPostfix({$bundle_id}) failed!");
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "receiptStr({$receiptStr}), bundle_id({$bundle_id})");
            return ERR_INVALID_RECEIPT;
        }
        $this->_db_suffix = $db_postfix;

        //$price = self::getAppleProductPrice($bundle_id, $this->_receiptArr['product_id']);
        //if ( false === $price ) {
        //    write_log("error", __FILE__, __FUNCTION__, __LINE__,
        //        "getProductPrice({$bundle_id}, {$this->_receiptArr['product_id']}) failed!");
        //    write_log("error", __FILE__, __FUNCTION__, __LINE__, "receiptStr({$receiptStr}), bundle_id({$bundle_id})");
        //    return ERR_INVALID_RECEIPT;
        //}
        //$this->_apple_price = $price;

        //$product_id = self::getSelfProductId($bundle_id, $this->_receiptArr['product_id']);
        //if ( false === $product_id ) {
        //    write_log("error", __FILE__, __FUNCTION__, __LINE__,
        //        "getSelfProductId({$bundle_id}, {$this->_receiptArr['product_id']}) failed!");
        //    write_log("error", __FILE__, __FUNCTION__, __LINE__, "receiptStr({$receiptStr}), bundle_id({$bundle_id})");
        //    return ERR_INVALID_RECEIPT;
        //}
        //$this->_self_product_id = $product_id;

        $this->_isValid = true;

        return ERR_OK;
    }


    public function verifyOK() {
        //验证通过
        $trans_id = $this->_receiptArr['transaction_id'];
        $orig_trans_id = $this->_receiptArr['original_transaction_id'];
        $product_id = $this->_receiptArr['product_id'];
        $item_id = intval($this->_receiptArr['item_id']);
        $quantity = intval($this->_receiptArr['quantity']);
        $purchase_date = intval($this->_receiptArr['purchase_date_ms']/1000);
        $orig_purchase_date = intval($this->_receiptArr['original_purchase_date_ms']/1000);
        $udid = $notify_data['udid'];
        if ( empty($udid) ) {
            $udid = $this->_receiptArr['unique_identifier'];
        }
        $app_version = $this->_receiptArr['bvrs'];
        $bundle_id = $this->_receiptArr['bid'];
        $device = isset($notify_data['device']) ? $notify_data['device'] : 'null';
        $jailbreak = $notify_data['jailbreak'];

        $channel_id = $notify_data['channel_id'];
        $user_id = $notify_data['user_id'];
        $user_regtime = $notify_data['regtime'];
        $server_id = $notify_data['server_id'];
        $self_product_id = $this->_self_product_id;
        $game_id = self::getGameID($bundle_id);
        if ( false === $game_id ) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "getGameID({$bundle_id}) failed!");
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "receiptStr({$receiptStr}), bundle_id({$bundle_id})");
            return ERR_INVALID_RECEIPT;
        }

        $bill_info = array(
            //小票相关
            'trans_id' => $trans_id,
            'original_trans_id' => $orig_trans_id,
            'product_id' => $product_id,
            'item_id' => $item_id,
            'quantity' => $quantity,
            'purchase_date' => $purchase_date,
            'original_purchase_date' => $orig_purchase_date,
            'uuid' => $udid,
            'device' => $device,
            'app_version' => $app_version,
            'bundle_id' => $bundle_id,
            'is_jailbreak' => $jailbreak,
            'is_sandbox' => $this->_isSandbox ? 1 : 0,

            //游戏相关
            'game_id' => $game_id,
            'channel_id' => $channel_id,
            'user_id' => $user_id,
            'role_create_time' => $user_regtime,
            'server_id' => $server_id,
            'db_suffix' => $this->_db_suffix,
    }

    public function verifyReceipt($notify_data, &$bill_info)
    {
        $bundle_id = $notify_data['app_name'];
        $receiptStr = $notify_data['receipt'];
        $parse_result = $this->parseReceiptString($receiptStr, $bundle_id);
        if ( ERR_OK != $parse_result ) {
            return $parse_result;
        }

        if ($this->_isSandbox) {
            write_log("warn", __FILE__, __FUNCTION__, __LINE__, "SANDBOX: " . print_r($notify_data, true));
            // return ERR_IS_SAND_BOX;
        }


        // 小票校验
        $check_url = $this->_isSandbox ? APPLE_SANDBOX_CHECK_URL : APPLE_ITUNES_CHECK_URL;
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "check_url: {$check_url}");
        $postData = json_encode(
            array('receipt-data' => $this->_receiptStr)
        );
        $ch = curl_init($check_url);
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
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "curl_errno: {$errno}");
            return ERR_APPLE_SYSERR;
        }
        $response = json_decode($response, true);
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "apple response: " . print_r($response, true));
        if ($response['status'] == 21005) {//The receipt server is not currently available
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "response->status: {$response['status']}");
            return ERR_APPLE_SYSERR;
        } else if ($response['status']) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "INVALID RECEIPT: wrong status({$response['status']})");
            return ERR_CLEAR_RECEIPT;
        }



        //验证通过
        $trans_id = $this->_receiptArr['transaction_id'];
        $orig_trans_id = $this->_receiptArr['original_transaction_id'];
        $product_id = $this->_receiptArr['product_id'];
        $item_id = intval($this->_receiptArr['item_id']);
        $quantity = intval($this->_receiptArr['quantity']);
        $purchase_date = intval($this->_receiptArr['purchase_date_ms']/1000);
        $orig_purchase_date = intval($this->_receiptArr['original_purchase_date_ms']/1000);
        $udid = $notify_data['udid'];
        if ( empty($udid) ) {
            $udid = $this->_receiptArr['unique_identifier'];
        }
        $app_version = $this->_receiptArr['bvrs'];
        $bundle_id = $this->_receiptArr['bid'];
        $device = isset($notify_data['device']) ? $notify_data['device'] : 'null';
        $jailbreak = $notify_data['jailbreak'];

        $channel_id = $notify_data['channel_id'];
        $user_id = $notify_data['user_id'];
        $user_regtime = $notify_data['regtime'];
        $server_id = $notify_data['server_id'];
        $self_product_id = $this->_self_product_id;
        $game_id = self::getGameID($bundle_id);
        if ( false === $game_id ) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "getGameID({$bundle_id}) failed!");
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "receiptStr({$receiptStr}), bundle_id({$bundle_id})");
            return ERR_INVALID_RECEIPT;
        }

        $bill_info = array(
            //小票相关
            'trans_id' => $trans_id,
            'original_trans_id' => $orig_trans_id,
            'product_id' => $product_id,
            'item_id' => $item_id,
            'quantity' => $quantity,
            'purchase_date' => $purchase_date,
            'original_purchase_date' => $orig_purchase_date,
            'uuid' => $udid,
            'device' => $device,
            'app_version' => $app_version,
            'bundle_id' => $bundle_id,
            'is_jailbreak' => $jailbreak,
            'is_sandbox' => $this->_isSandbox ? 1 : 0,

            //游戏相关
            'game_id' => $game_id,
            'channel_id' => $channel_id,
            'user_id' => $user_id,
            'role_create_time' => $user_regtime,
            'server_id' => $server_id,
            'db_suffix' => $this->_db_suffix,
        );

        return ERR_OK;
    }

};
