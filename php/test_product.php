<?php
require_once('functions.php');
$url = 'http://185.26.28.109/platform/product/service/router.php';
$sign = md5("cmd=0819&third_name=rw1&key=taomee");
$data = array(
    'cmd' => '0819',
    'third_name' => 'rw1',
    'sign' => $sign,
);

echo get_url_contents($url, $data, 'post', 'json');
