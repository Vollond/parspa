<?php
/** модель работы с пользователями **/


require_once("db_connect.php");
function add_post($num){
	global $db;
	$query = "insert into posts (num) values('{$num}')";
	mysqli_query($db,$query) or die("пост не добавлен");
}

function make_user($name,$chat_id){
	global $db;
//	$name = mysqli_real_escape_string($name);
//	$chat_id = mysqli_real_escape_string($chat_id);
//	$query = "insert into users (name) values('{$name}')";
	$query = "insert into users (name,chat_id) values('{$name}','{$chat_id}')";

	mysqli_query($db,$query) or die("пользователя создать не удалось");
}
/*
$a = @mysql_fetch_array(mysql_query("SELECT 'pole_name' FROM 'table' WHERE 'pole_name'='".$name."' LIMIT 1")); 
IF(isset($a['pole_name'])) echo 'Повтор'; 
else echo 'Уникальная запись';
*/

function is_user_set($name){
	global $db;
//	$name = mysqli_real_escape_string($name);
	$query = "select * from users where name='asd' LIMIT 1";
	$result = mysqli_query($db,$query);
	
    if(mysqli_fetch_array($result) !== false) return true;
    return false;
}

// задание настройки
function set_udata($name,$data = array()){
	global $db;
	//$name = mysqli_real_escape_string($name);
	//if(!is_user_set($name)){
	//	make_user($name,0); // если каким-то чудом этот пользователь не зарегистрирован в базе
//	}
	$data = json_encode($data,JSON_UNESCAPED_UNICODE);
	mysqli_query($db,"update users SET data_json = '{$data}' WHERE name = '{$name}'"); // обновляем запись в базе
}

// считываение настройки
function get_udata($name){
	global $db;
	$res = array();
	//$name = mysqli_real_escape_string($name);
	$result = mysqli_query($db, "select * from users where name='$name'");
	$arr = mysqli_fetch_assoc($result);
    if(isset($arr['data_json'])){
		$res = json_decode($arr['data_json'], true);
	}
	
	return $res;
}