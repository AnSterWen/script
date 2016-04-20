<?php
class commonController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        require_once(TAOMEE_PATH . 'Lib/Util/Page.class.php'); 
    }

    /* 商品名称是否存在 */
    public function checkproductnameAction()
    {
        global $item_arr_error;
      
        $product_id   = $this->http->get('product_id');
        $product_name = $this->http->get('product_name');
        $flag = $this->http->get('flag');
        
        $data = array(
            'cmd'	        =>    $flag,
	        'product_name'	=>    $product_name,
            'product_id'   =>    $product_id
        );
        $result = itemModel::send($data);
       
        $ret = array();
        
        if(isset($result['result']) && $result['result'] == 0)
        {
            $ret['result'] = 0;
            $ret['desc']   = '操作成功!';
        }
        elseif(isset($result['result']) && $result['result'] != 0)
        {
            $ret['result'] = $result['result'];
            $ret['desc']   = $item_arr_error[$result['result']];
        }
        else
        {
            $ret['result'] = $result['result'];
            $ret['desc']   = '验证商品名称时出错!请联系管理员 !';   
        }
        echo json_encode($ret);
        return;
    }

	/* 游戏中ID是否存在 */
    public function checkgameidAction()
    {
        global $item_arr_error;
        
        $product_id = $this->http->get('product_id');
        $game_id    = $this->http->get('game_id');
        $type       = $this->http->get('type');
        $flag       = $this->http->get('flag');
        
        $data = array(
            'cmd'	        =>    $flag,
            'product_id'    =>    $product_id,
	        'game_id'	    =>    $game_id,
	        'product_type'	=>    $type,
        );
        $result = itemModel::send($data);
        $ret = array();
        if(isset($result['result']) && $result['result'] == 0)
        {
            $ret['result'] = 0;
            $ret['desc']   = '操作成功!';
        }
        elseif(isset($result['result']) && $result['result'] != 0)
        {
            $ret['result'] = $result['result'];
            $ret['desc']   = $item_arr_error[$result['result']];
        }
        else
        {
            $ret['result'] = $result['result'];
            $ret['desc']   = '验证游戏中ID和商品类型时出错!请联系管理员 !';   
        }
        echo json_encode($ret);
        return;
    }
    
    /*
     * 查看操作审计
     */
    public function logAction()
    {
        global $game_type;
        
        $uname = $this->http->get('user_name');
        $uid   = $this->http->get('user_id');
        $sdate = $this->http->has('date_f') ? $this->http->get('date_f') : date('Y-m-d');
        $edate = $this->http->get('date_t') ? $this->http->get('date_t') : date('Y-m-d',time()+86400);
        $game  = $this->http->get('type');
        $page  = $this->http->get('page');
        
        $query_data = array(
            'user_id'   => $uid,
	        'user_name' => $uname,
	        'date_f'    => $sdate,
	        'date_t'    => $edate,
	        'type'      => $game,
        	'page'      => $page,
        );
        
        $conn = mysql_connect(AUDIT_DB_HOST,AUDIT_DB_USER,AUDIT_DB_PWD);
        if (!$conn){
            Log::write('logAction conn error:'.mysql_error());
            $this->response->set('err_str','连接数据库出错!');
            mysql_close($conn);
        }else {
            $where = "WHERE `time`>='{$sdate}' AND `time`<='{$edate}'";
	        $order = ' ORDER BY `id` DESC';
	        $limit = ' LIMIT ';
	        
	        if (!empty($uname)){
	            $where .= "AND `uname`='{$uname}' ";
	        }
	        if (!empty($uid)){
	            $where .= "AND `uid`={$uid} ";
	        }
	        if (!empty($game)){
	            $where .= "AND `game`='{$game}' ";
	        }
	        if (empty($page) || $page < 0 ){
	            $page = 1;
	        }
	        $limit .= (20 * ($page-1)).',20';
	        
	        $sql  = "SELECT SQL_CALC_FOUND_ROWS `game`,`uid`,`uname`,`ip`,`item`,`desc`,`time` FROM ".AUDIT_DB_NAME.".t_item_audit ";
	        $sql .= $where.$order.$limit;
	        $ret = mysql_query($sql);
	        $ret_count  = mysql_query('SELECT FOUND_ROWS();');
	        $list_count = mysql_fetch_row($ret_count); 
	        if (!$ret){
	            Log::write($sql);
	            Log::write('logAction select error:'.mysql_error());
	            $this->response->set('err_str','查询数据库失败!');
	            mysql_close($conn);
	        }else {
	            
	            $str_page = new Page(
			    $list_count[0], 
			    $page, 
			    20, 
				'm=common&a=log&user_name='.$uname.'&user_id='.$uid.'&date_f='.$sdate.'&date_t='.$edate.'&type='.$game.'&page='.$page);
	            
	            $res = array();
	            while ($row = mysql_fetch_assoc($ret)){
	                $res[] = $row;
	            }
	            $this->response->set('page_bar', $str_page->show());
		        $this->response->set('goto_bar', $str_page->goto_page());
	            $this->response->set('log_list',$res);
	            $this->response->set('list_count',$list_count[0]);
	            mysql_close($conn);
	        }
        }
        $this->response->set('query_data',$query_data);
        $this->response->set('game_type',$game_type);
	    $this->response->set('layout_right_file', 'Audit/audit_log.html');
	    if ($this->http->has('ajax'))
		{
		    echo $this->view->ajax_return('Common/audit_log.html');
		}
		else
		{
			$this->view->display();
		}
    }
}
?>
