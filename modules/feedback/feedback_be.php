<?php
    session_start();
    include "../../connection.php";
    $_SESSION['error_fb'] = 0;
    echo $_SESSION['user'];
    $error = "";
    try{
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $user=$_SESSION['user'];
            $content=$_POST['txtopn'];
            $sqlQuery = "SELECT MAX(feedbackID) AS maxFbID FROM feedback";
            $result = mysqli_query($conn, $sqlQuery);
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $fb = $row['maxFbID']+1;
            } else {
              $fb = 1000;
            }
            
            $sql_fb_send="insert into feedback (feedbackID,userName,content,display) values($fb,'$user','$content',1) ";
            $conn->query($sql_fb_send);
        }
    }
    catch(Exception $ex){
        $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
        $_SESSION['error_fb']++;
    }
    if($_SESSION['error_fb']!=0){
        if($error!=""){
            $_SESSION['error'] = $error;
            header("Location: feedback.php");
      //    echo "dh<br>";
      //    echo $_SESSION['error'];
        }
    }
    else {
        $_SESSION['success'] = "Thêm thành công";
        header("Location: feedback.php");
      //echo "ch";
    }
    mysqli_close($conn);
?>