<?php
/**
* 
* 用户名密码表
* @var unknown_type
*/
if (defined('VERSION') && VERSION == 'testing' ){
    $admin_list = array(
        'admin' => 'admin',
        'candice' => 'candice'
    );
}


   $admin_id_list = array(
           'admin' => 1,
           'tonyliu' => 2,
           'justin' => 3
   );

   $auth_list = array(
	   'none' => array(
		   'trade' => 1,
		   'sign' => 1,
		   'verify' => 1,
		   'getItemJson' => 1,
		   'demo|verifyget' => 1,
		   'cliverify' => 1,
		   'aliwapChannel' => 1,
		   'aliwapPay' => 1,
		   'aliwapVerify' => 1,
		   'aliwapCallback' => 1,
		),  
	);
