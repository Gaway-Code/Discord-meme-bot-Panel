<?php
session_start();
require_once "../config.php";
$mysql = new mysqli($host, $user, $pass, $database);

$error = '';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = SHA1(MD5(htmlspecialchars(trim($_POST['pass']))));
    $pass2 = SHA1(MD5(htmlspecialchars(trim($_POST['pass2']))));

    //sprawdzanie poprawnosci Email
    $sprawdz = '/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,4}$/';
    if (!preg_match($sprawdz, $email)) {
        $error = '<div class="alert alert-secondary" role="alert">
  Nie prawidlowy email!
</div>';
    } else if ($_POST['email'] == '' || $_POST['pass'] == '' || $_POST['pass2'] == '') {
        $error = '<div class="alert alert-secondary" role="alert">
  Nie wypelniłeś wszystkich pól!
</div>';
    } else if ($pass != $pass2) {
        $error = '<div class="alert alert-secondary" role="alert">
  Podane hasła nie zgadzają się!
</div>';
    } else {
        $sql = "INSERT INTO users (id_user, email, pass, aktywne,admin,token) VALUES (null ,'$email','$pass','0','0',null )";
        $result = $mysql->query($sql);
        if ($result) {
            $error = '<div class="alert alert-success" role="alert">
  Konto zostało założone pomyślnie! <a href="../login/index.php"> Zaloguj się</a>
</div>';
        } else {
            $error = '<div class="alert alert-danger" role="alert">
  bład łączenia z baza danych! ' . $mysql->error . '
</div>';
        }
    }
}
?>

<!doctype html>
<html lang="pl">
<head>
    <?php include '../meta.php'?>
    <title>Meme rejestracja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <link rel="stylesheet" href="../CSS/login.css">
</head>
<body class="text-center text-white bg-dark">

<main class="form-signin">
    <form method="post">
        <img class="mb-4" src="../Assets/memelogo.png" alt="">
        <?php echo $error; ?>
        <div class="form-floating ">
            <input type="email" class="form-control text-white" id="email" name="email" placeholder="name@example.com">
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control text-white" id="pass" name="pass" placeholder="Password">
            <label for="floatingPassword">Hasło</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control text-white" id="pass2" name="pass2" placeholder="Password">
            <label for="floatingPassword">Powtórz hasło</label>
        </div>
        <button class="w-100 btn btn-lg btn-danger" id="submit" name="submit" type="submit">Zarejestruj się</button>
        <p class="mt-5 mb-3 text-muted">&copy; Gaway</p>
    </form>
</main>

</body>
</html>
