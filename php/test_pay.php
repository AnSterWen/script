<?php
require_once('data.php');
$url = 'http://185.26.28.109/platform/paycheck/apple/apple_pay.php';



echo  get_url_contents($url,$data,$method="get",$timeout=60);





function get_url_contents($url,$data,$method="get",$timeout=60) 
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    if('get' == strtolower($method))
    {
        $url = is_array($data) ? $url.'?'.http_build_query($data) : $url . '?' .$data;
        curl_setopt($ch, CURLOPT_URL, $url);
    }
    else
    {
        $data = is_array($data) ? http_build_query($data) : $data;
        curl_setopt($ch, CURLOPT_URL, $url);          #指定url的地址
        curl_setopt($ch, CURLOPT_POST, 1);            #指定post方法
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  #指定post发送数据,$data为数组
    }
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);#设置等待时间
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}  



echo "\n";
?>
