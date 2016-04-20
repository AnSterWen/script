<?php
ini_set("memory_limit","80M");
require '../service/lib/wdb_pdo.class.php';
require '../svr/config/iapconf.php';

$dbname = $_GET['db'];
$stime_str = $_GET['stime'];
$etime_str = $_GET['etime'];
$stime = strtotime($stime_str); // eg. 2013-04-27
$etime = strtotime($etime_str); // eg. 2013-04-28
$type = $_GET['type']; // json or ''
$stat = array_key_exists('stat', $_GET); // json or ''
$card_trade_id = $_GET['card_trade_id'];

$GROUP_FILTER = 0xffff0000;
$GROUP_FILTER_STRING = '0xffff0000';

function format_date ($ts) {
	return date('Y-m-d H:i:s', $ts);
}

function format_card_trade_desc ($card_trade_id) {
	global $GROUP_FILTER;
	$card_trade_id = intval($card_trade_id);
	switch ($card_trade_id & $GROUP_FILTER) {
	case 0x0:
		$card_provider = '阿里';
		break;
	case 0x10000:
		$card_provider = 'MMCARD';
		break;
	case 0x20000:
		$card_provider = '易宝';
		break;
	case 0x30000:
		$card_provider = 'MYCARD';
		break;
	case 0x40000:
		$card_provider = 'XMPAY';
		break;
	case 0x50000:
		$card_provider = '奇虎';
		break;
	case 0x60000:
		$card_provider = 'UC';
		break;
	case 0x70000:
		$card_provider = '机锋';
		break;
	case 0x80000:
		$card_provider = '当乐';
		break;
	case 0x80001:
		$card_provider = '当乐';
		break;
	default:
		$card_provider = '';
		break;
	}
	if ($card_provider) {
		return "（" . $card_provider . "）";
	}
	return '';
}

function format_card_trade_id ($card_trade_id) {
	return sprintf('0x%x', $card_trade_id) . format_card_trade_desc($card_trade_id);
}

function format_card_trade_id_group ($card_trade_id) {
	global $GROUP_FILTER;
	global $dbname;
	global $type;
	global $stime_str;
	global $etime_str;

	$card_trade_id_str = sprintf('0x%x', ($card_trade_id & $GROUP_FILTER));
	$url = $_SERVER["SCRIPT_NAME"] . "?db=$dbname&type=$type&stime=$stime_str&etime=$etime_str&card_trade_id=$card_trade_id_str";
	return '<a target="_blank" href="' . $url . '">' . $card_trade_id_str . format_card_trade_desc($card_trade_id) . '</a>';
}

function format_money_sum ($value) {
	return $value;
}

$doctitles = array(
	'IAP_00'=>'测试',
	'IAP_01'=>'摩尔卡丁车',
	'IAP_04'=>'赛尔号',
	'IAP_05'=>'摩尔庄园',
	'IAP_06'=>'斗转龙珠',
);
$doctitle = $doctitles[$dbname];
if (!$doctitle) $doctitle= '不明数据库';

if ($dbname && $stime && $etime) {
	$dsn = WDB_PDO::build_dsn($dbname, '10.1.1.28', 3306);
	$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

	if ($stat) {
		$sql = "select card_trade_id, sum(money_number) as value from buy_log_table where trade_time >= '$stime' and trade_time < '$etime' and buy_result=1 group by (card_trade_id & $GROUP_FILTER_STRING)";
		$fields = array(
			array('card_trade_id', 'format_card_trade_id_group'),
			array('value', 'format_money_sum'),
			);
	} else {
		$sql = "select * from buy_log_table where trade_time >= '$stime' and trade_time < '$etime' and buy_result=1";
		if ($card_trade_id) {
			$pre = substr($card_trade_id, 0, 2);
			if ($pre=='0x' || $pre=='0X') {
				$card_trade_id = hexdec($card_trade_id);
			} else {
				$card_trade_id = intval($card_trade_id);
			}
			$sql .= " and (card_trade_id & $GROUP_FILTER_STRING)=$card_trade_id";
		}
		$fields = array(
			'log_id',
			'user_id',
			'product_id',
			array('card_trade_id', 'format_card_trade_id'),
			'money_number',
			array('trade_time', 'format_date'),
			array('commit_time', 'format_date'),
			// 'buy_result',
			'items',
			);
	}
	$response = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);

	if ($type=='json') {
		header('Content-Type: application/json');
		echo json_encode($response);
	} else {
		header('Content-Type: text/html');
		$rows = $response;
		include('show_table.php');
	}
} else {
	$response = array(
		'ok'=>false,
		'args'=>array(
			'product_id'=>$product_id,
			'stime'=>$stime,
			'etime'=>$etime,
			'type'=>$type,
			),
		'example'=>'abuy_stat.php?db=IAP_06&stime=2013-04-26&etime=2013-04-28',
		);

	header('Content-Type: application/json');
	echo json_encode($response);
}

