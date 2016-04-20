<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 14-4-1
 * Time: 上午11:54
 */
//if (defined('VERSION') && VERSION == 'testing' ){
//    $database = array(
//        'user' => array(
//            'host'    =>'10.1.1.28',
//            'port'    =>'3306',
//            'name'    =>'IAP_user',
//            'user'    =>'backup',
//            'passwd'  =>'backup@pwd'
//        )
//    );
//
//}

if (defined('VERSION') && VERSION == 'testing' ){
    $database = array(
        'user' => array(
            'host'    =>'192.168.21.180',
            'port'    =>'3307',
            'name'    =>'IAP_user',
            'user'    =>'backup',
            'passwd'  =>'backup@pwd'
        )
    );
}else{
    $database = array(
        'user' => array(
            'host'    =>'10.1.1.238',
            'port'    =>'3306',
            'name'    =>'db_iap_mgr',
            'user'    =>'jfsqladmin',
            'passwd'  =>'jfsql!@#$OK'
        ),
    );
}

