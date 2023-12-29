<?php include "../../../connection.php"; ?>
<?php
    session_start(); 
    date_default_timezone_set("Asia/Bangkok");

    $display = 1;
    $error = "";
    $time = date("Y-m-d H:i:s");
    $isValid = true;
    try {
        if (isset($_POST['txtCardID_Edit'])) {
            $cardID = $_POST['txtCardID_Edit'];

// Check exist
            $result = mysqli_query($conn, "SELECT * FROM card WHERE cardID = $cardID AND display = 1");
            if (mysqli_num_rows($result) <= 0) {
                $error .= "ID thẻ không tồn tại. ";
                $isValid = false;
            }
            else {
                $status = $_POST['selectStatus_Edit'];
                $vehicleType = $_POST['selectVehicleType_Edit'];
                $type = $_POST['selectType_Edit'];
                
                if ($type == "Tháng") {
                    $date = $_POST['txtDate_Edit'];
                    $customerName = $_POST['txtCustomerName_Edit'];
                    $customerIdentityCard = $_POST['txtCustomerIdentityCard_Edit'];
                    $phoneNumber = $_POST['txtPhoneNumber_Edit'];
                    $licensePlate = $_POST['txtLicensePlate_Edit'];
                    $isExtend = isset($_POST['checkboxExtend_Edit']) ? $_POST['checkboxExtend_Edit'] : "";
                }

// UPDATE đầy đủ logic
                // Lưu ý khi thay đổi từ thẻ thường sang thẻ tháng, hoặc từ thẻ tháng sang thẻ thường
                // Thì cần phải INSERT INTO/DELETE phần tử thẻ tháng
                $row = mysqli_fetch_assoc($result);
                $typeBeforeEdit = $row['type'];
                $typeAfterEdit = $type;
                if ($isValid == true) {
                    // Từ thẻ thường
                    if ($typeBeforeEdit == "Thường") {
                        // sang thẻ gì cũng phải update card trước
                        $sqlQuery = "UPDATE card SET status = $status, vehicleType = '$vehicleType', type = '$type' WHERE cardID = $cardID;";
                        mysqli_query($conn, $sqlQuery);
                        // sang thẻ thường
                            // vừa xong ngay trên
                        // sang thẻ tháng (INSERT INTO phần tử thẻ tháng)
                        if ($typeAfterEdit == "Tháng") {
                            $sqlQuery = "INSERT INTO monthcard VALUES ($cardID, '$date', '$customerName', '$customerIdentityCard', '$phoneNumber', '$licensePlate', $display);";
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
                    // Từ thẻ tháng
                    if ($typeBeforeEdit == "Tháng") {
                        // sang thẻ gì cũng phải update card trước
                        $sqlQuery = "UPDATE card SET status = $status, vehicleType = '$vehicleType', type = '$type' WHERE cardID = $cardID;";
                        mysqli_query($conn, $sqlQuery);
                        // sang thẻ thường (DELETE phần tử thẻ tháng ĐẾN TẬN GỐC DATABASE)
                        if ($typeAfterEdit == "Thường") {
                            $sqlQuery = "DELETE FROM monthCard WHERE monthCardID = $cardID;";
                            mysqli_query($conn, $sqlQuery);
                        }
                        // sang thẻ tháng
                        if ($typeAfterEdit == "Tháng") {
                            $sqlQuery = "UPDATE monthcard SET date = '$date', customerName = '$customerName', customerIdentityCard = '$customerIdentityCard', phoneNumber = '$phoneNumber', licensePlate = '$licensePlate' WHERE monthCardID = $cardID;";
                            mysqli_query($conn, $sqlQuery);
                            if ($isExtend == "on") {
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
        }
    }
    catch (Exception $ex) {
        $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
        $isValid = false;
    }

    // echo($error);   // ĐÃ XONG thông báo ngầm

    if ($isValid == true) {
        $_SESSION['success'] = "Sửa thông tin thẻ thành công!";
    }
    else {
        if ($error != "") {
            $_SESSION['error'] = $error;
        }
    }
    
    mysqli_close($conn);
    
    if (isset($_GET['page'])) {
        $current_page = $_GET['page'];
        $url = "Card.php?page=$current_page";
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $url .= ("&search=". $_GET['search']);
        }
        header("Location: $url");
    }
    else {
        header("Location: Card.php");
    }
?>

<?php if (isset($_GET['search'])) { $search = $_GET['search']; echo("&search=". $_GET['search']);} ?>
