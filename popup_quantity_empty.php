


<div style="position: fixed; background-color: lawngreen; font-size: 1.3em; width: 20%; top: 25vh; right: 10px; z-index: 0; box-sizing: border-box; max-height: 50vh; padding: 20px; border-radius: 20px; overflow: auto;">

<?php
    $sqlQuery = "SELECT * FROM area WHERE vehicleType = 'Xe máy'";
    $result = mysqli_query($conn, $sqlQuery);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $areaName = $row['areaName'];
            $row2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM area WHERE areaName = '$areaName'"));
?>
            <p><i class="fa area-icon fa-motorcycle"></i> Khu <?php echo($row['areaName']) ?> còn trống <?php echo($row2['maxSize'] - $row2['currentSize']) ?> chỗ</p>
<?php
        }
    }
?>
<?php
    $sqlQuery = "SELECT * FROM area WHERE vehicleType = 'Ô tô'";
    $result = mysqli_query($conn, $sqlQuery);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $areaName = $row['areaName'];
            $row2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM area WHERE areaName = '$areaName'"));
?>
            <p><i class="fa area-icon fa-car"></i> Khu <?php echo($row['areaName']) ?> còn trống <?php echo($row2['maxSize'] - $row2['currentSize']) ?> chỗ</p>
<?php
        }
    }
?>
</div>