<?php
ini_set("memory_limit","80M");
require '../service/lib/wdb_pdo.class.php';
require '../svr/config/iapconf.php';

$product_price = array(
	'com.taomee.MoleWorld.sale0'=>6,
	'com.taomee.MoleWorld.sale5'=>30,
	'com.taomee.MoleWorld.sale1'=>68,
	'com.taomee.MoleWorld.sale4'=>98,
	'com.taomee.MoleWorld.sale6'=>163,
	'com.taomee.MoleWorld.sale2'=>328,
	'com.taomee.MoleWorld.sale3'=>648,
	);


$dbname = $_GET['dbname']; // IAP_02

$app = $_GET['app']; // com.taomee.MoleWorld
global $price_config;
$price = $price_config[$app];

$stime = strtotime($_GET['stime']); // eg. 2013-04-27
$etime = strtotime($_GET['etime']); // eg. 2013-04-28
$type = $_GET['type']; // json or ''


if ($dbname && $stime && $etime && $price) {
	$dsn = WDB_PDO::build_dsn($dbname, '10.1.1.28', 3306);
	$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

	$response = array();

	// get products id
	$sql = "select distinct product_id from t_ios_receipt_succ order by product_id";
	$products = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
	foreach ($price as $product_id=>$fee) {
		$sql = "select userid from t_ios_receipt_succ where product_id = '$product_id' and date >= '$stime' and date < '$etime'";
		$records = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
		$statistic_on_userid = array();
		foreach ($records as $record) {
			$userid = $record['userid'];
			$statistic_on_userid[$userid] += 1;
		}
		$statistic = array();
		foreach ($statistic_on_userid as $userid=>$count) {
			$userids = $statistic[$count];
			if (is_null($userids)) $statistic[$count] = $userids = array();
			//array_push($userids, $userid);
			array_push($statistic[$count], $userid);
		}
		ksort($statistic);
		$response[] = array(
			'product'=>$product_id,
			'fee'=>$fee,
			'sql'=>$sql,
			'statistic'=>$statistic,
			);
	}

	if ($type=='json') {
		header('Content-Type: application/json');
		echo json_encode($response);
	} else if ($type=='html') {
		header('Content-Type: text/html');
		echo '<html><head>';
		echo <<<htmlStyle
<style type="text/css">
span.user {
margin: 2px;
padding: 2px;
border: 1px solid #cdcdcd;
border-radius: 2px;
background-color: #eee;
display: inline-block;
min-width: 90px;
text-align: center;
}
div.product {
	background-color: #dfdfdf;
}
</style>
htmlStyle;
		echo '</head><body>';
		foreach ($response as $item) {
			echo '<div class="product">';
			echo '<h1>' . $item['product'] . '(费用: ' . $item['fee'] . ')</h1>';
			echo '<div class="statistic">';
			foreach ($item['statistic'] as $count=>$userids) {
				echo '<h3>' . $count . '次(' . count($userids) . '人)</h3>';
				echo '<div class="users">';
				echo '<span class="user">';
				echo join($userids, '</span>,<span class="user">');
				echo '</span>';
				echo '</div>';
			}
			echo '</div>';
			echo '</div>';
		}
		echo '</body></html>';
	} else if ($type=='text') {
		header('Content-Type: text/plain');
		foreach ($response as $item) {
			echo $item['product'] . ":\n";
			foreach ($item['statistic'] as $count=>$userids) {
				echo $count . ":\n";
				echo join($userids, ', ');
				echo "\n";
			}
			echo "\n";
		}
	} else {
		foreach ($response as $item) {
			$rmb = $product_price[$item['product']];
			echo 'Recharge record of ' . $rmb . ' RMB:<br>';
			foreach ($item['statistic'] as $count=>$userids) {
				echo $count . ':<br>';
				echo join($userids, ', ');
				echo ', ';
				echo '<br>';
				echo '<br>';
				echo '<br>';
			}
			echo '<br>';
			echo '<br>';
			echo '<br>';
		}
	}
} else {
	$response = array(
		'ok'=>false,
		'args'=>array(
			'db'=>$dbname,
			'price'=>$price,
			'stime'=>$stime,
			'etime'=>$etime,
			'type'=>$type,
			),
		'example'=>'imole_stat2.php?dbname=IAP_02&app=com.taomee.MoleWorld&stime=2013-04-26&etime=2013-04-28&type=json',
		);

	header('Content-Type: application/json');
	echo json_encode($response);
}

