<?php
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$data = array(
    1 => 100,
    2 => 200,
    3 => 300,
    'q' => 'qian shan',
    'p' => 'php'
);

foreach($data as $k => $v)
{
    $redis->hSet('lush',$k,$v);
}

$result = $redis->hGet('lush',22);
echo var_dump($result);



echo "\n";
