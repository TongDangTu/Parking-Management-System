<?php include "../../../connection.php"; ?>

<?php
    date_default_timezone_set("Asia/Bangkok");
    $date = date("Y/m/d");
    $time = date("H:i:s");
    
    $priceListID = "";

    $error = "";
    $output = "";
    $isValid = true;

    try {
      // Lấy ra priceListID tiếp theo
      $sqlQuery = "SELECT MAX(priceListID) AS maxPriceListID FROM pricelist WHERE display = 1";
      $result = mysqli_query($conn, $sqlQuery);
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $maxPriceListID = $row["maxPriceListID"];
        $priceListID = $maxPriceListID + 1;
      } else {
        $priceListID = 1000;
      }


    }
    catch (Exception $ex) {
      $error .= "<br><br>Lỗi hệ thống.<br>- Mã lỗi: ". $ex->getCode() ."<br>- Chi tiết: ". $ex->getMessage() ."<br>- Tại dòng code: ". $ex->getLine();
      $isValid = false;
    }

    mysqli_close($conn);
?>
