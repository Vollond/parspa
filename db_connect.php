<?php
/*подключение к базе данных*/

$host = "ec2-54-228-181-43.eu-west-1.compute.amazonaws.com"; // в 90% случаев это менять не надо
$password = "a26cd18c3d7dcc49c094c6a53c539d6d8e040eec033ce6086a3624fc35d0765a";
$username = "jprgrwfmiyzodr";
$databasename = "deni4gm2l8i6b7";

global $db;
$db = mysql_connect($host,$username,$password) or die("error: Failed_connect_database");

mysql_select_db($databasename, $db) or die("error:Database not selected witch mysql_select_db");

mysql_query('SET NAMES utf8',$db);
mysql_query('SET CHARACTER SET utf8',$db );
mysql_query('SET COLLATION_CONNECTION="utf8_general_ci"',$db ); 
setlocale(LC_ALL,"ru_RU.UTF8");