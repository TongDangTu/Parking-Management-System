<?php
session_start();
    include "../../../connection.php";
    $_SESSION["error_edit"] = 0;
    $error="";
    try{
    // echo $_SESSION['txtuser_edit_ajax'];
        $var1 = $_SESSION['txtuser_edit_ajax'];
        $user_edit = $_POST['txtuser_edit'];
        $idcard_edit = $_POST['txtidcard_edit'];
        
        $sql_edit_check_user="select * from Account where userName='".$user_edit."' and identityCard='".$idcard_edit."' and display = 1";
        $check_user = $conn->query($sql_edit_check_user);
        $sql_edit_check_cccd="select * from Account where userName!='".$user_edit."' and identityCard='".$idcard_edit."'  and display = 1";
        $check_cccd = $conn->query($sql_edit_check_cccd);

    // $user_edit = $pass_edit  = $name_edit  = $pos_edit  = $idcard_edit  = $date_edit  = $sex_edit  = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // if(!isset($_POST["usertxt"])){
            //     $_POST["usertxt"] = "";
            // }
            // if(!isset($_POST["passtxt"])){
            //     $_POST["passtxt"] = "";
            // }
            // if(!isset($_POST["nametxt"])){
            //     $_POST["nametxt"] = "";
            // }
            // if(!isset($_POST["txtidcard"])){
            //     $_POST["txtidcard"] = "";
            // }
            // if(!isset($_POST["txtdate"])){
            //     $_POST["txtdate"] = "";
            // }
            if($check_user->num_rows >0){
                
            }
            else{
            if($check_cccd->num_rows > 0){
                $error .= "<br>"."CCCD không được trùng với người khác"."<br>"; 
                $_SESSION['error_edit']++;
            }
        }

        //     if(empty($_POST["txtname_edit_error"])){
        //         $_SESSION["txtname_edit"] = "ten trong!";
        //         $_SESSION["error_edit"] +=1;
        //     }
        //     else if(!preg_match("/^[ A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ]{1,30}$/",$_POST["txtname_edit"]))
        //     {
        //         $_SESSION["txtname_edit_error"] = "sai định dạng!";
        //         $_SESSION["error_edit"] +=1;
        //     }
        //     if(empty($_POST["txtpass_edit"])){
        //         $_SESSION["txtpass_edit_error"] = "mk trống";
        //         $_SESSION["error_edit"] +=1;
        //     }
        //     else if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/",$_POST["txtpass_edit"]))
        //     {
        //         $_SESSION["txtpass_edit_error"] = "sai định dạng";
        //         $_SESSION["error_edit"] +=1;
        //     }
        //     if(empty($_POST["txtuser_edit"])){
        //         $_SESSION["txtuser_edit_error"] = "tên tk trong!";
        //         $_SESSION["error_edit"] +=1;
        //     }
        //     else if(!preg_match("/^[a-z0-9_-]{3,16}$/",$_POST["txtuser_edit"]))
        //     {
        //         $_SESSION["txtuser_edit_error"] = "sai định dạng!";
        //         $_SESSION["error_edit"] +=1;
        //     }
        //     if(empty($_POST["txtidcard_edit"])){
        //         $_SESSION["txtidcard_edit_error"] = "cccd trong!";
        //         $_SESSION["error_edit"] +=1;
        //     }
        //     else if(!preg_match("/^[0-9]*$/",$_POST["txtidcard_edit"]))
        //     {
        //         $_SESSION["txtidcard_edit_error"] = "sai định dạng!";
        //         $_SESSION["error_edit"] +=1;
        //     }
        }
            if($_SESSION["error_edit"] != 0){
                $_SESSION['error'] = $error;
                header("Location: Account.php");
                echo $error;
                //  echo $_SESSION['txtuser_edit'];
                //  echo $_SESSION['txtpass_edit'];
                //  echo $_SESSION['txtname_edit'];
                //  echo $_SESSION['txtidcard_edit'];
                //  echo $var1;
            }
            else{
                $user_edit = $_POST["txtuser_edit"];
                $name_edit = $_POST["txtname_edit"];
                $pos_edit = $_POST["slpos_edit"];
                $idcard_edit = $_POST["txtidcard_edit"];
                $date_edit = $_POST["txtdate_edit"];
                $sex_edit = $_POST["slsex_edit"];
                switch($pos_edit){
                    case "employee":
                        $pos_edit = "Nhân viên";
                        break;
                    case "admin":
                        $pos_edit = "Admin";
                        break;
                    }
                $sql3 = "update account 
                set 
                userName='$user_edit',
                name='$name_edit',
                position='$pos_edit',
                identityCard='$idcard_edit',
                birth='$date_edit',
                sex=$sex_edit,
                display=1 
                where userName = '$var1'";
            //   echo $sql3;
                //  $_SESSION['success'] = "Sửa thành công";
                
                $conn->query($sql3);
            }
        }
    catch(Exception $ex){
            $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
            $_SESSION['error_edit']++;
    }
    if($_SESSION['error_edit']!=0){
        if($error!=""){
            $_SESSION['error'] = $error;
        }
    }
    else {
        $_SESSION['success'] = "Sửa thành công";
    }
    //   sau khi eddit thì trở về trang chứa dữ liệu vừa edit 
    if (isset($_GET['currentpage'])) {
        $currentpage = $_GET['currentpage'];
        $stt=($currentpage-1)*$_GET['pagesize']+1;
        $url = "Account.php?currentpage=$currentpage&stt=$stt";
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $url .= ("&search=". $_GET['search']);
        }
        header("Location: $url");
    }
    else {
        header("Location: Account.php");
    }
            // header("Location: Account.php");
            //  echo $_GET['currentpage'];
            //   echo $_POST["txtuser_edit"] . "<br>";
            //   echo $_POST["txtpass_edit"] . "<br>";
            //   echo $_POST["txtname_edit"] . "<br>";
            //   echo $_POST["slpos_edit"] . "<br>";
            //   echo $_POST["txtidcard_edit"] . "<br>";
            //   echo $_POST["txtdate_edit"] . "<br>";
            //   echo $_POST["slsex_edit"] . "<br>";
            //   echo $sql3;
            
        
    //    echo($error);   // ĐÃ XONG thông báo ngầm
        mysqli_close($conn);
        
    ?>
