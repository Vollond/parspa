<?php
/**
 * revcom_bot
 *
 * @author - ��������� �������
 */
header('Content-Type: text/html; charset=utf-8');
require('PQ/phpQuery/phpQuery.php');

$html = file_get_contents("http://web.kpi.kharkov.ua/cmps/ru/category/glavnaya/");

phpQuery::newDocument($html);

$links = pq("#post-3372")->find("div");

$tmp = array();

foreach($links as $link){
/**
<?php echo "$link"; ?>
 */
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
<ul>
	<?php foreach($tmp as $value): ?>
	<li>
		<a href="<?php echo($value["url"]); ?>" target="_blank">
			<?php echo($value["text"]); ?>
		</a>
		<?php echo($value["text"]); ?>
		<?php echo($value["img"]); ?>
		<?php echo($value["url"]); ?>
		<?php echo($value["text2"]); ?>
	</li>
	<?php endforeach; ?>
</ul>