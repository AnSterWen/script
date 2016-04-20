<?php
if(VERSION == 'test'){
    $product_config = array(
        '00' => array(
            'name' => 'demo',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_00',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        ),
        '01' => array(
            'name' => 'icar',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_01',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        ),
        '02' => array(
            'name' => 'imole',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_02',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        ),
        '03' => array(
            'name' => 'iskate',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_03',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        ),
        '04' => array(
            'name' => 'iseer',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_04',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        ),
        '05' => array(
            'name' => 'imole_android',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_05',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
            'noti' => array(
                'ip'  => '192.168.21.175',
                'port'=> 20010,
                'cmd' => 0x8037,
            )
        ),
        '06' => array(
            'name' => 'douzhuan',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_06',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        ),
        '07' => array(
            'name' => 'iseer2',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_07',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        ),
        '08' => array(
            'name' => 'ahero',
            'db' => array(
                'host' => '10.1.1.238',
                'port' => 3306,
                'name' => 'IAP_08',
                'user' => 'platform',
                'pass' => 'pf@gl0ve'),
        ),
        '09' => array(
            'name' => 'aseer',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_09',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        ),
        '0A' => array(
            'name' => 'amole',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_0A',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        ),
        '0F' => array(
            'name' => 'oversea',
            'db' => array(
                'host' => '10.1.1.28',
                'port' => 3306,
                'name' => 'IAP_0F',
                'user' => 'backup',
                'pass' => 'backup@pwd'),
        )
    );
} else{
    $product_config = array(
         '08' => array(
                 'name' => 'ahero',
                  'db' => array(
                     'host' => '10.1.1.238',
                     'port' => 3306,
                     'name' => 'IAP_08',
                     'user' => 'jfsqladmin',
                     'pass' => 'jfsql!@#$OK'),
                ),
         );
}



