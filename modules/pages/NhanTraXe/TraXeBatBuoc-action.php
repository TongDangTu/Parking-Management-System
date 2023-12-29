<?php include "../../../connection.php"; ?>

<?php
    // Đối với các trường hợp đã gửi xe, nhưng lại làm mất thẻ, hoặc thẻ bị khóa,
    //     thì cần làm việc bên ngoài hệ thống với các nhân viên/admin
    //     để được các nhân viên/admin hỗ trợ
    // - Thẻ bị mất: cần có thêm 1 chỗ để BUỘC trả xe mà không cần thẻ (do trong thực tế thì phải cần thẻ từ để quét thẻ)
    // - Thẻ bị khóa: nhân viên/admin hỗ trợ mở khóa
?>


<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    $date = "";
    $time = "";
    $presentSeconds = strtotime(date("Y-m-d H:i:s"));
    $presentDay = date("d", $presentSeconds);
    $presentMonth = date("m", $presentSeconds);
    $presentYear = date("Y", $presentSeconds);
    
    // echo("\nNgày hiện tại: ". $presentDay);
    // echo("\nTháng hiện tại: ". $presentMonth);
    // echo("\nNăm hiện tại: ". $presentYear);

    $currentSize = "";
    $inSeconds = "";
    $outSeconds = $presentSeconds;
    $earlyRegistrationMonth = "";       // Số giây từ 1970 đến đầu tháng ngày đăng ký
    $money = "";
    
    $error = "";
    $output = "";
    $output_arr = array();
    $output_arr['time'] = "";
    $output_arr['date'] = "";
    $output_arr['money'] = "";
    $output_arr['success'] = "";
    $output_arr['error'] = "";
    $isValid = true;
    $isMonthCardOutOfDate = false;
    

    try {
        if (isset($_POST['licensePlate']) && isset($_POST['type']) && isset($_POST['areaName']) && isset($_POST['vehicleType'])) {
            $licensePlate = $_POST['licensePlate'];
            $type = $_POST['type'];
            $areaName = $_POST['areaName'];
            $vehicleType = $_POST['vehicleType'];

            $sqlQuery = "SELECT maxSize, currentSize FROM area WHERE areaName = '$areaName' AND display = 1";
            $result = mysqli_query($conn, $sqlQuery);
            // khu có tồn tại hay không ?
            if (mysqli_num_rows($result) <= 0) {
                $error .= "<br>Khu $areaName không tồn tại";
                $isValid = false;
            }
            else {
                $row = mysqli_fetch_assoc($result);
                $currentSize = $row['currentSize'];
                
                $sqlQuery = "SELECT * FROM vehicleinout WHERE licensePlate = '$licensePlate' ORDER BY time DESC";
                $result = mysqli_query($conn, $sqlQuery);
                if (mysqli_num_rows($result) <= 0) {
                    $error .= "<br>Xe có biển số $licensePlate chưa gửi xe trong bãi";
                    $isValid = false;
                }
                else {
                    $row = mysqli_fetch_assoc($result);
                    $cardID = $row['cardID'];

                    $sqlQuery = "SELECT * FROM card LEFT JOIN monthcard ON cardID = monthcardID WHERE cardID = $cardID AND (card.display = 1 OR monthcard.display = 1)";
                    $result = mysqli_query($conn, $sqlQuery);
                    // thẻ có tồn tại hay không ?
                    if (mysqli_num_rows($result) <= 0) {
                        $error .= "<br>ID thẻ $cardID không tồn tại";
                        $isValid = false;
                    }
                    else {
                        $row = mysqli_fetch_assoc($result);
                        // thẻ có bị khóa hay không?
                        if ($row['status'] == 0) {
                            $error .= "<br>Thẻ xe bị mất có ID thẻ $cardID của Xe có biển số $licensePlate đã bị khóa";
                            $isValid = false;
                        }
                        else {
                            if ($row['vehicleType'] != $vehicleType) {
                                $error .= "<br>Thẻ xe bị mất có ID thẻ $cardID của Xe có biển số $licensePlate là thẻ dành cho xe ". $row['vehicleType'];
                                $isValid = false;
                            }
                            else {
                                if ($type == "Tháng") {
                                    // Biển số của xe có trùng với biển số được đăng ký trong thẻ tháng hay không
                                    if ($licensePlate != $row['licensePlate']) {
                                        $error .= "<br>Biển số xe $licensePlate không trùng với biển số xe ". $row['licensePlate'] ." được đăng ký trong thẻ tháng";
                                        $isValid = false;
                                    }
                                    else {
                                        $registrationSeconds = strtotime($row['date']);
                                        $registrationDay = date("d", $registrationSeconds);
                                        $registrationMonth = date("m", $registrationSeconds);
                                        $registrationYear = date("Y", $registrationSeconds);
                                        // echo("Ngày đăng ký: ". $registrationDay);
                                        // echo("\nTháng đăng ký: ". $registrationMonth);
                                        // echo("\nNăm đăng ký: ". $registrationYear);
    
                                        $earlyRegistrationMonth = strtotime("$registrationYear-$registrationMonth-01 00:00:00");
                                        $effectiveSeconds = strtotime("+1 Month", $earlyRegistrationMonth);
                                        $effectiveDay = date("d", $effectiveSeconds);
                                        $effectiveMonth = date("m", $effectiveSeconds);
                                        $effectiveYear = date("Y", $effectiveSeconds);
                                        // echo("\nNgày được sử dụng: ". $effectiveDay);
                                        // echo("\nTháng được sử dụng: ". $effectiveMonth);
                                        // echo("\nNăm được sử dụng: ". $effectiveYear);
    
                                        if (($effectiveYear = $presentYear) && ($effectiveMonth == $presentMonth)) {
                                            goto checkVehicleIn;
                                        }
                                        else {
                                            if ($effectiveYear < $presentYear
                                            ||(($effectiveYear = $presentYear) && ($effectiveMonth < $presentMonth))) {
                                                // $error .= "<br>Thẻ đã hết hạn";
                                                // $isValid = false;
                                                $isMonthCardOutOfDate = true;
                                                goto checkVehicleIn;
                                            }
                                            else {
                                                if ($effectiveYear > $presentYear
                                                ||(($effectiveYear = $presentYear) && ($effectiveMonth > $presentMonth))) {
                                                    $error .= "<br>Thẻ này có hiệu lực vào tháng $effectiveMonth năm $effectiveYear";
                                                    $isValid = false;
                                                }
                                            }
                                        }
                                    }
                                }
                                else {  // là thẻ Thường
                                    checkVehicleIn:
                                    $sqlQuery = "SELECT * FROM vehicleinout WHERE cardID = $cardID AND display = 1 ORDER BY time DESC";
                                    $result = mysqli_query($conn, $sqlQuery);
                                    // Xe đã từng được Nhận/Trả chưa?
                                    if (mysqli_num_rows($result) > 0 ) {
                                        // thẻ đã từng ra vào
                                        $row = mysqli_fetch_assoc($result);
                                        if ($row['type'] == 0) {
                                            $error .= "<br>Xe có ID thẻ $cardID chưa gửi xe trong bãi";
                                            $isValid = false;
                                        }
                                        if ($row['type'] == 1) {
                                            $inSeconds = strtotime($row['time']);
                                            // kiểm tra biển số xe lúc ra có trùng khớp với biển số xe lúc vào không ?
                                            if ($row['licensePlate'] != $licensePlate) {
                                                $error .= "<br>Biển số xe lúc Trả xe không trùng khớp với biển số xe lúc Nhận xe";
                                                $isValid = false;
                                            }

                                        }
                                    }
                                    if (mysqli_num_rows($result) == 0 ) {
                                        $error .= "<br>Xe có ID thẻ $cardID chưa gửi xe trong bãi";
                                        $isValid = false;
                                    }
                                }
                            }
                        }
                        // }
                    }
                }
                // }
            }
            // INSERT INTO
            if ($isValid == true) {
                $vehicleInOutID = "";
                // lấy ra maxVehicleInOutID
                $sqlQuery = "SELECT MAX(vehicleInOutID) AS maxVehicleInOutID FROM vehicleinout";
                $result = mysqli_query($conn, $sqlQuery);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $maxVehicleInOutID = $row["maxVehicleInOutID"];
                    $vehicleInOutID = $maxVehicleInOutID + 1;
                } else {
                    $vehicleInOutID = 1000;
                }
    
                $sqlQuery = "INSERT INTO vehicleinout VALUES ($vehicleInOutID, 0, '". date("Y-m-d H:i:s") ."', '$licensePlate', '$vehicleType', $cardID, '". $_SESSION['user'] ."', 1)";
                mysqli_query($conn, $sqlQuery);
                $sqlQuery = "UPDATE area SET currentSize = ". ($currentSize - 1) ." WHERE areaName = '". $_POST['areaName'] ."'";
                mysqli_query($conn, $sqlQuery);

                // Tính tiền

                /////// Ô TÔ THÌ TÍNH TIỀN THEO GIỜ, KHÔNG PHẢI THEO NGÀY
                $sqlQuery = "SELECT * FROM pricelist WHERE display = 1 ORDER BY priceListID DESC";
                $result = mysqli_query($conn, $sqlQuery);
                // Có bảng giá thì mới thêm hóa đơn
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $priceListID = $row['priceListID'];
                    // Lấy giá từng loại xe theo ngày
                    $price = "";
                    if ($vehicleType == "Xe máy") {
                        $price = $row['motor'];
                    }
                    else {
                        $price = $row['car'];
                    }

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

                    if ($type == "Tháng") {
                        // Nếu là thẻ tháng chưa hết hạn
                        if ($isMonthCardOutOfDate == false) {
                            $money = 0;
                        }
                        else {  // Nếu là thẻ tháng đã hết hạn
                            $earlyExpiryMonth = strtotime("+2 Month", $earlyRegistrationMonth);
                            $year = date("Y", $earlyExpiryMonth);
                            $month = date("m", $earlyExpiryMonth);
                            $inSeconds = strtotime("$year-$month-01 00:00:00");
                            
                            goto calculatorMoney;
                        }
                    }
                    else {
                        calculatorMoney:
                        $outDate = date("Y-m-d H:i:s", $presentSeconds);
                        $outSeconds = $presentSeconds;
                        $parkingSeconds = $outSeconds - $inSeconds;
                        if ($vehicleType == "Xe máy") {
                            $num_day = ceil($parkingSeconds/60/60/24);
                        }
                        else { 
                            $num_day = ceil($parkingSeconds/60/60);     //num_hours cho ô tô
                        }
                        
                        $money = $price * $num_day;
    
                        $sqlQuery = "INSERT INTO payment VALUES ($paymentID, $money, '". $outDate ."', NULL, $vehicleInOutID, $priceListID, 1)";
                        mysqli_query($conn, $sqlQuery);
                    }
                }
                else {
                    $money = "Chưa có bảng giá. Không tính tiền.";
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
        $output_arr['date'] = date("d-m-Y", $presentSeconds);
        $output_arr['time'] = date("H:i:s", $presentSeconds);
        $output_arr['money'] = $money;
        $output_arr['success'] = "Trả xe bắt buộc thành công!";
    }
    else {
        if ($error != "") {
            $output_arr['error'] = $error;
        }
    }

    $encode = json_encode($output_arr, JSON_UNESCAPED_UNICODE);
    echo($encode);

    mysqli_close($conn);
?>