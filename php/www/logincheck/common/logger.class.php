<?php

define("TRACE_LEVEL", 6);
define("DEBUG_LEVEL", 5);
define("INFO_LEVEL",  4);
define("WARN_LEVEL",  3);
define("ERROR_LEVEL", 2);
define("FATAL_LEVEL", 1);

define("TRACE_PREFIX", "trace");
define("DEBUG_PREFIX", "debug");
define("INFO_PREFIX",  "info");
define("WARN_PREFIX",  "warn");
define("ERROR_PREFIX", "error");
define("FATAL_PREFIX", "fatal");

define("DEF_DIR", "./");  // 默认将日志文件写在当前目录
define("DEF_LEVEL", TRACE_LEVEL);
define("DEF_FILE_PREFIX", "");
define("DEF_APPENDIX_LEN", 3); // 默认每天同级别日志文件最多可以有1000个
define("DEF_MAX_SIZE", 30*1024*1024);	// 30MB

class Logger
{
	// 日志文件目录
	private $directory;
	
	// 日志级别
	private $level;
	
	// 日志文件名前缀
	private $file_prefix;
	
	// 日志文件名后缀长度,决定了在某个日期内同一个级别最大日志文件数量
	private $file_appendix_len;	// warn when nearly reach the $max_files value
	
	// 每个日志文件最大字节数
	private $max_size;

	/**
	 * 类 logger 构造函数，若参数无效，将会抛出一个Exception异常
	 *
	 * @param string  $directory	       日志文件目录,保证该目录已存在且程序有相关读写权限，若该目录不存在，程序不会自动创建该目录
	 * @param int     $level               日志级别
	 * @param string  $file_prefix         日志文件名前缀
	 * @param int     $file_appendix_len   日志文件名后缀长度,决定了在某个日期内同一个级别最大日志文件数量
	 * @param int     $max_size            每个日志文件最大字节数
	 */
	function __construct($directory = DEF_DIR, $level = DEF_LEVEL, $file_prefix = DEF_FILE_PREFIX, $file_appendix_len = DEF_APPENDIX_LEN , $max_size = DEF_MAX_SIZE)
	{
		//Todo: check parameters' validity
		if (is_string($directory) && strlen($directory)>0)
		{			
			$this->directory = $directory;
		}
		else 
		{
			throw new Exception("invalid directory value");
		}

		if (is_int($level) && $level>=FATAL_LEVEL && $level<=TRACE_LEVEL)
		{
			$this->level = $level;	
		}
		else 
		{
			throw new Exception("invalid level value");
		}

		if (is_string($file_prefix) && strlen($directory)>=0)
		{			
			$this->file_prefix = $file_prefix;
		}
		else 
		{
			throw new Exception("invalid file_prefix value");
		}

		if (is_int($file_appendix_len) && $file_appendix_len>0)
		{
			$this->file_appendix_len = $file_appendix_len;
		}
		else 
		{
			throw new Exception("invalid file_appendix_len value");
		}
				
		if (is_int($max_size) && $max_size>0)
		{
			$this->max_size = $max_size;
		}
		else 
		{
			throw new Exception("invalid max_size value");
		}		
	}
	
	function __destruct()
	{
		// Do nothing.
	}

	/**
	 * Write the specified message into log file in trace level
	 *
	 * @param string   $message
	 * 
	 * @return 0 on succes,-1 on error
	 */
	public function trace($message)
	{
		$ret = $this->log($message, TRACE_LEVEL);
		return $ret;		
	}

	/**
	 * Write the specified message into log file in debug level
	 *
	 * @param string   $message
	 * 
	 * @return 0 on succes,-1 on error
	 */
	public function debug($message)
	{
		$ret = $this->log($message, DEBUG_LEVEL);
		return $ret;		
	}	
	
	/**
	 * Write the specified message into log file in info level
	 *
	 * @param string   $message
	 * 
	 * @return 0 on succes,-1 on error
	 */
	public function info($message)
	{
		$ret = $this->log($message, INFO_LEVEL);
		return $ret;		
	}

	/**
	 * Write the specified message into log file in warn level
	 *
	 * @param string   $message
	 * 
	 * @return 0 on succes,-1 on error
	 */
	public function warn($message)
	{
		$ret = $this->log($message, WARN_LEVEL);
		return $ret;		
	}	
	
