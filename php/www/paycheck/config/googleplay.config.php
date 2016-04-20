<?php
require_once (dirname(__FILE__) . '/common.config.php');

define('LOG_PREFIX', 'googleplay/googleplay_pay_');

global $g_version;
if ($g_version === 'release') {
    //IP forbidden white list
    $g_white_list = array();
} else {
    //IP forbidden white list
    $g_white_list = array();
}

// googleplay支付回调配置
$g_googleplay_package_config = array(
    'tw.com.taomee.jfyzz' => array(
        'public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnXQxnlstRgtzRzigItXwJUss/6ZI0isN6+z4tYGmUiaDxtzKS4j4bM4n9399leaHW1XEFY1+ql4FmdIToEq/EaTt0OMa06C6DLnWenp17KDq691Hm9ZF7942RnuM7S3g34cP71+2ahPmPCr/AzcP69cRGp0slN5RZSi3cdQt9dsPnf8jUIVOx2Zm4s+VgCQLuIIzfylF21pghoMKJnV5c6CY57ZbxFYKdbQJx7puP8W1goj4KoZh2whYOR05Wzl3tGYbLKwzGV3yxN7VxjuXvFd381hzwpdH6pmX4eTGPAJaeHo1Tbs8FGcHtSeISDTeM70kaFE8E5BmDQMg8eEYiQIDAQAB',
        'pay_channel' => 'GOOGLE_PLAY_HK',
    ),
    'tw.com.taomee.jfyzz1' => array(
        'public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAhL+NUkSUptKYmeb2LGJ/PdDkTdqZ5JmE/YsOfpy2v5vfvgAH2L2td1Eaq3VNcT93G3Zo65O8xgmWGymMDBFlSQ0GCvoJ/5lY4ylwN6Wuu7ETpPbP2HY1WReO4Vu183nqO6K/DUY+l58RThl16NFjbGeNzsc0qPr5UjYMlZ0jV2ovAlkgkOtF1krfPyA1eM3xALbwdJ2xlP+xnst5FfKOk/0Oqw2zOtpKXfXkU9kIXs6Im6lG+C92DBxZXkZ6H0xJrFF3HllY9iOFmPicWfz5ZQ2j5664nA66TslgS5QcQ4LPGIwGx5lTXUj5Ts7mb8HMSS4shVDwahGK4rFhAcoMLQIDAQAB',
        'pay_channel' => 'GOOGLE_PLAY',
    ),
    'tw.com.taomee.jfyzz2' => array(
        'public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApgCxXv2bVJOiheOuRmtfsY4lkOhUQXHm+1DRfqJuR1YKRX5IRYx8etsKkeWvRluFUoyQiJm5K1lAuVBdFEgfkfIt4C+zwe7esq1JuGVoqVEzgjJeIEy22pKjntE7//ZYZC70K9TmgQitwGLA5xBy+VkYRePigfqFZVwm0sDsjNv1D7oppBNBYDYASgpXZIwC4QZOL496V41t9gzKo6SAiWYQ64w9NqnRe/VRpOWlndzPdMpWYdqiYrvSoI3l5UkxE+vUn2eH9eStmGkhd3xM1nXdQCmuFy+XRNyLEUgHzrV7bnR79pnvK1dGTWDZ+j6ShFPEcvlQKbIPSSBTb51DxwIDAQAB',
        'pay_channel' => 'GOOGLE_PLAY_TAIWAN',
    ),
    'tw.com.taomee.jfyzz3' => array(
        'public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAie8SN4whayYZMzSOol5bBV5KzNxroSEDua1zdGsPVuTzHQ1aYUVNRvcuumX2R0Y5LiD4NFpsppbGpamFRpAPkgurL903lCPOVxS9NswkZzvEs7Bs3la/wlPk5ZtQXRdCR6gsgvhmfd+MmUqA1kU3VB5ttLeEABpi0365Ekemctjgs5rA9pTyDCmiJNVIDdRu0cHZs8FwMbELPVdmaboyFECArMtMRcgo4PYvF9UwC9I2p0nU2pleLANqMt7xotCzH99y642yxXGwj8JBkpN9U3Jm2+LPzV3Pzkm/ejfg6zjh5MQ+DCPiQnhdN79rY2xduxsAumjndfC7Klo3w/hj9wIDAQAB',
        'pay_channel' => 'GOOGLE_PLAY_TW3',
    )
);

// 落统计汇率，例如台湾AHERO，将新台币转换成美元
$g_googleplay_exchange_rate = 0.03;
?>
