<?php
$conn = mysql_connect('10.1.16.31:3306','lush','lush');
if (!$conn)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('db_gm', $conn) or die('Could not select database.');
$sql = 'desc t_bill_change_log';
$res = mysql_query($sql);
if ($res !== false)
{
    $arr = array ();
    $row = mysql_fetch_row ($res);
    while ($row)
    {
        $arr [] = $row [0];
        $row = mysql_fetch_row ($res);
    }
}
print_r($arr);
