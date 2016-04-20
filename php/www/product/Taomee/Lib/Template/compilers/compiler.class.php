<?php

/**
 * base class
 */

if (! defined("TAOMEE_TPL_PATH")) {
    die("TAOMEE_TPL_PATH undefinition!");
}
include_once TAOMEE_TPL_PATH . "template.class.php";


class Compiler extends Template
{
    /**
     * 自动修复
     * @var boolean
     */
    var $auto_repair = false;
    /**
     * 解析函数
     * @var array
     */
    var $parse_fun_array = array(
        'parsePhp', 'parseIf', 'parseLoop', 'parseTag', 'parseTagFunc', 'parseInclude', 'parseGet' 
    );

    /**
     * Method: Template constructor
     * @param some parameter to the templates
     * @return void
     */
    
    function Compiler($params = NULL)
    {
        $this->Template($params);
    }

    /**
     * 取出模板内容
     * @param string $file_name
     * @return string or die
     */
    function readTemplate($file_name)
    {
        if (empty($this->source)) {
            if ($this->templateExists($file_name)) {
                $fp = fopen($file_name, 'r');
                $contents = fread($fp, filesize($file_name));
                fclose($fp);
                return $contents;
            }
            else {
                $dir = pathinfo($file_name);
                if ($this->autoRepair) {
                    if (@opendir($dir["dirname"])) {
                        die('<b>Template error:</b>template file does not exits: <b>' . $file_name . '</b>');
                    }
                    else {
                        if ($this->makeDir($dir["dirname"])) {
                            die('<b>Template Notice:</b>template_dir does not exits, Template engine repair the template_dir: <b>' . $dir["dirname"] . '</b> successfully, please refresh your page');
                        }
                        else {
                            die('<b>Template error:</b>template_dir does not exits, but Template engine fail to  repair the template_dir: <b>' . $dir["dirname"] . '</b>,please connect to your administrator to solve the problem');
                        }
                    }
                
                }
                else {
                    die('<b>Template error:</b> Unable to read template file: <b>' . $file_name . '</b>');
                }
            
            }
        
        }
        else {
            $source = &$this->source;
            return $this->$source($file_name);
        }
    }

    /**
     * 创建目录
     * @var $directory,$mode
     */
    function makeDir($directory, $mode = 0777)
    {
        if (@opendir($directory)) {
            return true;
        }
        else {
            if (@mkdir($directory, $mode)) {
                return true;
            }
            else {
                //try to repair the path
                $pathInfo = explode("/", $directory);
                $basedir = "";
                
                foreach($pathInfo as $var) {
                    if ($var == ".") {
                        $basedir = $basedir . "./";
                        $begin = false;
                    }
                    elseif ($var == "..") {
                        $basedir = $basedir . "../";
                        $begin = false;
                    }
                    else {
                        if (! $begin) {
                            $var = $var;
                            $begin = true;
                        }
                        else {
                            $var = '/' . $var;
                        }
                        
                        if ($this->makeDir($basedir . $var, $mode)) {
                            echo "System Auto Repair ${basedir}${var} <br>";
                            $repair = true;
                            $basedir = $basedir . $var;
                        }
                        else {
                            $repair = false;
                        }
                    
                    }
                
                }
                
                return $repair;
            
            }
        
        }
    
    }

    /**
     * 模板是否存在
     * @var $file_name
     */
    
