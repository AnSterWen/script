<?php

// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2008 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$



/**
 +------------------------------------------------------------------------------
 * Http 工具类
 * 提供一系列的Http方法
 +------------------------------------------------------------------------------
 * @category   ORG
 * @package  ORG
 * @subpackage  Net
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class Http 
{ //类定义开始

	private static $instance = null;
	
	/**
	 * 私有的构造函数
	 *
	 */
	private function __construct()
	{
		//... 
	}

	/**
	 * 生成单个实例
	 *
	 * @return Request object
	 */
	static public function get_instance() 
	{
    	if (null === self::$instance)
    	{
            self::$instance = new Http();
        }
        return self::$instance;
    }

    /**
     +----------------------------------------------------------
     * 下载文件
     * 可以指定下载显示的文件名，并自动发送相应的Header信息
     * 如果指定了content参数，则下载该参数的内容
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $filename 下载文件名
     * @param string $showname 下载显示的文件名
     * @param string $content  下载的内容
     * @param integer $expire  下载内容浏览器缓存时间
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    static function download($filename, $showname = '', $content = '', $expire = 180)
    {
        if (file_exists($filename)) {
            $length = filesize($filename);
        }
        elseif (is_file(UPLOAD_PATH . $filename)) {
            $filename = UPLOAD_PATH . $filename;
            $length = filesize($filename);
        }
        elseif ($content != '') {
            $length = strlen($content);
        }
        else {
            throw_exception($filename . L('_DOWN_FILE_NOT_EXIST_'));
        }
        if (empty($showname)) {
            $showname = $filename;
        }
        $showname = basename($showname);
        if (empty($filename)) {
            $type = mime_content_type($filename);
        }
        else {
            $type = "application/octet-stream";
        }
        //发送Http Header信息 开始下载
        header("Pragma: public");
        header("Cache-control: max-age=" . $expire);
        //header('Cache-Control: no-store, no-cache, must-revalidate');
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + $expire) . "GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()) . "GMT");
        header("Content-Disposition: attachment; filename=" . $showname);
        header("Content-Length: " . $length);
        header("Content-type: " . $type);
        header('Content-Encoding: none');
        header("Content-Transfer-Encoding: binary");
        if ($content == '') {
            readfile($filename);
        }
        else {
            echo ($content);
        }
        exit();
    }

    /**
     +----------------------------------------------------------
     * 显示HTTP Header 信息
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    function get_header_info($header = '', $echo = true)
    {
        ob_start();
        $headers = getallheaders();
        if (! empty($header)) {
            $info = $headers[$header];
            echo ($header . ':' . $info . "\n");
            ;
        }
        else {
            foreach($headers as $key => $val) {
                echo ("$key:$val\n");
            }
        }
        $output = ob_get_clean();
        if ($echo) {
            echo (nl2br($output));
        }
        else {
            return $output;
        }    
    }

    /**
     * HTTP Protocol defined status codes
     * @param int $num
     */
    function send_http_status($code)
    {
        static $_status = array(
            // Informational 1xx
        100 => 'Continue', 101 => 'Switching Protocols', 

        // Success 2xx
        200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 

        // Redirection 3xx
        300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', // 1.1
		303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', // 306 is deprecated but reserved
		307 => 'Temporary Redirect', 

        // Client Error 4xx
        400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 417 => 'Expectation Failed', 

        // Server Error 5xx
        500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported', 509 => 'Bandwidth Limit Exceeded' 
        );
        
        if (array_key_exists($code, $_status)) {
            header('HTTP/1.1 ' . $code . ' ' . $_status[$code]);
        }
    }
   
    /**
     * Alias to __get
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
    	if($this->is_post_back()) {
    		return isset($_POST[$key]) ? trim($_POST[$key]) : NULL ;    		     
    	}
    	else{    		
    		return isset($_GET[$key]) ? trim($_GET[$key]) : NULL ;  
    	}    	
    }

    /**
     * Alias to __isset()
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
    	if($this->is_post_back()) {
    		return isset($_POST[$key]) ? TRUE : FALSE ;
    	}
    	else{    		
    		return isset($_GET[$key]) ? TRUE : FALSE ;
    	}
    }
    
	/**
	 * 判断当前请求是否为 POST
	 *
	 * @return bool
	 */
    public function is_post_back()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}
    
	/**
	 * 返回上一个页面的 URL 地址(来源)
	 * @return string
	 */
	public function front_url()
	{
	    return isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
	}
	
	/**
	 * 返回当前页面的 URL 地址
	 * @return string
	 */
	public function current_url()
	{
	    $http = isset($_SERVER["HTTPS"])&&$_SERVER["HTTPS"] ? 'https' : 'http';
	    $http .= '://';
	    return $http.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];	    
	}

	/**
	 * 获取当前的url
	 */
	public function sess_current_url()
	{
		return $this->current_url();
	}
	
	/**
	 * 获取上一次的url
	 */
	public function sess_front_url()
	{
		$url = isset($_SESSION['sess_front_url']) ?
				$_SESSION['sess_front_url'] : '';		
		return $url;
	}
	
	/**
	 * 通过session记录url
	 */
	public function record_sess_url()
	{
		$_SESSION['sess_front_url'] = isset($_SESSION['sess_current_url']) ?
										$_SESSION['sess_current_url'] : '';
		$_SESSION['sess_current_url'] = $this->current_url();
	}
} //类定义结束
?>