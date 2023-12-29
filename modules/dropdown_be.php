<?php
    session_start();
    include "../connection.php";
    $_SESSION['error_dd'] = 0;
    $error="";
    try{
    $start = $_POST['txtDateStart'];
    $end = $_POST['txtDateEnd'];
    $cardtype=$_POST['selectType_Add'];
    $_SESSION['txtDateStart'] = $start;
    $_SESSION['txtDateEnd'] = $end;
    echo  $_SESSION['txtDateStart'];
    $sql_search_moto_in="SELECT card.type,vehicleinout.vehicleType FROM webbaiguixe.card inner join webbaiguixe.vehicleinout on card.cardID = vehicleinout.cardID where card.type='$cardtype' and time between '$start' and '$end' and vehicleinout.vehicleType='xe máy' and vehicleinout.type=1;";
    $sql_search_moto_out="SELECT card.type,vehicleinout.vehicleType FROM webbaiguixe.card inner join webbaiguixe.vehicleinout on card.cardID = vehicleinout.cardID where card.type='$cardtype' and time between '$start' and '$end' and vehicleinout.vehicleType='xe máy' and vehicleinout.type=0;";
    $sql_search_car_in="SELECT card.type,vehicleinout.vehicleType FROM webbaiguixe.card inner join webbaiguixe.vehicleinout on card.cardID = vehicleinout.cardID where card.type='$cardtype' and time between '$start' and '$end' and vehicleinout.vehicleType='ô tô' and vehicleinout.type=1;";
    $sql_search_car_out="SELECT card.type,vehicleinout.vehicleType FROM webbaiguixe.card inner join webbaiguixe.vehicleinout on card.cardID = vehicleinout.cardID where card.type='$cardtype' and time between '$start' and '$end' and vehicleinout.vehicleType='ô tô' and vehicleinout.type=0;";
    $rs1=$conn->query($sql_search_moto_in);
    $rs2=$conn->query($sql_search_moto_out);
    $rs3=$conn->query($sql_search_car_in);
    $rs4=$conn->query($sql_search_car_out);
    $_SESSION['m1'] = $rs1->num_rows;
    $_SESSION['m0'] = $rs2->num_rows;
    $_SESSION['c1'] = $rs3->num_rows;
    $_SESSION['c0'] = $rs4->num_rows;
    echo "<br>".is_numeric($_SESSION['m1']);
    echo "<br>".$_SESSION['m1'] . "<br>".$_SESSION['m0'] . "<br>".$_SESSION['c1'] . "<br>".$_SESSION['c0'] . "<br>";
    }
    catch(Exception $ex){
        $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
        $_SESSION['error_dd']++;
    }
    if($_SESSION['error_dd']!=0){
        if($error!=""){
            $_SESSION['error_dd_txt'] = $error;
        }
    }
    else {
        $_SESSION['success_dd_txt'] = "Tìm thành công";
    }
    header("Location:dropdown.php");
?>