    function templateExists($file_name)
    {
        if (file_exists($file_name)) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * 编译内容并生成中间文件
     * @var $file_name,$compile_name
     */
    function compile($file_name, $compile_name = NULL)
    {
        //$data = pathinfo($file_name);
        $basename = str_replace($this->template_dir, '', $file_name); //print_r($data);exit;
        

        if (! $this->templateExists($file_name)) {
            echo '<b>Template error:</b>no exists template file  : <b>' . $file_name . '</b>';
            return false;
        }
        else {
            if (! empty($compile_name)) {
                if (file_exists($this->compile_dir . $compile_name)) {
                    $expire = (filemtime($file_name) == filemtime($this->compile_dir . $compile_name)) ? true : false;
                    if ($expire)
                        return true;
                }
            }
            else {
                //echo '$file_name:' . $file_name . '<br>compile:' . $this->compile_dir . $this->compilefile_prefix . $data['basename'];exit;
                if (file_exists($this->compile_dir . $this->compilefile_prefix . $this->format($basename))) {
                    $expire = (filemtime($file_name) == filemtime($this->compile_dir . $this->compilefile_prefix . $this->format($basename))) ? true : false;
                    if ($expire)
                        return true;
                }
            }
        }
        
        $content = $this->readTemplate($file_name);
        
        $content = $this->compileFile($content);
        
        if (! empty($compile_name)) {
            if ($fp = fopen($this->compile_dir . $compile_name, 'w')) {
                fwrite($fp, $content);
                fclose($fp);
                touch($this->compile_dir . $compile_name, filemtime($file_name));
                //$this->logger->addFile(array('type'=>'cached','name'=>$this->compile_dir . $compile_name,'time'=>time()));
                return true;
            }
            else {
                die('<b>Template error:</b> Unable to write compiled file : <b>' . $this->compile_dir . $compile_name . '</b>');
            }
        
        }
        else {
            if ($fp = fopen($this->compile_dir . $this->compilefile_prefix . $this->format($basename), 'w')) {
                fwrite($fp, $content);
                fclose($fp);
                touch($this->compile_dir . $this->compilefile_prefix . $this->format($basename), filemtime($file_name));
                //$this->logger->addFile(array('type'=>'cached','name'=>$this->compile_dir . $compile_name,'time'=>time()));
                return true;
            }
            else {
                die('<b>Template error:</b> Unable to write compiled file : <b>' . $this->compile_dir . $this->compilefile_prefix . $file_name . '</b>');
            }
        }
    }

    
    /**
     * 编译内容
     * @var $contents
     */
    function compileFile($contents)
    {
        if (! empty($this->parse_first_function)) {
            foreach($this->parse_first_function as $var) {
                if (function_exists($var)) {
                    $contents = $var($contents);
                }
            }
        }
        
        foreach($this->parse_fun_array as $var) {
            $contents = $this->$var($contents);
        }
        
        if (! empty($this->parse_filter_function)) {
            foreach($this->parse_filter_function as $var) {
                if (function_exists($var)) {
                    $contents = $var($contents);
                }
            }
        }
        
        if ($this->compile_lang) {
            $this->parse_lang($contents);
        }
        
        return $contents;
    
    }

    /**
     * 编译php代码
     * @var $contents
     */
    function compile_php(&$contents)
    {
        //base64_decode
        

        $patt = "'<php>(.*)</php>'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $contents = str_replace($var, base64_decode($matches[1][$key]), $contents);
            }
        }
        
        $contents = $this->compileFile($contents);
        
