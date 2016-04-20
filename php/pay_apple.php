<?php
require_once("xiaop.php");

function js($str)
{
    $arr = array();
    $str = trim($str, " \t\n\"{};");
    $str = str_replace('"', '', $str);
    $slist = split(';', $str);
    
    foreach ($slist as $ss) 
    {
        $kv = split('=', $ss);
        $arr[trim($kv[0])] = trim($kv[1]);
    }
    return $arr;
}   

$str = base64_decode($data['receipt']);
$arr = js($str);
$info = base64_decode($arr['purchase-info']);
$info = str_replace('-', '_', $info);
$arr1 = js($info);
foreach($arr1 as $k => $v)
{
    printf("%-30s%-20s\n",$k,$v);
}        
        








echo "\n<========================================================>\n";
