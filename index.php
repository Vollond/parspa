<?php
/**
 * revcom_bot
 *
 * @author - Александр Штокман
 */
header('Content-Type: text/html; charset=utf-8');
// подрубаем API
require_once("vendor/autoload.php");

// дебаг
if(true){
	error_reporting(E_ALL & ~(E_NOTICE | E_USER_NOTICE | E_DEPRECATED));
	ini_set('display_errors', 1);
}

// создаем переменную бота
$token = "487405665:AAF3w09dg4a-of_ZBCmEWolqbZqNh1P6Yuk";
$bot = new \TelegramBot\Api\Client($token,null);

if($_GET["bname"] == "revcombot"){
	$bot->sendMessage("@burgercaputt", "Тест");
}

// если бот еще не зарегистрирован - регистируем
if(!file_exists("registered.trigger")){ 
	/**
	 * файл registered.trigger будет создаваться после регистрации бота. 
	 * если этого файла нет значит бот не зарегистрирован 
	 */
	 
	// URl текущей страницы
	$page_url = "https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$result = $bot->setWebhook($page_url);
	if($result){
		file_put_contents("registered.trigger",time()); // создаем файл дабы прекратить повторные регистрации
	} else die("ошибка регистрации");
}
function logg($txt) {
	$file = 'logg.txt';
$current = file_get_contents($file);
$current .= "$txt\n";
file_put_contents($file, $current);
	return $current;
}

function bd($lol) {
		if($lol==666){
		$file = 'text.txt';
		$current = 666;
		file_put_contents($file, $current);
	} 
	if($lol==777){
$file = 'text.txt';
$current = file_get_contents($file);
if($current>10){$current='stop';}
}
	if(($lol!=777)&&($lol!=666)){
$file = 'text.txt';
$current = file_get_contents($file);
$current=$current+1;
if($lol==0){$current=0;}
file_put_contents($file, $current);
if($current>10){$current='stop';}
}
	return $current;
}

function ad($lol) {
 
	if($lol==777){
$file = 'text2.txt';
$current = file_get_contents($file);
if($current==1){$current='stop';}
}
	else{
$file = 'text2.txt';
$current = file_get_contents($file);
if($lol==1){$current='stop';}
if($current==1){$current='stop';}
if($lol==0){$current=0;}
file_put_contents($file, $current);
}
	return $current;
}
function kk(){
	   $file = 'stop.txt';
	   $current = file_get_contents($file);
    $h=date(G);
	$a=1;
	if($h>16){$a=0.9;}
	if(($h==7)||($h==24)){$a=2;} 
	if($h<7){$a=5;}
	$a=$a*(rand(9,12)/10);
	if ($current=='stop'){$a=666;}
 	return $a;
}  
 
   function stop($lol){
	   $file = 'stop.txt';
	   	if ($lol==666)
		{$current='stop';
		file_put_contents($file, $current);}
		if($lol==777){
		$current = file_get_contents($file);
		return $current;}
 	return $current;
}   

