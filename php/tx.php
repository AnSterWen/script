<?php
$url = 'http://msdktest.qq.com/auth/verify_login';


$ch = curl_init();
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
$qs =  array(
    'appid' => 1104998434,
    'timestamp' => time(),
    'sig' => md5('NFUeVmW0wLd82XSF'.time()),
    'encode' => 1,
    'openid' => '2599288BC21B15AC761D5A88ABCEA803',
);
$query_string = array();
foreach ($qs as $key => $value)
{
    array_push($query_string, rawurlencode($key) . '=' . rawurlencode($value));
}
$query_string = join('&', $query_string);
$url = $url . '?' . $query_string;
$data = array(
'openid' => '2599288BC21B15AC761D5A88ABCEA803',
'openkey' => 'A6038F334D8BB0EB9F952AA636AB1F71',
'appid' => '1104998434',
//'version' => 'PHP SDK v1.0.0',
'userip' => '',
); 
$data = json_encode($data);
print_r($data);
curl_setopt($ch, CURLOPT_URL, $url);          #指定url的地址
curl_setopt($ch, CURLOPT_POST, 1);            #指定post方法
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  #指定post发送数据,$data为数组
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);#设置等待时间
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);
curl_close($ch);
echo json_encode($output);
echo "\n";
?>
