<?php
    session_start();
    if ($_SESSION['position'] == "Nhân viên") {
        header("Location: ../../index-employee.php");
    }
    else {
        if ($_SESSION['position'] == "Admin") {
            header("Location: ../../index-admin.php");
        }
        else {
            header("Location: ../../index-guess.php");
        }
    }
?>