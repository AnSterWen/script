<?php

$url = 'http://10.1.1.163/platform/logincheck/account_service.php?';
$param = array(
    'channel' => 1009,
    'extra_data' => '{"package":"aos"}',
    'game' => 'ago',
    'key' => 'd2d9a7e99ef11045f4714826b6b39aa3',
    'service' => 1016,
    'sess_id' => 'cAAyAFAAMgB5AGYAZQBwAEMASwBlAGwAMQBsAHYANAAyADQASAAxADcAZgBuAGMAaQA0AEwAUABpADEALwAxAGUASgBXACsAWgAyAC8AdwAyAEQAWQBpAFYAbAB6AGMAawBQAFAAQgBzAHYAMABRADkAcgBzAEcAWQBFAFgAYgAvAE0ANQA2AGwAWABMAG4AKwAyAHcAYQBKADMAbgBMAC8AdwBaAC8ANwA0AFEATwArAHAALwAvAG0AUQBKAGkAdAArAFoAYwBQAHYAQQBiAHcASQBUAFUAbgBmADAANQBhAHYAOABwAHIAMgBUAHEANQBSAHIAawBnAFAATAB1AHEAZwA3AEIAagBhAEQAZwB1AGwAeQBkAFEAegB4ADUAbABBAHMAawBBAGcAPQA9AA==',
    'user_id' => 14477051,
    'user_name' => 'Guest14477051',
    'sign' => '320af8aca3d268c0341abb17bbe96d77',
    'sign_type' => 'MD5'
);

$str = http_build_query($param);
$url .= $str;
echo $url;
echo "\n";
