<?php
session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = 0;
}
if ($_SESSION['login'] == 1) {
    echo "<script> location.href='../index.php'; </script>";
}
require_once "../config.php";
$mysql = new mysqli($host, $user, $pass, $database);

$error = '';
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = SHA1(MD5(htmlspecialchars(trim($_POST['pass']))));
    if ($_POST['email'] == '' || $_POST['pass'] == '') {
        $error = '<div class="alert alert-secondary" role="alert">
  Nie wypelniles wszystkich pól!
</div>';
    } else {
        $sql = "SELECT * FROM `users` WHERE `email` LIKE '" . $email . "'";
        $result = $mysql->query($sql);
        $row = mysqli_fetch_array($result);
        $id = $row['id_user'];
        $userMail = $row['email'];
        $userPass = $row['pass'];
        $userAktywny = $row ['aktywne'];
        $useradmin = $row ['admin'];

        if ($pass == $userPass) {
            if ($userAktywny == 0) {
                $error = "<div class=\"alert alert-secondary\" role=\"alert\">
  Twoje konto nie zostało aktywowane. Skontaktuj się z administratorem w celu aktywacji konta! $kontakt
</div>";
            } else {
                $_SESSION['login'] = 1;
                $_SESSION['id'] = $id;
                $_SESSION['email'] = $email;
                $_SESSION['aktywny'] = $userAktywny;
                $_SESSION['admin'] = $useradmin;
                echo "<script> location.href='index.php'; </script>";
            }
        } else {
            $error = '<div class="alert alert-secondary" role="alert">
  Błąd! Nieprawidłowe dane logowania!
</div>';
        }
    }
}

?>
<!doctype html>
<html lang="pl">
<head>

    <title>Meme logowanie</title>
    <?php include '../meta.php'?>
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
<body class="text-center text-white bg-dark body-log">

<main class="form-signin">
    <form method="post">
        <img class="mb-4" src="../Assets/memelogo.png" alt="">
        <?php echo $error; ?>
        <div class="form-floating ">
            <input type="email" class="form-control text-white" id="floatingInput" id="email" name="email"
                   placeholder="name@example.com">
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control text-white" id="floatingPassword" id="pass" name="pass"
                   placeholder="Password">
            <label for="floatingPassword">Hasło</label>
        </div>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Zapamiętaj mnie
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-danger" id="submit" name="submit" type="submit">Zaloguj się</button>
        <a href="../rejestracja"> Stwórz konto</a>
        <p class="mt-5 mb-3 text-muted">&copy; Gaway</p>
    </form>
</main>


</body>
</html>
