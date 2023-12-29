<?php include "../../../connection.php"; ?>

<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");

    $status = 1;
    $date = date("Y/m/d");
    $time = date("Y-m-d H:i:s");
    $customerName = "";
    $display = 1;
    $error = "";

    $isValid = true;
    try {
        if (empty($_POST['txtCardID_Add']) == false) {
            $cardID = $_POST['txtCardID_Add'];

// Check unique
            $result = mysqli_query($conn, "SELECT * FROM card WHERE cardID = $cardID;");
            if (mysqli_num_rows($result) > 0) {
                $error .= "ID thẻ đã tồn tại. ";
                $isValid = false;
            }
            else {
                $vehicleType = $_POST['selectVehicleType_Add'];
                $type = $_POST['selectType_Add'];
        
                if ($type == "Tháng") {
                    $customerName = $_POST['txtCustomerName_Add'];
                    $customerIdentityCard = $_POST['txtCustomerIdentityCard_Add'];
                    $phoneNumber = $_POST['txtPhoneNumber_Add'];
                    $licensePlate = $_POST['txtLicensePlate_Add'];
                }

// INSERT
                if ($isValid == true) {
                    if ($type == "Thường") {
                        $sqlQuery = "INSERT INTO card VALUES (". $cardID .",  ". $status .", '". $vehicleType ."', '". $type ."', ". $display .");";
                        mysqli_query($conn, $sqlQuery);
                    }
                    if ($type == "Tháng") {
                        $sqlQuery = "INSERT INTO card VALUES (". $cardID .",  ". $status .", '". $vehicleType ."', '". $type ."', ". $display .");";
                        mysqli_query($conn, $sqlQuery);
                        $sqlQuery = "INSERT INTO monthcard VALUES (". $cardID .",  '". $date ."', '". $customerName ."', '". $customerIdentityCard ."', '". $phoneNumber ."', '". $licensePlate ."', ". $display .");";
                        mysqli_query($conn, $sqlQuery);

                        $sqlQuery = "SELECT MAX(paymentID) AS maxPaymentID FROM payment WHERE display = 1";
                        $result = mysqli_query($conn, $sqlQuery);

                        $paymentID = "";
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $paymentID = $row['maxPaymentID'] + 1;
                        }
                        else {
                            $paymentID = 1000;
                        }
                        
                        $money = 0;
                        $sqlQuery = "SELECT * FROM pricelist WHERE display = 1 ORDER BY priceListID DESC";
                        $result = mysqli_query($conn, $sqlQuery);
                        if (mysqli_num_rows($result) > 0) {
                            $row = $result->fetch_assoc();
                            if ($vehicleType == "Xe máy") {
                                $money = $row["motorMonth"];
                            }
                            if ($vehicleType == "Ô tô") {
                                $money = $row["carMonth"];
                            }
    
                            $sqlQuery = "INSERT INTO payment VALUES ($paymentID, $money, '". $time ."', $cardID, NULL, ". $row['priceListID'] .", 1)";
                            mysqli_query($conn, $sqlQuery);
                        }
                    }
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
        $_SESSION['success'] = "Thêm thẻ mới thành công!";
    }
    else {
        if ($error != "") {
            $_SESSION['error'] = $error;
        }
    }
    mysqli_close($conn);
    header("Location: Card.php?page=999999999");
?>
