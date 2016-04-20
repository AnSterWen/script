<?php
// 基础路径
define('ROOT',          dirname(dirname(__FILE__)) . DS);
define('LIB_PATH',      ROOT . 'lib' . DS);
define('CONFIG_PATH',   ROOT . 'config' . DS);
define('HANDLER_PATH',  ROOT . 'handler' . DS);

// 加载文件
require_once CONFIG_PATH . 'define.php';
require_once CONFIG_PATH . 'config.php';
require_once CONFIG_PATH . 'function.php';
