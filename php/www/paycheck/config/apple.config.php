<?php
require_once (dirname(__FILE__) . '/common.config.php');

define('IOS_RECEIPT_MD5_TAIL', 'a8898beb143a4b0d46fc8259a2ac6717');
define('USD_EXCHANGE_RATE', 6.2);

define('APPLE_SANDBOX_CHECK_URL', 'https://sandbox.itunes.apple.com/verifyReceipt');
define('APPLE_ITUNES_CHECK_URL', 'https://buy.itunes.apple.com/verifyReceipt');
define('IAP_MAX_CHECK_COUNT', 2);
define('IAP_APP_STORE_CHANNEL_ID', 32);//appstore支付渠道编码

define('ERR_OK', '10000');
define('ERR_SYS_ERR', '10001');
define('ERR_WRONG_SIGN', '10002');
define('ERR_INVALID_PARAMS', '10003');
define('ERR_APPLE_SYSERR', '10004');
define('ERR_INVALID_RECEIPT', '10005');
define('ERR_REPEATED_CHECK', '10006');
define('ERR_HAS_ADD_ITEM', '10007');
define('ERR_ADD_ITEM_FAILED', '10008');
define('ERR_IS_SAND_BOX', '10009');
define('ERR_CLEAR_RECEIPT', '10119');// 验证处理错误，请清理小票



//统计游戏ID映射
$g_stat_game_map = array(
    //ahero
    82 => 616,
    );

$g_game_info_map = array(
    // 台湾ihero
    'tw.com.taomee.reverseworld' => array(
        'game_id' => 616, // 台湾IOS
        'db_postfix' => '08', // 数据库后缀
    ),  
);

// 落统计汇率，例如台湾AHERO，将新台币转换成美元
$g_appstore_exchange_rate = 0.03;

?>
