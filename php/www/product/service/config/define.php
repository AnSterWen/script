<?php
/* 定义全局变量 */
/* 版本 */
define('VERSION','release');

/* 默认每页数据记录数 */
define('PAGE_SIZE', 10);

if (defined('VERSION')
    && VERSION == 'release')
{
    /* 有效IP类型 */
    define('VALID_IP', '185.26.28.109');

    /* 数字签名字段名 */
    define('DIGITAL_SIGNATURE', 'sign');

    /* TOKEN */
    define('TOKEN_NAME',  'key');
    define('TOKEN_VALUE', 'taomee');
}
else if (defined('VERSION')
         && VERSION == 'pre-release')
{
    /* 有效IP类型 */
    define('VALID_IP', '10.1.1.101|10.1.1.27|10.1.6.69');

    /* 数字签名字段名 */
    define('DIGITAL_SIGNATURE', 'sign');

    /* TOKEN */
    define('TOKEN_NAME',  'key');
    define('TOKEN_VALUE', 'taomee');
}
else
{
    /* 有效IP类型 */
    define('VALID_IP', '');

    /* 数字签名字段名 */
    define('DIGITAL_SIGNATURE', 'sign');

    /* TOKEN */
    define('TOKEN_NAME',  'key');
    define('TOKEN_VALUE', 'taomee');
}

/* 错误日志 */
/* 日志路径 */
if(!defined('LOG_DIR'))
{
    define('LOG_DIR', ROOT .'tmp' . DS . 'log' . DS) ;
}
/**
 * 是否写日志
 * @var LOG_RECORD
 */
if(!defined('LOG_RECORD'))
{
    define('LOG_RECORD', true);
}
/**
 * 日志文件大小
 * @var APP_LOG_FILE_SIZE
 */
if (!defined('APP_LOG_FILE_SIZE'))
{
    define('APP_LOG_FILE_SIZE', 1048576 * 5); // 5M
}
if(!defined('APP_FILE_LOG_TYPE'))
{
    define('APP_FILE_LOG_TYPE', 3);
}
define('APP_WEB_LOG_ERROR', 0);
define('APP_WEB_LOG_DEBUG', 1);
define('APP_WEB_LOG', 2);
