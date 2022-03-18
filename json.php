<?php
header("Content-Type: application/json; charset=UTF-8");
require_once 'config.php';
$mysql = new mysqli($host, $user, $pass, $database);

$result = $mysql->query("SELECT url FROM memes ORDER BY RAND() LIMIT 1;");
if ($result) {
    $row = mysqli_fetch_array($result);
    $url = $row['url'];
}
echo "{\"url\" :\"$url\"}";
