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
/**
<?php echo "$link"; ?>
 */
	$link = pq($link);
<?php print "$link"; ?>


	$tmp[] = array(
		"text" => $link->text(),
		"url"  => $link->attr("href"),
		"img"  => $link->attr("src")
	);
}

phpQuery::unloadDocuments();
?>
<ul>
	<?php foreach($tmp as $value): ?>
	<li>
		<a href="<?php echo($value["url"]); ?>" target="_blank">
			<?php echo($value["text"]); ?>
		</a>
		<?php echo($value["text"]); ?>
		<?php echo($value["img"]); ?>
		<?php echo($value["url"]); ?>
	</li>
	<?php endforeach; ?>
</ul>