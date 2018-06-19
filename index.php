<?php
header('Content-Type: text/html; charset=utf-8');
//  API
require_once("vendor/autoload.php");
//  база данных
require_once("db_connect.php");
require_once("users.php");
require('PQ/phpQuery/phpQuery.php');


// дебаг
if(true){
	error_reporting(E_ALL & ~(E_NOTICE | E_USER_NOTICE | E_DEPRECATED));
	ini_set('display_errors', 1);
}

// создаем переменную бота
$token = "586003334:AAHM3Y4CkaEzY1P1hfJgY8n-1f3dEq6k5eA";
$bot = new \TelegramBot\Api\Client($token,null);

// демо постинга в канал(бот должен быть админом в канале)
if($_GET["bname"] == "post_channel"){
	$bot->sendMessage("@ваш канал", "Тест");
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

// Команды бота
// пинг. Тестовая
$bot->command('ping', function ($message) use ($bot) {
	$bot->sendMessage($message->getChat()->getId(), 'pong!');
});
		

// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать!';
    $bot->sendMessage($message->getChat()->getId(), $answer);
$keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "Пройти тест"],["text" => "Информация о кафедре"], ["text" => "Задать вопрос"], ["text" => "Контакты"]]], true, true);
$bot->sendMessage($message->getChat()->getId(), "Выберете интересущий вас раздел", false, null,null, $keyboard);
	make_user($message->getFrom()->getUsername(),$cid);
});

	
$bot->command('update_posts', function ($message) use ($bot) {


$html = file_get_contents("http://web.kpi.kharkov.ua/cmps/ru/category/glavnaya/");
$pq = phpQuery::newDocument($html);


$articls = $pq->find("article");


$art = array();

foreach($articls as $article){
	
$article = pq($article);
	$art[] = array(
	"num" => $article->attr("id")
	);
}

phpQuery::unloadDocuments();

foreach($art as $value){
	
$result=implode($value);


	global $db;
	$query = "insert into posts (num) values('{$result}')";
	if (mysqli_query($db,$query)==true)
	{
		
		$post_id = $result;
$html = file_get_contents("http://web.kpi.kharkov.ua/cmps/ru/category/glavnaya/");

$pq = phpQuery::newDocument($html);

$links = pq("#$post_id")->find("div");

$tmp = array();

foreach($links as $link){

	$link = pq($link);

	$tmp[] = array(
		"text" => $link->text(),
		"url"  => $link->attr("href"),
		"img"  => $link->find("img"),
		"text2" => $link->find("p")
	);
}

phpQuery::unloadDocuments();



foreach($tmp as $value2){ 
		preg_match_all('/(img|src)=("|\')[^"\'>]+/i',$value2["img"], $rresult);
		preg_match_all('/(href)=("|\')[^"\'>]+/',$value2["text2"], $rresult2);
		preg_match_all('/(<p>)[^<]+/',$value2["text2"], $rresult3);
		$txt = $rresult3[0][0];
		$img = $rresult[0][0];
		$url = $rresult2[0][0];
}

		$txt = substr( $txt, 3);
		$img = substr( $img, 5);
		$url = substr( $url, 6);
$img2 = preg_replace('/-\d\d\dx\d\d\d\./', '.', $img);



	
if ($img2!=null){
$p_text = "$txt [Читать дальше]($url) [⁠]($img2)";
	}
	else{
$p_text = "$txt [Читать дальше]($url)";
	}
$bot->sendMessage("@kaftest", $p_text, "markdown",$like);

		
}


}
});

$bot->command('image', function ($message) use ($bot) {
    $answer = 'Команды:
/ibutton - кнопки в сообщении
/buttons - reply-панель с кнопками
/getdoc - тестовый документ
/help - помощ';
$bot->sendMessage("@kaftest", "watfhjkhgfd**saST**FHYJGFDSADFTGHJSD S DS F123SADsdad [⁠](http://web.kpi.kharkov.ua/cmps/wp-content/uploads/sites/144/2018/05/photo_2018-05-25_00-13-04-min.jpg)", "markdown");
});


