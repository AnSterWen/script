<?php


/**
 * 
 * 数据验证类
 * 
 * @category    Util
 * @package     Util
 * @author      Rooney <Rooney@taomee.com>
 * 
 */
class Validation extends Base
{
    /**
     +----------------------------------------------------------
     * 预定义验证格式
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    static $regex = array(
        'require' => '/.+/', //匹配任意字符，除了空和断行符
		'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', 
		'phone' => '/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/', 
      //'mobile' => '/^((\(\d{2,3}\))|(\d{3}\-))?(13|15)\d{9}$/',
        'mobile' => '/^[0]?[1][358][\d]{9}$/', 
        'url' => '/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/', 
        'currency' => '/^\d+(\.\d+)?$/', 
        'number' => '/^\d+$/', 
        'zip' => '/^[1-9]\d{5}$/', 
        'qq' => '/^[1-9]\d{4,12}$/', 
        'integer' => '/^[-\+]?\d+$/', 
        'double' => '/^[-\+]?\d+(\.\d+)?$/', 
        'english' => '/^[A-Za-z]+$/', 
        'chinese' => '/^[\x{4e00}-\x{9fa5}]+$/u', 
        'username' => '/^[\w\-\.]{2,16}$/', 
        'username_cn' => '/^[\x{4e00}-\x{9fa5}]+$/u' 
    );
    
    static $all_auth_list = array();
    //static $user_auth_list = array();

    /**
     +----------------------------------------------------------
     * 验证数据项
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $checkName 验证的数据类型名或正则式
     * @param string $value  要验证的数据
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    static function check($value, $checkName)
    {
        if ($checkName == 'email') {
            return self::check_email_address($value);
        }
        else {
            $matchRegex = self::get_regex($checkName);
            return preg_match($matchRegex, trim($value));
        }
    }

    /**
     +----------------------------------------------------------
     * 取得验证类型的正则表达式
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $name 验证类型名称
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    static function get_regex($name)
    {
        if (isset(self::$regex[strtolower($name)])) {
            return self::$regex[strtolower($name)];
        }
        else {
            return $name;
        }
    }

    /**
     * 检测email 的格式
     *
     * @param    string $email
     * @return   bool
     */
    static function check_email_address($email)
    {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (! ereg("[^@]{1,64}@[^@]{1,255}", $email)) {
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for($i = 0; $i < sizeof($local_array); $i ++) {
            if (! ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
                return false;
            }
        }
        if (! ereg("^\[?[0-9]{1,3}\.[0-9]{1,3}\.[?[0-9]{1,3}\.[0-9]{1,3}\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for($i = 0; $i < sizeof($domain_array); $i ++) {
                if (! ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 验证用户权限
     * 
     * @param  string $aid action id, 该action的唯一标识
     * @return bool 
     */
    static function valid_auth($aid)
    {
        $auth_list = unserialize($_SESSION['user_auth_list']);
        if (!isset(self::$all_auth_list[$aid])) {
            return true;
        }
        else {
            if (empty($auth_list)) {
                return false;
            }
            else {
                clearstatcache() ;                           
                if (in_array(self::$all_auth_list[$aid], $auth_list)) {
                    return true;
                }
                else {
                    return false;
                }
            }
        }
    }

    /**
     * 加载权限文件
     *
     * @param  mixed  $arr
     * @param  int    $flag 1 all_auth_list, 2 user_auth_list
     * @return unknown
     */
    static function load_auth($arr, $flag)
    {
        if ($flag == 1) {
            self::$all_auth_list = $arr;
        }
        elseif ($flag == 2) {
            //self::$user_auth_list = $arr;
        }
        else {
            return false;
        }
        return true;
    }
    
    /**
     * 判断米米号是否合法
     * 
     * @param  int  $id  米米号
     * @return bool
     */
    static function valid_userid($id)
    {
        if(is_numeric($id)) {
	        $id = intval($id) ;
	        return  (($id >= 10000)&&($id < 9999999999)) ? true : false ;
        }
        else {
            return self::check_email_address($id, 'email') ;
        }
    }

} //类定义结束
?>