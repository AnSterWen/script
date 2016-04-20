<?php
require_once (dirname(__FILE__) . "/status.config.php");
$g_version = "release";
// $g_version = "debug";

// log directory
define('LOG_PREFIX', "account_service_");
define('LOG_DIR', dirname(dirname(__FILE__)) . '/log/');


define('ACCOUNT_DEFAULT_KEY', 'a09fbc85b88f4090ec91695245ca9dc4');
$g_allow_channels = array(
        '0'  =>  '2d30c589044ce696e72de879f5f990ab',//内部渠道
        '1'  =>  '2d30c589044ce696e72de879f5f990ab',
        '10000'  =>  '2d30c589044ce696e72de879f5f990ab',//内部渠道
        );

// 公共平台返回的错误
// $g_proxy_conf = array();
$g_db_config = array();

if (strcasecmp($g_version, "release") == 0) {
    //account proxy server
    // $g_proxy_conf = array(
    //     'ip'        => '192.168.21.180',
    //     'port'      => '24100',
    //     'pri_key'   => 'ca7b37d3bc95fe6c8319626377e8368b',
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "######$_REQUEST#####");
    //     );

    //db config
    $g_db_config = array(
        'db_host' => '10.1.23.72',
        'db_port' => 3306,
        'db_user' => 'jfsqladmin',
        'db_pass' => 'jfsql!@#$OK',
        'db_name' => 'db_userid',
        );

} else {//debug config
    //account proxy server
    // $g_proxy_conf = array(
    //     'ip'        => '10.1.1.101',
    //     'port'      => '24100',
    //     'pri_key'   => 'ca7b37d3bc95fe6c8319626377e8368b',
    //     );

    //db config
    $g_db_config = array(
        'db_host' => '10.1.1.28',
        'db_port' => 3306,
        'db_user' => 'backup',
        'db_pass' => 'backup@pwd',
        'db_name' => 'db_userid',
        );
}


?>
