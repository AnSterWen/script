<?php

class Dispatch extends Base 
{
	public $_m = NULL ;
	public $_a = NULL ;
	public $file = NULL ;
	
	public $http = NULL ;
	public $response = NULL ;
	public $user  = NULL ;
	public $view  = NULL ;
	
	public $error = NULL ;
	
	function __construct() 
	{
		$this->http     = Http::get_instance() ;
		$this->user     = User::get_instance() ;
		$this->response = Response::get_instance() ;
		
		$this->view     = new itemView();
	}
	
	public function get_model()
	{
		$this->_m = $this->http->has('m') ? htmlspecialchars($this->http->get('m')) : 'user';		
	}
	
	public function get_action()
	{
		$this->_a = $this->http->has('a') ? htmlspecialchars($this->http->get('a')) : 'index';	
	}
	
	public function is_login()
	{
		if(!$this->user->is_login())
		{
			$current_url = $this->http->current_url();
			$login_url = substr($current_url, 0, strpos($current_url, '?')). '?m=user';
			$this->user->set_req_url($current_url);
		    if ($this->http->has('ajax'))
			{
				exit('time out!');
			}
			else
			{
				redirect($login_url);
				exit();
			}
		}
		else
		{
			return true;
		}
	}
	
	public function run()
	{
		global $item_controller_path;
		global $product_config;
		$this->http->record_sess_url();
		$this->get_model();
		$this->get_action();
        echo "run </br>";
		if ($this->_m != 'user')
		{
			$this->is_login();
   		}

		if ($this->_m=='index' && $this->_a=='index')
		{	
			$str = 'index.php?m='.$this->_m;
		}
		else
		{
			$str = 'index.php?m='.$this->_m.'&a='.$this->_a;
            echo $str . '</br>';
	   	}
		$this->response->set('color_flag',$str); 	
			
	    $obj = '' ;

        echo json_encode($product_config);
		if (array_key_exists($this->_m, $product_config)) {
			$this->file = $item_controller_path."item_controller.php";
			$class_name = "itemController";
			$product = $this->_m;
		} else {
			$this->file = $item_controller_path . "{$this->_m}_controller.php" ;
			$class_name = "{$this->_m}Controller" ;
		}
		
		if(!file_exists($this->file)) {
            echo "找不到文件: ".$class_name;
			die('找不到 Controller 文件：'.$this->file );
		}

		if(!class_exists($class_name)) {
			require_cache($this->file) ;
		}	

		$action_name = "{$this->_a}Action" ;
        //indexAction

		if(! method_exists($class_name, $action_name)) {
			die('找不到 类方法：'.$action_name.'('.$class_name.'), 在文件：'.$this->file ) ;
		} else {	
			$obj = array_key_exists($this->_m, $product_config) ? new $class_name($this->_m) : new $class_name() ;
			$obj->{$action_name}() ;
		}
	}
}
?>
