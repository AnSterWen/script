<?php

/**
 +------------------------------------------------------------------------------
 * 日志处理类
 * 支持下面的日志类型
 * STAT_WEB_LOG_DEBUG 调试信息
 * STAT_WEB_LOG_ERROR 错误信息
 * SQL_LOG_DEBUG SQL调试
 * 分别对象的默认日志文件为
 * 调试日志文件 systemOut.log
 * 错误日志文件  systemErr.log
 * SQL日志文件  systemSql.log
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Util
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class Log
{ //类定义开始    

    static $log = array();

    /**
     * construct method
     */
    function __construct()
    {
        return true;
    }

    /**
     +----------------------------------------------------------
     * 日志直接写入
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @param mixed $message 日志信息( string or array )
     * @param string $type  日志类型
     * @param string $file  写入文件 默认取定义日志文件
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    static function write($message, $type = APP_WEB_LOG, $file = '')
    {
        if (! defined('LOG_RECORD') || ! LOG_RECORD) {
            return;
        }
        $now = date('[ y-m-d H:i:s ]');
        switch($type)
        {
            case APP_WEB_LOG_DEBUG:
                $logType = '[调试]';
                $destination = $file == '' ? LOG_DIR . "sysOut_" . date('y_m_d') . ".log" : $file;
                break;
            case APP_WEB_LOG_ERROR:
                $logType = '[错误]';
                $destination = $file == '' ? LOG_DIR . "sysErr_" . date('y_m_d') . ".log" : $file;
                break;
            case APP_WEB_LOG:
                // 运行时的日志记录
                $logType = '[日志]';
                $destination = $file == '' ? LOG_DIR . "sysLog_" . date('y_m_d') . ".log" : $file;
                break;
			default :
				$logType = '[Unknown]';
                $destination = $file == '' ? LOG_DIR . "sysErr_" . date('y_m_d') . ".log" : $file;
				break;
					
        }
        if (! is_writable(LOG_DIR)) {
            //ajax_return( create_error_array('400'), AJAX_TYPE ); 
            @mk_dir( LOG_DIR, 0777, true ) ;  // 创建目录，支持递归
            @chmod( LOG_DIR, 0777) ;  // 修改当前目录的权限
        }
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if (file_exists($destination) && APP_LOG_FILE_SIZE <= filesize($destination)) {
            //rename($destination, dirname($destination).'/'.time().'-'.basename($destination));			
            $fname = substr(basename($destination), 0, strrpos(basename($destination), '.log')) . "_" . time() . ".log";
            rename($destination, dirname($destination) . '/' . $fname);
        }
        if (is_array($message)) {
            $message = print_r($message, true);
        }
        clearstatcache();
        return error_log("$now\n$message\n", APP_FILE_LOG_TYPE, $destination);
    }

} //类定义结束
?>