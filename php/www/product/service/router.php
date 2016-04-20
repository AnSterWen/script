<?php
error_reporting(0);
date_default_timezone_set('Asia/Taipei');
define('DS', DIRECTORY_SEPARATOR);
require_once dirname(__FILE__) . DS . 'config' . DS . 'setup.inc.php';
/* 验证访问者IP是否有效 */
//if (!is_valid_client_ip())
//{
//    echo json_encode(array('result' => 99));
//    exit();
//}
/* 验证签名 */
//if (!is_valid_request())
//{
//    echo json_encode(array('result' => 98));
//    exit();
//}
/* 路由接口 */
$cmd = req_get_param('cmd');

$id2cmd = array(
    '04' => 'get_mb_list_simple',
    '05' => 'get_mb_list_agent',//支持短代
    '10' => 'commit_trade',
    '13' => 'gen_order_by_product_id',
    '14' => 'get_order_exdata',
    '15' => 'get_order_base_info',
    '16' => 'get_order_detail_info',
    '17' => 'gen_inner_order',//生成订单接口
    '18' => 'gen_order_by_third_name',
    '19' => 'get_product_detail_by_third_name',
);
global $product_config;
$cid = substr($cmd, -2, 2);
if ($cmd === NULL || !isset($id2cmd[$cid])){
    echo json_encode(array('result' => 2001, 'cmd'=>$cmd));
} else {
    $way = substr($cmd, 0, 2);
	$product = $product_config[$way];
	require_once HANDLER_PATH.'itemHandler.class.php';
	$handler = new itemHandler($product['db'], $way);
	$result = $handler->{$id2cmd[$cid]}();
    echo json_encode($result);
}
