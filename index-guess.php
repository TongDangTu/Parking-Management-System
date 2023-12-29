<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <title>ADEPRO</title>
	 
</head>
<body>
<style>
  * {
        box-sizing: border-box;
      }
      html,body {
  margin:0;
  /* overflow-y:hidden; */
}
    <?php
    include "guessIndex.css";
    include "bootstrap.css"
    ?>
    
</style>
<?php include "./modules/header-navbar/header.html" ?>

	<main>
      <div class="search-bar-wapper">
        <form class="search-bar" action="index-guess.php" method="post">
          <input
            type="text"
            placeholder="Nhập vào biển số hoặc ID thẻ"
            name="search"
          />
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>
      <?php include "connection.php"; ?>
      <?php
    if(!isset($_POST['search'])){
      $_POST['search'] = "";
    }
    else{
      $search = $_POST['search']; 
      $sql_search = "select * from webbaiguixe.vehicleinout inner join  webbaiguixe.parkitem on vehicleinout.cardID=parkitem.cardID where vehicleinout.display=1 and ( vehicleinout.cardID='".$search."' or vehicleinout.licensePlate='".$search."') and type=1 order by vehicleinout.vehicleInOutID desc limit 1";
      $rs=$conn->query($sql_search);
    ?>
      <?php 
      if($rs->num_rows > 0){ 
        while($row = $rs->fetch_assoc()) {
          ?>
          <div class="searchResult">        
            <p >
            <i class="fasearch fa-regular fa-id-badge first"></i>ID thẻ: <?php echo $row['cardID'] ?> 
            </p>
            <!-- <div class="flex">
              <i class="fasearch fa-regular fa-id-badge first"></i> <p> ID thẻ</p> <p> <?php // echo $row['cardID'] ?> </p>
            </div> -->
            <p>
            <i class="fasearch fa-solid fa-car"></i>Biển số: <?php echo $row['licensePlate']?> 
            </p>
            <p>
            <i class="fasearch fa-solid fa-building-user"></i>Khu: <?php echo  $row['areaName']?> 
            </p>
            <p>
            <i class="fasearch fa-solid fa-map-location-dot"></i>Ô đỗ: <?php echo  $row['location']?> 
            </p>
          </div>
          <?php
         if($row['type']==0){
          $_SESSION['rp_error'] = "Không có xe trong bãi";?>
       <p><i class="fa-sharp fa-solid fa-cars"></i><?php echo $_SESSION['rp_error']; ?> </p>
          <?php
        }
        }
    }
    else{
      $_SESSION['rp_error'] = "Xe hiện không có trong bãi hoặc thẻ xe chưa được sử dụng";?>
         <div class="searchResult" style="grid-template-columns:1fr; max-width:50%;">        
              <p><i class="fasearch fa-regular fa-face-smile-beam"></i><?php echo $_SESSION['rp_error']; ?> </p>
         </div>
      <?php
    }
    unset($_SESSION['rp_error']);
  }
      ?>
    </main>
    <?php include "./modules/footer.html" ?>
    <?php include "./popup_quantity_empty.php" ?>
</html>