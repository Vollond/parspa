<?php
/**
 * revcom_bot
 *
 * @author - Александр Штокман
 */
header('Content-Type: text/html; charset=utf-8');
// подрубаем API
require_once("vendor/autoload.php");
// подрубаем базу данных
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
	$bot->sendMessage($message->getChat()->getId(), $message->getReplyToMessage()->getText());
	$bot->sendMessage($message->getChat()->getId(), 'pong2!');
});
		

// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать!';
    $bot->sendMessage($message->getChat()->getId(), $answer);
	make_user($message->getFrom()->getUsername(),$cid);
});


	
	
	$bot->command('like', function ($message) use ($bot) {
		
		$like = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
		[
			[
				['callback_data' => 'data_test', 'text' => "love1111"],
			]
		]
	);
	$like2 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
		[
			[
				['callback_data' => 'data_test', 'text' => "love1"],
			]
		]
	);
	
$bot->sendMessage($message->getChat()->getId(), "тест", false, null,null,$like2);
});


$bot->on(function($update) use ($bot, $callback_loc, $find_command){
	$callback = $update->getCallbackQuery();
	$message = $callback->getMessage();
	$chatId = $message->getChat()->getId();
	$data = $callback->getData();
	$inlmsgid = $data->getInlineMessageId();
	//$text = $callback->getText();
	//	$bot->sendMessage($message->getChat()->getId(), "$inlmsgid");

	if($data == "data_test"){
		//$love1="$text 1";
			 //$callback->getId()
		$bot->editMessageReplyMarkup($inlmsgid, $like);
		}
	//	$bot->editMessageReplyMarkup($chatId,$message, $inlmsgid,$like2);
	//	$bot->answerCallbackQuery( $callback->getId(), "This is Ansver!",true);	}
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


	
$bot->command('update_posts', function ($message) use ($bot) {
/*	$img = "http://web.kpi.kharkov.ua/cmps/wp-content/uploads/sites/144/2018/03/28828314_1837764673183610_8045670836477995835_o-min-225x150.jpg";
	$plink = "http://web.kpi.kharkov.ua/cmps/ru/kharkiv-project-management-day-krupnejshee-it-sobytie-v-ukraine/";
	$ptext = "10 марта состоялась конференция, посвященная проектному менеджменту в IT — Kharkiv Project Management Day — крупнейшее событие в Украине. В конференции приняло участие около 400 проектных IT-менеджеров со всей страны. Своим опытом для них поделились более 40 опытных спикеров, среди них доцент кафедры компьютерного моделирования процессов и систем, к.т.н. — … ";
	$p_text = "$ptext [Читать дальше]($plink)";
	$bot->sendPhoto("@kaftest", $img);
	$bot->sendMessage("@kaftest", $p_text, "markdown");
*/

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
//$bot->sendMessage("@kaftest", $result);


	global $db;
	$query = "insert into posts (num) values('{$result}')";
	if (mysqli_query($db,$query)==true)
	{
		//$bot->sendMessage("@kaftest", "true");
		
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



	
if ($img2!=""){
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
/ibutton - кнопки в сообщении
/buttons - reply-панель с кнопками
/getdoc - тестовый документ
/help - помощ';
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

/*	// сохранение тестовых данных
	$data = array( "prevmsg" => $mtext );
	set_udata($message->getFrom()->getUsername(), $data);
	
	// тест получения данных
	$data = get_udata($message->getFrom()->getUsername());
	$bot->sendMessage($message->getChat()->getId(), json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
	*/





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
		file_put_contents("errdata",print_r($e,true));
	}
});

// Reply-Кнопки
$bot->command("buttons", function ($message) use ($bot) {
	$keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "Пройти тест"], ["text" => "Сиськи!"],["text" => "Информация о кафедре"], ["text" => "Задать вопрос"]]], true, true);

	$bot->sendMessage($message->getChat()->getId(), "тест", false, null,null, $keyboard);
});


