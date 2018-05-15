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

$links = pq("#post-3372")->find("a");
$imgs pq("#post-3372")->find("img");
$tmp = array();

foreach($links as $link){

	$link = pq($link);


	$tmp[] = array(
		"text" => $link->text(),
		"url"  => $link->attr("href")
	);
}

foreach($imgs as $img){

	$img = pq($img);


	$tmp[] = array(
		"img"  => $img->attr("src")
	);
}
	$img = pq($img);

phpQuery::unloadDocuments();
?>

<ul>
	<?php foreach($tmp as $value): ?>
	<li>
		<a href="<?php echo($value["url"]); ?>" target="_blank">
			<?php echo($value["text"]); ?>
			<?php echo($value["img"]); ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>