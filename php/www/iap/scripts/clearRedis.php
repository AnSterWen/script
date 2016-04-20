<?php
error_reporting(0);
date_default_timezone_set('Asia/Taipei');

require_once '../header.php';

$redis = new RedisServer('10.1.23.241', 6379);
$ipcount = $redis->hGetAll('IAP:TRADE:COUNT');
foreach ($ipcount as $k => $v) {
	$ka = split(':', $k);
	$day = date('YmdH');
	if ($ka[1] < $day) {
		$redis->hDel("IAP:TRADE:COUNT", $k);
		Log::write("IAP IP: $k => $v", 1);
	}
}

$redis = new RedisServer('10.1.23.241', 6380);
$ipcount = $redis->hGetAll('IAP:TRADE:COUNT');
foreach ($ipcount as $k => $v) {
	$ka = split(':', $k);
	$day = date('YmdH');
	if ($ka[1] < $day) {
		$redis->hDel("IAP:TRADE:COUNT", $k);
		Log::write("IAP IP: $k => $v", 1);
	}
}
