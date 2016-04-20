<?php
/**
 * 项目启动配置
 */

require_once 'Common/functions.php';
require_once 'Common/defines.inc.php';

require_cache( TAOMEE_LIB_PATH . 'Core' . DS . 'Base.class.php') ;
require_cache( TAOMEE_LIB_PATH . 'Core' . DS . 'Response.class.php');
require_cache( TAOMEE_LIB_PATH . 'Core' . DS . 'Controller.class.php');
require_cache( TAOMEE_LIB_PATH . 'Core' . DS . 'Model.class.php');
require_cache( TAOMEE_LIB_PATH . 'Core' . DS . 'View.class.php');
require_cache( TAOMEE_LIB_PATH . 'Util/Log.class.php') ;
require_cache( TAOMEE_LIB_PATH . 'Util/Validation.class.php') ;
require_cache( TAOMEE_LIB_PATH . 'Util/Http.class.php') ;
require_cache( TAOMEE_LIB_PATH . 'Util/Image.class.php') ;

/* 加载模板引擎  */
require_cache( TAOMEE_TPL_PATH . "template.factory.php") ;

/* 设置自定义错误处理函数 */
set_error_handler('taomee_error');

/* 设置时区 */
date_default_timezone_set('Asia/Shanghai');

/* 脚本结束前执行的函数 */
//register_shutdown_function('shutdown');

/* 设置自定义异常处理函数 */
//set_exception_handler('my_exception') ;

/* 设置脚本的最大允许时间 */
set_time_limit(120);

if(defined('VERSION') && VERSION == 'release') {
    error_reporting(0);
}
else {
    error_reporting(E_ALL);
}

?>
