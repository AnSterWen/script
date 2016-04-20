<?php

/**
 * make sure this is only included once!
 */
if (! defined("TEMPLATE_INCLUDED")) {
    define("TEMPLATE_INCLUDED", 1);

    /**
     * 模版引擎父类。
     *
     * 模版引擎父类，用来声明所有子类所需要的固定变量。
     * @package     template  (所属的模块名称)
     * @author      Jerry <jerryjiang15@163.com>
     * @version     $ID$
     */
    class Template
    {
        /**
         * reference to a {@link Logger} object
         * @see Logger
         * @var object Logger
         */
        var $logger;
        /**
         * 存放模版目录
         * @var string
         */
        var $template_dir = 'templates';
        /**
         * 存放模版临时编译文件目录
         * @var string
         */
        var $compile_dir = 'templates_c';
        /**
         * 是否检查模版临时编译文件
         * @var boolean
         */
        var $compile_check = true;
        /**
         * 是否强制编译
         * @var boolean
         */
        var $force_compile = false;
        /**
         * 是否缓存
         * @var boolean
         */
        var $caching = 0;
        /**
         * 存放缓存目录
         * @var string
         */
        var $cache_dir = 'cache';
        /**
         * 缓存存活期
         * @var int
         */
        var $cache_life_time = 3600;
        /**
         * 是否采用客户端缓存
         * @var boolean
         */
        var $client_caching = false;
        /**
         * 语言包路径
         * @var string
         */
        var $lang_dir = '';
        /**
         * 全局语言变量名
         * @var string
         */
        var $global_lang_name = 'global';
        /**
         * 是否加载语言包
         * @var boolean
         */
        var $compile_lang = false;
        /**
         * 模板标签左定界符
         * @var string
         */
        var $left_delimiter = '<';
        /**
         * 模板标签右定界符
         * @var string
         */
        var $right_delimiter = '>';
        /**
         * 模版临时编译文件前缀
         * @var string
         */
        var $compilefile_prefix = '&&^';
        /**
         * 模板变量左定界符
         * @var string
         */
        var $tag_left_delim = '[';
        /**
         * 模板变量右定界符
         * @var string
         */
        var $tag_right_delim = ']';
        /**
         * 模板预先解析函数
         * @var array
         */
        var $parse_first_function = array();
        /**
         * 模板预后解析函数
         * @var array
         */
        var $parse_filter_function = array();
        /**
         * 模板变量存放数组
         * @var boolean
         */
        var $tpl_vars = array();
        /**
         * 是否修复模板
         * @var boolean
         */
        var $check_tpl_modify = true;
        /**
         * 是否强制编译
         * @var boolean
         */
        //var $force_compile = false;
        /**
         * 是否自动修复
         * @var boolean
         */
        var $auto_repair = false;
        /**
         * 模板内容源取出函数
         * @var boolean
         */
        var $source = NULL;
        /**
         * 编译器文件名
         * @var string
         */
        var $compiler_file = 'mysitecompiler.class.php';
        /**
         * 编译器类名
         * @var string
         */
        var $compiler_class = 'MySiteCompiler';

        
        /**
         * constructor
         * 
         * will always fail, because this is an abstract class!
         */
        function Template($params)
        {
            if (isset($params['compiler_file']))
                $this->compiler_file = $params['compiler_file'];
            
            if (isset($params['compiler_class']))
                $this->compiler_class = $params['compiler_class'];
            
            if (isset($params['template_dir']))
                $this->template_dir = $params['template_dir'];
            
            if (isset($params['compile_dir']))
                $this->compile_dir = $params['compile_dir'];
            
            if (isset($params['cache_dir']))
                $this->cache_dir = $params['cache_dir'];
            
            if (isset($params['lang_dir']))
                $this->lang_dir = $params['lang_dir'];
        }

        /**
         * 获得工厂对象
         * 
         * will always fail, because this is an abstract class!
         */
        function &getInstance()
        {
            return DBFactory::getTemplateCompiler();
        }

        /**
         * assign a {@link Logger} object to the database
         * 
         * @see Logger
         * @param object $logger reference to a {@link Logger} object
         */
        function setLogger(&$logger)
        {
            //$this->logger =& $logger;
        }

        /**
         * 分配模板变量
         * @var $tpl_var,$value
         */
        function assign($tpl_var, $value = null)
        {
            
            if (is_array($tpl_var)) {
                foreach($tpl_var as $key => $val) {
                    if ($key != '') {
                        $this->tpl_vars[$key] = $val;
                    }
                }
            }
            else {
                if ($tpl_var != '') {
                    $this->tpl_vars[$tpl_var] = $value;
                }
            }
        }

        /**
         * 以引用方式分配模板变量
         * @var $tpl_var,&$value
         */
        function assignByRef($tpl_var, &$value)
        {
            
            if ($tpl_var != '')
                
                $this->tpl_vars[$tpl_var] = &$value;
        
        }

        /**
         * 清空所有模板变量
         */
        function clearAllAssign()
        {
            $this->tpl_vars = array();
        }

        /**
         * 注册模板预先解析函数
         * @var $function_name
         */
        function registerFirstFunction($function_name)
        {
            $this->parse_first_function[] = $function_name;
        }

        /**
         * 注册模板预先解析函数
         * @var $function_name
         */
        function registerFilterFunction($function_name)
        {
            $this->parse_filter_function[] = $function_name;
        }

        /**
         * 是否编译过
         * @var $function_name
         */
        function isCompiled()
        {
            if (! file_exists($this->compile_name))
                return false;
            
            $expire = (filemtime($this->compile_name) == filemtime($this->template_name)) ? true : false;
            
            if ($expire)
                return true;
            
            else
                return false;
        }

        /**
         * 是否生成过缓存
         * @var $file_name,$cache_id
         */
        function isCached($file_name, $cache_id = NULL)
        {
            if ($this->cached)
                return true;
            
            $this->cache_name = $this->cache_dir . md5($this->template_dir . $file_name . $cache_id) . '.cache';
            
            if (! file_exists($this->cache_name))
                return false;
            
            if (! ($mtime = filemtime($this->cache_name)))
                return false;
            
            $this->cache_expire_time = $mtime + $this->cache_life_time - time();
            
            if (($mtime + $this->cache_life_time) < time()) {
                unlink($this->cache_name);
                return false;
            }
            else {
                $this->cached = true;
                return true;
            }
        }

        /**
         * 格式化编译文件名
         * @var $file_name
         */
        function format($file_name)
        {
            $file_name = str_replace('/', '&', $file_name);
            $file_name = str_replace('\\', '&', $file_name);
            $file_name = str_replace('..', '^', $file_name);
            
            return $file_name;
        }

        /**
         * 取出待编译内容
         * @var $file_name,$compile
         */
        function fetch($file_name, $compile = 0)
        {
            $this->template_name = $this->template_dir . $file_name;
            $this->compile_name = $this->compile_dir . $this->compilefile_prefix . $this->format($file_name);
            $this->lang_name = $this->lang_dir . $file_name . '.lang.php';
            $this->global_lang_name = $this->lang_dir . $this->global_lang_name . '.lang.php';
            
            ob_start();
            
            if (file_exists($this->lang_name)) {
                include ($this->lang_name);
            }
            
            if (file_exists($this->global_lang_name)) {
                include ($this->global_lang_name);
            }
            
            //echo $this->compile_dir.'<br>';
            //echo $this->compile_name;exit;
            

            if (! $this->isCompiled()) {
                if ($this->compile($this->template_name)) {
                    include ($this->compile_name);
                }
            }
            else { //echo $this->compile_name;exit;
                include ($this->compile_name);
            }
            
            $contents = ob_get_contents();
            
            ob_end_clean(); //echo $contents;exit;
            

            if ($compile) {
                $contents = $this->compileOutput($contents);
            }
            
            return $contents;
        }

        /**
         * 取出缓存文件
         * @var $file_name,$cache_id,$compile
         */
        function fetchCache($file_name, $cache_id, $compile = 0)
        {
            $this->cache_name = $this->cache_dir . md5($this->template_dir . $file_name . $cache_id) . '.cache';
            
            if ($fp = @fopen($this->cache_name, 'r')) {
                $contents = fread($fp, filesize($this->cache_name));
                fclose($fp);
                return $contents;
            }
            else {
                $contents = $this->fetch($file_name, $compile);
                
                if ($fp = @fopen($this->cache_name, 'w')) {
                    fwrite($fp, $contents);
                    fclose($fp);
                    
                //$this->logger->addFile($this->cache_name, time());
                }
                else {
                    die('Unable to write cache.');
                }
                
                return $contents;
            }
        }

        /**
         * 删除缓存文件
         * @var $file_name,$cache_id
         */
        function clear_cache($file_name, $cache_id)
        {
            $this->cache_name = $this->cache_dir . md5($this->template_dir . $file_name . $cache_id) . '.cache';
            
            return @unlink($this->cache_name);
        }

        /**
         * 显示
         * @var $file_name,$enable_gzip:压缩技术
         */
        function display($file_name, $enable_gzip = NULL)
        {
            
            if (empty($enable_gzip)) {
                print($this->fetch($file_name));
            }
            else {
                $buffer = $this->fetch($file_name);
                ob_start('ob_gzhandler');
                print $buffer;
            }
        }

        /**
         * 显示缓存
         * @var $file_name,$cache_id,$enable_gzip:压缩技术
         */
        function displayCache($file_name, $cache_id = NULL, $enable_gzip = NULL)
        {
            if ($this->client_caching) {
                header("Last-Modified: " . gmdate("D, d M Y H:i:s", time() + $this->cache_expire_time) . " GMT");
                header("Expires: " . gmdate("D, d M Y H:i:s", time() + $this->cache_expire_time) . " GMT");
            }
            
            if (empty($enable_gzip)) {
                print($this->fetchCache($file_name, $cache_id));
            }
            else {
                $buffer = $this->fetchCache($file_name, $cache_id);
                ob_start('ob_gzhandler');
                print $buffer;
            }
        }

        /**
         * 运行缓存
         * @var $file_name,$cache_id,$enable_gzip:压缩技术
         */
        function runCache($file_name, $cache_id = NULL, $enable_gzip = NULL)
        {
            if (empty($enable_gzip)) {
                print($this->fetchCache($file_name, $cache_id));
            }
            else {
                $buffer = $this->fetchCache($file_name, $cache_id);
                ob_start('ob_gzhandler');
                print $buffer;
            }
        }
    
    }

}
?>
