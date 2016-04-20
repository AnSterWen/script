<?php

class itemView extends View  
{		
	public $_m = NULL ;
	public $_a = NULL ;
	
	public $http     = NULL ;	
	public $response = NULL ;
	public $user     = NULL ;
					
    public $e_str = NULL ;
    
    public $tpl_dir = NULL ;
    
    private $layout_data = array();
    
    // 错误对象
    public $error = NULL ;

	function __construct()
	{			
		parent::__construct();
		
		$this->http     = Http::get_instance() ;
		$this->response = Response::get_instance() ;	
		$this->user     = User::get_instance() ;
		
		$this->load_template();
	}
	
	/**
	 * 加载模板引擎
	 *
	 */
	public  function load_template()
	{
		if(!class_exists('TemplateFactory')) {
			$file = TAOMEE_TPL_PATH . "template.factory.php" ;
			if(!file_exists($file)) {
				die("Not found file: {$file}");
			}
			else {
				require_cache($file);
			}
		}
		$this->tpl = TemplateFactory::getTemplateCompiler();
		
	    $this->tpl->template_dir = APP_PATH . 'Views' . DS ; //声明模板存放目录
	    $this->tpl->compile_dir  = APP_PATH . 'Tmp'. DS .'Compiles' . DS ;	
	}
	
	/**
	 * 加载layout 文件，并对所有的变量赋值
	 *
	 * @param string $tpl_file 模板文件名
	 * @param string $only  0 加载layout， 1 加载单个文件
	 */
	public function display($tpl_file='layout.html', $only=false)
	{

	    $this->response->set('user_name_header', $this->user->get_user_name());

	    $user_auth_tree = $this->user->get_auth_list();
	    $this->response->set('item_tree', $user_auth_tree);

		// 加载数据信息
		$this->tpl->assign('response_data', $this->response->get());
		// 渲染模板
		if(!$only)
		{
			$this->tpl->assign('layout_data', $this->load_layout());
			$this->tpl->display($tpl_file) ;
		}
		else
		{
			if($this->response->has_error())
			{
				$tpl_file = $this->response->get_error('error_file');
				$tpl_file = empty($tpl_file) ? 'layout.html' : $tpl_file;
			}
			$this->tpl->assign('response_error', $this->response->get_error());
			$this->tpl->assign('layout_data', $this->load_layout());
			$this->tpl->display($tpl_file);
		}
	}
	
	/**
	 * ajax 请求右边的
	 */
	public function ajax_return($tpl_file='Common/right.html', $type='right')
	{
		// 加载数据信息		
		$this->tpl->assign('response_data', $this->response->get());
		switch ($type) {
			case 'left':
				return $this->load_left(true);
				break; 
			case 'header':
				return $this->load_header(true);
				break;
			case 'footer':
				return $this->load_footer(true);
				break;
			default:
				return $this->load_right(true);
				break;
		}
	}
	
	/**
	 * 加载layout的各个部分
	 *
	 * @return string
	 */
	public function load_layout()
	{
		$this->load_header() ;
		$this->load_left() ;
		$this->load_right() ;
		$this->load_footer() ;
		
		return $this->layout_data ;
	}
	
	/**
	 * 加载左边树结构
	 */
	public  function load_left($return=false)
	{
		ob_start() ;
		//ob_clean() ;
		if($this->response->has('layout_left_file')) {
			$tpl_file = $this->response->get('layout_left_file') ;
		}
		else {
			$tpl_file = 'Common/left.html' ;
		}
		$this->tpl->display($tpl_file) ;
		$this->layout_data['left'] = ob_get_contents() ;
			
		ob_end_clean() ;	
		
		return $return ? $this->layout_data['left'] : true ;
	}
	
	/**
	 * 加载头信息
	 */
	public function load_header($return=false)
	{
		ob_start() ;
		//ob_clean() ;
		if($this->response->has('layout_header_file')) {
			$tpl_file = $this->response->get('layout_header_file') ;
		}
		else {
			$tpl_file = 'Common/header.html' ;
		}
		
		$this->tpl->display($tpl_file) ;		
		$this->layout_data['header'] = ob_get_contents() ;
		
		ob_end_clean() ;
		
		return $return ? $this->layout_data['header'] : true ;
	}
	
	/**
	 * 加载尾信息
	 */
	public  function load_footer($return=false)
	{
		ob_start() ;
		//ob_clean() ;
		
		if($this->response->has('layout_footer_file')) {
			$tpl_file = $this->response->get('layout_footer_file') ;
		}
		else {
			$tpl_file = 'Common/footer.html' ;
		}
				
		$this->tpl->display($tpl_file) ;
		$this->layout_data['footer'] = ob_get_contents() ;		
		
		ob_end_clean() ;	
		return $return ? $this->layout_data['footer'] : true ;
	}
	
	/**
	 * 加载尾信息
	 */
	public  function load_right($return = false)
	{
		ob_start();
		//ob_clean();
				
		if($this->response->has_error())
		{
			$tpl_file = $this->response->get_error('error_file');
			$tpl_file = empty($tpl_file) ? 'Common/error.html' : $tpl_file;
		}
		elseif($this->response->has('layout_right_file'))
		{
			$tpl_file = $this->response->get('layout_right_file');
		}
		else
		{
			$tpl_file = 'Common/test.html' ;
		}
		
		$this->tpl->display($tpl_file) ;
		$this->layout_data['right'] = ob_get_contents() ;
		ob_end_clean() ;	
		return $return ? $this->layout_data['right'] : true;
	}
}
?>
