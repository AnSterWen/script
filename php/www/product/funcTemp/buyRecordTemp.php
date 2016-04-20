<?php
require_once '../service/lib/wdb_pdo.class.php';

$dsn = WDB_PDO::build_dsn('IAP_02', '10.1.1.28', 3306);
$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

//var_dump($db);
$product = array('com.taomee.MoleWorld.sale0', 
                 'com.taomee.MoleWorld.sale1', 
                 'com.taomee.MoleWorld.sale2',);
$stat = array('6'  => array(),
              '30' => array(),
              '68' => array(),
             );
$product_price_map = array('com.taomee.MoleWorld.sale0' => '6',
                           'com.taomee.MoleWorld.sale1' => '30',
                           'com.taomee.MoleWorld.sale2' => '68',
                          );
//print_r($product);    
             
foreach ($product as $k => $v)
{
    //print_r($v);
    //echo "</br>";
    $sql = "select userid from t_ios_receipt_succ where product_id = '";
    $sql .= $v . "' and date >= unix_timestamp('2013-04-12 00:00:00') and ";
    $sql .= "date < unix_timestamp('2013-04-15 00:00:00')";
    //echo $sql, "</br>";
    $data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
    //print_r($data);
    
    $temp = array();
    foreach ($data as $kk => $vv)
    {
        foreach ($vv as $kkk => $vvv)
        {
            if (isset($temp[$vvv]))
            {
                $temp[$vvv]++;
            }
            else
            {
                $temp[$vvv] = 1;
            }
        }
    }
    
    foreach ($temp as $kk => $vv)
    {
        if (!is_array($stat[$product_price_map[$v]][$vv]))
        {
            $stat[$product_price_map[$v]][$vv] = array();
        }
    }
    //print_r($temp);
    
    foreach ($temp as $kk => $vv)
    {
        array_push($stat[$product_price_map[$v]][$vv], $kk);
    }
    //usort($stat, 'my_sort');
    //echo "清明节期间", $stat[$product_price_map[$v]], "元的充值记录:", "</br>";
}

foreach ($product as $k => $v)
{
    echo "Recharge record of ", $product_price_map[$v], " RMB:</br>";
    foreach ($stat[$product_price_map[$v]] as $kk => $vv)
    {
        echo $kk, ":</br>";
        foreach ($vv as $kkk => $vvv)
        {
            echo $vvv, ", ";
        }
        echo "</br></br></br>";
    }
    echo "</br></br></br>";
}             

/*
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

function my_sort($a, $b)
{
    $k1 = 0;
    if (is_array($a))
    {
        foreach ($a as $k => $v)
        {
            $k1 = $k;    
        }
    }
    $k2 = 0;
    if (is_array($b))
    {
        foreach ($b as $k => $v)
        {
            $k2 = $k;
        }
    }
    return $k1 > $k2 ? 1 : -1;
}
