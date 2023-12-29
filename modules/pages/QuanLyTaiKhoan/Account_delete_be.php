<!-- <script>
    var cancel_btn = document.getElementsByClassName("btn btn-secondary");
    var modal = document.getElementById("myModal");
    cancel_btn.onclick = function(){
        modal.style.display = "none";
    }
</script> -->
<?php
    session_start();
     include "../../../connection.php";
    // đếch hiểu sao include đéo đc
    // $var1 = is_string($_GET["userName"]);
    // echo $var1;
    // echo $_GET["userName"];
    $_SESSION['error_del'] = 0;
    try{
     $var2 = $_GET["userName"];
    // $servername = "localhost";
    // $database = "webbaiguixe";
    // $username = "root";
    // $password = "chuhung2406...";
    // // Create connection
    // $conn = mysqli_connect($servername, $username, $password, $database);
    $sql2 = "update account set display = 0 where userName='$var2'" ;
   // echo $sql2;
    $conn->query($sql2);}
    catch(Exception $ex){
        $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
        $_SESSION['error_del']++;
    }
    if($_SESSION['error_edit']!=0){
        if($error!=""){
            $_SESSION['error'] = $error;
        }
    }
    else {
        $_SESSION['success'] = "Xóa thành công";
    }
    header("Location:Account.php");
?>