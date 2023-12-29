<?php include "../../../connection.php"; ?>
<?php
    session_start();
    $isValid = true;
    $error = "";
    try {
        if (isset($_GET['areaName'])) {
            $areaName = $_GET['areaName'];

            $sqlQuery = "SELECT currentSize FROM area WHERE areaName = '$areaName'";
            $result = mysqli_query($conn, $sqlQuery);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if ($row['currentSize'] > 0) {
                    $error .= "Khu $areaName đang có xe";
                    $isValid = false;
                }
            }
            else {
                $error .= "Không có khu $areaName";
                $isValid = false;
            }
            
            if ($isValid == true) {
                $sqlQuery = "DELETE FROM parkitem WHERE areaName = '$areaName'";
                mysqli_query($conn, $sqlQuery);

                $sqlQuery = "DELETE FROM area WHERE areaName = '$areaName'";
                mysqli_query($conn, $sqlQuery);
            }
        }
    }
    catch (Exception $ex) {
        $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
        $isValid = false;
    }

    // echo($error);   // ĐÃ XONG thông báo ngầm
    if ($isValid == true) {
        $_SESSION['success'] = "Xóa khu thành công!";
    }
    else {
        if ($error != "") {
            $_SESSION['error'] = $error;
        }
    }

    mysqli_close($conn);
    header("Location: Area.php");
?>