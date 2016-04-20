<?php
/**
 * taomee 公共函数库
 *
 * @category  Taomee
 * @package   Common
 * @author    Rooney<Rooney@taomee.com>
 */

/**
 +----------------------------------------------------------
 * URL重定向
 +----------------------------------------------------------
 * @static
 * @access public
 +----------------------------------------------------------
 * @param string $url  要定向的URL地址
 * @param integer $time  定向的延迟时间，单位为秒
 * @param string $msg  提示信息
 +----------------------------------------------------------
 */
function redirect($url, $time = 0, $msg = '')
{
    //多行URL地址支持
    $url = str_replace(array(
        "\n", "\r"
    ), '', $url);
    if (empty($msg)) {
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    }
    if (! headers_sent()) {
        // redirect
        //header("Content-Type:text/html; charset=" . C('OUTPUT_CHARSET'));
        if (0 === $time) {
            header("Location: " . $url);
        }
        else {
            header("refresh:{$time};url={$url}");
            echo ($msg);
        }
        exit();
    }
    else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0) {
            $str .= $msg;
        }
        exit($str);
    }
}

/**
 * 显示变量值
 *
 * @param unknown_type $var
 */
function pr($var, $exit=false)
{
    echo '<pre style="font-size:16px; color:#0000FF">';
    if (is_array($var)){
        print_r($var);
    }else if(is_object($var)){
        echo get_class($var)." Object";
    }else if(is_resource($var)){
        echo (string)$var;
    }else{
        echo var_dump($var);
    }
      echo '</pre>';
      if ($exit) exit;
}

/**
 +----------------------------------------------------------
 * 优化的require_once
 +----------------------------------------------------------
 * @param string $filename 文件名
 +----------------------------------------------------------
 * @return boolean
 +----------------------------------------------------------
 */
function require_cache($file_name)
{
    static $_import_files = array();
    if (file_exists($file_name)) {
        if (! isset($_import_files[$file_name])) {
            require $file_name;
            $_import_files[$file_name] = true;
            return true;
        }
        return false;
    }
    return false;
}

/**
 +----------------------------------------------------------
 * 优化的include_once
 +----------------------------------------------------------
 * @param string $filename 文件名
 +----------------------------------------------------------
 * @return boolen
 +----------------------------------------------------------
 */
function include_cache($file_name)
{
    static $_import_files = array();
    if (file_exists($file_name)) {
        if (! isset($_import_files[$file_name])) {
            include $file_name;
            $_import_files[$file_name] = true;
            return true;
        }
        return false;
    }
    return false;
}

/**
 * 自定义错误处理
 *
 * @access public
 *
 * @param int $errno 错误类型
 * @param string $errstr 错误信息
 * @param string $errfile 错误文件
 * @param int $errline 错误行数
 *
 * @return void
 */
function taomee_error($errno, $errstr, $errfile, $errline)
{
    switch($errno)
    {
        case E_ERROR:
        case E_USER_ERROR:
            $e_str = "ERROR: [$errno] $errstr " . basename($errfile) . " 第  $errline 行.\r\n";
            Log::write($e_str, APP_WEB_LOG_ERROR);
            exit();
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $e_str = "WARNING: [$errno] $errstr " . basename($errfile) . " 第  $errline 行.\r\n";
            break;
        case E_STRICT:
        case E_NOTICE:
        case E_USER_NOTICE:
        default:
            if(!defined('VERSION') || VERSION != 'release') {
                $e_str = "NOTICE: [$errno] $errstr " . basename($errfile) . " 第  $errline 行.\r\n";
            }
            else {
                $e_str = '' ;
            }
            //Log::record($errorStr);
            break;
    }

    if($e_str) {
        Log::write($e_str, APP_WEB_LOG_ERROR);
    }
}

function taomee_exception($e)
{
    $e_str = "Unknown Exception: " . $e->getMessage();
    Log::write($e_str, APP_WEB_LOG_ERROR);
}

/**
 * 递归的给数组执行 htmlspecialchars()
 *
 */
if( !function_exists('htmlspecialchars_deep')) {
    function htmlspecialchars_deep ($arr)
    {
        if(is_array($arr)) {
            foreach ($arr as &$val) {
                $val = htmlspecialchars_deep($val) ;
            }
        }
        else {
            $arr = htmlspecialchars($arr) ;
        }
        return $arr ;
    }
}

function get_mysql_connect(){
    global $database;

    require_once 'service/lib/wdb_pdo.class.php';
    $dsn = WDB_PDO::build_dsn($database["user"]["name"], $database["user"]["host"], $database["user"]["port"]);
    $db = new WDB_PDO($dsn, $database["user"]["user"], $database["user"]["passwd"], 'latin1');

    return $db;

}

function get_all_kinds(){
    $db = get_mysql_connect();
    $sql = "SELECT id,auth,title FROM t_kind";
    $result = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
    return $result;
}

/**
 * Get user powers from user-power-mgr system
 *
 * @param     string    $user_name
 * @param     string     $passwd
 * @param     int     $system_id
 * @param     int     $result_format
 * @return    mixed     return an array on success, or FALSE on error
 */
function user_login($user_name, $passwd)
{
//	global $admin_list;
//	global $admin_id_list;
    // Check if parameters are valid
    if (!is_string($user_name))
    {
        return array('status_code'=>1001,'err_desc'=>'用户名非法!');
    }

    if (empty($passwd) || empty($user_name))
    {
        return array('status_code'=>1003,'err_desc'=>'用户名或密码不能为空!');
    }

    $passwd = md5($passwd);
    $db = get_mysql_connect();
    $sql = "SELECT id FROM t_user WHERE user_state = 1 AND user_name = '".$user_name."' AND `password` = '".$passwd."'";
    $data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);

    if(!empty($data)){
        return array('id' => $data[0]["id"]);
    }else{
        return false;
    }
//	if(array_key_exists($user_name,$admin_list))
//	{
//		if($admin_list[$user_name] == $passwd)
//		{
//			return array('id' => $admin_id_list[$user_name]);
//		}
//		else
//		{
//			return false;
//		}
//	}
//	else
//	{
//		return false;
//	}
}
?>
