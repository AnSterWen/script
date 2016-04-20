<?php
require_once("functions.php");
$url = 'http://185.26.28.97/platform/account/account_service.php';//account的url
$keystr = '2d30c589044ce696e72de879f5f990ab'; //生成签名时的秘钥
$data = array(
    'service' => 10001,
    'channel' => 802,
    'name' => 'JF888',
    'passwd' => md5('123456'),
    'sign_type' => 'MD5',
);
$sign = make_md5_sign($data);
$data['sign'] = $sign;
$output =  get_url_contents($url, $data, 'get', 'json');
echo $output;
echo "\n";
