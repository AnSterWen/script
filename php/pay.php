<?php
$ch = curl_init();
$url = "http://119.29.108.239/platform/paycheck/txpay/tx_pay.php";
$data = array(
    'tradeNo' => '0801388400001192',
    'saveNum' => 1980,
    'extendInfo' => 0,
    'accessToken' => '4E03697C9F317C1351C4716DCC6B2FBB',
    'userId' => '9FB07CA304171E59A04A6A875609B0F0',
    'platform' => 2,
    'provideState' => -1,
    'pfKey' => '9a364d8ee6a11db6b761ff27b17a515c',
    'pf' => 'desktop_m_qq-2037-android-2037-qq-1104998434-9FB07CA304171E59A04A6A875609B0F0',
    'zoneId' => '1_1451309568',
    'payChannel' => 2,
    'payToken' => 'A29B1CC27674342F190ED6B277DA3143'
);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output = curl_exec($ch);
curl_close($ch);
echo $output;
echo "\n"
?>
