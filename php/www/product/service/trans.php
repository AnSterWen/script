<?php
require_once 'lib/wdb_pdo.class.php';

$dsn = WDB_PDO::build_dsn('IAP_06', '10.1.1.28', 3306);
$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

$sql = 'select id, map_id, count from product_id_map_table';
$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);

$productlist = array();
foreach ($data as $v) {
	$productlist[$v['id']] = array($v['map_id'] => array('base' => $v['count']));
}

foreach ($productlist as $k => $v) {
	$sql = 'update product_info_table set items="'.mysql_escape_string(json_encode($v)).'" where id='.$k;
	$ret = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC);
}
print_r($productlist);
