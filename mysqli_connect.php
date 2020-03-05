<?php 
header('Content-Type:text/html;charset=utf-8');
$servername = '';//服务器地址
$username = '';//mysql用户名
$password = '';//mysql密码
$sql_name = 'message';//数据库名
$link = @mysqli_connect($servername, $username, $password, $sql_name) or die('connect error!');

