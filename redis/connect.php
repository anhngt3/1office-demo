<?php
//Connecting to Redis server on localhost
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
//$redis->info();
//$allKeys = $redis->keys('tutorial-list*');
//echo $allKeys;
$redis->hMSet('user', ['id' => 1, 'name' => 'Joe', 'salary' => 2000]);
//$redis->save();
//var_dump($redis->hGetAll('user'));
?>