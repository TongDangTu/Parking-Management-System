<?php include "../../../connection.php"; ?>
<?php
    $output = "";
    $output_arr = array();
    if (isset($_POST['areaName'])) {
        $areaName = $_POST['areaName'];

        $sqlQuery = "SELECT * FROM area WHERE areaName = '$areaName'";
        $result = mysqli_query($conn, $sqlQuery);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output_arr['areaName'] = $row['areaName'];
                $output_arr['vehicleType'] = $row['vehicleType'];
                $output_arr['maxSize'] = $row['maxSize'];
                $output_arr['currentSize'] = $row['currentSize'];

                // $output .= $row['areaName'] ." ". $row['status'] ." ". $row['vehicleType'] ." ". $row['type'] ." ". $row['date'] ." ". $row['customerName'] ." ". $row['customerIdentityCard'] ." ". $row['phoneNumber'] ." ". $row['licensePlate'];
            }
        }
    }

    $encode = json_encode($output_arr, JSON_UNESCAPED_UNICODE);
    // $encode = json_encode($output, JSON_UNESCAPED_UNICODE);
    echo($encode);

    mysqli_close($conn);
?>