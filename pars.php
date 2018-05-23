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
$tmp = array();

foreach($links as $link){

	$link = pq($link);


	$tmp[] = array(
		"text" => $link->text(),
	//	"url"  => $link->attr("href"),
		"img"  => $link->attr("src")
	);
}

phpQuery::unloadDocuments();
?>
<script async src="https://telegram.org/js/telegram-widget.js?4" data-telegram-post="Serious_catalog/674" data-width="100%"></script>
<ul>
	<?php foreach($tmp as $value): ?>
	<li>
		<a href="<?php echo($value["img"]); ?>" target="_blank">
			<?php echo($value["text"]); ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>