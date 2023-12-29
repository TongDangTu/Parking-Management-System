<?php
    include "../../../connection.php";
    session_start();
    $_SESSION["error_add"] = 0;
    $error="";
    // $user_add = $_POST['txtuser_add'];
    // $idcard_add = $_POST['txtidcard_add'];
    // $sql_add_check_user="select * from Account where userName='".$user_add."'";
    // $check_user = $conn->query($sql_add_check_user);
    // $sql_add_check_cccd="select * from Account where identityCard='".$idcard_add."'";
    // $check_cccd = $conn->query($sql_add_check_cccd);
    //  $user_add = $pass_add = $name_add = $pos_add = $idcard_add = $date_add = $sex_add = "";
    try{
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // // if(!isset($_POST["txtuser"])){
        // //     $_POST["txtuser_add"] = "";
        // // }
        // // if(!isset($_POST["txtpass_add"])){
        // //     $_POST["txtpass_add"] = "";
        // // }
        // // if(!isset($_POST["txtname_add"])){
        // //     $_POST["txtname_add"] = "";
        // // }
        // // if(!isset($_POST["txtidcard_add"])){
        // //     $_POST["txtidcard_add"] = "";
        // // }
        // // if(!isset($_POST["txtdate_add"])){
        // //     $_POST["txtdate_add"] = "";
        // // }
        // if(empty($_POST["txtname_add"])){
        //     $_SESSION["txtname_add"] = "tên trống!!";
        //     $_SESSION["error_add"] +=1;
        // }
        // else if(!preg_match("/^[ A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ]{1,30}$/",$_POST["txtname_add"]))
        // {
        //     $_SESSION["txtname_add"] = "sai định dạng!!";
        //     $_SESSION["error_add"] +=1;
        // }
        // if(empty($_POST["txtpass_add"])){
        //     $_SESSION["txtpass_add"] = "mk trống!!";
        //     $_SESSION["error_add"] +=1;
        // }
        // else if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/"
        // ,$_POST["txtpass_add"]))
        // {
        //     $_SESSION["txtpass_add"] = "sai định dạng!!";
        //     $_SESSION["error_add"] +=1;
        // }
        // if(empty($_POST["txtuser_add"])){
        //     $_SESSION["txtuser_add"] = "tên tk trống!!";
        //     $_SESSION["error_add"] +=1;
        // }
        // else if(!preg_match("/^[a-z0-9_-]{3,16}$/",$_POST["txtuser_add"]))
        // {
        //     $_SESSION["txtuser_add"] = "sai định dạng!!";
        //     $_SESSION["error_add"] +=1;
        // }
        // if(empty($_POST["txtidcard_add"])){
        //     $_SESSION["txtidcard_add"] = "cccd trống!!";
        //     $_SESSION["error_add"] +=1;
        // }
        // else if(!preg_match("/^[0-9]*$/",$_POST["txtidcard_add"]))
        // {
        //     $_SESSION["txtidcard_add"] = "sai định dạng!!";
        //     $_SESSION["error_add"] +=1;
        // }
        $sql_add_check = "select * from account";
        $dat = $conn->query($sql_add_check);
        // $sql_add_check_cccd = "select * from account where display=0 identityCard=".$_POST['txtidcard_add'];
        // $dat2 = $conn->query($sql_add_check_cccd);
        foreach($dat as $d){
            if($d['userName'] == $_POST['txtuser_add']){
                $error .= "tên tài khoản đã tồn tại!!"."<br>" ;
                $_SESSION["error_add"] +=1;
            }
            if($d['identityCard'] == $_POST['txtidcard_add'] && $d['display']==1){
                $error .= "cccd ko thể trùng!!" . "<br>";
                $_SESSION["error_add"] +=1;
            }
        }
        // if($dat2->num_rows > 0){
        // }
    }
        if($_SESSION["error_add"] != 0){
            $_SESSION['error'] = $error;
           // echo $error ."<br>" . $_SESSION['error'];
           // header("Location: Account.php");
            
            //  echo "cj";
            // echo $_SESSION['txtuser_add'];
            // echo $_SESSION['txtpass_add'];
            // echo $_SESSION['txtname_add'];
            // echo $_SESSION['txtidcard_add'];
            // echo $_POST["txtuser_add"] . "<br>";
            // echo $_POST["txtpass_add"] . "<br>";
            // echo $_POST["txtname_add"] . "<br>";
            // echo $_POST["slpos_add"] . "<br>";
            // echo $_POST["txtidcard_add"] . "<br>";
            // echo $_POST["txtdate_add"] . "<br>";
            // echo $_POST["slsex_add"] . "<br>";
           //echo preg_match("/^[ A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ]{1,30}$/","chu đức");
            
        }
        else{
            $user_add = $_POST["txtuser_add"];
            $pass_add = $_POST["txtpass_add"];
            $name_add = $_POST["txtname_add"];
            $pos_add = $_POST["slpos_add"];
            $idcard_add = $_POST["txtidcard_add"];
            $date_add = $_POST["txtdate_add"];
            $sex_add = $_POST["slsex_add"];
            switch($pos_add){
                case "employee":
                    $pos_add = "Nhân viên";
                    break;
                case "admin":
                    $pos_add = "Admin";
                    break;
                }
            
            $sql3 = "insert into account(userName,password,name,position,identityCard,birth,sex,display) values ('$user_add','$pass_add','$name_add','$pos_add','$idcard_add','$date_add',$sex_add,1)";
            $conn->query($sql3);
           // header("Location: Account.php");
          //  echo "dh";
            }
        }
        catch(Exception $ex){
            $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
            $_SESSION['error_add']++;
        }
        if($_SESSION['error_add']!=0){
            if($error!=""){
                $_SESSION['error'] = $error;
                header("Location: Account.php");
            }
        }
        else {
            $_SESSION['success'] = "Thêm thành công";
            header("Location: Account.php");
        }
        mysqli_close($conn);
?>