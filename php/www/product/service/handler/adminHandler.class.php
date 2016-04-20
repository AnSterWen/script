<?php

require_once 'Handler.class.php';
/**
 * 赛尔2米币商品管理处理类
 *
 */
class itemHandler extends Handler
{
	function __construct($db, $pid)
	{
		parent::__construct();

		$dsn = WDB_PDO::build_dsn($db['name'], $db['host'], $db['port']);

		$this->wdb_pdo = new WDB_PDO($dsn, $db['user'], $db['pass'], 'latin1');
		$this->wdb_pdo->set_mode_debug();
		$this->pid = $pid;
	}

	private $pid = null;

	/**
	 * 根据条件获取米币商品列表
	 *
	 */
	function get_mb_list()
	{
		$_product_id      = req_get_param('product_id');
		$_game_id         = req_get_param('game_id');
		$_product_name    = req_get_param('product_name');
        $_index_id        = req_get_param('index_id');
		$_page_index      = req_get_param('page_index');
		$_page_size       = req_get_param('page_size');
        $_m               = req_get_param('m');

		$where = '';
		if ($_product_id !== NULL)
		{
			$where .= empty($where) ? 'where' : ' and';
			$where .= ' id='.$_product_id;
		}
		if ($_game_id !== NULL)
		{
			$where .= empty($where) ? 'where' : ' and';
			$where .= ' items like '. $this->wdb_pdo->quote('%"' . $_game_id . '":%');
		}
		if ($_product_name !== NULL)
		{
			$where .= empty($where) ? 'where' : ' and';
			$where .= ' name="'.$_product_name.'"';
		}
        if($_index_id !== NULL){
            $where .= empty($where)?'where':' and';
            $where .= ' category="'.$_index_id.'"';
        }

		$count = intval($_page_size) ? intval($_page_size) : PAGE_SIZE;
		$index = intval($_page_index) ? (intval($_page_index) - 1) * $count : 0;
//        if($_m != "oversea"){
//            $sql = 'select id as product_id, items, name, price, discount,'.
//                'from_unixtime(current_count, "%Y-%m-%d %H:%i") as start,'.
//                ' from_unixtime(total_count, "%Y-%m-%d %H:%i") as end, is_valid, category,'.
//                ' mobile_mm, mobile_game, unicom_woshop, telcom_game, telcom_esurfing, add_times, product_attr, extend_data'.
//                ' from product_info_table '.$where.' limit '.$index.','.$count;
//
//        }else{
            $sql = 'select id as product_id, items, name, price, discount,'.
                'from_unixtime(current_count, "%Y-%m-%d %H:%i") as start,'.
                ' from_unixtime(total_count, "%Y-%m-%d %H:%i") as end, is_valid, category,'.
                ' add_times, product_attr, extend_data , product_third_name , client_version , third_price'.
                ' from product_info_table '.$where.' limit '.$index.','.$count;
//        }

        $data1 = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL, array());
		$data2 = $this->wdb_pdo->execute('select found_rows() as count', WDB_PDO::SQL_RETURN_TYPE_ROW);

