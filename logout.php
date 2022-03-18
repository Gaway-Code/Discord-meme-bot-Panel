<?php
session_start();
session_unset();
echo "<script> location.href='login/index.php'; </script>";