<?php
require_once 'service/lib/wdb_pdo.class.php';

define(RECHARGE_200, 200/6.21*100);
define(RECHARGE_500, 500/6.21*100);
define(RECHARGE_1000, 1000/6.21*100);
define(RECHARGE_2000, 2000/6.21*100);

define(START_MONTH, "2012-10");

function get_end_month()
{
    return date("Y-m", time());
}

function get_next_month($yearMonth)
{
    return date("Y-m", strtotime($yearMonth."-01") + 32*24*60*60);
}

$category = array('200RMB', 
                  '500RMB',
                  '1000RMB',
                  '2000RMB',
                 );
                 
$IseerPriceMap = array(
			"com.taomee.iseer.vipgold1" => 99,
			"com.taomee.iseer.vipgold2" => 199,
			"com.taomee.iseer.vipgold3" => 499,
			"com.taomee.iseer.vipgold4" => 999,
			"com.taomee.iseer.vipgold5" => 1999,
			"com.taomee.iseer.vipgold6" => 4999,
		);
        
$data = array();
/*
$endMonth = get_end_month();
echo $endMonth, "\n";
*/
$month = START_MONTH;
do
{
    $data[$month] = array();
    foreach ($category as $k => $v)
    {
        $data[$month][$v] = 0;
    } 
    $month = get_next_month($month);  
} while (strtotime($month."-01") < strtotime(get_end_month()."-31"));

//print_r($data);

$dsn = WDB_PDO::build_dsn('IAP_04', '10.1.1.28', 3306);
$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

foreach ($data as $k => $v) //$k = "2012-10", etc
{
    foreach ($v as $kk => $vv) // $kk = 200RMB, 1000RMB
    {
        $stat = array();
        $sql = "select userid, money, product_id from t_ios_receipt_succ where 
                date >= unix_timestamp('";
        $sql .= $k."-01 00:00:00') and date <  unix_timestamp('";
        $sql .= get_next_month($k)."-01 00:00:00')";
        //echo "sql: ", $sql, "</br>";
        $result = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
        foreach ($result as $kkk => $vvv)
        {
           
            if ($vvv['money'] == 0)
            {
                $vvv['money'] = $IseerPriceMap[$vvv['product_id']];
            }
            if (isset($stat[$vvv['userid']]))
            {
                $stat[$vvv['userid']] += $vvv['money'];
            }
            else
            {
                $stat[$vvv['userid']] = $vvv['money'];
            }
        }
        //echo "stat: </br>";
        //print_r($stat);
        //$sum = 0;
        foreach ($stat as $kkk => $vvv)
        {
            if ($vvv >= RECHARGE_200 && $vvv < RECHARGE_500)
            {
                $data[$k]['200RMB']++;
            }
            if ($vvv >= RECHARGE_500 && $vvv < RECHARGE_1000)
            {
                $data[$k]['500RMB']++;
            }
            if ($vvv >= RECHARGE_1000 && $vvv < RECHARGE_2000)
            {
                $data[$k]['1000RMB']++;
            }
            else if ($vvv >= RECHARGE_2000)
            {
                $data[$k]['2000RMB']++;
            }
        }
    }
}

echo "IseerApp:", "</br></br>";
foreach ($data as $k => $v)
{
    echo "$k recharge record:", "</br>";
    foreach ($v as $kk => $vv)
    {
        echo  "$kk: ", $vv, "   ";        
    }
    echo "</br></br>";
}
 
?>