		if ($data1 === false || $data2 === false) {
			return array('result' => 2101);
		} else {
			$data = array('count' => $data2['count'], 'product_list' => $data1);
			return array('result' => 0, 'data' => $data);
		}
	}

	/**
	 * 增加商品信息
	 * @access public
	 * @param int      $_product_id
	 * @param string   $_product_name
	 * @param int      $_game_id
	 * @param int      $_count
	 * @param int      $_price
	 * @param int      $_total_count
	 * @param int      $_is_valid
	 * @return array
	 */
	public function add_mb_product_info()
	{
		$_items				= req_get_param('game_id');
		$_product_name    	= req_get_param('product_name');
		$_price           	= intval(req_get_param('price'));
		$_discount 			= intval(req_get_param('discount'));
		$_start   	= req_get_param('start');
		$_end     	= req_get_param('end');
		$_is_valid        	= intval(req_get_param('is_valid'));
		$_category			= intval(req_get_param('category'));
        $_product_attr = intval(req_get_param('product_attr'));
        $_add_times  = intval(req_get_param('add_times'));
        $_extend_data = req_get_param('extend_data');
        $_m = req_get_param('m');
        $_product_third_name = req_get_param('product_third_name');
        $_client_version = req_get_param('client_version');
        $_third_price = req_get_param('third_price');

		if ($_price < 0
			|| $_discount > 100 || $_discount < 0
			|| $_is_valid < 0 || $_is_valid > 2
			|| $_product_name == NULL) {
			return array('result' => 2019);
		}

		$_product_id = $this->get_valid_pid($_category);

		if (!$this->is_valid_product_name($_product_name,$_category)) {
			return array('result' => 2004);
		}
		
		$param1 = $_product_id;
		$param1 .= ',"'.$_product_name.'"';
		$param1 .= ','.$_price;
		$param1 .= ','.$_discount;
		$param1 .= ','.strtotime($_start);
		$param1 .= ','.strtotime($_end);
		$param1 .= ','.$_is_valid;
		$param1 .= ','.$_category;
        $param1 .= ','.$_product_attr;
        $param1 .= ','.$_add_times;
        $param1 .= ',"'.$_extend_data.'"';
//        if($_m == 'oversea'){
            $param1 .= ',"'.$_product_third_name.'"';
//        }
		$param1 .= ','. $this->wdb_pdo->quote($_items);

        $param1 .= ',"'.$_client_version.'"';
        $param1 .= ',"'.$_third_price.'"';
		$sql = array();
//        if($_m == 'oversea'){
            $sql[] = 'insert into product_info_table'.'(id,name,price,discount,current_count,total_count,is_valid,category,product_attr,add_times,extend_data,product_third_name,items,client_version,third_price,add_time, flag) values(' . $param1 . ',now(), 1)';
//        }else{
//            $sql[] = 'insert into product_info_table'.'(id,name,price,discount,current_count,total_count,is_valid,category,product_attr,add_times,extend_data,items,add_time, flag) values(' . $param1 . ',now(), 1)';
//        }
		return $this->wdb_pdo->commits($sql) ? array('result' => 0, 'product_id' => $_product_id) : array('result' => 2012);
	}

	/**
	 * 验证商品名字是否有效
	 * @access public
	 * @return array
	 */
	public function check_product_name()
	{
		$_product_name = req_get_param('product_name');
        $_category = req_get_param('category');
		if ($_product_name !== NULL && $this->is_valid_product_name($_product_name,$_category)) {
			return array('result' => 0);
		} else {
			return array('result' => 2004);
		}
	}

	private function is_valid_product_name($_product_name,$_category)
	{
        $sql = "SELECT * FROM product_info_table WHERE name = '".$_product_name."' AND category = ".$_category;
        $data = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
        if(empty($data)){
            return true;
        }else{
            return false;
        }

//		return !$this->wdb_pdo->exists('product_info_table', 'name', $_product_name);
	}

	public function set_product_info()
	{
		$_product_id      	= intval(req_get_param('product_id'));
		$_items				= req_get_param('game_id');
		$_product_name    	= req_get_param('product_name');
		$_price           	= intval(req_get_param('price'));
		$_discount 	= intval(req_get_param('discount'));
		$_start   	= req_get_param('start');
		$_end     	= req_get_param('end');
		$_is_valid        	= intval(req_get_param('is_valid'));
		$_category        	= intval(req_get_param('category'));
        $_product_attr = intval(req_get_param('product_attr'));
        $_add_times  = intval(req_get_param('add_times'));
        $_extend_data = req_get_param('extend_data');
        $_product_third_name = req_get_param('product_third_name');
        $_client_version = intval(req_get_param('client_version'));
        $_third_price = intval(req_get_param('third_price'));
        $_m = req_get_param('m');

		// 验证商品
		if ($_price < 0 || !($_discount <= 100 && intval($_discount) >= 0)
			|| $_is_valid < 0 || $_is_valid > 2)
			return array('result' => 2002);

		$set = 'set name="' . $_product_name . '"';
		$set .= ',items=' . $this->wdb_pdo->quote($_items);
		$set .= ',price=' . $_price;
		$set .= ',discount=' . $_discount;
		if ($_start != NULL)
			$set .= ',current_count=' . strtotime($_start);
		if ($_end != NULL)
			$set .= ',total_count=' . strtotime($_end);
		$set .= ',category=' . $_category;
        $set .= ',product_attr=' . $_product_attr;
        $set .= ',add_times=' . $_add_times;
        $set .= ',extend_data="' . $_extend_data . '"';
		$set .= ',is_valid=' . $_is_valid;
		$set .= ',flag=flag+1';
//        if($_m == 'oversea'){
            $set .= ',product_third_name="' . $_product_third_name . '"';
//        }
        $set .= ',client_version=' . $_client_version;
        $set .= ',third_price=' . intval($_third_price);
		$sql = array();
		$sql[] = 'update product_info_table ' . $set . ' where id=' . $_product_id;
        Log::write($sql[0]);

		$data = $this->wdb_pdo->commits($sql);
		return $data ? array('result' => 0) : array('result' => 2102);
	}

	public function set_item_agent_code()
	{
		$_product_id      	= intval(req_get_param('product_id'));
		$_mobile_mm_code    	= req_get_param('mobile_mm_code');
		$_mobile_game_code    	= req_get_param('mobile_game_code');
		$_unicom_woshop_code    	= req_get_param('unicom_woshop_code');
		$_telcom_game_code    	= req_get_param('telcom_game_code');
		$_telcom_esurfing_code    	= req_get_param('telcom_esurfing_code');

		
		$set = 'set mobile_mm="' . $_mobile_mm_code . '"';
		$set .= ',mobile_game="' . $_mobile_game_code . '"';
		$set .= ',unicom_woshop="' . $_unicom_woshop_code . '"';
		$set .= ',telcom_game="' . $_telcom_game_code . '"';
		$set .= ',telcom_esurfing="' . $_telcom_esurfing_code . '"';

		$sql = array();
		$sql[] = 'update product_info_table ' . $set . ' where id=' . $_product_id;
		$data = $this->wdb_pdo->commits($sql);
		return $data ? array('result' => 0) : array('result' => 2102);
	}

	public function get_valid_pid($category)
	{
        $category = $category > 0 ? ($category - 1) : 0;
		$minid = intval($this->pid, 16) * 10000 + $category * 1000 + 1;
		$maxid = intval($this->pid, 16) * 10000 + $category * 1000 + 999;
		$sql = "select max(id) as max from product_info_table where id between {$minid} and {$maxid}";
		$data = $this->wdb_pdo->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ROW);
		if (isset($data['max'])) {
			return $data['max'] < $maxid ? ($data['max'] + 1) : false;	
		} else {
			return $minid;
		}
	}
}
?>