// помощ
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/buttons - reply-панель с кнопками
';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

$bot->command('savetest', function ($message) use ($bot) {
    $bot->sendMessage($message->getChat()->getId(), "123");
	$data = array( "prevmsg" => $mtext );
	set_udata($message->getFrom()->getUsername(), $data);
	
	// тест получения данных
	$data = get_udata($message->getFrom()->getUsername());
	$bot->sendMessage($message->getChat()->getId(), json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
	$bot->sendMessage($message->getChat()->getId(), "456");
});


// Reply-Кнопки
$bot->command("buttons", function ($message) use ($bot) {
	$keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "Пройти тест"],["text" => "Информация о кафедре"], ["text" => "Задать вопрос"], ["text" => "Контакты"]]], true, true);
$bot->sendMessage($message->getChat()->getId(), "Выберете интересущий вас раздел", false, null,null, $keyboard);
	});


// регистрация юзера
$bot->on(function($Update) use ($bot){
	$message = $Update->getMessage();
	$mtext = $message->getText();
	$cid = $message->getChat()->getId();
	
	
	
	
	$data = get_udata($message->getFrom()->getUsername()); // получаем массив данных
	if(!isset($data["mode"])){ // если в нем нет режима - значит человек еще не взаимодействовал с этой командой
		$mode = "name"; // поэтому задаем ему действие по дефолту
	}else{
		$mode = $data["mode"];
	}

	if($mtext == "/dbact"){
$bot->sendMessage($message->getChat()->getId(), "старт");
		// по команде /dbact запускаем цепочку
		if($mode == "name"){
			$bot->sendMessage($message->getChat()->getId(), "Добрый день, укажите, пожалуйста, ваше имя");
			$data["mode"] = "aftername";
			set_udata($message->getFrom()->getUsername(), $data); // сохраняем изменения
		}
		
	}
	if($mode == "aftername"){
		// помещаем имя в массив данных
		$data["name"] = $message->getText(); // очевидно, что после запроса имени пользователь отправит следюущей командой свое имя, то есть оно будет в тексте сообщения.
		$bot->sendMessage($message->getChat()->getId(), "Добрый день, укажите ваш сайт");
		$data["mode"] = "website";
		set_udata($message->getFrom()->getUsername(), $data); // сохраняем изменения
	}
	if($mode == "website"){
		$data["website"] = $message->getText(); // очевидно, что после запроса сайта пользователь отправит следюущей командой свой сайт, то есть адрес будет в тексте сообщения.
		$bot->sendMessage($message->getChat()->getId(), "спасибо.");
		$data["mode"] = "done";
		set_udata($message->getFrom()->getUsername(), $data); // сохраняем изменения
	}
	
	/*if($mode == "done"){
		// если человек уже прошел опрос - выводим ему собранную у него-же информацию
		$bot->sendMessage($message->getChat()->getId(), "Вы уже проходили опрос и указали такие данные:\nИмя - ".$data["name"]."\nсайт - ".$data["website"]);
	}
	*/
}, function($message) use ($name){
	return true; // когда тут true - команда проходит
});

