<?php

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

//////////////////////////////
function make_md5_sign($params)
{       
   global $keystr;
   $arg = array();
   foreach ($params as $key => $val) 
   {
       if ($key == 'sign' || $key == 'sign_type')
       {
           continue;
       }
       $arg[$key] = $val;
   }   
       
   ksort($arg);
   $str = '';
   foreach ($arg as $key => $val) 
   {
       $str .= $key . '=' . $val . '&';
   }

   $channel = intval($params['channel']);
   $str .= "key=$keystr";
   return md5($str);
}











?>
