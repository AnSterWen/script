<?php
require_once 'Handler.class.php';
require_once 'icomm_card_proto.php';

class itemHandler extends Handler
{
	function __construct($db, $pid)
	{
		parent::__construct();
		global $product_config;
		$db = $product_config[$pid]['db'];

		$dsn = WDB_PDO::build_dsn($db['name'], $db['host'], $db['port']);

		$this->wdb_pdo = new WDB_PDO($dsn, $db['user'], $db['pass'], 'latin1');
		$this->wdb_pdo->set_mode_debug();
		$this->pid = $pid;
		//$this->noticonf = $product_config[$pid]['noti'];
	}

	private $pid = null;
	private $noticonf = null;

	function get_mb_list_simple()
	{
		$_page_index      = req_get_param('page_index');
		$_page_size       = req_get_param('page_size');
		$_category        = intval(req_get_param('category'));

		$count = intval($_page_size) ? intval($_page_size) : PAGE_SIZE;
		$index = intval($_page_index) ? (intval($_page_index) - 1) * $count : 0;
		$minid = intval($this->pid,16) * 10000;
		$maxid = $minid + 9999;
		$sql = 'select id as product_id, items, name, price, discount, current_count, total_count, third_price from product_info_table '.
			"where id >= $minid and id <= $maxid and is_valid!=0 and category=$_category limit $index,$count";
		$data = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
		if ($data == false) $data = array();
		$tmnow = time();
		foreach ($data as $k => $v) {
			$isactive = $tmnow >= $v['current_count'] && $tmnow <= $v['total_count'];
			unset($data[$k]['current_count']);
			unset($data[$k]['total_count']);
			$data[$k]['items'] = json_decode($v['items'], true);
			$data[$k]['orig_price'] = $data[$k]['price'];
			if ($isactive) {
				$data[$k]['price'] = strval($data[$k]['price'] * $data[$k]['discount'] / 100.0);
			}
			unset($data[$k]['discount']);
			$game_id = '';
			foreach ($data[$k]['items'] as $item => $count) {
				if (!empty($game_id)) $game_id .= ',';
				$game_id .= $item.'|'.$count['base'];
				if (!$isactive) unset($data[$k]['items'][$item]['gift']);
			}
			$data[$k]['game_id'] = $game_id;
		}
		return array('result' => 0, 'data' => $data);
	}

	function get_mb_list_agent()
	{
		$_page_index      = req_get_param('page_index');
		$_page_size       = req_get_param('page_size');
		$_category        = intval(req_get_param('category'));
		$_version        = intval(req_get_param('version'));
		$_version        = ($_version <= 0) ? 1 : $_version;

		$count = intval($_page_size) ? intval($_page_size) : PAGE_SIZE;
		$index = intval($_page_index) ? (intval($_page_index) - 1) * $count : 0;
		$minid = intval($this->pid,16) * 10000;
		$maxid = $minid + 9999;
		$sql = "SELECT id as product_id, items, name, price, discount, current_count, total_count,".
            "add_times, product_attr , product_third_name , extend_data , third_price".
            " FROM product_info_table".
            " WHERE id BETWEEN {$minid} AND {$maxid} AND is_valid != 0".
            " AND category = {$_category} AND client_version <= {$_version} LIMIT {$index},{$count}";

		$data = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
		if ($data == false) $data = array();
		$tmnow = time();
		foreach ($data as $k => $v) {
			$isactive = $tmnow >= $v['current_count'] && $tmnow <= $v['total_count'];
			unset($data[$k]['current_count']);
			unset($data[$k]['total_count']);

//			$mobile_mm_bit = (strlen(trim($data[$k]['mobile_mm'])) == 0) ? 0 : 1;
//			$mobile_game_bit = (strlen(trim($data[$k]['mobile_game'])) == 0) ? 0 : 1;
//			$unicom_woshop_bit = (strlen(trim($data[$k]['unicom_woshop'])) == 0) ? 0 : 1;
//			$telcom_game_bit = (strlen(trim($data[$k]['telcom_game'])) == 0) ? 0 : 1;
//			$telcom_esurfing_bit = (strlen(trim($data[$k]['telcom_esurfing'])) == 0) ? 0 : 1;
//			$agent_bit = $mobile_mm_bit + ($mobile_game_bit << 1) + ($unicom_woshop_bit << 2)
//							+ ($telcom_game_bit << 3) + ($telcom_esurfing_bit << 4);
//			unset($data[$k]['mobile_mm']);
//			unset($data[$k]['mobile_game']);
//			unset($data[$k]['unicom_woshop']);
//			unset($data[$k]['telcom_game']);
//			unset($data[$k]['telcom_esurfing']);

			$data[$k]['items'] = json_decode($v['items'], true);
			$data[$k]['orig_price'] = $data[$k]['price'];
			if ($isactive) {
				$data[$k]['price'] = strval($data[$k]['price'] * $data[$k]['discount'] / 100.0);
			}
			unset($data[$k]['discount']);
			$game_id = '';

            if(is_array($data[$k]['items'])){
                foreach ($data[$k]['items'] as $item => $count) {
                    if (!empty($game_id)) $game_id .= ',';
                    $game_id .= $item.'|'.$count['base'];
                    if (!$isactive) unset($data[$k]['items'][$item]['gift']);
                }
            }

			$data[$k]['game_id'] = $game_id;
            $data[$k]['product_third_name'] = $v["product_third_name"];
//			$data[$k]['msg_agent'] = strval($agent_bit);
		}
		return array('result' => 0, 'data' => $data);
	}

