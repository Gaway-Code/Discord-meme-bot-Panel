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
$idSESSION = $_SESSION['id'];
$isadmin = "SELECT * FROM `users` WHERE `id_user` = $idSESSION";
$resultISADMIN = $mysql->query($isadmin);
if ($resultISADMIN) {
    $row = mysqli_fetch_array($resultISADMIN);
    $czyadmin = $row['admin'];
} else {
    echo $mysql->error;
}
if (isset($_POST['usun'])) {
    $id_meme = $_POST['usun'];
    $selectSQL = "SELECT * FROM `memes` WHERE `id_memes` = $id_meme";
    $deleteSQL = "DELETE FROM `memes` WHERE `memes`.`id_memes` = $id_meme";
    $resultSELECT = $mysql->query($selectSQL);
    if ($resultSELECT) {
        $row = mysqli_fetch_array($resultSELECT);
        $fileName = $row['name'];
        unlink("../memiki/" . $fileName);
    }
    $resultDELETE = $mysql->query($deleteSQL);
    if ($resultDELETE) {
        $error = '<div class="alert alert-success" role="alert">
  Usunąłeś mema!
</div>';
    } else {
        $error = '<div class="alert alert-danger" role="alert">
  bład łączenia z baza danych! ' . $mysql->error . '
</div>';
    }
}
?>
<!doctype html>
<html lang="PL" class="h-100">
<head>
    <?php include '../meta.php'?>
    <title>Meme przeglądanie</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="../CSS/przegladanie.css" rel="stylesheet">

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
<body class=" h-100  text-white ">


<div class=" d-flex w-100 h-100 p-3 mx-auto flex-column custom-center ">
    <div class="cover-container d-flex w-100 h-10 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div class="mx-auto">
                <img class="text-left" src="/Assets/memelogo.png" alt="">
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link" href="../index.php">Dodawanie</a>
                    <a class="nav-link active" aria-current="page" href="#">Przeglądanie</a>
                    <?php
                    if ($_SESSION['admin'] == 1) {
                        echo '<a class="nav-link" href="../AdminPanel/">Użytkownicy</a>';
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
                        $sql = "SELECT * FROM `memes`";
                        $result = $mysql->query($sql);
                        if ($result) {
                            while ($row = mysqli_fetch_array($result)) {
                                $name = $row['name'];
                                $id = $row['id_memes'];
                                echo "<div class=\"col-3 text-center\">
                        <img class=\"demo cursor img-thumbnail my-3\" src=\"../memiki/$name\">";
                                if ($czyadmin == 1) {
                                    echo "<button type=\"submit\" class=\"btn btn-danger\" value=\"$id\" name='usun'>Usuń</button>";
                                }
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <footer class="mt-auto text-white-50">
    </footer>

</div>
</body>
</html>
