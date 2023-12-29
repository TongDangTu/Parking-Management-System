<?php include "../../../connection.php"; ?>
<?php
    session_start();
    $isValid = true;
    $error = "";
    try {
        if (isset($_GET['cardID']) && isset($_GET['type'])) {
            $cardID = $_GET['cardID'];
            $type = isset($_GET['type']);

            if ($type == "Tháng") {
                $sqlQuery = "UPDATE monthcard SET display = 0 WHERE monthCardID = ". $cardID .";";
                mysqli_query($conn, $sqlQuery);
            }

            $sqlQuery = "UPDATE card SET display = 0 WHERE cardID = ". $cardID .";";
            mysqli_query($conn, $sqlQuery);
        }
    }
    catch (Exception $ex) {
        $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
        $isValid = false;
    }

    // echo($error);   // ĐÃ XONG thông báo ngầm
    if ($isValid == true) {
        $_SESSION['success'] = "Xóa thẻ thành công!";
    }
    else {
        if ($error != "") {
            $_SESSION['error'] = $error;
        }
    }

    mysqli_close($conn);
    header("Location: Card.php");
?>