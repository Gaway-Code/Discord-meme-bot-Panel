<?php
session_start();
require_once "config.php";
$mysql = new mysqli($host, $user, $pass, $database);

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = 0;
}
if ($_SESSION['login'] == 0) {
    echo "<script> location.href='login/index.php'; </script>";
}
$error = '';
if (isset($_POST['dodaj'])) {
    $uploaddir = 'memiki/';
    $uploadfile = $uploaddir . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        $error = '<div class="alert alert-success" role="alert">
  Plik został wysłany!
</div>';
        $filename = $_FILES['file']['name'];
        $url = $domena . "/memiki/" . $filename;
        $user = $_SESSION['email'];
        $result = $mysql->query("INSERT INTO memes (url,name, user) VALUES ('$url','$filename','$user')");

    } else {
        $error = '<div class="alert alert-secondary" role="alert">
  Wysyłanie nie powiodło się!
</div>';
    }
}
?>
<!doctype html>
<html lang="pl" class="h-100">
<head>
<?php include 'meta.php'?>
    <title>meme upload</title>

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


    <link href="CSS/home.css" rel="stylesheet">
</head>
<body class="h-100  text-white ">

<div class=" d-flex w-100 h-100 p-3 mx-auto flex-column custom-center ">
    <div class="cover-container d-flex w-100 h-10 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div class="mx-auto">
                <img class="text-left" src="/Assets/memelogo.png" alt="">
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link active" aria-current="page" href="#">Dodawanie</a>
                    <a class="nav-link" href="przeglądanie/index.php">Przeglądanie</a>
                    <?php
                    if ($_SESSION['admin'] == 1) {
                        echo '<a class="nav-link" href="AdminPanel/">Użytkownicy</a>';
                    }
                    ?>
                    <a class="nav-link" href="logout.php">Wyloguj</a>
                </nav>
            </div>
        </header>
    </div>


    <main class="px-3">
        <section>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo $error; ?>
                                <div class="zdj"><H3 class="lead">Dodaj Mema</H3></div>
                                <div class="preview-zone hidden">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <div><b>Podgląd</b></div>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-danger btn-xs remove-preview">
                                                    <i class="fa fa-times"></i> Reset
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body"></div>
                                    </div>
                                </div>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>Kliknij bądz wrzuć obrazek.</p>
                                    </div>
                                    <input type="file" name="file" id="file" name="img_logo" class="dropzone">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" name="dodaj" id="dodaj" class="btn btn-danger pull-right">Dodaj
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <footer class="mt-auto text-white-50">
    </footer>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src="scrypt.js"></script>
</body>
</html>
