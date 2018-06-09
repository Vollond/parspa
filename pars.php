<?php
/**
 * revcom_bot
 *
 * @author - Александр Штокман
 */
header('Content-Type: text/html; charset=utf-8');
require('PQ/phpQuery/phpQuery.php');
require_once("db_connect.php");
require_once("index.php");


$bot->sendMessage("@kaftest", $answer);
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

foreach($art as $value): 
echo ($value["num"]);
add_post($value["num"]);
echo "\n";
endforeach;


function pars_post($post_id){
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


foreach($tmp as $value): 
		preg_match_all('/(img|src)=("|\')[^"\'>]+/i',$value["img"], $result);
		preg_match_all('/(href)=("|\')[^"\'>]+/',$value["text2"], $result2);
		preg_match_all('/(<p>)[^<]+/',$value["text2"], $result3);
		$txt = $result3[0][0];
		$img = $result[0][0];
		$url = $result2[0][0];
	 endforeach; 

		$txt = substr( $txt, 3);
		$img = substr( $img, 5);
		$url = substr( $url, 6);
		echo"$txt \n $img \n  $url ";
		
	$p_text = "$txt [Читать дальше]($url)";
	$bot->sendPhoto("@kaftest", $img);
	$bot->sendMessage("@kaftest", $p_text, "markdown");

}


function add_post($num){
	global $db;
	$query = "insert into posts (num) values('{$num}')";
	if (mysqli_query($db,$query)==true)
	{
		echo "true!!";
		pars_post($num);
}
}
?>