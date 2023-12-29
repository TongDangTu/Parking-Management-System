<?php
    session_start();
    $_SESSION['login'] = false;
    $_SESSION['user'] = "";
    $_SESSION['pass'] = "";
    $_SESSION['position'] = "";
    $_SESSION['error_login'] = "";
    // session_destroy();
    header("Location:/DoAnWeb/index-guess.php");
?>