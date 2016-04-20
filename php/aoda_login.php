<?php
$url = 'http://52.26.98.212/platform/logincheck/account_service.php?';
$data = array(
    'service' => 1016,
    'channel' => 10000,
    'name' => 'JF888',
    'passwd' => md5('123456'),
//    'sign' => '93dbaa7aa33c8e53ebdefe1289ce6e3b',
    'sign_type' => 'MD5',
);
$sign = make_md5_sign($data);
$data['sign'] = $sign;
$url .= http_build_query($data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
$output = curl_exec($ch);
curl_close($ch);
echo $output;
echo "\n";

function make_md5_sign($params)
{       
    /* 过滤掉参数sign和sign_type */
    $arg = array();
   foreach ($params as $key => $val) 
   {
        if ($key == 'sign' || $key == 'sign_type' || $key == 'PHPSESSID' || $key == '__utma' || $key == '__utmz') {
           continue;
       }
       $arg[$key] = $val;
   }   
       
   /* 参数按ASCII排序 */
   ksort($arg);
   $str = '';
   /* 将参数用&连起来 */
   foreach ($arg as $key => $val) {
       $str .= $key . '=' . $val . '&';
   }

   /* 最后加上key参数 */
   $channel = intval($params['channel']);
   //$key = get_channel_key($channel);
   $key = '54f69280ab3ddf3cbdf686f3838600af';
//   $key = '2d30c589044ce696e72de879f5f990ab';
   $str .= "key=$key";

   return md5($str);
}
