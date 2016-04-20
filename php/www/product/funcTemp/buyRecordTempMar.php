<?php
require_once 'service/lib/wdb_pdo.class.php';

define(RECHARGE_LEVEL, 1000/6.21*100);

$dsn = WDB_PDO::build_dsn('IAP_02', '10.1.1.28', 3306);
$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');


$stat = array(); // userid => money
$product_price_map = array('com.taomee.MoleWorld.sale0' => '6',
                           'com.taomee.MoleWorld.sale1' => '30',
                           'com.taomee.MoleWorld.sale2' => '68',
                          );

$sql = "select userid, money from t_ios_receipt_succ where 
        date >= unix_timestamp('2013-03-01 00:00:00') and 
        date <  unix_timestamp('2013-04-01 00:00:00')";

$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
//print_r($data);

foreach ($data as $k => $v)
{
    if (isset($stat[$v['userid']]))
    {
        $stat[$v['userid']] += $v['money'];
    }
    else
    {
        $stat[$v['userid']] = $v['money'];
    }
}
/*
print_r($stat);
echo "</br>";
*/
$result = array();  
foreach ($stat as $k => $v)
{
    if ($v >= RECHARGE_LEVEL)
    {
        array_push($result, $k);
    }
}

echo "recharge >= 1000 RMB's players in March: </br>";
foreach ($result as $k => $v)
{
    echo $v, "</br>";
}
  
?>