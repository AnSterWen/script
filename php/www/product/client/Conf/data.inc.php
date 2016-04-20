<?php

require_once 'client/Conf/config.inc.php';
global $database;

require_once 'service/lib/wdb_pdo.class.php';
$dsn = WDB_PDO::build_dsn($database["user"]["name"], $database["user"]["host"], $database["user"]["port"]);
$db = new WDB_PDO($dsn, $database["user"]["user"], $database["user"]["passwd"], 'latin1');
$db = get_mysql_connect();
$kind_sql = "SELECT id,auth,title,precmd FROM t_kind";
$results = $db->execute($kind_sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
$product_config = array();
foreach($results as $result){
    $list_sql = "SELECT title,auth_id,url FROM t_kind_list WHERE kind_id = ".$result["id"];
    $lists = $db->execute($list_sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
    $array = array();
    foreach($lists as $list){
        $array[$list["title"]] = array("auth_id"=>$list["auth_id"],"url"=>$list["url"]);
    }
    $product_config[$result["auth"]] = array(
        "title" => $result["title"],
        "precmd" => $result["precmd"],
        "list" => $array,
    );
}
//$product_config = array(
//    'admin_user' => array(
//        'title' => '用户管理',
//        'precmd' => '0B',
//        'list' => array(
//            '用户管理'   => array('auth_id'=>2097680016,'url'=>'index.php?m=admin_user&a=user_list') ,
////            '添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=demo&a=addmbitempage') ,
//        )
//    ),
//    'demo' => array(
//		'title' => '测试',
//		'precmd' => '00',
//		'list' => array(
//			'米币商品列表'   => array('auth_id'=>2097680016,'url'=>'index.php?m=demo&a=getitemlist') ,
//			'添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=demo&a=addmbitempage') ,
//		)
//	),
//	'icar' => array(
//		'title' => '摩尔卡丁车',
//		'precmd' => '01',
//		'list' => array(
//			'米币商品列表'   => array('auth_id'=>2097680016,'url'=>'index.php?m=icar&a=getitemlist') ,
//			'添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=icar&a=addmbitempage') ,
//		)
//	),
//	'iseer' => array(
//		'title' => '赛尔号',
//		'precmd' => '04',
//		'list' => array(
//			'米币商品列表'   => array('auth_id'=>2097680016,'url'=>'index.php?m=iseer&a=getitemlist') ,
//			'添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=iseer&a=addmbitempage') ,
//		)
//	),
//	'imole_android' => array(
//		'title' => 'imole安卓版',
//		'precmd' => '05',
//		'list' => array(
//			'米币商品列表'   => array('auth_id'=>2097680016,'url'=>'index.php?m=imole_android&a=getitemlist') ,
//			'添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=imole_android&a=addmbitempage') ,
//			'商品短代编码'   => array('auth_id'=>2097680018,'url'=>'index.php?m=imole_android&a=getagentlist') ,
//		)
//	),
//	'douzhuan' => array(
//			'title' => '斗转龙珠',
//			'precmd' => '06',
//			'list' => array(
//					'米币商品列表'   => array('auth_id'=>2097680016,'url'=>'index.php?m=douzhuan&a=getitemlist') ,
//					'添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=douzhuan&a=addmbitempage') ,
//			)
//	),
//	'iseer2' => array(
//		'title' => '赛尔号2',
//		'precmd' => '07',
//		'list' => array(
//			'米币商品列表'   => array('auth_id'=>2097680016,'url'=>'index.php?m=iseer2&a=getitemlist') ,
//			'添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=iseer2&a=addmbitempage') ,
//		)
//	),
//	'ahero' => array(
//		'title' => 'Ahero',
//		'precmd' => '08',
//		'list' => array(
//			'米币商品列表'   => array('auth_id'=>2097680016,'url'=>'index.php?m=ahero&a=getitemlist') ,
//			'添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=ahero&a=addmbitempage') ,
//			'商品短代编码'   => array('auth_id'=>2097680018,'url'=>'index.php?m=ahero&a=getagentlist') ,
//		)
//	),
//	'aseer' => array(
//		'title' => 'Aseer',
//		'precmd' => '09',
//		'list' => array(
//			'米币商品列表'   => array('auth_id'=>2097680016,'url'=>'index.php?m=aseer&a=getitemlist') ,
//			'添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=aseer&a=addmbitempage') ,
//			'商品短代编码'   => array('auth_id'=>2097680018,'url'=>'index.php?m=aseer&a=getagentlist') ,
//		)
//	),
//	'amole' => array(
//		'title' => 'Amole',
//		'precmd' => '0A',
//		'list' => array(
//			'米币商品列表'   => array('auth_id'=>2097680016,'url'=>'index.php?m=amole&a=getitemlist') ,
//			'添加米币商品'   => array('auth_id'=>2097680017,'url'=>'index.php?m=amole&a=addmbitempage') ,
//			'商品短代编码'   => array('auth_id'=>2097680018,'url'=>'index.php?m=amole&a=getagentlist') ,
//		)
//	),
//
//);

$game_type = array(
    'login','demo',
);
/* 错误码 */
$item_arr_error = array(
    98   => '非法请求',
    99   => '所在IP受到限制',
    2001 => '访问的接口不存在',
    2002 => '商品ID错误',
    2003 => '商品游戏ID错误',
    2004 => '商品名称错误',
    2005 => '商品价格错误',
    2006 => 'VIP折扣率错误',
    2007 => '普通会员折扣率错误',
    2008 => '是否VIP字段错误',
    2009 => '购买上限错误',
    2010 => '当前库存量错误',
    2011 => '总库存错误',
    2012 => '当前商品是否有效错误',
    2013 => '商品ID已被使用或统计项ID已存在',
    2014 => '赠送的金豆数错误',
    2015 => '商品种类错误',
    2016 => '商品游戏id和数目格式出错!',
	2017 => '商品数量超过用户可以拥有的上限',
	2018 => '批量增加的普通商品与游戏ID数量不同',
    2019 => '商品类型有误',
	2020 => '赠送的通宝数无效',
	2021 => '商品游戏ID和数目和有效期格式出错',
    2022 => '有效期无效',
    2023 => '是否永久性无效',
	2101 => '数据库查询失败',
    2102 => '数据库修改失败',
);
?>