// Команды бота
// пинг. Тестовая
$bot->command('ping', function ($message) use ($bot) {
	$bot->sendMessage("@nitcshe", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
});

//-1001088197401
$bot->command('bann', function ($message) use ($bot) {
$bot->sendMessage($message->getChat()->getId(), "1");
$bot->restrictChatMember(-1001088197401, 397432994, strtotime("+5 days"), false, false, false, false);
$bot->sendMessage($message->getChat()->getId(), "да?");
});



$bot->command('prom', function ($message) use ($bot) {
//$bot->sendMessage($message->getChat()->getId(), "1");
//$bot->promoteChatMember(-1001088197401, 441528629, can_pin_messages=True);
$bot->sendMessage($message->getChat()->getId(), "да?");
});

$bot->command('bd', function ($message) use ($bot) {
	$answer=bd(777);
	$bot->sendMessage($message->getChat()->getId(), "вот: $answer");
});
$bot->command('delb', function ($message) use ($bot) {
	 $answer=bd(0);
});

$bot->command('stop_spam', function ($message) use ($bot) {
	$answer=stop(666);
	$bot->sendMessage($message->getChat()->getId(), "вот: $answer");
});

$bot->command('stop_b', function ($message) use ($bot) {
	$answer=bd(666);
	$bot->sendMessage($message->getChat()->getId(), "вот: $answer");
});
$bot->command('ad', function ($message) use ($bot) {
	$answer=ad(777);
	$bot->sendMessage($message->getChat()->getId(), "вот: $answer");
});
$bot->command('dela', function ($message) use ($bot) {
	 $answer=ad(0);
});
$bot->command('cat', function ($message) use ($bot) {
	$bot->sendMessage("322682583", "asd" );
	$bot->sendMessage("322682583", $bot->getChatMembersCount(-1001130109518));
});



$bot->command('test_t', function ($message) use ($bot) {

	if((bd(777)!='stop')&&(ad(777)!='stop')){
	while(bd(777)!='stop') {
	if((bd(1)!='stop')&&(ad(777)!='stop')){
	$h=date(G);
	$a=1;
	if($h>10){$a=0.9;}
	if($h<8){$a=2.5;}
		if(ad(777)=='stop'){
			$bot->sendMessage($message->getChat()->getId(), "ПИИИДООР!!!");
		} 
	ad(1);
	$x=bd(777);
	$bot->sendMessage($message->getChat()->getId(), "$x");


	$bot->ForwardMessage("@tmesale", "@vp_telegram", 12178); 
$bot->sendMessage($message->getChat()->getId(), "$x 1");sleep(40);
	$bot->ForwardMessage("@PR_Free", "@vp_telegram", 12178); 
$bot->sendMessage($message->getChat()->getId(), "$x 2");sleep(40);
//	$bot->ForwardMessage("@TGPR_RealType", "@vp_telegram", 12178);
//	$bot->sendMessage($message->getChat()->getId(), "$x 3");sleep(5);
	$bot->ForwardMessage("@zayavi_o_sebe", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 4");sleep(40);
//	$bot->ForwardMessage("@megi_VP", "@vp_telegram", 12178);
//$bot->sendMessage($message->getChat()->getId(), "$x 5");sleep(40);
	$bot->ForwardMessage("@kingtelegrams", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 6");sleep(40);
	$bot->ForwardMessage("@piarGo", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 7");sleep(40);
	$bot->ForwardMessage("@hosting_pr ", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 8");sleep(40);

	//$bot->ForwardMessage("@Maestro_Group", "@vp_telegram", 12178);
//$bot->sendMessage($message->getChat()->getId(), "$x 9");sleep(40);

	//$bot->ForwardMessage("@piars", "@vp_telegram", 12178);
//$bot->sendMessage($message->getChat()->getId(), "$x 10");sleep(40);
	$bot->ForwardMessage("@prfree", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 11");sleep(40);
	$bot->ForwardMessage("@FreeVPP ", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 12");sleep(40);
	$bot->ForwardMessage("@piarzero ", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 13");sleep(40);
//$bot->ForwardMessage("@piarzero ", "@vp_telegram", 12178);
//$bot->sendMessage($message->getChat()->getId(), "$x 14");sleep(40);
	//$bot->ForwardMessage("@PRTalk_one", "@vp_telegram", 12178);
//$bot->sendMessage($message->getChat()->getId(), "$x 15");sleep(40);
	$bot->ForwardMessage("@AdToChat ", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 16");sleep(40);
	$bot->ForwardMessage("@chat_5 ", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 17");sleep(40);
	$bot->ForwardMessage("@piar_one ", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 18");sleep(40);
	$bot->ForwardMessage("@Piar_Vp_Pop_Group", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 19");sleep(40);
	$bot->ForwardMessage("@PRvTG", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 20");sleep(40);
	//$bot->ForwardMessage("@Gopiar", "@vp_telegram", 12178);
//$bot->sendMessage($message->getChat()->getId(), "$x 21");sleep(40);
	$bot->ForwardMessage("@PiArTim ", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 22");sleep(40);
	$bot->ForwardMessage("@ipiar", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 23");sleep(40);
	$bot->ForwardMessage("@Piartv", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 24");sleep(40);
	$bot->ForwardMessage("-1001083582145", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 25");sleep(40);
	$bot->ForwardMessage("@piarchat", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 26");sleep(40);
	$bot->ForwardMessage("@PRnorules", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 27");sleep(40);
	$bot->ForwardMessage("@spam999_chat", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 28");sleep(40);
$bot->ForwardMessage("@MaestroPRchat", "@vp_telegram", 12178);
$bot->sendMessage($message->getChat()->getId(), "$x 29 end");sleep(40);

		$bot->sendMessage("-1001087347668", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 01");sleep(40);
			$bot->sendMessage("-1001080174252", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 02");sleep(40);
		$bot->sendMessage("-1001140678525", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 03");sleep(40);
		$bot->sendMessage("-1001097200747", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 04");sleep(40);
	/*	$bot->sendMessage("-1001109113929", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 05");sleep(40); */
		$bot->sendMessage("-1001089694021", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 06");sleep(40);
		$bot->sendMessage("-1001093376994", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 07");sleep(40);/*
		$bot->sendMessage("-1001113516975", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 08");sleep(40);*/
		$bot->sendMessage("-1001070493759", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 09");sleep(40);
		$bot->sendMessage("-1001127198642", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 010");sleep(40);
		$bot->sendMessage("-1001092316121", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 011");sleep(40);
		/*$bot->sendMessage("-1001104167913", '#Услуги #Продам
1. 👨‍👩‍👧‍👦 Накрутка подписчиков в каналы и чаты
Не боты. Подписчики живые, активные. Не отписываются и не банятся. Просматривают посты.
7р/подписчик - до 100 подписчиков
6р/подписчик - 100-500
5р/подписчик - 500+

2. 🔝 Реклама на сутки Три в Одном
+ Пост в @Serious_catalog
+ Закреп в шапке @vp_telegram
+ Рекламная строчка в описанни каталога и чата
200р / Сутки

По всем вопросам обращаться -  @Palanikbot
Подробнее - @ProgProm
');
$bot->sendMessage($message->getChat()->getId(), "$x 012 end");sleep(40);
*/
	//danilpradbot


	sleep(rand(100,500)+500*$a);
$bot->sendMessage($message->getChat()->getId(), "2! $x 1");sleep(40);

$bot->ForwardMessage("@vp_telegram", "@ProgProm", 13); 
$bot->sendMessage($message->getChat()->getId(), "$x 1"); sleep(40);
	$bot->ForwardMessage("@tmesale", "@ProgProm", 10); 
$bot->sendMessage($message->getChat()->getId(), "$x 2");sleep(40);
	$bot->ForwardMessage("@PR_Free", "@ProgProm", 10); 
$bot->sendMessage($message->getChat()->getId(), "$x 3");sleep(40);
//	$bot->ForwardMessage("@TGPR_RealType", "@ProgProm", 10);//
//$bot->sendMessage($message->getChat()->getId(), "$x 4");sleep(5);
	$bot->ForwardMessage("@zayavi_o_sebe", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 5");sleep(40);
//	$bot->ForwardMessage("@megi_VP", "@ProgProm", 10);
//$bot->sendMessage($message->getChat()->getId(), "$x 6");sleep(40);
	$bot->ForwardMessage("@kingtelegrams", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 7");sleep(40);
	$bot->ForwardMessage("@piarGo", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 8");sleep(40);
	$bot->ForwardMessage("@hosting_pr ", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 9");sleep(40);

//	$bot->ForwardMessage("@Maestro_Group", "@vp_telegram", 12178);
//$bot->sendMessage($message->getChat()->getId(), "$x 10");sleep(40);
//	$bot->ForwardMessage("@piars", "@vp_telegram", 12178);
//$bot->sendMessage($message->getChat()->getId(), "$x 11");sleep(40);
	$bot->ForwardMessage("@prfree", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 12");sleep(40);
	$bot->ForwardMessage("@FreeVPP ", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 13");sleep(40);
	$bot->ForwardMessage("@piarzero ", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 14");sleep(40);
//$bot->ForwardMessage("@piarzero ", "@vp_telegram", 12178);
//$bot->sendMessage($message->getChat()->getId(), "$x 15");sleep(40);
//	$bot->ForwardMessage("@PRTalk_one", "@ProgProm", 10);
//$bot->sendMessage($message->getChat()->getId(), "$x 15");sleep(40);
	$bot->ForwardMessage("@AdToChat ", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 16");sleep(40);
	$bot->ForwardMessage("@chat_5 ", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 17");sleep(40);
	$bot->ForwardMessage("@piar_one ", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 18");sleep(40);
	$bot->ForwardMessage("@Piar_Vp_Pop_Group", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 19");sleep(40);
	$bot->ForwardMessage("@PRvTG", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 20");sleep(40);
	//$bot->ForwardMessage("@Gopiar", "@ProgProm", 10);
//$bot->sendMessage($message->getChat()->getId(), "$x 21");sleep(40);
$bot->ForwardMessage("@PiArTim ", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 22");sleep(40);
	$bot->ForwardMessage("@ipiar", "@ProgProm", 10); 
$bot->sendMessage($message->getChat()->getId(), "$x 23");sleep(40);
	$bot->ForwardMessage("@Piartv", "@ProgProm", 10); 
$bot->sendMessage($message->getChat()->getId(), "$x 24");sleep(40);
	$bot->ForwardMessage("-1001083582145", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 25");sleep(40);
	$bot->ForwardMessage("@piarchat", "@ProgProm", 10); 
$bot->sendMessage($message->getChat()->getId(), "$x 26");sleep(40);
	$bot->ForwardMessage("@PRnorules", "@ProgProm", 10); 
$bot->sendMessage($message->getChat()->getId(), "$x 27");sleep(40);
	$bot->ForwardMessage("@spam999_chat", "@ProgProm", 10); 
$bot->sendMessage($message->getChat()->getId(), "$x 28");sleep(40);
$bot->ForwardMessage("@MaestroPRchat", "@ProgProm", 10);
$bot->sendMessage($message->getChat()->getId(), "$x 29 End");sleep(40);


sleep(rand(200,1000)+4500*$a);
	
	//sleep(55*60);

	ad(0);
	}}}
});

$bot->command('infoqwerty', function ($message) use ($bot) {
	$bot->sendMessage("322682583", $message->getMessageId());
	$bot->sendMessage("322682583", $message->getChat()->getId());
	$bot->sendMessage("322682583", $message->getFrom()->getId());
	

});

// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать!';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// помощ
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/help - помощ';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// передаем картинку
$bot->command('getpic', function ($message) use ($bot) {
	$pic = "http://aftamat4ik.ru/wp-content/uploads/2017/03/photo_2016-12-13_23-21-07.jpg";

    $bot->sendPhoto($message->getChat()->getId(), $pic);
});

// передаем документ
$bot->command('getdoc', function ($message) use ($bot) {
	$document = new \CURLFile('shtirner.txt');

    $bot->sendDocument($message->getChat()->getId(), $document);
});

// Кнопки у сообщений
$bot->command("ibutton", function ($message) use ($bot) {
	$keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
		[
			[
				['callback_data' => 'data_test', 'text' => 'Answer'],
				['callback_data' => 'data_test2', 'text' => 'ОтветЪ']
			]
		]
	);

	$bot->sendMessage($message->getChat()->getId(), "тест", false, null,null,$keyboard);
});

// Обработка кнопок у сообщений
$bot->on(function($update) use ($bot, $callback_loc, $find_command){
	$callback = $update->getCallbackQuery();
	$message = $callback->getMessage();
	$chatId = $message->getChat()->getId();
	$data = $callback->getData();
	
	if($data == "data_test"){
		$bot->answerCallbackQuery( $callback->getId(), "This is Ansver!",true);
	}
	if($data == "data_test2"){
		$bot->sendMessage($chatId, "Это ответ!");
		$bot->answerCallbackQuery($callback->getId()); // можно отослать пустое, чтобы просто убрать "часики" на кнопке
	}

}, function($update){
	$callback = $update->getCallbackQuery();
	if (is_null($callback) || !strlen($callback->getData()))
		return false;
	return true;
});

// обработка инлайнов
$bot->inlineQuery(function ($inlineQuery) use ($bot) {
	mb_internal_encoding("UTF-8");
	$qid = $inlineQuery->getId();
	$text = $inlineQuery->getQuery();
	
	// Это - базовое содержимое сообщения, оно выводится, когда тыкаем на выбранный нами инлайн
	$str = "Что другие?
Свора голодных нищих.
Им все равно...
В этом мире немытом
Душу человеческую
Ухорашивают рублем,
И если преступно здесь быть бандитом,
То не более преступно,
Чем быть королем...
Я слышал, как этот прохвост
Говорил тебе о Гамлете.
Что он в нем смыслит?
<b>Гамлет</b> восстал против лжи,
В которой варился королевский двор.
Но если б теперь он жил,
То был бы бандит и вор.";
	$base = new \TelegramBot\Api\Types\Inline\InputMessageContent\Text($str,"Html");
	
	// Это список инлайнов
	// инлайн для стихотворения
	$msg = new \TelegramBot\Api\Types\Inline\QueryResult\Article("1","С. Есенин","Отрывок из поэмы `Страна негодяев`");
	$msg->setInputMessageContent($base); // указываем, что в ответ к этому сообщению надо показать стихотворение
	
	// инлайн для картинки
	$full = "http://aftamat4ik.ru/wp-content/uploads/2017/05/14277366494961.jpg"; // собственно урл на картинку 
	$thumb = "http://aftamat4ik.ru/wp-content/uploads/2017/05/14277366494961-150x150.jpg"; // и миниятюра
	
	$photo = new \TelegramBot\Api\Types\Inline\QueryResult\Photo("2",$full,$thumb);
	
	// инлайн для музыки
	$url = "http://aftamat4ik.ru/wp-content/uploads/2017/05/mongol-shuudan_-_kozyr-nash-mandat.mp3";
	$mp3 = new \TelegramBot\Api\Types\Inline\QueryResult\Audio("3",$url,"Монгол Шуудан - Козырь наш Мандат!");
	
	// инлайн для видео
	$vurl = "http://aftamat4ik.ru/wp-content/uploads/2017/05/bb.mp4";
	$thumb = "http://aftamat4ik.ru/wp-content/uploads/2017/05/joker_5-150x150.jpg";
	$video = new \TelegramBot\Api\Types\Inline\QueryResult\Video("4",$vurl,$thumb, "video/mp4","коммунальные службы","тут тоже может быть описание");
	
	// отправка
	try{
		$result = $bot->answerInlineQuery( $qid, [$msg,$photo,$mp3,$video],100,false);
	}catch(Exception $e){
		file_put_contents("rdata",print_r($e,true));
	}
});

// Reply-Кнопки
$bot->command("buttons", function ($message) use ($bot) {
	$keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "Власть советам!"], ["text" => "Сиськи!"]]], true, true);

	$bot->sendMessage($message->getChat()->getId(), "тест", false, null,null, $keyboard);
});

// Отлов любых сообщений + обрабтка reply-кнопок
$bot->on(function($Update) use ($bot){
	
	$message = $Update->getMessage();
	$mtext = $message->getText();
	$name = $message->getChat()->getUsername();
	$cid = $message->getChat()->getId();
	$uid = $message->getFrom()->getId();
	$uname = $message->getFrom()->getUsername();
	if(($name!="nitcshe")&&($cid!="-1001394826177")&&($name!="piars")&&($name!="tgplug")&&($name!="PRTalk")&&($name!="PrTalk2")&&($name!="piarGo")&&($name!="AdToChat")&&($name!="MaestroPRchat")&&($name!="besplatnyipiar")&&($name!="megi_VP")){
	$txt="$cid $name :  $mtext";
	logg($txt);}
	if($name!="nitcshe"){
	//$message->getFrom()->getId() 406900318
	}
	if(($uname!="nitcshe")&&($uname!="upRiseup")){ 
	if($cid==-1001394826177){
	if($message->getChat()->getUsername() == "advanceup"){
	$bot->deleteMessage(-1001394826177, $message->getMessageId());	
	//$bot->sendMessage("322682583", "$uname : $mtext");
	$txt="$uname :  $mtext";
	logg($txt);
	$bot->restrictChatMember(-1001394826177, $uid , strtotime("+3660 days"), false, false, false, false);
	}}}
	
	
	if(mb_stripos($mtext,"Сиськи") !== false){
		$pic = "http://aftamat4ik.ru/wp-content/uploads/2017/05/14277366494961.jpg";

		$bot->sendPhoto($message->getChat()->getId(), $pic);
	}
}, function($message) use ($name){
	return true; // когда тут true - команда проходит
});

// запускаем обработку
$bot->run();

echo "бот";