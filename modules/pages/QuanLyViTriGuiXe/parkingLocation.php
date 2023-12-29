<?php session_start();
if (isset($_SESSION['login']) == false) {
    header("Location: /DoAnWeb/login/index.php");
} 
else {
    if (($_SESSION['login']) == false) {
        header("Location: /DoAnWeb/login/index.php");
    }
    else {
      if (isset($_GET['areaName']) == false || $_GET['areaName'] == "" || isset($_GET['vehicleType']) == false || ($_GET['vehicleType'] != "Xe máy" && $_GET['vehicleType'] != "Ô tô")) {
        header("Location: ChonKhu.php");
      }
      else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>ADEPRO - Danh sách vị trí </title>
</head>

<body>
    <style>
<?php
        include "../../../guessIndex.css";
        include "../../../bootstrap.css";
        include "../../../connection.php";
        include "parkingLocation.css";
?>
        h3 {
            text-align: center;
        }

        .page-link {
            padding: 10px !important;
            margin: 3px !important;
        }
    </style>
<?php
    include "../../header-navbar/header.php";
?>
        <h3>Danh sách vị trí khu <?php echo($_GET['areaName']) ?></h3>
        <div class="grid-container">
<?php
            $sqlQuery = "SELECT * FROM parkItem WHERE areaName = '". $_GET['areaName'] ."'";
            $result = mysqli_query($conn, $sqlQuery);

            if (!$result) {
                die("Invalid query: " . $$conn->error);
            }

            // phân trang BY TongDangTu
            $sizePage = 40;
            $number_rows = mysqli_num_rows($result);
            $number_pages = ceil($number_rows / $sizePage);
            if (isset($_GET["page"])) {
                $current_page = $_GET["page"];
                if ($current_page > $number_pages) {
                $current_page = $number_pages;
                }
                if ($current_page < 1) {
                $current_page = 1;
                }
            }
            else {
                $current_page = 1;
            }

            $i = 0;
            $row_start = ($current_page - 1) * $sizePage + 1;
            $row_end = $current_page * $sizePage;

            $total = 45;
            $max = 40;
            while ($row = mysqli_fetch_assoc($result)) {
                $i++;
                if ($i >= $row_start && $i <= $row_end) {
                $parkItemID = $row['parkItemID'];
                $cardID = $row['cardID'];
?>
                <div id="grid-item" class="gridItem<?php echo($row['parkItemID']) ?>" <?php if ($cardID == "") { echo("style='background-color: #28a745;'"); } else { echo("style='background-color: red;'"); } ?>>
                    <div id="locationID-wapper">
                        <span name="locationID"><?php echo($row['location']) ?><span>
                    </div>
                    <div id="locationInput">
                        <input type="text" class="input" id="cardID<?php echo($row['parkItemID']) ?>" data-parkitemid="<?php echo($row['parkItemID']) ?>" placeholder="ID thẻ" value="<?php echo($cardID) ?>">
                        <input type="text" class="input" id="licensePlate<?php echo($row['parkItemID']) ?>" data-parkitemid="<?php echo($row['parkItemID']) ?>" placeholder="Biển số" value="<?php
                            if ($cardID != "") {
                                $thisVehicleInResult = mysqli_query($conn, "SELECT * FROM parkItem INNER JOIN vehicleinout ON parkItem.cardID = vehicleinout.cardID WHERE parkItem.cardID = $cardID ORDER BY time DESC");
                                if (mysqli_num_rows($thisVehicleInResult) > 0) {
                                    $thisVehicleIn = mysqli_fetch_assoc($thisVehicleInResult);
                                    echo($thisVehicleIn['licensePlate']);
                                }
                            }
                        ?>">
                    </div>
                    <i id="fa" class="<?php
                    if (isset($_GET['vehicleType'])) {
                        if ($_GET['vehicleType'] == "Xe máy") {
                            echo ("fa-solid fa-motorcycle");
                        }
                        if ($_GET['vehicleType'] == "Ô tô") {
                            echo ("fa area-icon fa-car");
                        }
                    }
                    ?>"></i>
                </div>
<?php
                
                }
            }
            mysqli_close($conn);
?>
        </div>
<?php           
    }
?>


<?php
    if ($number_pages > 1) {
?>
    <div aria-label="Page navigation">
        <ul class="pagination justify-content-center">
        <li class="page-item ">
            <a class="page-link"
            href="?vehicleType=<?php echo($_GET['vehicleType']) ?>&areaName=<?php echo($_GET['areaName']) ?>&page=1<?php if (isset($_GET['search'])) {
                $search = $_GET['search'];
                echo ("&search=" . $_GET['search']);
            } ?>">
            <<</a>
        </li>
        <li class="page-item ">
            <a class="page-link"
            href="?vehicleType=<?php echo($_GET['vehicleType']) ?>&areaName=<?php echo($_GET['areaName']) ?>&page=<?php echo (($current_page - 1)) ?><?php if (isset($_GET['search'])) {
                $search = $_GET['search'];
                echo ("&search=" . $_GET['search']);
                } ?>">
            <</a>
        </li>
