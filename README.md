
# Discord-Meme-Bot-Panel

Discord-meme-bot-www jest stroną rozszerzająca możliwości mojego projektu bota [Discord-meme-bot](https://github.com/Gaway-Code/meme-discord-bot). Strona umożliwia wysyłanie obrazków na serwer i generowana JSONa z linkiem do obrazka. Użytkownik ma możliwość dodania obrazka i przeglądu obrazków. Administrator musi aktywować konto użytkownika aby on mogł z korzystać z panelu.

# Wymagania
- PHP 7.2
- MYSQL
- Uprawnienia dla www-data do folderu memiki (chown www-data:www-data -R memiki)
- Stworzona struktura bazy (import pliku strukura_bazy.sql)

# Konfiguracja
config.php
```
$host = ""; #adres do bazy
$user = ""; #użytkowik bazy danych
$pass = ""; #hasło
$database = ""; #nazwa bazy danych

$domena = "http://meme.gaway.pl"; #tutaj wpisz url twojej strony
$kontakt = "Gaway#4391"; #kontakt do administratora
```
php.ini
```
post_max_size = 10M #Domyślnie jest 2mb. Przy dużych obrazkach może się okazać za mało
```
## Demo
- Panel logowania
  ![](https://i.ibb.co/xJBNk1d/logowanie.png)
- Dodawanie memów
  ![](https://i.ibb.co/JqF3YGC/dodawanie.png)
- Przeglądanie memów
  ![](https://i.ibb.co/gwDcTnx/przegladanie.png)
- Zarządzanie użytkownikami
  ![](https://i.ibb.co/9pdRc1C/obraz-2022-03-18-013718.png)
## License

[MIT](https://choosealicense.com/licenses/mit/)


## Authors

- [@Gaway-code](https://github.com/Gaway-Code)
- [@Harddoc](https://github.com/Harddoc)

