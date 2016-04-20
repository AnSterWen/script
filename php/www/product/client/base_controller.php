<?php

class BaseController extends Controller
{
    protected $http = NULL ;
    protected $user  = NULL ;
        
    protected $model = NULL ;
    protected $view  = NULL ;
    protected $response = NULL ;
    
    protected $m = NULL ;
    protected $a = NULL ;
        
    /**
     * 构造函数，定义改项目使用的缓存文件目录
     * 
     * @package   Stat_Controller
     * @category  Controller
     */
    function __construct()
    {
        parent::__construct();     
         
		$this->http = Http::get_instance() ;	
		$this->user = User::get_instance() ;	
		$this->response = Response::get_instance() ;	

		$this->view  = new itemView() ;
    }

    /**
     * 析构函数
     */
    function __destruct()
    {
        $this->Model = NULL;
        $this->View  = NULL;
    }

	function setModelName($model)
	{
		$this->m = $model;
	}
}
?>
