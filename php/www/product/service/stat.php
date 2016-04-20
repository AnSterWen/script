<?php
ini_set("memory_limit","80M");
require_once 'lib/wdb_pdo.class.php';
require_once 'config/iapconf.php';
global $price_config;

$dsn = WDB_PDO::build_dsn('IAP_04', '10.1.1.28', 3306);
$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

$result = array();
$sql = "select uuid, date, product_id  from t_ios_receipt_succ";
$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
foreach ($data as $v) {
	$result[] = array('u' => $v['uuid'], 't' => $v['date'], 'm' => $price_config['com.taomee.seer'][$v['product_id']]);
}
print_r(json_encode($result));
