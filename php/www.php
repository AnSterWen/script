<?php

$data1 = array();
function repeat1004(&$data)
{
    global $data1;
    $data1 = $data;
}

foreach ($data1 as $key => $value)
{
    echo $key . '------->' . $value . "\n";
}

?>
