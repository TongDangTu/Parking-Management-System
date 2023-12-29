<?php include "../../../connection.php"; ?>

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
    
    $error = "";
    $output = "";
    $output_arr = array();
    $output_arr['time'] = "";
    $output_arr['date'] = "";
    $output_arr['success'] = "";
    $output_arr['error'] = "";
    $isValid = true;
    

    try {
        if (isset($_POST['cardID']) && isset($_POST['licensePlate']) && isset($_POST['type']) && isset($_POST['areaName']) && isset($_POST['vehicleType'])) {
            $cardID = $_POST['cardID'];
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
                if ($row['maxSize'] <= $row['currentSize']) {
                    // khu có đầy hay không ?
                    $error .= "<br>Khu $areaName đã đầy";
                    $isValid = false;
                }
                else {
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
                            $error .= "<br>Thẻ có ID $cardID đã bị khóa";
                            $isValid = false;
                        }
                        else {
                            if ($row['vehicleType'] != $vehicleType) {
                                $error .= "<br>Thẻ có ID $cardID là thẻ dành cho xe ". $row['vehicleType'];
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
    
                                        $effectiveSeconds = strtotime("+1 Month", $registrationSeconds);
                                        $effectiveDay = date("d", $effectiveSeconds);
                                        $effectiveMonth = date("m", $effectiveSeconds);
                                        $effectiveYear = date("Y", $effectiveSeconds);
                                        // echo("\nNgày được sử dụng: ". $effectiveDay);
                                        // echo("\nTháng được sử dụng: ". $effectiveMonth);
                                        // echo("\nNăm được sử dụng: ". $effectiveYear);
    
                                        if (($effectiveYear == $presentYear) && ($effectiveMonth == $presentMonth)) {
                                            goto checkVehicleIn;
                                        }
                                        else {
                                            if ($effectiveYear < $presentYear
                                            ||(($effectiveYear == $presentYear) && ($effectiveMonth < $presentMonth))) {
                                                $error .= "<br>Thẻ đã hết hạn";
                                                $isValid = false;
                                            }
                                            else {
                                                if ($effectiveYear > $presentYear
                                                ||(($effectiveYear == $presentYear) && ($effectiveMonth > $presentMonth))) {
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
                                        if ($row['type'] == 1) {
                                            $error .= "<br>Xe có ID thẻ $cardID đang gửi trong bãi";
                                            $isValid = false;
                                        }
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
    
                $sqlQuery = "INSERT INTO vehicleinout VALUES ($vehicleInOutID, 1, '". date("Y-m-d H:i:s") ."', '$licensePlate', '$vehicleType', $cardID, '". $_SESSION['user'] ."', 1); "
                          . "UPDATE area SET currentSize = ". ($currentSize + 1) ." WHERE areaName = '". $_POST['areaName'] ."';";
                mysqli_multi_query($conn, $sqlQuery);
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
        $output_arr['success'] = "Nhận xe thành công!";
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