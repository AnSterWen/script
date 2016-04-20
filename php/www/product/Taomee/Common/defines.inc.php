<?php

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

if (! defined('ROOT')) {
    define('ROOT', dirname(dirname(dirname(__FILE__))) . DS);
}

if (! defined('TAOMEE_PATH')) {
    define('TAOMEE_PATH', dirname(dirname(__FILE__)) . DS);
}

if(!defined('TAOMEE_DIR')) {
	define('TAOMEE_DIR', basename(dirname(dirname(__FILE__)))) ;
}

if (!defined('TAOMEE_LIB_PATH')) {
	define('TAOMEE_LIB_PATH', ROOT.DS.TAOMEE_DIR.DS.'Lib'.DS) ;
}

/* 模板引擎目录 */
if(!defined('TAOMEE_TPL_PATH')) {
	define('TAOMEE_TPL_PATH', TAOMEE_LIB_PATH . 'Template' . DS);
}

?>