<?php
        if ($current_page > 3) {
?>
            <b style="margin-top: 7px;"> . . . </b>
<?php
        }
        for ($i = 1; $i <= $number_pages; $i++) {
            if (abs($i - $current_page) <= 2) {
            if ($i == $current_page) {
?>
                <li class="page-item"><a class="page-link"
                    href="?vehicleType=<?php echo($_GET['vehicleType']) ?>&areaName=<?php echo($_GET['areaName']) ?>&page=<?php echo ($i) ?><?php if (isset($_GET['search'])) {
                        $search = $_GET['search'];
                        echo ("&search=" . $_GET['search']);
                    } ?>"
                    style="background-color: #ccc;"><?php echo ($i) ?></a></li>
                <?php
            }
            else {
?>
                <li class="page-item"><a class="page-link"
                    href="?vehicleType=<?php echo($_GET['vehicleType']) ?>&areaName=<?php echo($_GET['areaName']) ?>&page=<?php echo ($i) ?><?php if (isset($_GET['search'])) {
                        $search = $_GET['search'];
                        echo ("&search=" . $_GET['search']);
                    } ?>"><?php echo ($i) ?></a></li>
<?php
            }
            }
        }
        if ($number_pages - $current_page > 2) {
?>
            <b style="margin-top: 7px;"> . . . </b>
<?php
        }
?>
        <li class="page-item">
            <a class="page-link"
            href="?vehicleType=<?php echo($_GET['vehicleType']) ?>&areaName=<?php echo($_GET['areaName']) ?>&page=<?php echo (($current_page + 1)) ?><?php if (isset($_GET['search'])) {
                $search = $_GET['search'];
                echo ("&search=" . $_GET['search']);
                } ?>">></a>
        </li>
        <li class="page-item">
            <a class="page-link"
            href="?vehicleType=<?php echo($_GET['vehicleType']) ?>&areaName=<?php echo($_GET['areaName']) ?>&page=<?php echo ($number_pages) ?><?php if (isset($_GET['search'])) {
                $search = $_GET['search'];
                echo ("&search=" . $_GET['search']);
                } ?>">>></a>
        </li>
        </ul>
    </div>
<?php
    }
?>
    <?php include "../../footer.html" ?>
</body>
</html>
<?php
    }
}
?>
<script>
  $(document).ready(function(){
    var input = $(".input");
    for (var i = 0; i < input.length; i++) {
        input[i].onblur = function(){
            var vehicleType = "<?php echo($_GET['vehicleType']) ?>";
            var parkItemID = $(this).data("parkitemid");
            var cardID = $("#cardID"+ parkItemID).val();
            var licensePlate = $("#licensePlate"+ parkItemID).val();
            // alert(vehicleType);
            if ((cardID == "" && licensePlate == "") || (cardID != "" && licensePlate != "")) {
                $.ajax({
                    url: "parkingLocation-action.php",
                    type: "post",
                    dataType: "html",
                    data: {
                        vehicleType, parkItemID, cardID, licensePlate
                        // parkItemID, cardID, licensePlate
                    }
                }).done(function(result){
                    var decode = JSON.parse(result);
                    // alert("parkItemID: "+ decode.parkItemID +"\n"+ "cardID: "+ decode.cardID +"\n"+ "licensePlate: "+ decode.licensePlate +"\n"+ "status: "+ decode.status +"\n"+ "success: "+ decode.success +"\n"+ "error: "+ decode.error);
                    if (decode.status == "0") {
                        $(".gridItem"+decode.parkItemID).css("background-color", "#28a745");
                    }
                    if (decode.status == "1") {
                        $(".gridItem"+decode.parkItemID).css("background-color", "red");
                    }
                    if (decode.status == "") {
                        $(".gridItem"+decode.parkItemID).css("background-color", "yellow");
                    }
                });
            }
        };
    }

  });
</script>