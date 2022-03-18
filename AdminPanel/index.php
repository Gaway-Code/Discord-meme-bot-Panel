<?php
session_start();
require_once "../config.php";
$mysql = new mysqli($host, $user, $pass, $database);
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = 0;
}
if ($_SESSION['login'] == 0) {
    echo "<script> location.href='../login/index.php'; </script>";
}
if ($_SESSION['admin'] == 0) {
    echo "<script> location.href='../index.php'; </script>";
}
$error = "";

if (isset($_POST['aktywuj'])) {
    $id_user = $_POST['aktywuj'];
    $sqlUpdate = "UPDATE `users` SET `aktywne` = '1' WHERE `users`.`id_user` = $id_user";
    $result = $mysql->query($sqlUpdate);
}
if (isset($_POST['dezaktywuj'])) {
    $id_user = $_POST['dezaktywuj'];
    $sqlUpdate = "UPDATE `users` SET `aktywne` = '0' WHERE `users`.`id_user` = $id_user";
    $result = $mysql->query($sqlUpdate);
}
if (isset($_POST['daj-admin'])) {
    $id_user = $_POST['daj-admin'];
    $sqlUpdate = "UPDATE `users` SET `admin` = '1' WHERE `users`.`id_user` = $id_user";
    $result = $mysql->query($sqlUpdate);
}
if (isset($_POST['zabierz-admin'])) {
    $id_user = $_POST['zabierz-admin'];
    $sqlUpdate = "UPDATE `users` SET `admin` = '0' WHERE `users`.`id_user` = $id_user";
    $result = $mysql->query($sqlUpdate);
}
if (isset($_POST['usun'])) {
    $id_user = $_POST['usun'];
    $sqlUpdate = "DELETE FROM `users` WHERE `users`.`id_user` = $id_user";
    $result = $mysql->query($sqlUpdate);
}

?>
<!doctype html>
<html lang="pl" class="h-100">
<head>
    <?php include '../meta.php'?>
    <title>Meme admin panel</title>

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

    <link href="../CSS/home.css" rel="stylesheet">
</head>
<body class="h-100  text-white ">

<div class=" d-flex w-100 h-100 p-3 mx-auto flex-column custom-center ">
    <div class="cover-container d-flex w-100 h-10 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div class="mx-auto">
                <img class="text-left" src="/Assets/memelogo.png" alt="">
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link" href="../index.php">Dodawanie</a>
                    <a class="nav-link" href="../przeglądanie/">Przeglądanie</a>
                    <?php
                    if ($_SESSION['admin'] == 1) {
                        echo '<a class="nav-link active" aria-current="page" href="#">Użytkownicy</a>';
                    }
                    ?>
                    <a class="nav-link" href="../logout.php">Wyloguj</a>
                </nav>
            </div>
        </header>
    </div>

    <main class="px-3">
        <form method="post">
            <div class="gallery">
                <div class="container-p ">
                    <div class="row mb-3">
                        <?php
                        echo $error;
                        $sql = "SELECT * FROM `users`";
                        $result = $mysql->query($sql);
                        if ($result) {
                            while ($row = mysqli_fetch_array($result)) {
                                $email = $row['email'];
                                $id = $row['id_user'];
                                $czyAktywne = $row['aktywne'];
                                $czyAdmin = $row['admin'];
                                echo "<div class=\"col-sm text-center pb-3\">
                            <div class=\"jumbotron jumbotron-fluid bg-secondary text-white rounded  py-3 \"  >
                                <h4 class=\"mx-2 res-text\" >$email</h4>
                                <p class=\"res-text\">Zarządzaj użytkownikiem</p>";
                                if ($czyAktywne == 0) {
                                    echo " <button type=\"submit\" class=\"btn btn-success mx-3 my-1 res-text\" value=\"$id\" name='aktywuj'>Aktywuj</button>";
                                } else {
                                    echo " <button type=\"submit\" class=\"btn btn-danger mx-3 my-1 res-text\" value=\"$id\" name='dezaktywuj'>Dezaktywuj</button>";
                                }
                                if ($czyAdmin == 0) {
                                    echo "<button type=\"submit\" class=\"btn btn-success mx-3 my-1 res-text\" value=\"$id\" name='daj-admin'>Daj admina</button>";
                                } else {
                                    echo "<button type=\"submit\" class=\"btn btn-danger mx-3 my-1 res-text\" value=\"$id\" name='zabierz-admin'>Zabierz admina</button>";
                                }
                                echo "<button type=\"submit\" class=\"btn btn-danger mx-3 my-1 res-text\" value=\"$id\" name='usun'>usuń</button>";
                                echo " </div>
                        </div>";
                            }
                        }
                        ?>
                    </div>
                </div>
        </form>
    </main>


    <footer class="mt-auto text-white-50">
    </footer>


</div>

</body>
</html>