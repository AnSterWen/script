<?php
require_once 'service/lib/wdb_pdo.class.php';
echo "begin:"
$dsn = WDB_PDO::build_dsn('IAP_02', '10.1.1.28', 3306);
$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

$result = array();
$sql = "select userid from t_ios_receipt_succ where product_id = 'com.taomee.MoleWorld.sale0' and 
 date >= unix_timestamp('2013-04-04 00:00:00') and date <= unix_timestamp('2013-04-06 00:00:00')";
//$sql = "select user_id, money_number, commit_time from buy_log_table where buy_result=1";
$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);

echo "original data: </br>";
print_r($data);

$stat = array('6'  => array(),
	'30' => array(),
    '68' => array(),);
/*
$temp = array();
foreach ($data as $k => $v)
{
	foreach ($v as $kk => $vv)
	{
		if (isset($temp[$vv]))
		{
			$temp[$vv]++;
		}
		else
		{
			$temp[$vv] = 1;
		}
	}	

}
 */
echo "</br>";
print_r($temp);
/*
$stat = array();
foreach ($data as $v) {
	$day = date('Y-m-d', $v['commit_time']);
	if (!isset($stat[$day]))
		$stat[$day] = array($v['user_id'] => array());
	$stat[$day][$v['user_id']][] = $v['money_number'];
}
ksort($stat);
foreach ($stat as $day => $v) {
	$ucnt = count($v);
	$pcnt = 0;
	$fee = 0;
	foreach ($v as $u) {
		$pcnt += count($u);
		$fee += array_sum($u);
	}
	$fee = $fee / 100.;
	echo $day.":\t人数($ucnt) 人次($pcnt) 金额($fee)<br/>";
}
*/
