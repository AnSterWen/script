<?php
define('DS', DIRECTORY_SEPARATOR);
require_once dirname(__FILE__) . DS . 'config' . DS . 'setup.inc.php';
require_once dirname(__FILE__) . DS . 'config' . DS . 'config.php';
require_once "lib/wdb_pdo.class.php";
require_once "icomm_card_proto.php";

function noti_to_game_svr($config, $db, $logid, $hid, $data, $cid = 0)
{
	$proto = new Cicomm_card_proto($config['ip'], $config['port']);
	$items = json_decode($data['items'], true);
	if (!is_array($items)) {
		$items = json_decode($items, true);
	}
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
	print_r($ret);
	if ($ret['result']== 0) {
		$sql = "update buy_log_table set noti_count=100, last_noti_time=".time()." where log_id=".$logid;
		$this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC);
	}

}


foreach ($product_config as $pid => $product) {
	if (isset($product['noti'])) {
		$dsn = WDB_PDO::build_dsn($product['db']['name'], $product['db']['host'], $product['db']['port']);
		$db = new WDB_PDO($dsn, $product['db']['user'], $product['db']['pass'], 'latin1');

		$noti_time = array(
			6 => 7*24*3600,	
			5 => 3*24*2600,
			4 => 24*3600,
			3 => 8*3600,
			2 => 3600,
			1 => 600,
			0 => 0,
		);

		foreach ($noti_time as $count => $seconds) {
			$tm = time() - $seconds;
			$sql = "select log_id, product_id, user_id, dest_user_id, items, card_trade_id from buy_log_table where buy_result=1 and noti_count = $count and last_noti_time < $tm;";
			$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
			if ($data) {
				foreach ($data as $d) {
					$logid = $d['log_id'];
					$sql = "update buy_log_table set noti_count=$count+1, last_noti_time=".time()." where log_id=$logid and noti_count=$count";
					if ($db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC)) {
						$hid = intval(sprintf("%02X%06X", $pid, $d['product_id']), 16);
						noti_to_game_svr($product['noti'], $db, $logid, $hid, $d, $d['card_trade_id']);
					} else {
						print_r($sql);
					}
				}
			}
		}

	}
}

