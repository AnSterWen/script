<?php
require_once 'service/lib/wdb_pdo.class.php';
$Id = $_GET['pid'];

$dsn = WDB_PDO::build_dsn("IAP_$Id", '10.1.1.28', 3306);
$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

$result = array();
$sql = "select user_id, money_number, commit_time from buy_log_table where buy_result=1";
$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
$stat = array();
foreach ($data as $v) {
	$day = date('Y-m-d', $v['commit_time']);
	if (!isset($stat[$day]))
		$stat[$day] = array($v['user_id'] => array());
	$stat[$day][$v['user_id']][] = $v['money_number'];
}
ksort($stat);
$result = array();
foreach ($stat as $day => $v) {
	$ucnt = count($v);
	$pcnt = 0;
	$fee = 0;
	foreach ($v as $u) {
		$pcnt += count($u);
		$fee += array_sum($u);
	}
	$fee = $fee / 100.;
	$result[$day] = array('renshu' => $ucnt, 'renci' => $pcnt, 'fee' => $fee);
}
print_r(json_encode($result));

