<?php
$ch = curl_init();
$url = "http://10.1.1.238/platform/www/logincheck/account_service.php";
$data = array(
    'service' =>'1016',
    'game' => 'ahero',
    'channel' => '10000',
    'user_id' => '123',
    'sess_id' => '123',
    'app_id' => '123',
    'app_key' => '123',
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output = curl_exec($ch);
curl_close($ch);
echo $output . "\n";
exit();
?>
