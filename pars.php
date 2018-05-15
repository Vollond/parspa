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

$links = pq("#tabnews_newsc")->find("a");

$tmp = array();

foreach($links as $link){

	$link = pq($link);

	$tmp[] = array(
		"text" => $link->text(),
		"url"  => $link->attr("href")
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
	</li>
	<?php endforeach; ?>
</ul>