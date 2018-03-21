<?php
/*подключение к базе данных*/

$host = "eu-cdbr-west-02.cleardb.net"; // в 90% случаев это менять не надо
$password = "faf87cca";
$username = "bd8f9d12dfabef";
$databasename = "heroku_6da0db36e924815";

global $db;
$db = mysql_connect($host,$username,$password) or die("error: Failed_connect_database");

mysql_select_db($databasename, $db) or die("error:Database not selected witch mysql_select_db");

mysql_query('SET NAMES utf8',$db);
mysql_query('SET CHARACTER SET utf8',$db );
mysql_query('SET COLLATION_CONNECTION="utf8_general_ci"',$db ); 
setlocale(LC_ALL,"ru_RU.UTF8");