	public function noti_to_game_svr($out_trade_no, $cid = 0)
	{
		Log::write("Noti $out_trade_no");
		if (isset($this->noticonf)) {
			$logid = intval(substr($out_trade_no, 8, 8), 16);
			$hid = intval(substr($out_trade_no, 0, 8), 16);
			$sql = "select user_id, money_number, dest_user_id, items from buy_log_table where log_id=$logid";
			$data = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ROW);
			if ($data != false) {
				$config = $this->noticonf;
				$proto = new Cicomm_card_proto($config['ip'], $config['port']);
				$items = json_decode($data['items'], true);
				if (!is_array($items)) {
					$items = json_decode($items, true);
				}
				Log::write($items);
				$itemlist = array();
				foreach ($items as $k => $v) {
					$item = new item_t();
					$item->itemid = $k;
					if ($cid == 0x80000) {
						$item->count = $data['money_number'] / 100 * 3;
					} else {
						$item->count = $v['base'];
						if (isset($v['gift'])) $item->count += $v['gift'];
					}
					$itemlist[] = $item;
				}
				$ret = $proto->iap_noti_online_item($config['cmd'], $data['user_id'], $data['dest_user_id'], $logid, $hid, $itemlist);
				Log::write($ret);
				if ($ret['result']!= 0) {
					$sql = "update buy_log_table set noti_count=1, last_noti_time=".time()." where log_id=".$logid;
				} else {
					$sql = "update buy_log_table set noti_count=100, last_noti_time=".time()." where log_id=".$logid;
				}

				$this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC);
			} else {
				Log::write($sql);
			}
		}
	}

	/**
	 *
	 * 获取所有米币商品
	 *
	 */
	function gen_order_by_product_id()
	{
		$product_id = intval(req_get_param('subject'));
		$userid = intval(req_get_param('userid'));
		$dest_user_id = intval(req_get_param('dest_user_id'));
        $extra_data = req_get_param('exdata');
		$pid = $this->pid;
		Log::write("gen_order_by_product_id: $pid/$product_id/$userid/$dest_user_id");
		if ($dest_user_id == 0) $dest_user_id = $userid;

		$db = $this->wdb_pdo;
		$sql = 'select name, price, discount, items, current_count, total_count,'.
			'third_price, product_third_name'.
			' from product_info_table where id='.$product_id.' and is_valid=1';
		Log::write($sql);
		$ret = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ROW);
		if ($ret == false) {
			return array('result' => 2101);
		}

		$tmnow = time();
		$fee = $ret['price'];
		$itemlist = json_decode($ret['items'], true);
		if ($tmnow >= $ret['current_count'] && $tmnow <= $ret['total_count'])
			$fee = $fee * $ret['discount'] / 100.0;
		else {
			$tmp = array();
			foreach ($itemlist as $k => $v) {
				$tmp[$k]['base'] = $v['base'];
			}
			$itemlist = $tmp;
		}

		$data['total_fee'] = $fee / 100.0;
        $data['product_name'] = $ret['name'];
        $data['product_third_name'] = $ret['product_third_name'];
        $data['third_price'] = $ret['third_price'];

        $sql = 'insert into buy_log_table(user_id, dest_user_id, product_id,'.
            ' money_number, trade_time, buy_result, items, extra_data)';
        $sql .= " values($userid,$dest_user_id,$product_id,$fee,$tmnow,0, \""
            .mysql_escape_string(json_encode($itemlist)).'", "'
            .mysql_escape_string($extra_data).'")';
		$ret = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC, array());
		if ($ret === false)
		{
			return array('result' => 2101, $sql);
		}

		$sql = 'select last_insert_id() as logid from buy_log_table;';
		$ret = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ROW);
		if ($ret == false) {
			return array('result' => 2101);
		}

		$data['out_trade_no'] = sprintf("%02X%06X%08X", intval($this->pid, 16), $product_id, $ret['logid']);
		return array('result' => 0, 'data' => $data);
	}

    function gen_order_by_third_name()
    {
        $product_id = req_get_param('subject');
        $userid = intval(req_get_param('userid'));
        $dest_user_id = intval(req_get_param('dest_user_id'));
        $extra_data = req_get_param('exdata');
        $pid = $this->pid;
        Log::write("gen_order_by_third_name: $pid/$product_id/$userid/$dest_user_id");
        if ($dest_user_id == 0) $dest_user_id = $userid;

        $db = $this->wdb_pdo;
        $sql = "SELECT id, name, price, discount, items, current_count, total_count,".
            "third_price, product_third_name".
            " FROM product_info_table".
            " WHERE product_third_name = '{$product_id}' and is_valid = 1";
        Log::write($sql);
        $ret = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ROW);
        if ($ret == false) {
            return array('result' => 2101);
        }

        $tmnow = time();
        $fee = $ret['price'];
        $itemlist = json_decode($ret['items'], true);
        if ($tmnow >= $ret['current_count'] && $tmnow <= $ret['total_count'])
            $fee = $fee * $ret['discount'] / 100.0;
        else {
            $tmp = array();
            foreach ($itemlist as $k => $v) {
                $tmp[$k]['base'] = $v['base'];
            }
            $itemlist = $tmp;
        }

        $product_id = $ret['id'];
        $data['product_id'] = $product_id;
        $data['total_fee'] = $fee / 100.0;
        $data['product_name'] = $ret['name'];
        $data['product_third_name'] = $ret['product_third_name'];
        $data['third_price'] = $ret['third_price'];
        $data['item_list'] = $itemlist;

        $sql = 'insert into buy_log_table(commit_time,product_count,user_id, dest_user_id, product_id,'.
            ' money_number, trade_time, buy_result, items, extra_data)';
        $sql .= " values($tmnow,0,$userid,$dest_user_id,$product_id,$fee,$tmnow,0, \""
            .mysql_escape_string(json_encode($itemlist)).'", "'
            .mysql_escape_string($extra_data).'")';

        $ret = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC, array());
        if ($ret === false)
        {
            return array('result' => 2101, $sql);
        }

        $sql = 'select last_insert_id() as logid from buy_log_table;';
        $ret = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ROW);
        if ($ret == false) {
            return array('result' => 2101);
        }

        $data['out_trade_no'] = sprintf("%02X%06X%08X", intval($this->pid, 16), $product_id, $ret['logid']);
        return array('result' => 0, 'data' => $data);
    }

	function commit_trade()
	{
		$trade_no = req_get_param('out_trade_no');
		if (strlen($trade_no) != 16) {
			Log::write("Err Tradeno: $trade_no");
			return array('result' => 2102);
		}

		$productid = intval(substr($trade_no, 0, 8), 16);
		$logid = intval(substr($trade_no, 8, 8), 16);

		$sql = "select * from buy_log_table where log_id=$logid";
		$data = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ROW);
		if ($data == false) {
			Log::write("Err Sql: $sql");
			return array('result' => 2101);
		}

		$channel = intval(req_get_param('channel'));
		$fee = intval(req_get_param('total_fee')*100);
		if ($channel != 0x80000 && ($data['money_number'] - $fee > 100)) {
			return array('result' => 2101);
		}
		$cseq = mysql_escape_string(req_get_param('cseq'));
		$cuserid = mysql_escape_string(req_get_param('cuserid'));
		$exdata = mysql_escape_string(req_get_param('exdata'));
		$cotime =  time();
		
		$sql = "update buy_log_table set money_number=$fee, commit_time=$cotime, yeepay_trade_id=\"$cseq\", card_trade_id=$channel, buy_result=1 where log_id=$logid and buy_result != 1";
		if ($this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC,array())) {
			$this->noti_to_game_svr($trade_no, $channel);
		} else {
			Log::write($sql);
		}

		$items = mysql_escape_string($data['items']);
		$sql = "insert into t_buy_log(product_id, log_id, user_id, dst_user_id, count, money, trade_time, commit_time, channel, cseq, cuserid, state, items, exdata) values ($productid, $logid, {$data['user_id']}, {$data['dest_user_id']}, {$data['product_count']}, $fee, {$data['trade_time']}, $cotime, $channel, \"$cseq\", \"$cuserid\", 0, \"$items\", \"$exdata\");";
		$dsn = WDB_PDO::build_dsn("token_conf", "192.168.21.134", 3306);
		$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');
		if (!$db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC, array())) {
			Log::write("Err SQL: $sql");
		}
		return array('result' => 0);
	}

	function get_order_exdata()
    {
        $_order_id = req_get_param('order_id');
        $log_id = intval(substr($_order_id, 8, 8), 16);

        $sql = "SELECT money_number as price, extra_data FROM buy_log_table WHERE log_id = {$log_id}";
        $data = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
        $result = 0;
        if ($data == false) {
            $data = array();
            $result = 1001;
        }   
        else {
            $order_info = json_decode( urldecode( str_replace( "\\", "", $data[0]['extra_data'] ) ),true );
            $order_info['m'] = $data[0]['price'];
            $order_info['cu'] = 0;
            $order_info['od'] = $_order_id;

            $data = array();
            $data['extra_data'] = json_encode($order_info);
        }   

        return array('result' => $result, 'data' => $data);
    }   

	function get_order_base_info()
    {   
        $_order_id = req_get_param('order_id');
        $msgagent = req_get_param('msgagent');
        $log_id = intval(substr($_order_id, 8, 8), 16);

        $sql = "SELECT user_id, product_id, from_unixtime(trade_time) as time, money_number as price, extra_data".
            " FROM buy_log_table WHERE log_id = {$log_id}";
        $res = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
        if ($res == false) {
            $data = array();
            $result = 1001;
        }   
        else {
            $order_info = json_decode( urldecode( str_replace("\\", "", $res[0]['extra_data']) ), true );
            $order_info['m'] = $res[0]['price'];
            $order_info['cu'] = 0;
            $order_info['od'] = $_order_id;

            $data = array();
            $data['userid'] = $res[0]['user_id'];
            $data['ordertime'] = $res[0]['time'];
            $data['payfee'] = $res[0]['price'];

            $product_id = $res[0]['product_id'];
            switch($msgagent) {
            case "mmarket":
                $agent_name = "mobile_mm";
                break;
            case "mgamebase":
                $agent_name = "mobile_game";
                break;
            case "unipay":
                $agent_name = "unicom_woshop";
                break;
            case "dianxinlovegame":
                $agent_name = "telcom_game";
                break;
            case "dianxintianyi":
                $agent_name = "telcom_esurfing";
                break;
            default:
                $agent_name = "unicom_woshop";
                break;
            }
            $sql = "SELECT name as product_name, {$agent_name} AS agent_name".
                " FROM product_info_table WHERE id = {$product_id}";
            $res = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
            if ($res == false) {
                $data = array();
                $result = 1001;
            } else {
                $data['feename'] = $res[0]['product_name'];
                $data['serviceid'] = $res[0]['agent_name'];//计费点
                $data['extra_data'] = json_encode($order_info);
                $result = 0;
            }
        }   

        return array('result' => $result, 'data' => $data);
    }   


	function get_order_detail_info()
    {
        $_order_id = req_get_param('order_id');
        $log_id = intval(substr($_order_id, 8, 8), 16);

        $sql = "SELECT product_id, money_number as price, items, extra_data FROM buy_log_table WHERE log_id = {$log_id}";
        $rows = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);

        $result = 0;
        $data = array();
        if ($rows == false) {
            $result = 1001;
        }   
        else {
            $order_info = json_decode( urldecode( str_replace( "\\", "", $rows[0]['extra_data'] ) ),true );
            $order_info['m'] = $rows[0]['price'];
            $order_info['cu'] = 0;
            $order_info['od'] = $_order_id;
            $items = $rows[0]['items'];

            $product_id = $rows[0]['product_id'];
            $sql = "SELECT product_third_name, add_times, product_attr, extend_data".
                " FROM product_info_table WHERE id = {$product_id}";
            $rows = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
            if ($rows == false) {
                $result = 1001;
            } else {
                $data['product_third_name'] = $rows[0]['product_third_name'];
                $data['product_add_times'] = $rows[0]['add_times'];
                $data['product_attr_int'] = $rows[0]['product_attr'];
                $data['product_attr_string'] = $rows[0]['extend_data'];
                $data['product_items'] = $items;
                $data['extra_data'] = json_encode($order_info);
            }
        }   

        return array('result' => $result, 'data' => $data);
    }   

	function get_product_detail_by_third_name()
    {
        $product_third_name = req_get_param('third_name');

        $result = 0;
        $data = array();
//        $product_id = $rows[0]['product_id'];
        $sql = "SELECT id, name, price, third_price, items, add_times, product_attr, extend_data".
            " FROM product_info_table WHERE product_third_name = '{$product_third_name}'";
        $rows = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
        if ($rows == false) {
            $result = 1001;
        } else {
            $data['product_id'] = $rows[0]['id'];
            $data['product_name'] = $rows[0]['name'];
            $data['product_price'] = $rows[0]['price'];
            $data['product_third_price'] = $rows[0]['third_price'];
            $data['product_items'] = $rows[0]['items'];

            $data['product_add_times'] = $rows[0]['add_times'];
            $data['product_attr_int'] = $rows[0]['product_attr'];
            $data['product_attr_string'] = $rows[0]['extend_data'];
        }

        return array('result' => $result, 'data' => $data);
    }   

}
?>
