<?php
//define('VERSION', 'testing');
defined('VERSION') || define('VERSION', 'release');

define('ITEM_LIST_PAGE_SIZE',15);

/**
 * stat 的日志路径
 * @var LOG_DIR
 */
if(!defined('LOG_DIR')) {
    define('LOG_DIR', APP_PATH.'Tmp'.DS.'Log'.DS ) ;
}

/**
 * 是否写日志
 * @var LOG_RECORD
 */
if(!defined('LOG_RECORD')) {
    define('LOG_RECORD', true);
}

/**
 * 日志文件大小
 * @var STAT_STAT_LOG_FILE_SIZE
 */
if (!defined('APP_LOG_FILE_SIZE')) {
    define('APP_LOG_FILE_SIZE', 1048576 * 5); // 5M
}

if(!defined('APP_FILE_LOG_TYPE')) {
    define('APP_FILE_LOG_TYPE', 3); // error_log message_type = 3
}

define('APP_WEB_LOG_ERROR', 0);
define('APP_WEB_LOG_DEBUG', 1);
define('APP_WEB_LOG', 2);

define('ISO_RECEIPT_MD5_TAIL', 'ta0mee$(eceip)@ios');

// 配置(VERSION控制内外网配置)
if (defined('VERSION') && VERSION == 'release')
{
    // 私钥
    define('ITEM_PRIVATE_KEY', 'taomee') ;
    //host
    define('ITEM_HOST','10.1.23.241/platform/product');
    //interface
    define('ITEM_MANAGER_FILE','service/admin.php');

    define('AUDIT_DB_HOST','10.1.23.72');
    define('AUDIT_DB_USER','jfsqladmin');
    define('AUDIT_DB_PWD' ,'jfsql!@#$OK');
    define('AUDIT_DB_NAME','db_iap_mgr');
}
elseif (defined('VERSION') && VERSION == 'pre-release')
{
    // 私钥
    define('ITEM_PRIVATE_KEY',  'taomee') ;
    // 接口地址
    define('ITEM_HOST',         '10.1.1.101');
    //interface
    define('ITEM_MANAGER_FILE', 'service/admin.php');

    define('AUDIT_DB_HOST',     '10.1.1.101');
    define('AUDIT_DB_USER',     'root');
    define('AUDIT_DB_PWD' ,     'ta0mee');
    define('AUDIT_DB_NAME',     'db_item');
}
else
{
     // 私钥
    define('ITEM_PRIVATE_KEY', 'taomee') ;
    //host
    //define('ITEM_HOST','10.1.1.27');
    define('ITEM_HOST','10.10.41.66/product');
    //interface
    define('ITEM_MANAGER_FILE','service/admin.php');

    define('AUDIT_DB_HOST','10.1.1.27');
    define('AUDIT_DB_USER','root');
    define('AUDIT_DB_PWD' ,'ta0');
    define('AUDIT_DB_NAME','db_item');
}
