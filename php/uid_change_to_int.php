<?php

function uid_change_to_int($channel_id,$user_id)
{
    $data = array('channel_id' => $channel_id,'key' => $user_id);
    ksort($data);
    $sign = '7af1ebd05e55fd2bbf196d40db01cedb';
    $signature = md5(http_build_query($data) . "&sign=" . $sign);
    $data['sign'] = $signature;
    $s_url = 'www.123.com';
    $a_result = get_url_contents($s_url, $data, 'get', 'json');
    return ($a_result['result'] == '0') ? intval($a_result['value']) : -1;
}

function get_url_contents($url,$data,$method="get",$data_type='var_export',$timeout=60) 
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



}  




?>
