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
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>ADEPRO - Quản lý khu vực</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body>
<style>
    <?php include "../../../guessIndex.css";
    include "../../../bootstrap.css";
    include "../../../connection.php";

    ?>
    th,
    td {
    text-align: center !important;
    }

    .card {
        padding: 40px;
    }

    .form-group {
    display: grid;
    grid-template-columns: 40% 50%;
    row-gap: 3px;
    margin-top: 16px;
    }

    label {
    margin-top: auto;
    margin-bottom: auto;
    }

    .page-link {
    padding: 10px !important;
    margin: 3px !important;
    }

    .errorMessenge {
    display: block;
    color: red;
    grid-column-start: 2;
    text-align: left;
    margin-bottom: 0;
    font-size: 0.7rem;
    }

    /* .form-group label{
                width:200px;
            } */
</style>
<?php include "../../header-navbar/header-admin.html" ?>
<div id="error_box" class="alert alert-danger alert-dismissible fade show" style="display: none; position: sticky; top: 8vh;width: 100%; z-index:10; text-align: center;">
    <strong>Thất bại!</strong><span id="error_content"></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<div id="success_box" class="alert alert-success alert-dismissible fade show" style="display: none; position: sticky; top: 8vh;width: 100%; z-index:10; text-align: center;">
    <strong>Thành công! </strong><span id="success_content"></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<main style="margin-top: 10vh">
    <section class="content" style=" margin:auto; width:30%; min-width: 400px;">
        <!-- Default box -->
        <div class="card">
            <form>
                <div class="form-group">
                    <label for="password_old">Mật khẩu hiện tại</label>
                    <input type="password" class="form-control" id="password_old" placeholder="Nhập mật khẩu hiện tại">
                    <p id="errorPasswordOld" class="errorMessenge">.</p>
                </div>
                <div class="form-group">
                    <label for="password_new">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="password_new" placeholder="Nhập mật khẩu mới">
                    <p id="errorPasswordNew" class="errorMessenge">.</p>
                </div>
                <div class="form-group">
                    <label for="password_new">Nhập lại mật khẩu mới</label>
                    <input type="password" class="form-control" id="password_new_confirm" placeholder="Nhập lại mật khẩu mới">
                    <p id="errorPasswordNewConfirm" class="errorMessenge">.</p>
                </div>
                <button type="button" class="btn btn-primary" id="submitChangePassword">Lưu thay đổi</button>
            </form>
        </div>
    </section>
</main>
<?php include "../../footer.html" ?>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
</body>

</html>
      <?php
  }
}
?>

<script>
    $(document).ready(function () {
        $("#submitChangePassword").click(function(e){
            e.preventDefault();
            var passwordOld = $("#password_old").val();
            var passwordNew = $("#password_new").val();
            var passwordNewConfirm = $("#password_new_confirm").val();
            $.ajax({
                url: "change_password_action.php",
                type: "post",
                dataType: "html",
                data : {
                    passwordOld, passwordNew, passwordNewConfirm
                }
            }).done(function(result){
                const row = JSON.parse(result);
                var success = row.success;
                var error = row.error;
                
                if (success != "") {
                    turnOnNoftification(true, success);
                }
                if (error != "") {
                    turnOnNoftification(false, error);
                }
            });
        });

        // Báo lỗi regex form 
        errorRegexForm();
        // Listen Event: oninput
        function errorRegexForm () {
            password_old.oninput = function() {
                checkRegexForm("password_old");
                this.setCustomValidity('');
            };
            password_new.oninput = function() {
                checkRegexForm("password_new");
                this.setCustomValidity('');
            };
            password_new_confirm.oninput = function() {
                checkRegexForm("password_new_confirm");
                this.setCustomValidity('');
            };
        }
        
        // Check regex form , and display error
        function checkRegexForm (id) {
            var isValid = true;
            var content = $("#password_old").val();
            var pattern = "^[a-zA-Z0-9]{8,}$";
            var text = content;
            if (text.match(pattern)) {
                $("#errorPasswordOld").html(".");
            }
            else {
                if (id == "password_old") {
                    $("#errorPasswordOld").html("Tối thiểu 8 kí tự gồm chữ và số không có kí tự đặc biệt");
                }
                isValid = false;
            }
            var content = $("#password_new").val();
            var pattern = "^[a-zA-Z0-9]{8,}$";
            var text = content;
            var passwordOld = text;
            if (text.match(pattern)) {  
                $("#errorPasswordNew").html(".");
            }
            else {
                if (id == "password_new") {
                    $("#errorPasswordNew").html("Tối thiểu 8 kí tự gồm chữ và số không có kí tự đặc biệt");
                }
                isValid = false;
            }
            var content = $("#password_new_confirm").val();
            var pattern = "^[a-zA-Z0-9]{8,}$";
            var text = content;
            var passwordNew = text;
            if (text.match(pattern)) {
                $("#errorPasswordNewConfirm").html(".");
            }
            else {
                if (id == "password_new_confirm") {
                    $("#errorPasswordNewConfirm").html("Tối thiểu 8 kí tự gồm chữ và số không có kí tự đặc biệt");
                }
                isValid = false;
            }

            if (passwordOld != "" && passwordNew != "" && passwordOld != passwordNew) {
                $("#errorPasswordNewConfirm").html("Mật khẩu mới được nhập lại chưa giống");
                isValid = false;
            }
            
            abledButton(isValid);
        }
        
        // abled button 
        function abledButton (isValid) {
            if (isValid == false) {
                $("#submitChangePassword").prop("disabled", true);
            }
            else {
                $("#submitChangePassword").prop("disabled", false);
            }
        }

        function turnOnNoftification (SuccessOrError, text) {
            if (SuccessOrError == false) {
                $("#error_content").html(text);
                // $("#error_box").toggle();
                $("#error_box").show();
                setTimeout(function(){
                    // $("#error_box").toggle();
                    $("#error_box").hide();
                }, 3000);
            }
            if (SuccessOrError == true) {
                $("#success_content").html(text);
                // $("#success_box").toggle();
                $("#success_box").show();
                setTimeout(function(){
                    // $("#success_box").toggle();
                    $("#success_box").hide();
                }, 3000);
            }
        }
    });
</script>