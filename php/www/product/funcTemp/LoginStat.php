<?php
require_once 'service/lib/wdb_pdo.class.php';

/*
 * 从USER库中找出2013-2-2号注册的用户
 */
$dsn = WDB_PDO::build_dsn('USER', '192.168.21.136', 3306);
$db = new WDB_PDO($dsn, 'imole', 'Y1deBuR3', 'latin1');


$sql = "select userid, ctime from t_user where ctime >= unix_timestamp('2013-02-05 00:00:00') and 
        ctime <  unix_timestamp('2013-02-06 00:00:00')";

$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
$user = array();
//$result = array();

foreach ($data as $k => $v)
{
    array_push($user, array($v['userid'], $v['ctime']));    
}

//print_r($user);

foreach ($user as $k => $v)
{
    $dbName = sprintf("USER_%d", $v[0]%10);
    $tableName = sprintf("t_attrib_%02d", $v[0]/100%100);
    //echo $dbname, "</br>";
    $dsn = WDB_PDO::build_dsn($dbName, '192.168.21.136', 3306);
    $db = new WDB_PDO($dsn, 'imole', 'Y1deBuR3', 'latin1');
    $sql = "select aval from $tableName where userid = $v[0] and akey = 259";
    $data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
    foreach ($data as $kk => $vv)
    {
        //$result[$v[0]] = $vv['aval'];    
        $sdate = date("Y-m-d", $v[1]);
        $edate = date("Y-m-d", $vv['aval']);
        $user[$k][1] = (strtotime($edate."00:00:00") - strtotime($sdate."00:00:00"))/(24*60*60) + 1;
        //$user[$k][1] = round(($vv['aval'] - $v[1])/(24*60*60), 0);
    }
}

echo "register from 2013-02-02: </br>";
foreach ($user as $k => $v)
{
    echo $v[0], ": ", $v[1], "</br>";    
}

?>