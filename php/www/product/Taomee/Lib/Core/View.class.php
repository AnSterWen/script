<?php
class View extends Base 
{
	protected  $tpl = NULL ;
	
	public function __construct()
	{
		parent::__construct();
		//$this->load_template();
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
				die("Not found file: {$file}") ;
			}
			else {
				require_cache($file);
			}
		}
		
		$this->tpl = TemplateFactory::getTemplateCompiler();
		$this->tpl->template_dir = APP_PATH . 'Tpl' . DS ; //声明模板存放目录
	    $this->tpl->compile_dir  = APP_PATH . 'Tmp'.DS.'Compiles' . DS ;			
	}
		
}

?>