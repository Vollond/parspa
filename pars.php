<?php
/**
 * revcom_bot
 *
 * @author - Александр Штокман
 */
header('Content-Type: text/html; charset=utf-8');
require('PQ/phpQuery/phpQuery.php');

$html = file_get_contents("http://web.kpi.kharkov.ua/cmps/ru/category/glavnaya/");

phpQuery::newDocument($html);

$links = pq("#post-3372")->find("div");

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


foreach($tmp as $value): 
preg_match_all('/(img|src)=("|\')[^"\'>]+/i',$value["img"], $result);
 endforeach; 
 
 foreach($tmp as $value): 
preg_match_all('/(href)=("|\')[^"\'>]+',$value["text2"], $resultt);
print_r ($resultt);
echo("$resultt");
 endforeach; 
 
phpQuery::unloadDocuments();
?>

	<?php foreach($tmp as $value): ?>
	
		<?php 
		preg_match_all('/(href)=("|\')[^"\'>]+',$value["text2"], $result2);
		print_r($result2);
		echo"00\n";
	//	print_r($value["url"]);
		echo"1\n";
		echo($value["text2"]);
		echo"2\n";  
		echo($result[0][0]);
			?>
	
	<?php endforeach; ?>
