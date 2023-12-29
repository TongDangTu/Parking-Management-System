<?php 
  session_start(); 
  // check login và phân quyền
  if (isset($_SESSION['login']) == false) {
    header("Location: /DoAnWeb/login/index.php");
  }
  else {
    if (($_SESSION['login']) == false) {
      header("Location: /DoAnWeb/login/index.php");
    }
    else {
      if (($_SESSION['position']) == "Admin") {
        header("Location: /DoAnWeb/index-admin.php");
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
    <link rel="stylesheet" href="/DoAnWed/modules/feedback/feedback_css.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<script src="../plugins/jquery/jquery.min.js"></script>
<body>
    <style>
                <?php
    include "../../guessIndex.css";
    include "../../bootstrap.css";
    include "../../connection.php";
    ?>
        #feedback {
            position: relative;
            display: flex;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            align-items: center;
            justify-content: center;
        }
        div#feedback {
            padding-bottom: 40px;
        }
        
        .feedback {
            background-color: #353030;
            position: relative;
            display: block;
            height: 450px;
            width: 350px;
            border: 3px solid rgb(226, 147, 0);
            border-radius: 5px;
        }
        
        .name-feedback {
            position: relative;
            text-align: center;
            font-size: 30px;
            background: linear-gradient(to top, #FFAE46, #FFF050);
            text-transform: uppercase;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-top: 30px;
        }
        
        .close-feedback {
            position: absolute;
            right: 0;
            top: 0;
            color: #fff;
            padding: 12px;
            cursor: pointer;
            opacity: 0.9;
        }
        
        .close-feedback:hover {
            opacity: 0.9;
            background-color: rgb(226, 147, 0);
            cursor: pointer;
        }
        
        .input-feedback {
            width: 80%;
            height: 25px;
            outline: none;
            border: 2px solid rgb(226, 147, 0);
            padding: 5px 10px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            font-size: 15px;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .input-feedback-name {
            margin-bottom: 5px;
        }
        
        .input-feedback-title {
            margin-bottom: 5px;
        }
        
        .textarea-feedback {
            width: 80%;
            height: 250px;
            max-height: 250px;
            outline: none;
            border: 2px solid rgb(226, 147, 0);
            padding: 5px 10px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            font-size: 15px;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 5px;
        }
        
        .back-feedback {
            cursor: pointer;
            color: #fff;
            background-color: rgb(226, 147, 0);
            font-size: 20px;
            width: 100px;
            height: 40px;
            outline: none;
            border: 2px solid white;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            position: relative;
            left: 10%;
        }
        
        .send-feedback {
            cursor: pointer;
            color: #fff;
            background-color: rgb(226, 147, 0);
            font-size: 20px;
            width: 100px;
            height: 40px;
            outline: none;
            border: 2px solid white;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
    <?php
    include "../header-navbar/header-employee.html";
  ?>
    <div style="margin-top: 10vh" id="feedback">
        <form action="feedback_be.php" method="post" class="feedback">
            <h1 class="name-feedback">FEEDBACK</h1>
        
            <!-- <div class="name">
                <input class="input-feedback input-feedback-name" type="text" name="txtdesc" placeholder="Full name">
            </div>
            <div class="name">
                <input class="input-feedback input-feedback-title" type="text" name="txttitle" placeholder="Title">
            </div> -->
            <textarea class="textarea-feedback" id="inputOpn" cols="10" rows="5" name="txtopn" placeholder="Enter your opinios here"></textarea>

            <!-- <button class="back-feedback feedback-button ">Back</button> -->
            <button class="send-feedback feedback-button" id="fbSendBtn">Send</button>
            <p id="erMFb"><font color="red"></font></p>
        </form>

    </div>  
    <?php
    include "../footer.html";
  ?>

</body>
<script>
    $(document).ready(function(){
        if($('#inputOpn').val()==""){
            $('#fbSendBtn').attr("disabled",true);
            $('#erMFb').html("Ý kiến đang đê trống");
        }
         $('#inputOpn').on('input',function(){
               text = $('#inputOpn').val();
        //       const regex = new RegExp(/.{1,300}$/);
        //       if(regex.test(text)==false){
        //         $('#erMFb').html("Nhập quá nhiều");
        //         $('#fbSendBtn').attr("disabled",true);
        //       }
        //       else{
        //         $('#erMFb').html(" ");
        //         $('#fbSendBtn').attr("disabled",false);
        //       }
        // định giới hạn kí tự nhập và ko cho nhập linh tinh nhưng thôi do việc kiểm soát là rất khó
        // tk nào nhập vớ vẩn thì nó cx lưu user vào,quản lý vào xem là biết,đuổi luôn:))
              if($('#inputOpn').val() == ""){
                $('#erMFb').html("Ý kiến đang để trống");
                $('#fbSendBtn').attr("disabled",true);
              }
              else{
                $('#erMFb').html(" ");
                $('#fbSendBtn').attr("disabled",false);
              }
           });
    });
</script>
</html>
<?php
      }
    }
  }
?>