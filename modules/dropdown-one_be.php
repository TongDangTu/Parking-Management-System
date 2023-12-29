<?php
session_start();
    include "../connection.php";
    $_SESSION['error_dd_one'] = 0;
    $error="";
    try{
    $start = $_POST['txtDateStartOne'];
    $end = $_POST['txtDateEndOne'];
    $cardtype=$_POST['selectType_Add_one'];
    $_SESSION['txtDateStartOne'] = $start;
    $_SESSION['txtDateEndOne'] = $end;
   // echo  $_SESSION['txtDateStart'];
    if($cardtype=="Thường"){
        $sql_search_moto_out="SELECT card.type,vehicleinout.vehicleType FROM webbaiguixe.card inner join webbaiguixe.vehicleinout on card.cardID = vehicleinout.cardID where card.type='$cardtype' and time between '$start' and '$end' and vehicleinout.vehicleType='xe máy' and vehicleinout.type=0;";
        $sql_search_car_out="SELECT card.type,vehicleinout.vehicleType FROM webbaiguixe.card inner join webbaiguixe.vehicleinout on card.cardID = vehicleinout.cardID where card.type='$cardtype' and time between '$start' and '$end' and vehicleinout.vehicleType='ô tô' and vehicleinout.type=0;";
    }
    if($cardtype=="Tháng"){
        $sql_search_moto_out="SELECT count(card.cardID),card.cardID FROM webbaiguixe.card inner join webbaiguixe.vehicleinout on card.cardID = vehicleinout.cardID where card.type='Tháng' and time between '$start' and '$end' and vehicleinout.vehicleType='Xe máy' group by card.cardID;";
        $sql_search_car_out="SELECT count(card.cardID),card.cardID FROM webbaiguixe.card inner join webbaiguixe.vehicleinout on card.cardID = vehicleinout.cardID where card.type='Tháng' and time between '$start' and '$end' and vehicleinout.vehicleType='ô tô' group by card.cardID;";
    }
    $sql_pricelist="SELECT * FROM webbaiguixe.pricelist where display=1";
    $rs1=$conn->query($sql_search_moto_out);
    $rs2=$conn->query($sql_search_car_out);
    $rs3=$conn->query($sql_pricelist);
    $motorsearch = $rs1->num_rows;
    $carsearch = $rs2->num_rows;
    while($row = $rs3->fetch_assoc()){
        if($cardtype=="Thường"){
            $motorPrice = $row['motor'];
            $carPrice = $row['car'];
        }
        if($cardtype=="Tháng"){
            $motorPrice= $row['motorMonth'];
            $carPrice = $row['carMonth'];
        }
    }
    $_SESSION['motor_dd_one'] = $motorsearch*$motorPrice;
    $_SESSION['car_dd_one'] = $carsearch*$carPrice;
    // echo "<br>".is_numeric($_SESSION['m1']);
    echo "<br> xe máy:".$_SESSION['motor_dd_one'] . "<br> ô tô:".$_SESSION['car_dd_one'] . "<br>";
    }
    catch(Exception $ex){
        $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
        $_SESSION['error_dd_one']++;
    }
    if($_SESSION['error_dd_one']!=0){
        if($error!=""){
            $_SESSION['error_dd_one_txt'] = $error;
        }
    }
    else {
        $_SESSION['success_dd_one_txt'] = "Tìm thành công";
    }
    header("Location:dropdown-one.php");
?>