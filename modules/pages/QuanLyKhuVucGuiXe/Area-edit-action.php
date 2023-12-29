<?php include "../../../connection.php"; ?>

<?php
    session_start(); 

    $error = "";
    $isValid = true;
    try {
        if (isset($_POST['txtAreaName_Edit']) && isset($_POST['selectVehicleType_Edit']) && isset($_POST['txtMaxSize_Edit'])) {
            $areaName = $_POST['txtAreaName_Edit'];

            // Check exist
            $result = mysqli_query($conn, "SELECT * FROM area WHERE areaName = '$areaName'");
            if (mysqli_num_rows($result) <= 0) {
                $error .= "Khu $areaName không tồn tại. ";
                $isValid = false;
            }
            else {
                $row = mysqli_fetch_assoc($result);
                if ($row['currentSize'] > 0) {
                    $error .= "Khu $areaName đang có xe";
                    $isValid = false;
                }
                else {
                    $maxSizeOld = $row['maxSize'];
                    $vehicleType = $_POST['selectVehicleType_Edit'];
                    $maxSize = $_POST['txtMaxSize_Edit'];
                    if ($isValid == true) {
// UPDATE area:vehicleType, maxSize
                        $sqlQuery = "UPDATE area SET vehicleType = '$vehicleType', maxSize = $maxSize WHERE areaName = '$areaName'";
                        mysqli_query($conn, $sqlQuery);
                        if ($maxSizeOld != $maxSize) {
// DELETE parkitem
                            $sqlQuery = "DELETE FROM parkitem WHERE areaName = '$areaName'";
                            mysqli_query($conn, $sqlQuery);
        
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
// INSERT parkitem   
                            for ($i = 1; $i <= $maxSize; $i++) {
                                $sqlQuery = "INSERT INTO parkItem VALUES ($parkItemID, $i, '$areaName', NULL, 0, 1)";
                                mysqli_query($conn, $sqlQuery);
                                $parkItemID++;
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
        $_SESSION['success'] = "Sửa thông tin khu thành công!";
    }
    else {
        if ($error != "") {
            $_SESSION['error'] = $error;
        }
    }
    
    mysqli_close($conn);
    
    if (isset($_GET['page'])) {
        $current_page = $_GET['page'];
        $url = "Area.php?page=$current_page";
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $url .= ("&search=". $_GET['search']);
        }
        header("Location: $url");
    }
    else {
        header("Location: Area.php");
    }
?>

<?php if (isset($_GET['search'])) { $search = $_GET['search']; echo("&search=". $_GET['search']);} ?>
