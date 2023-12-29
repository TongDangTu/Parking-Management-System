<?php include "../../../connection.php"; ?>

<?php
    session_start();

    $error = "";
    $isValid = true;
    try {
        if (isset($_POST['txtAreaName_Add']) && isset($_POST['selectVehicleType_Add']) && isset($_POST['txtMaxSize_Add'])) {
            $areaName = $_POST['txtAreaName_Add'];

// Check unique
            $result = mysqli_query($conn, "SELECT * FROM area WHERE areaName = '$areaName';");
            if (mysqli_num_rows($result) > 0) {
                $error .= "Khu $areaName đã tồn tại. ";
                $isValid = false;
            }
            else {
                $parkItemID = "";
                $sqlQuery = "SELECT MAX(parkItemID) AS maxParkItemID FROM parkitem";
                $result = mysqli_query($conn, $sqlQuery);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $maxParkItemID = $row["maxParkItemID"];
                    $parkItemID = $maxParkItemID + 1;
                } else {
                    $parkItemID = 1000;
                }

                $vehicleType = $_POST['selectVehicleType_Add'];
                $maxSize = $_POST['txtMaxSize_Add'];

// INSERT
                if ($isValid == true) {
                    $sqlQuery = "INSERT INTO area VALUES ('$areaName', '$vehicleType', $maxSize, 0, 1);";
                    mysqli_query($conn, $sqlQuery);

                    for ($i = 1; $i <= $maxSize; $i++) {
                        $sqlQuery = "INSERT INTO parkItem VALUES ($parkItemID, $i, '$areaName', NULL, 0, 1)";
                        mysqli_query($conn, $sqlQuery);
                        $parkItemID++;
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
        $_SESSION['success'] = "Thêm khu mới thành công!";
    }
    else {
        if ($error != "") {
            $_SESSION['error'] = $error;
        }
    }
    mysqli_close($conn);
    header("Location: Area.php");
?>
