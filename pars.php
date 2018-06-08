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

/*
foreach($tmp as $value): 
preg_match_all('/(img|src)=("|\')[^"\'>]+/i',$value["img"], $result);
 endforeach; 
 
 foreach($tmp as $value): 
preg_match_all('/(href)=("|\')[^"\'>]+/',$value["text2"], $resultt);
//print_r ($resultt);
endforeach; 
 */
phpQuery::unloadDocuments();
?>

	<?php foreach($tmp as $value): ?>
	
		<?php 
		preg_match_all('/(img|src)=("|\')[^"\'>]+/i',$value["img"], $result);
		preg_match_all('/(href)=("|\')[^"\'>]+/',$value["text2"], $result2);

//		echo($value["text2"]);
//		echo($result[0][0]);
//		echo($result2[0][0]);
		
		echo"\n\n\n";
		$txt = $value["text2"];
		$img = $result[0][0];
		$url = $result2[0][0];
//		echo"$txt \n $img \n  $url ";
			?>
	
	<?php endforeach; ?>
<?php 	
		echo"$txt \n $img \n  $url ";
?>
