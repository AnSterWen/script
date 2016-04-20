<?php
require_once ("wdb_pdo.class.php");

$dsn = WDB_PDO::build_dsn('token_conf', '192.168.21.134', 3306);
$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

$result = '';
if (isset($_REQUEST['MyCardID'])) {
	$cardid = mysql_escape_string($_REQUEST['MyCardID']);
	$sql = "select * from t_mycard_ingame_history where cardid=\"$cardid\"";
	$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ROW);
	if ($data != false) {
		$mycardno = strlen($data['mycard_no']) == 0 ? $data['cardid'] : $data['mycard_no'];
		$result .= $data['cardid'].','.$data['mycard_custid'].','.$mycardno.','.sprintf('%08X%08X', $data['product_id'], $data['logid']).','.date('Y-m-d H:i:s', $data['trade_time']).'<BR>';
	}
} else if (isset($_REQUEST['StartDate']) && isset($_REQUEST['EndDate'])) {
	$sdate = strtotime($_REQUEST['StartDate']);
	$edate = strtotime($_REQUEST['EndDate']) + 86400;
	$sql = "select * from t_mycard_ingame_history where trade_time >= $sdate and trade_time <=$edate;";
	$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
	if ($data != false) {
		foreach ($data as $d) {
			$mycardno = strlen($d['mycard_no']) == 0 ? $d['cardid'] : $d['mycard_no'];
			$result .= $d['cardid'].','.$d['mycard_custid'].','.$mycardno.','.sprintf('%08X%08X', $d['product_id'], $d['logid']).','.date('Y-m-d H:i:s', $d['trade_time']).'<BR>';
		}
	}

}

echo $result;
