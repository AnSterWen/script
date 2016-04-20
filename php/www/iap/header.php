<?php

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

define('APP_PATH', dirname(__FILE__) . DS ) ;

ini_set("memory_limit","80M");
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH);
define('VERSION', 'release');

define('LOG_DIR', APP_PATH.'log'.DS ) ;
define('APP_LOG_FILE_SIZE', 1048576 * 100); // 5M

define('ISO_RECEIPT_MD5_TAIL', 'ta0mee$(eceip)@ios');

define('SERVICE_URL', 'http://10.1.23.241/platform/product/service/router.php');
define('CARD_SERVER_IP', '192.168.xx.xxx');
define('CARD_SERVER_PORT', 42100);

define('TAOMEE_LIB_PATH', dirname(__FILE__).DS.'Lib'.DS) ;

require_once( TAOMEE_LIB_PATH . 'Util/functions.php') ;
require_once( TAOMEE_LIB_PATH . 'Util/Log.class.php') ;
require_once( TAOMEE_LIB_PATH . 'Util/Http.class.php') ;
require_once( TAOMEE_LIB_PATH . 'Util/RedisServer.php') ;
require_once( TAOMEE_LIB_PATH . 'Util/Tea.class.php') ;
require_once( TAOMEE_LIB_PATH . 'Pay/Alipay.class.php') ;
require_once( TAOMEE_LIB_PATH . 'Pay/Mycard.class.php') ;
require_once( TAOMEE_LIB_PATH . 'Pay/Xmpay.class.php') ;
require_once( TAOMEE_LIB_PATH . 'Pay/Yeepay.class.php') ;
require_once( TAOMEE_LIB_PATH . 'Proto/icomm_card_proto.php') ;
require_once( TAOMEE_LIB_PATH . "Pay/wdb_pdo.class.php");

/* 设置自定义错误处理函数 */
set_error_handler('taomee_error');

/* 设置时区 */
// date_default_timezone_set('Asia/Shanghai');

/* 脚本结束前执行的函数 */
//register_shutdown_function('shutdown');

/* 设置自定义异常处理函数 */
//set_exception_handler('my_exception') ;

/* 设置脚本的最大允许时间 */
set_time_limit(120);

if(defined('VERSION') && VERSION == 'release') {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
}

require_once APP_PATH . 'item_model.php';
?>
