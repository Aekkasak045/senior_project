<?php
$host = "localhost";
$username = "root";
$password = "kuse@fse2018";
$db = "smartlift";
$cn = mysqli_connect($host, $username, $password, $db);

$redis = new Redis();
$redis->connect('52.221.67.113', 6379);
$redis->auth('kuse@fse2023');