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

phpQuery::unloadDocuments();
?>

	<?php foreach($tmp as $value): ?>
	
		<?php 
		preg_match_all('/(img|src)=("|\')[^"\'>]+/i',$value["img"], $result);
		preg_match_all('/(href)=("|\')[^"\'>]+/',$value["text2"], $result2);
		preg_match_all('/(<p>)[^<]+/',$value["text2"], $result3);
		$txt = $result3[0][0];
		$img = $result[0][0];
		$url = $result2[0][0];
		$txt = mb_substr( $result3[0][0], 3);
		$img = mb_substr( $result[0][0], 5);
		$url = mb_substr( $result2[0][0], 6);
		
			?>
	
	<?php endforeach; ?>
<?php 	
		echo"$txt \n $img \n  $url ";
?>
