<?php
echo "123";
$db = parse_url(getenv("DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");
echo $db;