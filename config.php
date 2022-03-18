<?php
$host = ""; #adres do bazy
$user = ""; #użytkowik bazy danych
$pass = ""; #hasło
$database = ""; #nazwa bazy danych

$domena = "http://meme.gaway.pl"; #tutaj wpisz url twojej strony
$kontakt = "Gaway#4391"; #kontakt do administratora

$db = new mysqli($host, $user, $pass, $database);

if ($db->connect_error) {
    die("error " . $db->connect_error);
}
?>
