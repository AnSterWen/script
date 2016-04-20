<?php
ini_set("memory_limit","80M");
require_once 'lib/wdb_pdo.class.php';
require_once 'config/iapconf.php';
global $price_config;
$price = $price_config['com.taomee.MoleWorld'];

$dsn = WDB_PDO::build_dsn('IAP_02', '10.1.1.28', 3306);
$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

$sdate = strtotime('2012-12-24');
$edate = strtotime('2012-12-27');
$sql = "select * from t_ios_receipt_succ where date >= $sdate and date < $edate";
$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
$stat = array();
foreach ($data as $log) {
	$fee = $price[$log['product_id']];
	if (isset($stat[$log['userid']])) {
		$stat[$log['userid']]['count'] += 1;
		$stat[$log['userid']]['money'] += $fee;
	} else {
		$stat[$log['userid']] = array('count' => 1, 'money' => $fee);
	}
}
print_r($stat);

$maxcount = 0;
$maxfee = 0;
$max1 = array();
$max2 = array();
foreach ($stat as $u => $d) {
	if ($d['count'] > $maxcount) {
		$max1 = array($u);
		$maxcount = $d['count'];
	} else if ($d['count'] == $maxcount) {
		$max1[] = $u;
	}

	if ($d['money'] > $maxfee) {
		$max2 = array($u);
		$maxfee = $d['money'];
	} else if ($d['money'] == $maxfee) {
		$max2[] = $u;
	}
}

print_r($maxcount);
echo "\n";
print_r($maxfee);
echo "\n";
print_r($max1);
print_r($max2);
