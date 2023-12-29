<?php
    session_start();
    if (isset($_SESSION['login']) == false) {
      header("Location: /DoAnWeb/login/index.php");
    }
    else {
      if (($_SESSION['login']) == false) {
        header("Location: /DoAnWeb/login/index.php");
      }
      else {
        if (($_SESSION['position']) == "Nhân viên") {
          header("Location: /DoAnWeb/index-employee.php");
        }
        else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<script src="./plugins/jquery/jquery.min.js"></script>
<body style="background-color: beige !important;">
    <style>
        <?php
    include "../../guessIndex.css";
    include "../../bootstrap.css";
    include "../../connection.php";
    ?>
        #dropdown-test {
            position: relative;
            display: block;
            padding: 0;
            margin: 0;
        }
        div#dropdown-test {
            padding-bottom: 40px;
        }
        
        .dropdown-list {
            position: relative;
            display: block;
            width: 60%;
            height: 350px;
            background-color: #D1CFB9;
            color: black;
            border: 3px solid transparent;
            border-radius: 5px;
            right: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        
        .dropdown-list-name {
            position: relative;
            text-align: center;
            font-size: 30px;
            background: black;
            text-transform: uppercase;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-top: 30px;
        }
        
        .dropdown-time {
            display: flex;
            font-size: 20px;
            color: rgb(232, 228, 186);
            justify-content: center;
            align-items: center;
        }
        .dropdown-time-one {
            width: 30%;
            height: 100%;
            margin-right: 88px;

        }
        .dropdown-time-for{
            width: 30%;
            height: 100%;

            margin-left: 88px;
        }
        .dropdown-time-two{
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        .dropdown-time-test{
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        .dropdown-type {
            font-size: 22px;
            margin-right: 10px;
            color: black;
        }
        .dropdown-time-input {
            width: 130px;
            height: 25px;
            border: 2px solid rgb(226, 147, 0);
            border-radius: 2px;
            font-size: 16px;
        }
        .dropdown-select {
            width: 130px;
            height: 26px;
            border: 2px solid rgb(226, 147, 0);
            border-radius: 2px;
            font-size: 16px;
        }
        
        .dropdown-button {
            cursor: pointer;
            color: #fff;
            background-color: rgb(226, 147, 0);
            font-size: 20px;
            width: 80px;
            height: 35px;
            outline: none;
            border: 2px solid white;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            position: relative;
            margin-bottom: 5px;
        }
        
        .dropdown-list-enter-out {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }
        
        .dropdown-list-enter {
            width: 30%;
            height: 100%;
            background-color: #E8E4BA;
            text-align: center;
            padding-bottom: 20px;
            border-radius: 5px;
            border: 2px solid transparent;
            color: rgb(232, 228, 186);
        }
        
        
        .dropdown-input {
            width: 100px;
            height: 25px;
            border: 2px solid rgb(226, 147, 0);
            border-radius: 2px;
            font-size: 18px;
        }
        
        .input-number{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .input-type{
            font-size: 22px;
            margin-right: 10px;
            color: #000;
        }
        .input-type-oto{
            padding-left: 27px;
        }
        .icon_input {
            color: #000;
            font-size: 25px;
            padding: 10px;
        }
    </style>
    <?php
    include "../modules/header-navbar/header-admin.html";
    ?>
    <main style="margin-top: 10vh; height: 50vh;">
    <?php
    if (isset($_SESSION['error_dd_one_txt'])) {
      if ($_SESSION['error_dd_one_txt'] != "") {
?>
        <div id="error_box" class="alert alert-danger alert-dismissible fade show" style="position: sticky;top: 8vh;width: 100%; z-index:1; text-align: center;">
          <strong>Thất bại! </strong><span id="error"><?php echo($_SESSION['error_dd_one_txt']) ?></span>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
<?php
        // $_SESSION['error'] = "";
        unset($_SESSION['error_dd_one_txt']);
      }
    }
    else {
      if (isset($_SESSION['success_dd_one_txt'])) {
        if ($_SESSION['success_dd_one_txt'] != "") {
?>
          <div id="error_box" class="alert alert-success alert-dismissible fade show" style="position: sticky;top: 8vh;width: 100%; z-index:1; text-align: center;">
            <strong>Thành công! </strong><span id="error"><?php echo($_SESSION['success_dd_one_txt']) ?>,Từ ngày <?php if(isset($_SESSION['txtDateStartOne'])){echo $_SESSION['txtDateStartOne'];} 
          ?> đến ngày <?php if(isset($_SESSION['txtDateEndOne'])){echo $_SESSION['txtDateEndOne'];} else {echo "chu";} ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
<?php
          // $_SESSION['success'] = "";
          unset($_SESSION['success_dd_one_txt']);
        }
      }
    }
?>
        <section>
        <div id="dropdown-test">
            <div class="dropdown-list">
                
                <form action="dropdown-one_be.php" method="post">
                <h1 class="dropdown-list-name">Báo cáo doanh thu</h1>
                <div class="dropdown-time">
                    <div class="dropdown-time-one">
                    <div class="dropdown-time-two">
                    <h2 class="dropdown-type">Từ:</h2>
                    <input type="date" id="txtDateStartOne" name="txtDateStartOne" class="dropdown-time-input" required oninvalid="this.setCustomValidity('Không được để trống')" oninput="this.setCustomValidity('')"> 
                    </div>
                    <div class="dropdown-time-two">
                    <h2 class="dropdown-type">Đến:</h2>
                    <input type="date" id="txtDateEndOne" name="txtDateEndOne" class="dropdown-time-input" required oninvalid="this.setCustomValidity('Không được để trống')" oninput="this.setCustomValidity('')">
                    </div>
                    </div>
                    <div class="dropdown-time-for">
                    <div class="dropdown-time-test">
                    <h2 class="dropdown-type">Loại thẻ:</h2>
                    <select class="selectType_dropdown dropdown-select" name="selectType_Add_one">
                        <option value="Thường">Thường</option>
                        <option value="Tháng">Tháng</option>
                    </select>
                    </div>
                    <button class="dropdown-button" id="searchddbtn">Tìm</button>
                    </div>
                    
                </div>
                </form>
                <div class="dropdown-list-enter-out">
                    <div class="dropdown-list-enter">
                        <h2 style="color:black;">Tổng doanh thu</h2>
                        <div class="input-number">
                        <i class="fas fa-solid fa-car-side icon_input"></i>
                            <input type="number" readonly value="<?php if(isset($_SESSION['car_dd_one'])){
                                echo $_SESSION['car_dd_one'];
                            }else{ echo 0;} ?>" class="dropdown-list-enter-car dropdown-input">
                        </div>
                        <div class="input-number">
                        <i class="fa-solid fa-motorcycle icon_input"></i>
                            <input type="number" readonly value="<?php if(isset($_SESSION['motor_dd_one'])){
                                echo $_SESSION['motor_dd_one'];
                            } else{ echo 0;} ?>" class="dropdown-list-enter-moto dropdown-input">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <?php
             unset($_SESSION['car_dd_one']);
             unset($_SESSION['motor_dd_one']);
        ?>
    </main>
        <?php include "../modules/footer.html" ?>
</body>
<script>
<?php
      if (isset($_POST['txtDateStartOne'])) {
?>
        $("#txtDateStartOne").val("<?php echo($_POST['txtDateStartOne']) ?>");
<?php
      }
?>
<?php
      if (isset($_POST['txtDateEndOne'])) {
?>
        $("#txtDateEndOne").val("<?php echo($_POST['txtDateEndOne']) ?>");
<?php
      }
?>
     $("document").ready(function(){
        
    //     var SearchDDArr = $("#searchddbtn");
    //     SearchDDArr.onclick(function(e){
    //         var dates = $(this).data("dates");
    //         var datee = $(this).data("datee");
    //         $.ajax({
    //       url:"dropdown_be.php",
    //       type:"post",
    //       dataType:"html",
    //       data:{
    //         dates,datee
    //       }
    //     }).done(function(rs){
    //       var row = JSON.parse(rs);
    //       var userName = row.userName;
    //       var password = row.password;
    //       var name = row.name;
    //       var position = row.position;
    //       var identityCard = row.identityCard;
    //       var birth = row.birth;
    //       var sex = row.sex;

          
    //       $("#inputUser_Edit").val(userName);
    //       $("#inputPassword_Edit").val(password);
    //       $("#inputName_Edit").val(name);
    //       $("#inputCCCD_Edit").val(identityCard);
    //       $("#inputBday_Edit").val(birth);
    //       // alert(userName +" "+ password +" "+ name +" "+ position +" "+ identityCard +" "+ birth +" "+ sex);
    //       $("#selectChucVu_Edit option[value='"+ position +"']").prop("selected", true);
    //       $("#selectGioiTinh_Edit option[value='"+ sex +"']").prop("selected", true);
    //     });
    //     });
         });
</script>
</html>
<?php
        }
    }
}
?>