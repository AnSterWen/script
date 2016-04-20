<?php

/**
 * 相应组件，方便显示在view层
 *
 */

class Response
{
	private $data = array() ;
	private $error = array() ;
	private $debug = array() ;
	private static $instance = NULL ;
	
	/**
	 * 私有的构造函数
	 */
	private function __construct()
	{
		// ...
	}
	
	/**
	 * 生成单个实例
	 *
	 * @return Response object
	 */
	static public function get_instance()
	{
		if(null === self::$instance) {
			self::$instance = new Response() ;
		}
		return  self::$instance ;
	}
	
	/**
	 * 设置数据  对写进的字符进行过滤
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	function set($key,$value='')
	{
	    if (is_array($key))
	    { 
	        foreach ($key as $k=>$v)
				$this->data[$k] = (is_numeric($v) || empty($v) ) ? $v : htmlspecialchars_deep($v) ;
	    }
		else
		{
	        $this->data[$key] = (is_numeric($value) || empty($value) ) ? $value : htmlspecialchars_deep($value) ;
	    }	    
	}
	
	/**
	 * 获得数据
	 *
	 * @param string $key :键名,没有其键值则返回 null 如果为空则返回对应的数据.
	 * @return unknown
	 */
	function get($key = '')
	{
		return $key ? (isset($this -> data[$key]) ? $this -> data[$key] : null) : $this -> data;
	}
	
	/**
	 * 判断数字是否存在
	 *
	 * @param string $key 键名, 没有其键值则返回 null 如果为空则返回对应数据是否为空.
	 * @return unknown
	 */
	function has($key='') 
	{
		return $key ? ( isset($this->data[$key]) ? true : false ) : count($this->data) ;
	}
	
	/**
     * 判断是否有错误信息
     *
     * @return bool
     */
	function has_error() 
	{
		return count($this->error)>0;
	}
	
	/**
	 * 添加错误信息
	 *
	 * @param mixed $field
	 * @param string $errorMsg
	 * 
	 * 例子: add_error('error1','文件没有找到!');
	 *      add_error(array('error1'=>'文件没有找到!',
	 *                     'error1'=>'没有登录!')); 
	 */
	function add_error($field, $error_msg='')
	{
		if (is_array($field))
		{
			foreach ($field as $k=>$v) $this -> error[$k] = (is_numeric($v) || empty($v) ) ? $v : htmlspecialchars($v);
		}else{
			$this -> error[$field] = (is_numeric($error_msg) || empty($error_msg) ) ? $error_msg : htmlspecialchars($error_msg);
		}
	}
	/**
	 * 得到错误信息
	 *
	 * @param mixed $field :错误索引,如果没有定义则返回所有的错误信息,否则返回对应的错误信息
	 * @return unknown
	 */
	function get_error ($field = '') 
	{
		return $field ? (isset($this -> error[$field]) ? $this -> error[$field] : null) : $this -> error;
	}
	
    /**
     * 判断是否有调试信息
     *
     * @return bool
     */
	function has_debug() 
	{
		return count($this -> debug) > 0;
	}
	
	/**
	 * 添加调试信息
	 *
	 * @param mixed $field
	 * @param string $debugMsg
	 * 
	 * 例子: add_debug('error1','文件没有找到!');
	 *      add_debug(array('error1'=>'文件没有找到!',
	 *                     'error2'=>'没有登录!')); 
	 */
	function add_debug ($field,$debugMsg='')
	{
		if (is_array($field))
		{
			foreach ($field as $k=>$v) $this -> debug[$k] = (is_numeric($v) || empty($v) ) ? $v : htmlspecialchars($v) ;
		}
		else
		{
			$this -> debug[$field] = (is_numeric($debugMsg) || empty($$debugMsg) ) ? $debugMsg : htmlspecialchars($debugMsg) ;
		}
	}
	
	/**
	 * 得到调试信息
	 *
	 * @param mixed $field :错误索引,如果没有定义则返回所有的调试信息,否则返回对应的调试信息
	 * @return unknown
	 */
	function get_debug ($field = '')
	{
		return $field ? (isset($this -> debug[$field]) ? $this -> debug[$field] : null) : $this -> debug;
	}

	/**
	 * 得到数据库调试信息
	 * 
	 * 说明:SQL调试信息只有当 MY_DEBUG 常量设为 true 时才有
	 * @param prec:SQL查询的时间小数位
	 * @return string 
	 */
	function get_sql_debug_info($prec=8)
	{
	    $html = '';
	    $body = ''; 
	    if (MY_DEBUG && $this->get('db_debug'))
	    {
	        $tpl = MY_CORE_ROOT.'Libs/db.debug.tpl';
	        $conent = file_get_contents($tpl);
	        eval($conent); //生成 $_InfoHeader, $_InfoBaby, $_InfoFooter 三个变量
	        foreach ($this->get('db_debug') as $row)
	        {
        		$search = array("[ExecTime]","[TotalTime]","[Sql]");
        		$replace = array(round($row['ExecTime'],$prec),round($row['TotalTime'],$prec),$row['Sql']);
        		$body .= str_replace($search,$replace,$_InfoBaby);	            
	        }
	        $html = $_InfoHeader . $body . $_InfoFooter;
	    }
	    return $html;
	}
	
}
?>