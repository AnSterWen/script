<?php
error_reporting(0);
date_default_timezone_set('Asia/Taipei');
define('DS', DIRECTORY_SEPARATOR);
require_once dirname(__FILE__) . DS . 'config' . DS . 'setup.inc.php';
/* 验证访问者IP是否有效 */
if (!is_valid_client_ip())
{
    echo json_encode(array('result' => 99));
    exit();
}
/* 验证签名 */
if (!is_valid_request())
{
    echo json_encode(array('result' => 98));
    exit();
}
/* 路由接口 */
$cmd = req_get_param('cmd');
$id2cmd = array(
    '01' => 'get_mb_list',
    '03' => 'add_mb_product_info',
    '05' => 'check_product_name',
    '09' => 'set_product_info',
    '10' => 'set_item_agent_code',
);
global $product_config;
$cid = substr($cmd, -2, 2);
if ($cmd === NULL || !isset($id2cmd[$cid])){
    echo json_encode(array('result' => 2001, 'cmd'=>$cmd));
} else {
    $way = substr($cmd, 0, 2);
	$product = $product_config[$way];
	require_once HANDLER_PATH.'adminHandler.class.php';
	$handler = new itemHandler($product['db'], $way);
	$result = $handler->{$id2cmd[$cid]}();
    echo json_encode($result);
}