	/**
	 * Write the specified message into log file in error level
	 *
	 * @param string   $message
	 * 
	 * @return 0 on succes,-1 on error
	 */
	public function error($message)
	{
		$ret = $this->log($message, ERROR_LEVEL);
		return $ret;		
	}

	/**
	 * Write the specified message into log file in fatal level
	 *
	 * @param string   $message
	 * 
	 * @return 0 on succes,-1 on error
	 */
	public function fatal($message)
	{
		$ret = $this->log($message, FATAL_LEVEL);
		return $ret;		
	}	
			
	/**
	 * Write the specified message into log file in the specified level
	 *
	 * @param string  $message	 
	 * @param int     $level 		
	 * 
	 * @return  0 on succes,-1 on error
	 */
	protected  function log($message, $level)
	{
		if ($level > ($this->get_log_level()))
		{
			// Not need to write log.
			return 0;
		}
		
		$file_name = $this->get_file_name($level);
		if (!$file_name)
		{
			return -1;
		}
	
		$now = strftime("[%H:%M:%S]");  // current time,format hh:mm:ss
		$content = $now.$message."\n";

		if (error_log($content, 3, $file_name) == FALSE)
		{
			return -1;
		}
	
		return 0;		
	}

	/**
	 * Get available log file name 
	 * 
	 * @param $level  log level
	 *
	 * @return string return an usable file name on success,FALSE on error 
	 */
	private function get_file_name($level)
	{
		$current_date = strftime("%Y%m%d");	//format:yyyymmdd
		$max_files = pow(10, $this->file_appendix_len);
		$file_level_prefix = $this->get_log_level_prefix($level);
		
		if (substr($this->directory, -1, 1) != "/")
		{
			$this->directory = $this->directory."/";
		}

        // added by rooney at 2010.10.21
        if(!is_writeable($this->directory)) {
            @mkdir($this->directory, 0777, true) ;
        }
		
		$file_name = $this->directory.$this->file_prefix.$file_level_prefix.$current_date;
			
		for ($i=0; $i<$max_files; $i++)
		{
			$test_name = sprintf("%s%0{$this->file_appendix_len}d", $file_name, $i);
			$file = @fopen("$test_name","r");
			
			if ($file)
			{
				// File exists
				$size = filesize ("$test_name");
				//echo "size:$size";
				
				if ($size >= $this->max_size)
				{
					// File's size larger than $max_size value
					fclose($file);
					continue;
				}
				else 
				{
					// This file qualifies the requirement
					fclose($file);
					$file_name = $test_name;
					break;
				}
			}
			else 
			{
				// File not exist,try to create it
				//echo "$test_name";
				
				$file = fopen("$test_name",'x');
				if ($file)
				{
					// Create file successs
					fclose($file);
					$file_name = $test_name;
					break;
				}
				else 
				{
					// Create file error
					return FALSE;
				}
			}				
		}
		
		return $file_name;
	}	
	
	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function get_log_level()
	{
		return $this->level;
	}

	public function get_log_level_prefix($level)
	{
		$log_level_prefix = FALSE;
		
		switch ($level)
		{
			case TRACE_LEVEL:
				$log_level_prefix = TRACE_PREFIX;
				break;
			case DEBUG_LEVEL:
				$log_level_prefix = DEBUG_PREFIX;
				break;
			case INFO_LEVEL:
				$log_level_prefix = INFO_PREFIX;
				break;
			case WARN_LEVEL:
				$log_level_prefix = WARN_PREFIX;
				break;
			case ERROR_LEVEL:
				$log_level_prefix = ERROR_PREFIX;
				break;
			case FATAL_LEVEL:
				$log_level_prefix = FATAL_PREFIX;
				break;																
			default:
				$log_level_prefix = FALSE;
		}
		
		return $log_level_prefix;
	}
	
	/**
	 * reset logger directory for third party game log.
	 * @param unknown_type $s_dir
	 */
	public function set_log_directory($directory)
	{
	   //Todo: check parameters' validity
        if (is_string($directory) && strlen($directory)>0)
        {           
            $this->directory = $directory;
        }
        else 
        {
            throw new Exception("invalid directory value in funciton ".__FUNCTION__);
        }
	}
}

?>