        return $contents;
    }

    
    //-------------------------------开始内容解析函数---------------------------//
    

    /**
     *
     * compile language label to php code
     * {lang:can_not_connected_to_you}
     *
     */
    
    function parse_lang(&$contents)
    {
        $patt = "/\{LANG:([a-zA-Z0-9_-]+)\}/siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[1] as $key => $var) {
                $contents = str_replace($matches[0][$key], $this->lang_tag_format($var), $contents);
            }
        }
        
        $patt = "/\{LANG_GLOBAL:([a-zA-Z0-9_-\s]+)\}/siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[1] as $key => $var) {
                $contents = str_replace($matches[0][$key], $this->lang_global_tag_format($var), $contents);
            }
        }
    }

    function lang_tag_format($var)
    {
        $var = "<?php echo \$LANG['{$var}'];?>";
        return $var;
    }

    function lang_global_tag_format($var)
    {
        if (strpos($var, ' ')) {
            $vars = explode(' ', $var);
            
            foreach($vars as $key => $var1) {
                $return .= "<?php echo \$LANG_GLOBAL['{$var1}'];?>";
            }
        }
        else {
            $return = "<?php echo \$LANG_GLOBAL['{$var}'];?>";
        }
        
        return $return;
    }

    
    function parseTag($contents)
    {
        $patt = "/" . preg_quote($this->tag_left_delim) . "\\$([\S]+)" . preg_quote($this->tag_right_delim) . "/siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[1] as $key => $var) {
                $contents = str_replace($matches[0][$key], $this->parse_tag_format_display($var), $contents);
            }
        }
        
        $patt = "/" . preg_quote('{') . "\\$(.*)" . preg_quote('}') . "/siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[1] as $key => $var) {
                if (strpos($matches[0][$key], "this->tpl_vars"))
                    continue;
                
                $contents = str_replace($matches[0][$key], $this->parse_tag_format_var($var), $contents);
            }
        }
        
        $patt = "/" . preg_quote($this->tag_left_delim) . "\\*(.*)" . preg_quote($this->tag_right_delim) . "/siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[1] as $key => $var) {
                $contents = str_replace($matches[0][$key], $this->parse_tag_format_global_display($var), $contents);
            }
        }
        
        $patt = "/" . preg_quote('{') . "\\*(.*)" . preg_quote('}') . "/siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[1] as $key => $var) {
                if (strpos($matches[0][$key], "this->tpl_vars"))
                    continue;
                $contents = str_replace($matches[0][$key], $this->parse_tag_format_global_var($var), $contents);
            }
        
        }
        
        return $contents;
    }

    /*
	function parse_tag_format_var($string)
	{
		$header = "{\$this->tpl_vars";
		
		if(strpos($string, '.')) 
		{
			$data = explode('.',$string);
			$string = '';

			foreach($data as $key=>$var) 
			{
				$var = $this->parse_tag_format_varIN($var);
				$string .= "[\"".$var."\"]";
			}
			$string = $header.$string;
		}  
		else
		{
			$string = $header."['".$string."']";
		}

		return $string."}";
	}
	*/
    function parse_tag_format_var($string)
    {
        $header = "{\$this->tpl_vars";
        
        if (strpos($string, '.')) {
            $data = explode('.', $string);
            $string = '';
            
            foreach($data as $key => $var) {
                $string .= "['" . $var . "']";
            }
            
            $string = $header . $string . "}";
        }
        else {
            $string = $header . "['" . $string . "']}";
        }
        
        return $string;
    }

    function parse_tag_format_var2($string)
    {
        $header = "\$this->tpl_vars";
        
        if (strpos($string, '.')) {
            $data = explode('.', $string);
            $string = '';
            
            foreach($data as $key => $var) {
                $var = $this->parse_tag_format_varIN($var);
                $string .= "[\"" . $var . "\"]";
            }
            $string = $header . $string;
        }
        else {
            $string = $header . "['" . $string . "']";
        }
        
        return $string;
    }

    function parse_tag_format_varIN($string)
    {
        $header = "{\$this->tpl_vars";
        $substr = substr($string, 0, 1);
        
        if (strpos($string, ':') && $substr == '$') {
            $string = substr($string, 1);
            $data = explode(':', $string);
            $string = '';
            
            foreach($data as $key => $var) {
                $string .= "['" . $var . "']";
            }
            
            $string = $header . $string . "}";
        }
        return $string;
    }

    function parse_tag_format_display($string)
    {
        $header = "<?php echo \$this->tpl_vars";
        
        if (strpos($string, '.')) {
            $data = explode('.', $string);
            $string = '';
            
            foreach($data as $key => $var) {
                $var = $this->parse_tag_format_varIN($var);
                $string .= "[\"" . $var . "\"]";
            }
            $string = $header . $string . ";?>";
        }
        else {
            $string = $header . "[\"" . $string . "\"];?>";
        }
        
        return $string;
    }

    function parse_tag_format_global_var($string)
    {
        $header = "{\$GLOBALS";
        
        if (strpos($string, '.')) {
            $data = explode('.', $string);
            $string = '';
            
            foreach($data as $key => $var) {
                $string .= "[\"" . $var . "\"]";
            }
            
            $string = $header . $string . ";?>";
        }
        else {
            $string = $header . "[\"" . $string . "\"];?>";
        }
        
        return $string . "}";
    
    }

    function parse_tag_format_global_display($string)
    {
        $header = "<?php echo \$GLOBALS";
        
        if (strpos($string, '.')) {
            $data = explode('.', $string);
            $string = '';
            
            foreach($data as $key => $var) {
                $string .= "['" . $var . "']";
            }
            
            $string = $header . $string . ";?>";
        }
        else {
            $string = $header . "['" . $string . "'];?>";
        }
        return $string;
    }

    function parsePhp(&$contents)
    {
        $patt = "'" . preg_quote($this->left_delimiter) . "php" . preg_quote($this->right_delimiter) . "(.*)" . preg_quote($this->left_delimiter) . "/php" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $contents = str_replace($matches[1][$key], base64_encode($matches[1][$key]), $contents);
            }
        }
        return $contents;
    }

    function parseIf(&$contents)
    {
        $patt = "'" . preg_quote($this->left_delimiter) . "if[\s]+([^\n]+)" . preg_quote($this->right_delimiter) . "'si";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $str = "<?php if(" . $matches[1][$key] . "): ?>";
                $data = $this->format_var($str);
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        $patt = "'" . preg_quote($this->left_delimiter) . "elseif[\s]+([^\n]+)" . preg_quote($this->right_delimiter) . "'si";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $str = "<?php elseif(" . $matches[1][$key] . "): ?>";
                $data = $this->format_var($str);
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        $patt = "'" . preg_quote($this->left_delimiter) . "else" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $data = "<?php else: ?>";
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        $patt = "'" . preg_quote($this->left_delimiter) . "/if" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $data = "<?php endif;?>";
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        return $contents;
    }

    
    function format_var($data)
    {
        $patt = "/([^[])\\$([a-zA-Z0-9_\.]+)/";
        
        if (preg_match_all($patt, $data, $matches)) {
            $matches[2] = array_unique($matches[2]);
            foreach($matches[2] as $key => $var) {
                if ($var == 'this')
                    continue;
                if ($var == 'GLOBALS')
                    continue;
                $data = preg_replace("/\\$" . preg_quote($matches[2][$key]) . "([^a-zA-Z0-9_\.])/", $this->format_control_local($var) . "\\1", $data);
            }
        }
        
        $patt = "/([^[])\\*([a-zA-Z0-9_\.]+)/";
        
        if (preg_match_all($patt, $data, $matches)) {
            foreach($matches[2] as $key => $var) {
                $data = preg_replace("/\\$" . preg_quote($matches[2][$key]) . "([^a-zA-Z0-9_\.])/", $this->format_control_local($var) . "\\1", $data);
                $data = str_replace($matches[0][$key] . ' ', $matches[1][$key] . $this->format_control_global($var) . ' ', $data);
            }
        }
        return $data;
    }

    
    function format_control_local($string)
    {
        $header = "\$this->tpl_vars";
        
        if (strpos($string, '.')) {
            $data = explode('.', $string);
            $string = '';
            
            foreach($data as $key => $var) {
                $var = $this->parse_tag_format_varIN($var);
                $string .= "['" . $var . "']";
            }
            $string = $header . $string;
        }
        else {
            $string = $header . "['" . $string . "']";
        }
        
        return $string;
    }

    
    function format_control_global($string)
    {
        $header = "\$GLOBALS";
        
        if (strpos($string, '.')) {
            $data = explode('.', $string);
            $string = '';
            
            foreach($data as $key => $var) {
                $string .= "['" . $var . "']";
            }
            $string = $header . $string;
        
        }
        else {
            $string = $header . "['" . $string . "']";
        }
        
        return $string;
    }

    function parseLoop(&$contents)
    {
        $patt = "'" . preg_quote($this->left_delimiter) . "loop[\s]+([\S]+)[\s]+var=([a-zA-Z0-9_]+)[\s]*" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $str = "<?php if(!empty(" . $matches[1][$key] . " )): \n foreach (" . $matches[1][$key] . " as  \$this->tpl_vars['" . $matches[2][$key] . "']): ?>";
                $data = $this->format_var($str);
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        $patt = "'" . preg_quote($this->left_delimiter) . "loop[\s]+([\S]+)[\s]+key=([a-zA-Z0-9_]+)[\s]+var=([a-zA-Z0-9_]+)[\s]*" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $str = "<?php if(!empty(" . $matches[1][$key] . " )): \n foreach (" . $matches[1][$key] . " as  \$this->tpl_vars['" . $matches[2][$key] . "']=>\$this->tpl_vars['" . $matches[3][$key] . "']): ?>";
                $data = $this->format_var($str);
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        $patt = "'" . preg_quote($this->left_delimiter) . "loop[\s]+([\S]+)[\s]+var=([a-zA-Z0-9_]+)[\s]+key=([a-zA-Z0-9_]+)[\s]*" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $str = "<?php if(!empty(" . $matches[1][$key] . " )): \n foreach (" . $matches[1][$key] . " as  \$this->tpl_vars['" . $matches[3][$key] . "']=>\$this->tpl_vars['" . $matches[2][$key] . "']): ?>";
                $data = $this->format_var($str);
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        $patt = "'" . preg_quote($this->left_delimiter) . "/loop" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $data = "<?php endforeach; endif;?>";
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        //------------------------------------foreach------------------------------------
        $patt = "'" . preg_quote($this->left_delimiter) . "foreach[\s]+name=\"([\S]+)\"[\s]+var=\"([a-zA-Z0-9_]+)\"[\s]*" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $str = "<?php if(!empty(\$" . $matches[1][$key] . " )): \n foreach (\$" . $matches[1][$key] . " as  \$this->tpl_vars['" . $matches[2][$key] . "']): ?>";
                $data = $this->format_var($str);
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        $patt = "'" . preg_quote($this->left_delimiter) . "foreach[\s]+name=\"([\S]+)\"[\s]+key=\"([a-zA-Z0-9_]+)\"[\s]+var=\"([a-zA-Z0-9_]+)\"[\s]*" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $str = "<?php if(!empty(\$" . $matches[1][$key] . " )): \n foreach (\$" . $matches[1][$key] . " as  \$this->tpl_vars['" . $matches[2][$key] . "']=>\$this->tpl_vars['" . $matches[3][$key] . "']): ?>";
                $data = $this->format_var($str);
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        $patt = "'" . preg_quote($this->left_delimiter) . "foreach[\s]+name=\"([\S]+)\"[\s]+var=\"([a-zA-Z0-9_]+)\"[\s]+key=\"([a-zA-Z0-9_]+)\"[\s]*" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $str = "<?php if(!empty(\$" . $matches[1][$key] . " )): \n foreach (\$" . $matches[1][$key] . " as  \$this->tpl_vars['" . $matches[3][$key] . "']=>\$this->tpl_vars['" . $matches[2][$key] . "']): ?>";
                $data = $this->format_var($str);
                $contents = str_replace($var, $data, $contents);
            }
        }
        
        $patt = "'" . preg_quote($this->left_delimiter) . "/foreach" . preg_quote($this->right_delimiter) . "'siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[0] as $key => $var) {
                $data = "<?php endforeach; endif;?>";
                $contents = str_replace($var, $data, $contents);
            }
        }
        return $contents;
    }

    function parseInclude($contents)
    {
        $patt = "/" . preg_quote($this->left_delimiter) . "include:[\s]*file[\s]*=[\s]*\"(.*)\"[\s]*" . preg_quote($this->right_delimiter) . "/siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[1] as $key => $var) {
                $contents = str_replace($matches[0][$key], $this->parse_include_format($var), $contents);
            }
        }
        return $contents;
    }

    
    function path2name($string)
    {
        $string = str_replace('./', '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace('/', '_', $string);
        $string = str_replace('\\', '_', $string);
        $string = str_replace('..', '--', $string);
        $string = str_replace('.', '-', $string);
        $string = str_replace(':', '%', $string);
        return $string;
    }

    
    function parse_include_format($string)
    {
        $header = "<?php include(\$this->compile_dir.\"";
        $string = str_replace('"', '', $string);
        $string = str_replace("'", '', $string);
        $string = str_replace(' ', '', $string);
        
        if (strpos('Jerry' . $string, "file:")) {
            $string = str_replace("file:", '', $string);
            //$new_name = $this->compile_dir.$this->compilefile_prefix . 'include_'.$this->path2name($string).'.html';
            //$this->compile_name  = $this->compile_dir . $this->compilefile_prefix . $this->format($this->template_name);
            $new_name = $this->compilefile_prefix . $this->format($this->template_dir . $string);
            
            if ($this->compile($string, $new_name)) {
                $string = "<?php include(\"" . $new_name . "\");?>";
            }
            else {
                $string = "<b>Template error : </b>unable to compile template: <b>{$string}</b>";
            }
        }
        elseif (strpos('Jerry' . $string, "http://")) {
            $string = "<?php include(\"" . $string . "\");?>";
        }
        elseif (strpos('Jerry' . $string, "{\$")) {
            eval("\$string = \"$string\";");
            $new_name = $this->compilefile_prefix . $this->format($this->template_dir . $string);
            
            if ($this->compile($string, $new_name)) {
                $string = "<?php include(\"" . $new_name . "\");?>";
            }
            else {
                $string = "<b>Template error : </b>unable to compile template: <b>{$string}</b>";
            }
        }
        elseif (strpos('Jerry' . $string, "../")) {
            $num = 0;
            $dir = '';
            $data = explode('/', $string);
            
            foreach($data as $var) {
                if ($var == '..')
                    $num ++;
            }
            
            $string = str_replace('../', '', $string);
            $string = str_replace('./', '', $string);
            $data = explode('/', $this->template_dir);
            
            $num = count($data) - $num - 1;
            
            for($i = 0; $i < $num; $i ++) {
                $dir .= $data[$i] . '/';
            }
            
            $new_name = $this->compile_dir . $this->compilefile_prefix . $this->format($this->template_dir . $string);
            
            if ($this->compile($dir . $string, $new_name)) {
                $string = "<?php include(\"" . $new_name . "\");?>";
            }
            else {
                $string = "<b>Template error : </b>unable to compile template: <b>{$string}</b>";
            }
        
        }
        else {
            $new_name = $this->compilefile_prefix . $this->format($this->template_dir . $string);
            
            if ($this->compile($this->template_dir . $string, $new_name)) {
                $string = "<?php include(\"" . $this->compile_dir . $new_name . "\");?>";
            }
            else {
                $string = "<b>Template error : </b>unable to compile template: <b>{$string}</b>";
            }
        
        }
        
        return $string;
    }

    
    function parseGet($contents)
    {
        $patt = "/" . preg_quote($this->left_delimiter) . "get:[\s]+file=(.*)[\s]*" . preg_quote($this->right_delimiter) . "/siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[1] as $key => $var) {
                $contents = str_replace($matches[0][$key], $this->parse_get_format($var), $contents);
            }
        }
        return $contents;
    }

    
    function parse_get_format($string)
    {
        $header = "<?php include(\"" . $this->template_dir;
        $string = str_replace('"', '', $string);
        $string = str_replace("'", '', $string);
        $string = str_replace(' ', '', $string);
        
        $num = 0;
        $dir = '';
        
        if (strpos('Jerry' . $string, "file:")) {
            $string = str_replace("file:", '', $string);
            $string = "<?php include(\"" . $string . "\");?>";
        }
        elseif (strpos('Jerry' . $string, "http://")) {
            $string = str_replace("http:\/\/", '', $string);
            $string = "<?php include(\"" . $string . "\");?>";
        }
        elseif (strpos('Jerry' . $string, "{\$")) {
            $string = "<?php include(\"" . $string . "\");?>";
        }
        elseif (strpos('Jerry' . $string, "../")) {
            $data = explode('/', $string);
            
            foreach($data as $var) {
                if ($var == '..')
                    $num ++;
            }
            
            $string = str_replace('../', '', $string);
            $string = str_replace('./', '', $string);
            $data = explode('/', $this->template_dir);
            $num = count($data) - $num - 1;
            
            for($i = 0; $i < $num; $i ++) {
                $dir .= $data[$i] . '/';
            }
            $string = "<?php include('" . $dir . $string . "');?>";
        
        }
        else {
            $string = str_replace('./', '', $string);
            $string = $header . $string . "\");?>";
        }
        
        return $string;
    }

    function parseTagFunc($contents)
    {
        $patt = "/" . preg_quote('[') . "@([\S^(]+)\(([^]]+)\)" . preg_quote(']') . "/siU";
        
        if (preg_match_all($patt, $contents, $matches)) {
            foreach($matches[1] as $key => $var) {
                $contents = str_replace($matches[0][$key], $this->parse_tag_func_format($var, $matches[2][$key]), $contents);
            }
        }
        
        return $contents;
    
    }

    function parse_tag_func_format($funName, $params)
    {
        $header = "<?php echo ";
        $patt = "/\\$([a-zA-Z0-9_\.]+)/si";
        
        if (preg_match_all($patt, $params, $matches)) {
            foreach($matches[1] as $key => $var) {
                $params = str_replace($matches[0][$key], $this->parse_tag_format_var2($var), $params);
            }
        }
        
        $string = $header . $funName . '(' . $params . ");?>";
        
        return $string;
    }

}

?>