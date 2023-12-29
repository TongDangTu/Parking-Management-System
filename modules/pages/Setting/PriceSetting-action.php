<?php include "../../../connection.php"; ?>
<?php
    session_start();
    $isValid = true;
    $error = "";
    try {
        if (isset($_POST['numberMotor']) && isset($_POST['numberCar']) && isset($_POST['numberMotorMonth']) && isset($_POST['numberCarMonth'])) {
            $motor = $_POST['numberMotor'];
            $car = $_POST['numberCar'];
            $motorMonth = $_POST['numberMotorMonth'];
            $carMonth = $_POST['numberCarMonth'];

            if (($motor % 1000 != 0) && ($car % 1000 != 0) && ($motorMonth % 1000 != 0) && ($carMonth % 1000 != 0)) {
                $error .= "Giá tiền phải được làm tròn đến hàng nghìn";
                $isValid = false;
            }
            else {
                if ($isValid == true) {
                    $priceListID = "";
                    $sqlQuery = "SELECT MAX(priceListID) AS maxPriceListID FROM pricelist";
                    $result = mysqli_query($conn, $sqlQuery);
                    if (mysqli_num_rows($result)) {
                        $row = mysqli_fetch_assoc($result);
                        $priceListID = $row['maxPriceListID'] + 1;
                    }
                    else {
                        $priceListID = 1000;
                    }
        
                    $sqlQuery = "INSERT INTO pricelist VALUES ($priceListID, $motor, $car, $motorMonth, $carMonth, 1)";
                    mysqli_query($conn, $sqlQuery);
                }
            }
        }
    }
    catch (Exception $ex) {
        $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
        $isValid = false;
    }

    // echo($error);   // ĐÃ XONG thông báo ngầm
    if ($isValid == true) {
        $_SESSION['success'] = "Thay đổi Bảng giá thành công!";
    }
    else {
        if ($error != "") {
            $_SESSION['error'] = $error;
        }
    }

    mysqli_close($conn);
    header("Location: PriceSetting.php");
?>