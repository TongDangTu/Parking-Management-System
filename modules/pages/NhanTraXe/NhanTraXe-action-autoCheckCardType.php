<?php include "../../../connection.php"; ?>

<?php
    $output = "";
    $output_arr = array();
    if (isset($_POST['cardID'])) {
        $cardID = $_POST['cardID'];

        $sqlQuery = "SELECT * FROM card LEFT JOIN monthcard ON cardID = monthcardID WHERE card.cardID = $cardID AND (card.display = 1 OR monthcard.display = 1);";
        $result = mysqli_query($conn, $sqlQuery);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
            $output_arr['cardID'] = $row['cardID'];
            $output_arr['type'] = $row['type'];
            $output_arr['licensePlate'] = $row['licensePlate'];
            // $output .= $row['cardID'] ." ". $row['status'] ." ". $row['vehicleType'] ." ". $row['type'] ." ". $row['date'] ." ". $row['customerName'] ." ". $row['customerIdentityCard'] ." ". $row['phoneNumber'] ." ". $row['licensePlate'];
            }
        }
    }

    $encode = json_encode($output_arr, JSON_UNESCAPED_UNICODE);
    echo($encode);

    mysqli_close($conn);
?>