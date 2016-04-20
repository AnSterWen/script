<?php 
  class  itemController extends BaseController
  {
	private $product = NULL;
  	public function  __construct($m)
	{		
		global $product_config;
		parent::__construct();
		require_once(TAOMEE_PATH . 'Lib/Util/Page.class.php');
		$this->m = $m;
		$this->product = $product_config[$this->m];
	}
	
	/*默认action*/
    public function indexAction()
    {
    	$this->getitemlistAction();
    }

    public function delete_userAction(){
        $id = $this->http->get("id");
        $db = get_mysql_connect();
        $sql = "Update t_user SET user_state = 0 WHERE id = ".$id;
        $result = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
        echo 'ok';
    }

    public function submit_userAction(){
          $user_name = $this->http->get("user_name");
          $password = $this->http->get("user_password");
          $auths = $this->http->get("auth");

          $auths = explode(",",$auths);

          $db = get_mysql_connect();
          $sql = "SELECT id FROM t_user WHERE user_state = 1 AND user_name = ".$user_name;
          $result = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
          if(!$result){
              $password = md5($password);
              $time = new DateTime('now');
              $time = $time->format("Y-m-d H:i");

              $insert_sql = "INSERT INTO `t_user`
                (`user_name`,`password`,`user_state`,`user_reg_datetime`) VALUES
                ('".$user_name."','".$password."','1','".$time."')";
              $db->execute($insert_sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
              $sql_getId = "select LAST_INSERT_ID()";
              $uid = $db->execute($sql_getId, WDB_PDO::SQL_RETURN_TYPE_ALL);
              $uid = $uid[0]["LAST_INSERT_ID()"];

              foreach($auths as $auth){
                  if($auth != ""){
                      $auth_sql = "INSERT INTO `t_user_auth` (`user_id`, `auth`, `grant_datetime`) VALUES ('".$uid."', '".$auth."', '".$time."')";
                      $db->execute($auth_sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
                  }
              }
              echo "ok";
          }else{
              echo "用户名重复！";
          }
      }

    public function add_userAction(){
        $this->response->set('m',$this->http->get('m',true));
        $this->response->set('a',$this->http->get('a',true));

        $kinds = get_all_kinds();
        $this->response->set('kinds',$kinds);

        $this->response->set('layout_right_file', 'User/add_user.html');
        if ($this->http->has('ajax'))
        {
            echo $this->view->ajax_return('User/add_user.html');
        }
        else
        {
            $this->view->display();
        }

    }


    public function user_listAction(){


        $page_index    = $this->http->has('page')       ? $this->http->get('page') : 1;
        $page_size     = defined('ITEM_LIST_PAGE_SIZE') ? ITEM_LIST_PAGE_SIZE      : 10;

        $db = get_mysql_connect();
        $sql = "SELECT * FROM t_user WHERE user_state = 1";
        $result = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);

        $this->response->set('title', '用户');
        $this->response->set('model', $this->m);

        $this->response->set('result',$result);
        $this->response->set('layout_right_file', 'User/user_list.html');
        if ($this->http->has('ajax'))
        {
            echo $this->view->ajax_return('User/user_list.html');
        }
        else
        {
            $this->view->display();
        }
    }
    
    /**
     * 获取赛尔2米币商品列表
     */
    public function getitemlistAction()
    {
	    global $item_arr_error;

	    $product_id    = $this->http->has('item_id')      ? $this->http->get('item_id')      : NULL;
	    $product_name  = $this->http->has('item_name')    ? $this->http->get('item_name')    : NULL;
	    $game_id       = $this->http->has('item_game_id') ? $this->http->get('item_game_id') : NULL;
        $index_id      = $this->http->has('index_id')? $this->http->get('index_id'):NULL;

        if($this->http->has('type') && $this->http->get('type') == 'post'){
            $_SESSION['product_id'] = $product_id;
            $_SESSION['product_name'] = $product_name;
            $_SESSION['game_id'] = $game_id;
            $_SESSION['index_id'] = $index_id;
        }else{
            $product_id = $_SESSION['product_id'];
            $product_name = $_SESSION['product_name'];
            $game_id = $_SESSION['game_id'];
            $index_id = $_SESSION['index_id'];
        }

	    $page_index    = $this->http->has('page')       ? $this->http->get('page') : 1;
	    $page_size     = defined('ITEM_LIST_PAGE_SIZE') ? ITEM_LIST_PAGE_SIZE      : 10;

	    $data = array(
	        'cmd'          =>    $this->product['precmd'].'01',
	        'product_id'   =>    $product_id,
	        'game_id'	   =>    $game_id,
	        'product_name' =>    $product_name,
	        'page_index'   =>    $page_index,
	        'page_size'    =>    $page_size,
            'index_id' => $index_id,
            'm' => $this->m,
	    );

	    $result = itemModel::send($data);
	    //翻页类
	    $str_page = new Page($result['data']['count'],  $page_index,  $page_size,
				'm='.$this->m.'&a=getitemlist&item_id='.$product_id.'&item_name='.$product_name.'&item_game_id='.$game_id);
	    if (isset($result['result']) && $result['result'] != 0)
	    {
	        $this->response->set('err_str','查询商品列表出错：'.$item_arr_error[$result['result']]);
	    }
	    elseif (isset($result['result']) && $result['result'] == 0)
	    {
	        $this->response->set('page_bar', $str_page->show());
		    $this->response->set('goto_bar', $str_page->goto_page());
	    }
	    else 
	    {
	        $this->response->set('err_str','系统错误!请联系管理员!');
	    }
		
	    //查询条件
	    $query_data = array(
	        'item_id'      => $product_id,
	    	'item_name'    => $product_name,
	        'item_game_id' => $game_id,
            'index_id' => $index_id
	    );


	    foreach ($result['data']['product_list'] as &$val)
	    {
            $val['org_discount'] = $val['discount'];
	        if ($val['discount'] == 100)
	            $val['discount'] = '不打折';
	        else 
	            $val['discount'] = ($val['discount']/10).'折';
	            
	        $val['price'] = $val['price']/100;

            $p_items = json_decode($val['items']);
//            $val['items'] = key($p_items);
            $val['base'] = current($p_items)->base;
            $val['gift'] = current($p_items)->gift;
	    }

	    //判断用户是否具有修改商品的权限
	    $this->response->set('edit_flag',true);
	    
		$this->response->set('title', $this->product['title']);
		$this->response->set('model', $this->m);
	    
	    $this->response->set('page',$page_index);
	    $this->response->set('query_data',$query_data);
	    $this->response->set('arr_item_list', $result['data']['product_list']);
	    $this->response->set('layout_right_file', 'Item/item_list.html');
	    if ($this->http->has('ajax'))
		{
		    echo $this->view->ajax_return('Item/item_list.html');
		}
		else
		{
			$this->view->display();
		}
    }
    
    
    /**
     * 
     * 添加赛尔2米币商品页面
     */
    public function addmbitempageAction()
    {
        $pname    = $this->http->has('pname')      ? $this->http->get('pname')      : NULL;
        $itemid    = $this->http->has('item_id')      ? $this->http->get('item_id')      : NULL;
        $count    = $this->http->has('count')      ? $this->http->get('count')      : NULL;
        $base    = $this->http->has('base')      ? $this->http->get('base')      : NULL;
        $gift    = $this->http->has('gift')      ? $this->http->get('gift')      : NULL;
        $price    = $this->http->has('price')      ? $this->http->get('price')      : NULL;
        $discount    = $this->http->has('discount')      ? $this->http->get('discount')      : NULL;
        $start    = $this->http->has('start')      ? $this->http->get('start')      : NULL;
        $end    = $this->http->has('end')      ? $this->http->get('end')      : NULL;
        $category    = $this->http->has('category')      ? $this->http->get('category')      : NULL;
        $j_flag    = $this->http->has('j_flag')      ? $this->http->get('j_flag')      : NULL;

        $item_info = array(
            'product_name'=>$pname,
            'itemid'=>$itemid,
            'count'=>$count,
            'gift'=>$gift,
            'base'=>$base,
            'price'=>$price,
            'discount'=>$discount,
            'start'=>$start,
            'end'=>$end,
            'category'=>$category,
            'm' => $this->m,
        );
        $this->response->set('item_info', $item_info);
		$this->response->set('title', $this->product['title']);
		$this->response->set('model', $this->m);
		$this->response->set('flag', intval($this->product['precmd'], 16));
	    $this->response->set('layout_right_file', 'Item/add_item.html');
        $this->response->set('j_flag',$j_flag);

	    if ($this->http->has('ajax'))
		{
		    echo $this->view->ajax_return('Item/add_item.html');
		}
		else
		{
			$this->view->display();
		}
    }
    
    /**
     * 
     * 添加赛尔2米币商品
     */
    public function addmbitemAction()
	{
	    $game_id            = $this->http->get('item_game_id');       
		$count			    = $this->http->get('item_count');
	    $product_name       = $this->http->get('item_name');   
	    $price              = $this->http->get('item_price');     
	    $discount           = $this->http->get('user_discount');        
	    $is_valid           = $this->http->get('if_effective');
		$category		    = $this->http->get('item_category');
        $product_attr = $this->http->get('product_attr');
        $add_times = $this->http->get('add_times');
        $extend_data = $this->http->get('extend_data');
        $product_third_name = $this->http->get('product_third_name');
        $client_version = $this->http->get('client_version');
        $third_price = $this->http->get('third_price');

		$items = array($game_id => array('base' => $count));
		if ($this->http->has('item_gift')) {
			$gift = $this->http->get('item_gift');
			if ($gift) $items[$game_id]['gift'] = $gift;
		}

	    $data = array(
	        'cmd'			        => $this->product['precmd'].'03',	
		    'game_id'               => json_encode($items),
		    'product_name'          => $product_name,   
			'itemid'		        => $game_id,
			'count'			        => $count,
		    'price'                 => $price,     
		    'discount'              => $discount,       
		    'start'                 => date('Y-m-d H:i'),
		    'end'                   => date('Y-m-d H:i'),
		    'is_valid'              => $is_valid,
		    'category'              => $category,
            'product_attr' => $product_attr,
            'add_times'  => $add_times,
            'extend_data' => $extend_data,
            'm' => $this->m,
            'product_third_name' => $product_third_name,
            'client_version' => $client_version,
            'third_price' => $third_price,
	    );

		if ($this->http->has('start')) {
			$data['start'] = $this->http->get('start');
		}

		if ($this->http->has('end')) {
			$data['end'] = $this->http->get('end');
		}
	    
	    if ($game_id == NULL ||
            $product_name == NULL ||
	        $price == NULL ||
            $discount == NULL ||
            $is_valid == NULL)
            {
                $this->response->set('err_str','添加商品时出错:提交信息不全!');
                $this->response->set('item_info',$data);
                $this->addmbitempageAction();
            }
	    
		$result = itemModel::send($data);
		if(isset($result['result']) && $result['result'] == 0)
		{
			$a_login = array(
				'game'  => $this->m,
				'uid'   => $this->user->get_user_id(),
				'uname' => $this->user->get_user_name(),
				'item'  => $result['product_id'],
				'desc'  => '添加商品',
			);
			audit($a_login);

			$this->response->set('ok_str','添加成功!');
			$this->response->set('front_url','index.php?m='.$this->m.'&a=addmbitempage');
			$this->response->set('layout_right_file', 'Common/ok.html') ;
			$this->view->display();
		} elseif(isset($result['result']) && $result['result'] != 0) {
    		global $item_arr_error;
			$this->response->set('err_str','添加商品时出错:'.$item_arr_error[$result['result']]);
			$this->response->set('item_info',$data);
			$this->addmbitempageAction();
		} else {
			$this->response->set('err_str','系统错误!请联系管理员!');
			$this->response->set('item_info',$data);
			$this->addmbitempageAction();
		}
	}
	    
   /**
    * 
    * 编辑米币商品页面
    */
	public function edititempageAction()
	{
	    global $item_arr_error;
	    $product_id = $this->http->get('item_id');
	    $quest_from = $this->http->get('quest_from');
	    
	    $pid   = $this->http->get('pid');
	    $gid   = $this->http->get('gid');
	    $pname = $this->http->get('pname');
	    $page  = $this->http->get('page');
	    $ptype = $this->http->get('ptype');
	   	$this->response->set('page',$page);
	    if (!empty($quest_from) && $quest_from == 1)
	    {
	        //根据商品ID获取该商品的相关信息
	        $item_data = array(
	            'cmd'         => $this->product['precmd'].'01',
	            'product_id'  => $product_id,
                'm'           => $this->m,
	        );
	        $product_info = itemModel::send($item_data);
	        if (isset($product_info['result']) && $product_info['result'] == 0)
	        {
				$product = $product_info['data']['product_list'][0];
				$items = json_decode($product['items'], true);
				$product['itemid'] = key($items);
				$product['count'] = $items[$product['itemid']]['base'];
				if (isset($items[$product['itemid']]['gift'])) {
					$product['gift'] = $items[$product['itemid']]['gift'];
				} else {
					$product['gift'] = 0;
				}
	            $this->response->set('item_info',$product);
	        } elseif (isset($product_info['result']) && $product_info['result'] != 0) {
                $this->response->set('err_str','获取商品信息时出错:'.$item_arr_error[$product_info['result']]);
            } else {
                $this->response->set('err_str','获取商品信息时发生系统错误，请联系管理员!');
            }
	    }
	    $this->response->set('front_url','index.php?m='.$this->m.'&a=index&item_id='.$pid.'&item_name='.$pname.'&item_game_id='.$gid.'&page='.$page.'&item_type='.$ptype);
	    $this->response->set('item_id',$product_id);

		$this->response->set('title', $this->product['title']);
		$this->response->set('model', $this->m);

	    $this->response->set('layout_right_file', 'Item/edit_item.html');
	    if ($this->http->has('ajax'))
		{
		    echo $this->view->ajax_return('Item/edit_item.html');
		}
		else
		{
			$this->view->display();
		}
	}
	
   /**
    * 
    * 编辑米币商品
    */
	public function edititemAction()
	{
	    global $item_arr_error;
	    
	    $product_id      = $this->http->get('item_id');         
	    $game_id         = $this->http->get('item_game_id');       
		$count			 = $this->http->get('item_count');
	    $product_name    = $this->http->get('item_name');   
	    $price           = $this->http->get('item_price');     
	    $discount = $this->http->get('user_discount'); 
	    $add_time =        $this->http->get('add_time'); 
	    $start   = $this->http->get('start'); 
	    $end     = $this->http->get('end');    
	    $is_valid        = $this->http->get('if_effective');
		$category		 = $this->http->get('item_category');
        $product_attr = $this->http->get('product_attr');
        $add_times = $this->http->get('add_times');
        $extend_data = $this->http->get('extend_data');
        $product_third_name = $this->http->get('product_third_name');
        $client_version = $this->http->get('client_version');
        $third_price = $this->http->get('third_price');
	   	$page			 = $_GET['page'];

	    //若修改时发生错误，则记录用户之前输入的信息
	    $data_back = array(
	        'product_id'      => $product_id,        
		    'item_game_id'         => $game_id,       
		    'item_count'         => $game_id,       
		    'product_name'    => $product_name, 
		    'price'           => $price,     
		    'discount' 		=> $discount,       
		    'start'   => $start,
		    'end'     => $end,   
		    'is_valid'        => $is_valid,
	        'add_time'        => $add_time,
            'add_times' => $add_times,
            'product_attr' => $product_attr,
            'extend_data' => $extend_data,
            'product_third_name' => $product_third_name,
            'client_version' => $client_version,
            'third_price' => $third_price,
            'm' => $this->m,
	    );

	    if ($product_id == NULL ||
            intval($game_id) == 0 ||
            $count == NULL ||
            $product_name == NULL ||
	        $price == NULL ||
            $discount == NULL ||
            $is_valid == NULL)
            {
                $this->response->set('err_str','修改商品时出错:提交信息不全!');
                $this->response->set('item_info',$data_back);
                $this->edititempageAction();
            }
	    else 
	    {
			$items = array($game_id => array('base' => $count));
			if ($this->http->has('item_gift')) {
				$gift = $this->http->get('item_gift');
				if ($gift) $items[$game_id]['gift'] = $gift;
			}

			$data = array(
				'cmd'			  => $this->product['precmd'].'09',	
				'product_id'      => $product_id,        
				'game_id'         => json_encode($items),
				'product_name'    => $product_name, 
				'price'           => $price,     
				'discount'			=> $discount,       
				'start'   => $start,
				'end'     => $end,   
				'is_valid'        => $is_valid,
				'category'        => $category,
                'product_attr' => $product_attr,
                'add_times'  => $add_times,
                'extend_data' => $extend_data,
                'product_third_name' => $product_third_name,
                'client_version' => $client_version,
                'third_price' => $third_price,
                'm' => $this->m,
			);

		    $result = itemModel::send($data);

		    if(isset($result['result']) && $result['result'] == 0) {
		        $a_login = array(
                    'game'  => $this->m,
			        'uid'   => $this->user->get_user_id(),
			        'uname' => $this->user->get_user_name(),
			        'item'  => $product_id,
			        'desc'  => '修改商品',
                );
                audit($a_login);

		        $this->response->set('ok_str','修改成功!');
				$front_url = 'index.php?m='.$this->m.'&a=getitemlist&page=' . $page;
				redirect($front_url);
		    } elseif(isset($result['result']) && $result['result'] != 0) {
				print_r($result);
		        $this->response->set('err_str','修改商品信息时出错:'.$item_arr_error[$result['result']]);
		        $this->response->set('item_info',$data_back);
			    $this->edititempageAction();
		    } else {
		        $this->response->set('err_str','系统错误!请联系管理员!');
			    $this->response->set('item_info',$data_back);
			    $this->edititempageAction();
		    }
	    }
	}


    /**
     * 获取赛尔2米币商品列表
     */
    public function getagentlistAction()
    {
	    global $item_arr_error;

	    $product_id    = $this->http->has('item_id')      ? $this->http->get('item_id')      : NULL;
	    $product_name  = $this->http->has('item_name')    ? $this->http->get('item_name')    : NULL;
	    $game_id       = $this->http->has('item_game_id') ? $this->http->get('item_game_id') : NULL;
	    
	    $page_index    = $this->http->has('page')       ? $this->http->get('page') : 1;
	    $page_size     = defined('ITEM_LIST_PAGE_SIZE') ? ITEM_LIST_PAGE_SIZE      : 10;
	    
	    $data = array(
	        'cmd'          =>    $this->product['precmd'].'01',
	        'product_id'   =>    $product_id,
	        'game_id'	   =>    $game_id,
	        'product_name' =>    $product_name,
	        'page_index'   =>    $page_index,
	        'page_size'    =>    $page_size,
            'm' => $this->m,
	    );

	    $result = itemModel::send($data);
	    //翻页类
	    $str_page = new Page($result['data']['count'],  $page_index,  $page_size, 
				'm='.$this->m.'&a=getagentlist&item_id='.$product_id.'&item_name='.$product_name.'&item_game_id='.$game_id);
	    if (isset($result['result']) && $result['result'] != 0)
	    {
	        $this->response->set('err_str','查询商品短代列表出错：'.$item_arr_error[$result['result']]);
	    }
	    elseif (isset($result['result']) && $result['result'] == 0)
	    {
	        $this->response->set('page_bar', $str_page->show());
		    $this->response->set('goto_bar', $str_page->goto_page());
	    }
	    else 
	    {
	        $this->response->set('err_str','系统错误!请联系管理员!');
	    }
		
	    //查询条件
	    $query_data = array(
	        'item_id'      => $product_id,
	    	'item_name'    => $product_name,
	        'item_game_id' => $game_id,
	    );
        //echo json_encode($query_data);

	    foreach ($result['data']['product_list'] as &$val)
	    {
	        if ($val['discount'] == 100)
	            $val['discount'] = '不打折';
	        else 
	            $val['discount'] = ($val['discount']/10).'折';
	            
	        $val['price'] = $val['price']/100;
	    }

	    
	    //判断用户是否具有修改商品的权限
	    $this->response->set('edit_flag',true);
	    
		$this->response->set('title', $this->product['title']);
		$this->response->set('model', $this->m);
	    
	    $this->response->set('page',$page_index);
	    $this->response->set('query_data',$query_data);
	    $this->response->set('arr_item_list', $result['data']['product_list']);
	    $this->response->set('layout_right_file', 'Item/agent_list.html');
	    if ($this->http->has('ajax'))
		{
		    echo $this->view->ajax_return('Item/agent_list.html');
		}
		else
		{
			$this->view->display();
		}
    }


	public function editagentpageAction()
	{
	    global $item_arr_error;
	    $product_id = $this->http->get('item_id');
	    $quest_from = $this->http->get('quest_from');
	    
	    $pid   = $this->http->get('pid');
	    $gid   = $this->http->get('gid');
	    $pname = $this->http->get('pname');
	    $page  = $this->http->get('page');
	    $ptype = $this->http->get('ptype');
	   	$this->response->set('page',$page); 
	    if (!empty($quest_from) && $quest_from == 1)
	    {
	        //根据商品ID获取该商品的相关信息
	        $item_data = array(
	            'cmd'         => $this->product['precmd'].'01',
	            'product_id'  => $product_id
	        );
	        $product_info = itemModel::send($item_data);
	        if (isset($product_info['result']) && $product_info['result'] == 0)
	        {
				$product = $product_info['data']['product_list'][0];
				$items = json_decode($product['items'], true);
				$product['itemid'] = key($items);
				$product['count'] = $items[$product['itemid']]['base'];
				if (isset($items[$product['itemid']]['gift'])) {
					$product['gift'] = $items[$product['itemid']]['gift'];
				} else {
					$product['gift'] = 0;
				}
	            $this->response->set('item_info',$product);
	        } elseif (isset($product_info['result']) && $product_info['result'] != 0) {
                $this->response->set('err_str','获取商品信息时出错:'.$item_arr_error[$product_info['result']]);
            } else {
                $this->response->set('err_str','获取商品信息时发生系统错误，请联系管理员!');
            }
	    }
	    $this->response->set('front_url','index.php?m='.$this->m.'&a=getagentlist&page=' . $page);
	    $this->response->set('item_id',$product_id);

		$this->response->set('title', $this->product['title']);
		$this->response->set('model', $this->m);

	    $this->response->set('layout_right_file', 'Item/agent_edit.html');
	    if ($this->http->has('ajax'))
		{
		    echo $this->view->ajax_return('Item/agent_edit.html');
		}
		else
		{
			$this->view->display();
		}
	}

   /**
    * 
    * 编辑商品短代编码
    */
	public function editagentAction()
	{
	    global $item_arr_error;
	    
	    $product_id      = $this->http->get('item_id');         
	    $product_name    = $this->http->get('item_name');   
	    $price           = $this->http->get('item_price');     
	   	$page			 = $_GET['page'];
		$mobile_mm_code	    = $this->http->get('item_mobile_mm');
		$mobile_game_code   = $this->http->get('item_mobile_game');
		$uni_woshop_code    = $this->http->get('item_unicom_woshop');
		$tel_game_code      = $this->http->get('item_telcom_game');
		$tel_esurfing_code  = $this->http->get('item_telcom_esurfing');

	    //若修改时发生错误，则记录用户之前输入的信息
	    $data_back = array(
	        'product_id'      => $product_id,        
		    'product_name'    => $product_name, 
		    'price'           => $price,     
		    'mobile_mm_code'        => $mobile_mm_code,
		    'mobile_game_code'      => $mobile_game_code,
		    'unicom_woshop_code'    => $uni_woshop_code,
		    'telcom_game_code'      => $tel_game_code,
		    'telcom_esurfing_code'  => $tel_esurfing_code,
            'm' => $this->m,
	    );


        if ($product_id == NULL ||
            $product_name == NULL ||
            $price == NULL)
        {
            $this->response->set('err_str','修改商品短代编码时出错:提交信息不全!');
            $this->response->set('item_info',$data_back);
            $this->edititempageAction();
        }
	    else 
	    {
			$data = array(
				'cmd'			  => $this->product['precmd'].'10',	
				'product_id'      => $product_id,        
				'product_name'    => $product_name, 
				'price'           => $price,     
                'mobile_mm_code'        => $mobile_mm_code,
                'mobile_game_code'      => $mobile_game_code,
                'unicom_woshop_code'    => $uni_woshop_code,
                'telcom_game_code'      => $tel_game_code,
                'telcom_esurfing_code'  => $tel_esurfing_code,
                'm' => $this->m,
			);


		    $result = itemModel::send($data);
		    if(isset($result['result']) && $result['result'] == 0) {
		        $a_login = array(
                    'game'  => $this->m,
			        'uid'   => $this->user->get_user_id(),
			        'uname' => $this->user->get_user_name(),
			        'item'  => $product_id,
			        'desc'  => '修改商品短代编码',
                );
                audit($a_login);  
		        
		        $this->response->set('ok_str','修改成功!');
				$front_url = 'index.php?m='.$this->m.'&a=getagentlist&page=' . $page;
				redirect($front_url);
		    } elseif(isset($result['result']) && $result['result'] != 0) {
				print_r($result);
		        $this->response->set('err_str','修改商品信息时出错:'.$item_arr_error[$result['result']]);
		        $this->response->set('item_info',$data_back);
			    $this->editagentpageAction();
		    } else {
		        $this->response->set('err_str','系统错误!请联系管理员!');
			    $this->response->set('item_info',$data_back);
			    $this->editagentpageAction();
		    }
	    }
	}

}
