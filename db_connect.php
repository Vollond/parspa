<?php
$db = parse_url(getenv("DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");


	$query = "select 'Привет!' as field_1, 123 as field_2";
	$result = pg_query($db, $query);
	$result = pg_fetch_assoc($result); 
	echo $result['field_1'] . '</br>' . $result['field_2'];
        pg_close($db);
echo "123 \n";