// регистрация юзера
$bot->on(function($Update) use ($bot){
	$message = $Update->getMessage();
	$mtext = $message->getText();
	$cid = $message->getChat()->getId();
	
	//make_user($message->getFrom()->getUsername(),$cid);
	
	
/*	// сохранение тестовых данных
	$data = array( "prevmsg" => $mtext );
	set_udata($message->getFrom()->getUsername(), $data);
	
	// тест получения данных
	$data = get_udata($message->getFrom()->getUsername());
	$bot->sendMessage($message->getChat()->getId(), json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
	*/
	
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
	
	/* обработка постов из канала
	$cpost = $Update->getChannelPost();
	if($cpost){
		// текст
		$text = $cpost->getText();
		// фотки
		$photo = $cpost->getPhoto();
		if($photo){
			$photo_id = $photo[0]->getFileId();
			$file = $bot->getFile($photo_id);
			$furl = $bot->getFileUrl().'/'.$file->getFilePath();
			file_put_contents(basename($furl), file_get_contents( $furl ) );
		}
		file_put_contents("lastmsg",$text);
	}*/
	// все что ниже - нахуй не нужно(внашем случае)!
	//file_put_contents("mtext",$bot->getRawBody()); - получение всего json ответа
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
	
	if(mb_stripos($mtext,"Сиськи") !== false){
		$pic = "http://aftamat4ik.ru/wp-content/uploads/2017/05/14277366494961.jpg";

		$bot->sendPhoto($message->getChat()->getId(), $pic);
	}
	if(mb_stripos($mtext,"власть советам") !== false){
		$bot->sendMessage($message->getChat()->getId(), "Смерть богатым!");
	}
	
	$data = get_udata($message->getFrom()->getUsername()); // получаем массив данных
	if(!isset($data["obrsv1"])){ // если в нем нет режима - значит человек еще не взаимодействовал с этой командой
		$obrsv1 = "off"; // поэтому задаем ему действие по дефолту
	}else{
		$obrsv1 = $data["obrsv1"];
	}
	
	if(mb_stripos($mtext,"Задать вопрос") !== false){
		// по команде /dbact запускаем цепочку
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
		$data["test"] = "0";
$keyboard2 = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "1"], ["text" => "2"],["text" => "3"]]], true, true);
$bot->sendMessage($message->getChat()->getId(), "Отвечайте!", false, null,null, $keyboard2);
	$bot->sendMessage($message->getChat()->getId(), "0Яблоко? 1, 2 или 3??");
		$data["0"] = $mtext;
				set_udata($message->getFrom()->getUsername(), $data); 
	}
	if($test == "0"){
				$data["test"] = "1";
				set_udata($message->getFrom()->getUsername(), $data); 
				$keyboard2 = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "1"], ["text" => "2"],["text" => "3"]]], true, true);

$bot->sendMessage($message->getChat()->getId(), "1Груша? 1, 2 или 3??", false, null,null, $keyboard2);

		$data["1"] = $mtext;
				set_udata($message->getFrom()->getUsername(), $data); 
	}
	if($test == "1"){
				$data["test"] = "2";
				set_udata($message->getFrom()->getUsername(), $data); 
$bot->sendMessage($message->getChat()->getId(), "2Груша? 1, 2 или 3??", false, null,null, $keyboard2);

		$data["2"] = $mtext;
				set_udata($message->getFrom()->getUsername(), $data); 
	}
	if($test == "2"){
				$data["test"] = "3";
				set_udata($message->getFrom()->getUsername(), $data); 
$bot->sendMessage($message->getChat()->getId(), "3Груша? 1, 2 или 3??", false, null,null, $keyboard2);

		$data["3"] = $mtext;
				set_udata($message->getFrom()->getUsername(), $data); 
	}
	//1+2-3+4-5/ if>5, вы дизайнер.
		
	
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