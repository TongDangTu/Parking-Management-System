<?php include "../../../connection.php"; ?>

<?php
    session_start();
    
    $vehicleType = "";
    $parkItemID = "";
    $cardID = "";
    $licensePlate = "";
    $error = "";
    $output_arr = array();
    $output_arr['parkItemID'] = "";
    $output_arr['cardID'] = "";
    $output_arr['licensePlate'] = "";
    $output_arr['status'] = "";
    $output_arr['success'] = "";
    $output_arr['error'] = "";
    $isValid = true;
    
    try {
        if (isset($_POST['parkItemID']) && isset($_POST['cardID']) && isset($_POST['licensePlate'])) {
            $vehicleType = $_POST['vehicleType'];
            $parkItemID = $_POST['parkItemID'];
            $cardID = $_POST['cardID'];
            $licensePlate = $_POST['licensePlate'];
            $output_arr['parkItemID'] = $parkItemID;

            if (preg_match("/^[1-9]\\d{3,}$/", $cardID) == 0) {
                $isValid = false;
                // error
            }
            else {
                if (preg_match("/^[0-9A-Z ]+-?[0-9A-Z ]+$/", $licensePlate) == 0) {
                    $isValid = false;
                    // error
                }
                else {
                    $sqlQuery = "SELECT * FROM card WHERE cardID = $cardID AND display = 1";
                    $result = mysqli_query($conn, $sqlQuery);
                    if (mysqli_num_rows($result)) {
                        $row = mysqli_fetch_assoc($result);
                        if ($vehicleType != $row['vehicleType']) {
                            $isValid = false;
                        }
                        else {
                            $sqlQuery = "SELECT * FROM vehicleinout WHERE cardID = $cardID AND display = 1 ORDER BY time DESC";
                            $result = mysqli_query($conn, $sqlQuery);
                            // Xe đã từng được Nhận/Trả chưa?
                            if (mysqli_num_rows($result) > 0 ) {
                                // thẻ đã từng ra vào
                                $row = mysqli_fetch_assoc($result);
                                if ($row['type'] == 0) {
                                    // $error .= "<br>Xe có ID thẻ $cardID chưa gửi xe trong bãi";
                                    $isValid = false;
                                }
                                if ($row['type'] == 1) {
                                    // kiểm tra biển số xe lúc ra có trùng khớp với biển số xe lúc vào không ?
                                    if ($row['licensePlate'] != $licensePlate) {
                                        // $error .= "<br>Biển số xe lúc Trả xe không trùng khớp với biển số xe lúc Nhận xe";
                                        $isValid = false;
                                    }
                                    else {
                                        $sqlQuery = "SELECT COUNT(*) AS isExist FROM parkitem WHERE cardID = $cardID AND parkItemID != $parkItemID";
                                        $result = mysqli_query($conn, $sqlQuery);
                                        $row = mysqli_fetch_assoc($result);
                                        if ($row['isExist'] >= 1) {
                                            // $error .= "<br>ID thẻ đã tồn tại trong bảng parkItem";
                                            $isValid = false;
                                        }
                                    }
                                }
                            }
                            else {
                                $isValid = false;
                                // Chưa từng được ra vào
                            }
                        }
                    }

                }
            }

            if ($cardID == "" && $licensePlate == "") {
                $sqlQuery = "UPDATE parkItem SET cardID = NULL, status = 0, display = 1 WHERE parkItemID = $parkItemID";
                mysqli_query($conn, $sqlQuery);
                $output_arr['status'] = "0";
            }
            else {
                if ($isValid == true) {
                    $sqlQuery = "UPDATE parkItem SET cardID = $cardID, status = 1, display = 1 WHERE parkItemID = $parkItemID";
                    mysqli_query($conn, $sqlQuery);
                    $output_arr['status'] = "1";
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
        $output_arr['cardID'] = $cardID;
        $output_arr['licensePlate'] = $licensePlate;
        $output_arr['success'] = "Thay đổi thành công";
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