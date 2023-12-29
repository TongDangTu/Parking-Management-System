<?php include "../../../connection.php"; ?>

<?php
    session_start();
    
    $error = "";
    $output = "";
    $output_arr = array();
    $output_arr['success'] = "";
    $output_arr['error'] = "";
    $isValid = true;

    try {
        if (isset($_POST['passwordOld']) && isset($_POST['passwordNew']) && isset($_POST['passwordNewConfirm'])) {
            $passwordOld = $_POST['passwordOld'];
            $passwordNew = $_POST['passwordNew'];
            $passwordNewConfirm = $_POST['passwordNewConfirm'];

            $sqlQuery = "SELECT * FROM account WHERE userName = '". $_SESSION['user'] ."' AND password = '$passwordOld' AND display = 1";
            $result = mysqli_query($conn, $sqlQuery);
            
            if (mysqli_num_rows($result) <= 0) {
                $error .= "<br>Mật khẩu hiện tại không chính xác";
                $isValid = false;
            }
            else {
                if ($isValid == true) {
                    $sqlQuery = "UPDATE account SET password = '$passwordNew' WHERE userName = '". $_SESSION['user'] . "' AND display = 1";
                    mysqli_multi_query($conn, $sqlQuery);
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
        $output_arr['success'] = "Đổi mật khẩu thành công!";
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