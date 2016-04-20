<?php
error_reporting(0);
date_default_timezone_set('Asia/Taipei');

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
$root     = dirname(__FILE__) ;
if (! defined('TAOMEE_PATH')) {
    define('TAOMEE_PATH', $root . DS . 'Taomee' . DS);
}
if(!defined('APP_PATH')) {
	define('APP_PATH', $root . DS . 'client' . DS ) ;
}

$item_controller_path = APP_PATH . 'Controller' . DS ;

/**
 * stat 配置库文件
 * @var LOG_DIR
 */
if(!defined('APP_CONF_PATH')) {	
	define('APP_CONF_PATH', APP_PATH.'Conf'.DS ) ;
}
/**
 * 加载基本配置项
 */
require_once APP_CONF_PATH . 'setup.inc.php';

$dispatch_file = APP_PATH.'dispatch.php' ;
//ob_start() ;

if(!file_exists($dispatch_file)) {
	exit("Not found file: $dispatch_file \r\n") ;
} else {
	include_cache($dispatch_file) ;
	$obj = new Dispatch() ;
	$obj->run() ;
}

//ob_end_flush() ;
?>
