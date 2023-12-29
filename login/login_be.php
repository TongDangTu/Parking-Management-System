<?php
    session_start();
    include "../connection.php";
    $sql = "select * from account where display = 1";
    $data=$conn->query($sql);
    foreach($data as $d){
        if($d['userName'] == $_POST['txtuser'] && $d['password'] == $_POST['txtpass']){
            $_SESSION['login'] = true;
            $_SESSION['user'] = $_POST['txtuser'];
            $_SESSION['pass'] = $_POST['txtpass'];
            $_SESSION['position'] = $d['position'];
            $_SESSION['error_login'] = "";
            if($d['position'] == "Nhân viên"){
                header("Location:../index-employee.php");
            }
            if($d['position'] == "Admin"){
                header("Location:../index-admin.php");
            }
            break;  
        }
        else
        {
            $_SESSION['login'] = false;
            $_SESSION['error_login'] = "User or password is wrong!";
            header("Location:index.php");        
        }
    }
    // echo($_SESSION['position']);
?>