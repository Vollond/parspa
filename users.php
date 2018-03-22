<?php
/** модель работы с пользователями **/
/*
require_once("db_connect.php");
global $db;

if (mysqli_connect_errno()) {
    echo "Не удалось подключиться: \n";
	echo mysqli_connect_error();
}

$query = "insert into users (name) values('bsc')";
//$query= "SHOW databases";
mysqli_query($db, $query) or die("пользователя создать не удалось");
echo $mysqli_error;
*/
function make_user($name,$chat_id){
	global $db;
	$name = mysqli_real_escape_string($name);
//	$chat_id = mysqli_real_escape_string($chat_id);
	$query = "insert into users (name) values('{$name}')";
	mysqli_query($query,$db) or die("пользователя создать не удалось");
	echo "удалось? \n";
}

function is_user_set($name){
	global $db;
	$name = mysqli_real_escape_string($name);
	$result = mysqli_query("select * from users where name='$name' LIMIT 1",$db);

    if(mysqli_fetch_array($result) !== false) return true;
    return false;
}

// задание настройки
function set_udata($name,$data = array()){
	global $db;
	$name = mysqli_real_escape_string($name);
	if(!is_user_set($name)){
		make_user($name,0); // если каким-то чудом этот пользователь не зарегистрирован в базе
	}
	$data = json_encode($data,JSON_UNESCAPED_UNICODE);
	mysqli_query("update `users` SET data_json = '{$data}' WHERE name = '{$name}'",$db); // обновляем запись в базе
}

// считываение настройки
function get_udata($name){
	global $db;
	$res = array();
	$name = mysqli_real_escape_string($name);
	$result = mysqli_query("select * from `users` where name='$name'",$db);
	$arr = mysqli_fetch_assoc($result);
    if(isset($arr['data_json'])){
		$res = json_decode($arr['data_json'], true);
	}
	
	return $res;
}