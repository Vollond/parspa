<?php
/** модель работы с пользователями **/

function make_user($name,$chat_id){
	global $db;
	$name = mysql_real_escape_string($name);
	$chat_id = mysql_real_escape_string($chat_id);
	$query = "insert into `users`(name,chat_id) values('{$name}','{$chat_id}')";
	mysql_query($query,$db) or die("пользователя создать не удалось");
}

function is_user_set($name){
	global $db;
	$name = mysql_real_escape_string($name);
	$result = mysql_query("select * from `users` where name='$name' LIMIT 1",$db);

    if(mysql_fetch_array($result) !== false) return true;
    return false;
}

// задание настройки
function set_udata($name,$data = array()){
	global $db;
	$name = mysql_real_escape_string($name);
	if(!is_user_set($name)){
		make_user($name,0); // если каким-то чудом этот пользователь не зарегистрирован в базе
	}
	$data = json_encode($data,JSON_UNESCAPED_UNICODE);
	mysql_query("update `users` SET data_json = '{$data}' WHERE name = '{$name}'",$db); // обновляем запись в базе
}

// считываение настройки
function get_udata($name){
	global $db;
	$res = array();
	$name = mysql_real_escape_string($name);
	$result = mysql_query("select * from `users` where name='$name'",$db);
	$arr = mysql_fetch_assoc($result);
    if(isset($arr['data_json'])){
		$res = json_decode($arr['data_json'], true);
	}
	
	return $res;
}