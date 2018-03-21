<?php
global $db;
$db = parse_url(getenv("CLEARDB_DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");
$databasename = "heroku_6da0db36e924815";

mysql_select_db($databasename, $db) or die("error:Database not selected witch mysql_select_db");

mysql_query('SET NAMES utf8',$db);
mysql_query('SET CHARACTER SET utf8',$db );
mysql_query('SET COLLATION_CONNECTION="utf8_general_ci"',$db ); 
setlocale(LC_ALL,"ru_RU.UTF8");
