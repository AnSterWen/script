<?php
$g_version = 'release';

// timezone
date_default_timezone_set('Asia/Taipei');

// log directory
define('LOG_DIR', dirname(dirname(__FILE__)) . '/log/');

// payservice返回的错误
define('UNKNOWN_ERROR', 1);
define('CREATE_SOCKET_ERROR', 2);
define('SOCKET_CONNECT_ERROR', 3);
define('SEND_DATA_ERROR', 4);
define('SEND_DATA_LENGTH_ERROR', 5);
define('RECV_DATA_ERROR', 6);
define('MD5_UNEQUAL_ERROR', 7);
define('NOT_SUPPORT_TYPE', 8);
define('WRONG_RECV_MSG', 9);

// 支付渠道对应的ID
$g_pay_channel = array(
    'googleplay'    => 1003,
    'apple'         => 32,
    'mycard'        => 1005, // 台湾MyCard充值
    'mycardweb'     => 1005, // 台湾MyCardWeb充值
    'mol'           => 1006, // 台湾MOL充值
    'molweb'        => 1006, // 台湾MOLWeb充值
);

// 统计排除的用户ID
$g_exclude_users = array();

// 首充值配置
define('PAY_MONTH_CARD', 2); //月卡属性值
define('PAY_FIRST_INCLUDE_GIFT', false); //首充是否包含赠送的gift
define('PAY_COUNT_TO_USER', 1); //首充精确到用户
define('PAY_COUNT_TO_PRODUCT', 2); //首充精确到商品
$g_pay_count_type = PAY_COUNT_TO_USER;
$g_fp_allow_channel = array(32, 1003, 1005, 1006);//首充允许渠道

// 公共平台返回的错误
$g_proxy_conf = array();
$g_db_config = array();

//pay proxy server
$g_proxy_conf = array(
        'ip'        => '10.1.23.241',
        'port'      => '24100',
        'pri_key'   => 'a1c426a504829bf9d20b761ba6ec6d98',
        );

//db config
$g_db_config = array(
        'db_host' => '10.1.23.72',
        'db_port' => 3306,
        'db_user' => 'jfsqladmin',
        'db_pass' => 'jfsql!@#$OK',
        'db_name' => 'db_overseas_billing',
        );

//用于拉取订单的信息
$g_get_order_params = array(
        'pri_key' => 'taomee',
        'get_url' => 'http://10.1.23.241/platform/product/service/router.php?',
        );

// 扩展字段缩写定义
$g_extend_field = array(
    'game_id' => 'gd',
    'channel_id' => 'cd',
    'server_id' => 'sd',
    'product_id' => 'pd',
    'third_product_id' => 'tn',
    'order_id' => 'od',
    'price' => 'm',
    'user_id' => 'ud',
    'role_create_time' => 'ut',
    'currency' => 'cu',
    'extend_data' => 'ed',
    'debug' => 'dg'
);

?>
