<?php
error_reporting(0);
date_default_timezone_set('Asia/Taipei');
session_start();
require 'header.php' ;

$m = $_GET['m'];
$a = $_GET['a'];

if (!array_key_exists($m, itemModel::$ProductList)) {
	die(json_encode(array('result'=>-1)));
}

require_once(APP_PATH."item_controller.php") ;

$action_name = "{$a}Action" ;

$obj = new itemController($m);
$obj->{$action_name}() ;

//ob_end_flush() ;

?>