// Отлов любых сообщений + обрабтка reply-кнопок
$bot->on(function($Update) use ($bot){
	
	$message = $Update->getMessage();
	$mtext = $message->getText();
	$cid = $message->getChat()->getId();
	
	// array of https://github.com/TelegramBot/Api/blob/master/src/Types/PhotoSize.php
	$photos = $message->getPhoto();
	if(!empty($photos)) foreach($photos as $ph){
		$fileId = $ph->getFileId();
		$data = $bot->downloadFile($fileId);
		file_put_contents("file.jpg",$data);
		$bot->sendMessage($message->getChat()->getId(), "Файл загружен");
	}
	


//
	if(mb_stripos($mtext,"Информация о кафедре") !== false){
		$k_img="web.kpi.kharkov.ua/cmps/wp-content/uploads/sites/144/2016/02/Animatsiya-na-sajt-menshe-8-mb.gif";
		$k_txt = "
*Вас приветствует коллектив кафедры компьютерного моделирования процессов и систем!*
Кафедра была создана в 1964 году для подготовки кадров высшей квалификации, которые обладали бы как практической инженерной подготовкой, так и фундаментальными знаниями в области математики и информационных технологий. Система обучения студентов, созданная к тому времени в инженерно-физическом институте, стала использоваться для подготовки инженеров — разработчиков систем управления различных летательных аппаратов, в том числе и космических.

В течении прошедших десятилетий кафедрой выпущено более полутора тысяч специалистов, которые работают на таких предприятиях, как НПО «ХАРТРОН-АРКОС», завод им. Шевченко, НИИ комплексной автоматизации, в университетах и научных институтах.
";
	$k_txt2 = "		В настоящее время кафедра готовит бакалавров, инженеров и магистров по специальностям:  [⁠]($k_img)
*-«Интеллектуальные и робототехнические системы»*
*-«Проектирование, создание и анализ компьютерных систем»*
[Информация для абитуриентов](http://web.kpi.kharkov.ua/cmps/ru/abiturientam/)
";
		$bot->sendMessage($message->getChat()->getId(), $k_txt, "markdown");	
		$bot->sendMessage($message->getChat()->getId(), $k_txt2, "markdown");	
		$bot->sendVideo($message->getChat()->getId(), "http://i.yapx.ru/BkXUO.mp4");
		}
		
	if(mb_stripos($mtext,"Контакты") !== false){
		$k_img="http://web.kpi.kharkov.ua/cmps/wp-content/uploads/sites/144/2018/03/Plakat-min-768x1181.jpg";
		$k_txt = "
Вас приветствует коллектив кафедры компьютерного моделирования процессов и систем!
[Информационный ролик о специальностях кафедры](https://www.youtube.com/watch?v=HsKNzXDoHps)
Кафедра была создана в 1964 году для подготовки кадров высшей квалификации, которые обладали бы как практической инженерной подготовкой, так и фундаментальными знаниями в области математики и информационных технологий. Система обучения студентов, созданная к тому времени в инженерно-физическом институте, стала использоваться для подготовки инженеров — разработчиков систем управления различных летательных аппаратов, в том числе и космических.

В течении прошедших десятилетий кафедрой выпущено более полутора тысяч специалистов, которые работают на таких предприятиях, как НПО «ХАРТРОН-АРКОС», завод им. Шевченко, НИИ комплексной автоматизации, в университетах и научных институтах.

[Информация для абитуриентов](http://web.kpi.kharkov.ua/cmps/ru/abiturientam/)

";
	$k_txt3 = "	
61002, г. Харьков, ул. Кирпичова 2,
НТУ „ХПИ”,
математический корпус, 1 этаж
Телефоны кафедры:
+38(057)707-64-54
+38(057)707-64-36
Факс кафедры:
+38(057)707-64-54
e-mail: brdm@kpi.kharkov.ua
e-mail: cmpskhpi@gmail.com
	[Сайт](http://web.kpi.kharkov.ua/cmps/ru/kafedra-cmps/)
	[Фейсбук](https://www.facebook.com/official.cmps/)
	[Инстаграм](https://www.instagram.com/official_cmps/)
	[Группа в вк](https://vk.com/official_cmps)
	[Канал в телеграме](https://t.me/official_cmps)
";
		$bot->sendMessage($message->getChat()->getId(), $k_txt3, "markdown", true, null, null, null);	
		}
	
	


	
	$data = get_udata($message->getFrom()->getUsername()); // получаем массив данных
	if(!isset($data["obrsv1"])){ // если в нем нет режима - значит человек еще не взаимодействовал с этой командой
		$obrsv1 = "off"; // поэтому задаем ему действие по дефолту
	}else{
		$obrsv1 = $data["obrsv1"];
	}
	
	if(mb_stripos($mtext,"Задать вопрос") !== false){
		$data["obrsv1"] = "on";
		set_udata($message->getFrom()->getUsername(), $data); 
		$bot->sendMessage($message->getChat()->getId(), "Напишите свой вопрос и вам ответят в ближайшее время");

	}
	if($obrsv1 == "on"){
				$data["obrsv1"] = "off";
				set_udata($message->getFrom()->getUsername(), $data); 
				$bot->forwardMessage(322682583,$message->getChat()->getId(), $message->getMessageId());
	}

	
}, function($message) use ($name){
	return true; // когда тут true - команда проходит
});


// тест
$bot->on(function($Update) use ($bot){
	$message = $Update->getMessage();
	$mtext = $message->getText();
	$cid = $message->getChat()->getId();
	
	$data = get_udata($message->getFrom()->getUsername()); // получаем массив данных
	if(!isset($data["test"])){ // если в нем нет режима - значит человек еще не взаимодействовал с этой командой
		$test = "off"; // поэтому задаем ему действие по дефолту
	}else{
		$test = $data["test"];
	}
	
	if(mb_stripos($mtext,"Пройти тест") !== false){
		$bot->sendMessage($message->getChat()->getId(), "Тест будет реализован позже", false, null,null, $keyboard);
	/*	$data["test"] = "0";
$keyboard2 = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "1"], ["text" => "2"],["text" => "3"]]], true, true);
$bot->sendMessage($message->getChat()->getId(), "Отвечайте!", false, null,null, $keyboard2);
	$bot->sendMessage($message->getChat()->getId(), "Выберете 1, 2 или 3?");
		$data["0"] = $mtext;
				set_udata($message->getFrom()->getUsername(), $data); 
	}
	if($test == "0"){
				$data["test"] = "1";
				set_udata($message->getFrom()->getUsername(), $data); 
				$keyboard2 = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "1"], ["text" => "2"],["text" => "3"]]], true, true);

$bot->sendMessage($message->getChat()->getId(), "Выберете 1, 2 или 3?", false, null,null, $keyboard2);

		$data["1"] = $mtext;
				set_udata($message->getFrom()->getUsername(), $data); 
	}
	if($test == "1"){
				$data["test"] = "2";
				set_udata($message->getFrom()->getUsername(), $data); 
$bot->sendMessage($message->getChat()->getId(), "Выберете 1, 2 или 3?", false, null,null, $keyboard2);

		$data["2"] = $mtext;
				set_udata($message->getFrom()->getUsername(), $data); 
	}
	if($test == "2"){
				$data["test"] = "3";
				set_udata($message->getFrom()->getUsername(), $data); 
$bot->sendMessage($message->getChat()->getId(), "Выберете 1, 2 или 3?", false, null,null, $keyboard2);

		$data["3"] = $mtext;
				set_udata($message->getFrom()->getUsername(), $data); 
				$keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "Пройти тест"],["text" => "Информация о кафедре"], ["text" => "Задать вопрос"], ["text" => "Контакты"]]], true, true);
				$bot->sendMessage($message->getChat()->getId(), "Вы прошли тест. Результы будут позже", false, null,null, $keyboard);
	}
*/
		
	
}, function($message) use ($name){
	return true; // когда тут true - команда проходит
});


// обратная связь
$bot->on(function($Update) use ($bot){
	$message = $Update->getMessage();
	$mtext = $message->getText();
	$cid = $message->getChat()->getId();

		if($message->getReplyToMessage()->getText() !== false){
$bot->sendMessage($message->getReplyToMessage()->getForwardfrom()->getId(), $mtext);
	}
	
}, function($message) use ($name){
	return true; // когда тут true - команда проходит
});




// запускаем обработку
$bot->run();

echo "бот";