<?php
class User extends Base 
{	
	// 单例对象
	private static $instance = null;
	
	/**
	 * 构造函数
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 单例
	 */
	static function get_instance()
	{
		if (null === self::$instance)
		{
			self::$instance = new User();
		}
		return self::$instance;		
	}
	
	/**
	 * 用户登录操作
	 */
	public function login($user_name, $user_id)
 	{
		$_SESSION['item_user_id'] 		 = $user_id;
 	    $_SESSION['item_user_name']      = $user_name;
		//$_SESSION['user_auth_list']      = serialize($auth_list);
	}
	
	/**
	 * 注销
	 */
	public function logout()
	{
		$_SESSION = array();
	}
	
	/**
	 * 判断用户是否登录
	 */
	public function is_login()
	{
	    if (isset($_SESSION['item_user_id']) && !empty($_SESSION['item_user_id']))
		{	
		    return true;
		}
		else
		{
		    return false;
		}
	}
	
	/**
	 * 获取用户名
	 * @return user_name
	 */
	public function get_user_name()
	{
		return $_SESSION['item_user_name'];
	}
	
	/**
	 * 获取用户ID
	 * @return user_id
	 */
	public function get_user_id()
	{
		return $_SESSION['item_user_id'];
	}
	
	/**
	 * 获取用户有权限看到的树结构的数组
	 * @return auth_list
	 */
	public function get_auth_list()
	{
	    global $product_config;

        $uid = $this->get_user_id();
//	    if (!isset($_SESSION['item_user_tree']))
//	    {
            $db = get_mysql_connect();
            $sql = "SELECT auth FROM t_user_auth WHERE user_id = ".$uid;
            $results = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);

            $array = array();
            foreach($results as $result){
                $array[$result["auth"]] = $product_config[$result["auth"]];
            }
            $product_config = $array;

			foreach ($product_config as $key => &$val)
			{
				foreach($val['list'] as $key2 => $val2) 
				{
					$val['list'][$key2] = $val2['url'] ;
				}
				// 对已有的数组进行重组;
				if(empty($val['list'])) unset($product_config[$key]) ;				
			}
			// 经过权限过滤过的树形结构
			$_SESSION['item_user_tree'] = serialize($product_config) ;
//	    }
	    return unserialize($_SESSION['item_user_tree']);
	}

    function first_auth(){
        $uid = $this->get_user_id();
        $db = get_mysql_connect();
        $sql = "SELECT k.auth FROM t_kind k JOIN t_user_auth ua ON ua.auth = k.auth WHERE k.auth != 'admin_user' AND ua.user_id = ".$uid." GROUP BY k.`index` ASC";
        $results = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
//        print_r($results);
        return $results[0]["auth"];
    }

	/**
	 * 判断权限ID是否在权限列表中
	 */
	function is_valid_action($action_id)
	{
		$auth_list = unserialize($_SESSION['user_auth_list']) ;
		return in_array($action_id, $auth_list);
	}

	/**
	 * 设置用户请求链接
	 * @param string $req_url
	 * @return 
	 */	
	public function set_req_url($req_url)
	{
		$_SESSION['item_req_url'] = $req_url;
	}
	
	/**
	 * 获取用户请求链接
	 * @return string $req_url
	 */
	public function get_req_url()
	{
		return isset($_SESSION['item_req_url']) ? $_SESSION['item_req_url'] : '';
	}
}
?>
