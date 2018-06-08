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

$articls = pq("#content")->find("id");

$art = array();

foreach($articls as $article){
	
$article = pq($article);
		
	$art[] = array(
	"num" => $article->attr("id")
	);
}

$links = pq("#post-3358")->find("div");

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

<?php 
foreach($art as $value): 
echo ($value["num"]);
echo "0\n";
endforeach;
?>


	<?php foreach($tmp as $value): ?>
	
		<?php 
		preg_match_all('/(img|src)=("|\')[^"\'>]+/i',$value["img"], $result);
		preg_match_all('/(href)=("|\')[^"\'>]+/',$value["text2"], $result2);
		preg_match_all('/(<p>)[^<]+/',$value["text2"], $result3);
		$txt = $result3[0][0];
		$img = $result[0][0];
		$url = $result2[0][0];
		?>
	
	<?php endforeach; ?>
<?php 	
		$txt = substr( $txt, 3);
		$img = substr( $img, 5);
		$url = substr( $url, 6);
		
		echo"$txt \n $img \n  $url ";
?>
