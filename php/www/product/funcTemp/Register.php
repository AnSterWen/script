<?php
require_once '../service/lib/wdb_pdo.class.php';

$date = $_GET['date'];
/*
 * 从USER库中找出2013-2-2号注册的用户
 */
$dsn = WDB_PDO::build_dsn('USER', '192.168.21.136', 3306);
$db = new WDB_PDO($dsn, 'imole', 'Y1deBuR3', 'latin1');

$lower = strtotime($date);
$upper = $lower + 24 * 60 *60;
$sql = "select userid from t_user where ctime >= $lower and 
        ctime <  $upper";

$data = $db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_ALL);
$user = array();
//$result = array();

foreach ($data as $k => $v)
{
    array_push($user, $v['userid']);    
}

//print_r($user);


echo "register on $date: </br>";
foreach ($user as $k => $v)
{
    echo $v, "</br>";    
}

?>
