<?php session_start();
if (isset($_SESSION['login']) == false) {
    header("Location: /DoAnWeb/login/index.php");
} else {
    if (($_SESSION['login']) == false) {
        header("Location: /DoAnWeb/login/index.php");
    }
    else {
        if ((isset($_GET['areaName']) == false || $_GET['areaName'] == "") && isset($_GET['vehicleType']) == false || $_GET['vehicleType'] == "") {
            header("Location: /DoAnWeb/modules/pages/NhanTraXe/ChonKhu.php");
        }
        else {
?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
            <title>ADEPRO - Nhận/Trả xe</title>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </head>

        <body>
            <style>
                * {
                    box-sizing: border-box;
                }

                html,
                body {
                    margin: 0;
                    /* overflow-y:hidden; */
                }

                <?php include "../../../guessIndex.css";
                include "../../../bootstrap.css";
                include "../../../connection.php";

                ?>
                .col {
                    width: 80%;
                    margin: auto;
                }

                .form-group {
                    display: grid;
                    grid-template-columns: 40% 60%;
                    padding: 5px;
                }

                label {
                    margin-top: auto;
                    margin-bottom: auto;
                }

                .card-footer {
                    display: flex;
                    justify-content: space-between;
                }

                input {
                    padding-left: 10px
                }

                .errorMessenge {
                    display: block;
                    color: red;
                    grid-column-start: 2;
                    text-align: left;
                    margin-bottom: 0;
                    font-size: 0.7rem;
                }

                .readonly{
                    background-color:#bcbcbc !important;
                }

            </style>
            <?php include "../../header-navbar/header.php";
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            ?>
            <!-- <div id="load_data"> </div> -->
            <div id="error_box" class="alert alert-danger alert-dismissible fade show" style="display: none; position: sticky; top: 8vh;width: 100%; z-index:10; text-align: center;">
                <strong>Thất bại!</strong><span id="error_content"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <div id="success_box" class="alert alert-success alert-dismissible fade show" style="display: none; position: sticky; top: 8vh;width: 100%; z-index:10; text-align: center;">
                <strong>Thành công! </strong><span id="success_content"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <main class="row" id="row" style="margin: 20px;display:grid ; grid-template-columns: repeat(2, 1fr) ">
                <div class="col">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-center">Nhận xe</h3>
                        </div>

                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="txtCardID_Receive">ID thẻ:</label>
                                    <input type="text" class="form-control" id="txtCardID_Receive" placeholder="Nhập ID thẻ">
                                    <p class="errorMessenge" id="errorCardID_Receive">.</p>
                                </div>
                                <div class="form-group">
                                    <label for="txtLicensePlate_Receive">Biển số xe</label>
                                    <input type="text" class="form-control" id="txtLicensePlate_Receive" placeholder="Nhập biển số xe">
                                    <p class="errorMessenge" id="errorLicensePlate_Receive">.</p>
                                </div>
                                <div class="form-group">
                                    <label for="txtType_Receive">Loại thẻ</label>
                                    <input readonly type="text" class="form-control readonly" id="txtType_Receive" placeholder="" value="">
                                </div>
                                <div class="form-group">
                                    <label for="txtDate_Receive">Ngày</label>
                                    <input readonly type="text" class="form-control readonly" id="txtDate_Receive" value="" />
                                </div>
                                <div class="form-group">
                                    <label for="txtTime_Receive">Giờ</label>
                                    <input readonly type="text" class="form-control readonly" id="txtTime_Receive" value="">
                                </div>
                                <div class="form-group">
                                    <label for=""> </label>
                                    <input readonly class="form-control" id="" value="" style="visibility: hidden;">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="reset" class="btn btn-secondary" id="btn_reset_Receive">Đặt lại</button>
                                <button type="button" class="btn btn-primary" id="btn_submit_Receive">Nhận</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-center">Trả xe</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="txtCardID_Return">ID thẻ:</label>
                                    <input type="text" class="form-control" id="txtCardID_Return" placeholder="Nhập ID thẻ">
                                    <p class="errorMessenge" id="errorCardID_Return">.</p>

                                </div>
                                <div class="form-group">
                                    <label for="txtLicensePlate_Return">Biển số xe</label>
                                    <input type="text" class="form-control" id="txtLicensePlate_Return" placeholder="Nhập biển số xe">
                                    <p class="errorMessenge" id="errorLicensePlate_Return">.</p>
                                </div>
                                <div class="form-group">
                                    <label for="txtType_Return">Loại thẻ</label>
                                    <input readonly type="text" class="form-control readonly" id="txtType_Return" placeholder="" value="">
                                </div>
                                <div class="form-group">
                                    <label for="txtDate_Return">Ngày</label>
                                    <input readonly type="text" class="form-control readonly" id="txtDate_Return" value="" />
                                </div>
                                <div class="form-group">
                                    <label for="txtTime_Return">Giờ</label>
                                    <input readonly type="text" class="form-control readonly" id="txtTime_Return" value="">
                                </div>
                                <div class="form-group">
                                    <label for="txtMoney_Return" style="color: red;">Thành tiền</label>
                                    <input readonly class="form-control readonly" id="txtMoney_Return" value="" style="color: red;">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="reset" class="btn btn-secondary" id="btn_reset_Return">Đặt lại</button>
                                <button type="button" class='btn btn-warning' data-toggle="modal" data-target="#modalMatThe" id="btn_warning_Return">Mất thẻ xe</button>
                                <button type="submit" class="btn btn-primary" id="btn_submit_Return">Trả</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
            <?php include "../../footer.html" ?>
            <?php include "MatTheXe.php" ?>
            
        </body>
        </html>
        <script src="../../plugins/jquery/jquery.min.js"></script>
        <script>
    $(document).ready(function(){
// Nhận xe
// Gửi dữ liệu đi
        $("#txtCardID_Receive").blur(function(){
            var cardID = $("#txtCardID_Receive").val();
            $.ajax({
                url: "NhanTraXe-action-autoCheckCardType.php",
                type: "post",
                dataType: "html",
                data: {
                    cardID
                }
            }).done(function(result){
                clearFormReceive();
                const row = JSON.parse(result);
                $("#txtType_Receive").val(row.type);
                $("#txtLicensePlate_Receive").val(row.licensePlate);
                $("#btn_submit_Receive").prop("disabled", false);
            });
        });

        // Báo lỗi regex form Receive
        errorRegexFormReceive();
        // Listen Event: oninput
        function errorRegexFormReceive () {
            txtCardID_Receive.oninput = function() {
                checkRegexFormReceive("txtCardID_Receive");
            };
        
            txtLicensePlate_Receive.oninput = function() {
                checkRegexFormReceive("txtLicensePlate_Receive");
            };
        }

        function checkRegexFormReceive (id) {
            var isValid = true;
            var content = $("#txtCardID_Receive").val();
            var pattern = "^[1-9]\\d{3,}$";
            var text = content;
            if (text.match(pattern)) {
                $("#errorCardID_Receive").html(".");
            }
            else {
                if (id == "txtCardID_Receive") {
                $("#errorCardID_Receive").html("ID thẻ không hợp lệ");
                }
                isValid = false;
            }
            var content = $("#txtLicensePlate_Receive").val();
            var pattern = "^[0-9A-Z ]+-?[0-9A-Z ]+$";
            var text = content;
            if (text.match(pattern)) {
                $("#errorLicensePlate_Receive").html(".");
            }
            else {
                if (id == "txtLicensePlate_Receive") {
                $("#errorLicensePlate_Receive").html("Biển số xe không hợp lệ.");
                }
                isValid = false;
            }
            abledButtonReceive(isValid);
        }

        function abledButtonReceive (isValid) {
            if (isValid == false) {
                $("#btn_submit_Receive").prop("disabled", true);
            }
            else {
                $("#btn_submit_Receive").prop("disabled", false);
            }
        }

        //
        $("#btn_reset_Receive").click(function(){
            clearFormReceive();
        })

        // clear Form Receive
        function clearFormReceive () {
            $("#errorCardID_Receive").html(".");
            $("#errorLicensePlate_Receive").html(".");

            abledButtonReceive(true);
        }

    // Gửi dữ liệu vào database Receive
        $("#btn_submit_Receive").click(function(event){
            event.preventDefault();
            var cardID = $("#txtCardID_Receive").val();
            var licensePlate = $("#txtLicensePlate_Receive").val();
            if (cardID == "" || licensePlate == "") {
                if (cardID == "") {
                $("#errorCardID_Receive").html("Không được để trống");
                }
                if (licensePlate == "") {
                    $("#errorLicensePlate_Receive").html("Không được để trống");
                }
            }
            else {
                var type = $("#txtType_Receive").val();
                var areaName = "<?php echo($_GET['areaName']) ?>";
                var vehicleType = "<?php echo($_GET['vehicleType']) ?>";
                $.ajax({
                    url: "NhanXe-action.php",
                    type: "post",
                    dataType: "html",
                    data: {
                        cardID, licensePlate, type, areaName, vehicleType
                    }
                }).done(function(result){
                    decode = JSON.parse(result);
                    var date = decode.date;
                    var time = decode.time;
                    var success = decode.success;
                    var error = decode.error;
                    
                    // Thông báo lỗi logic nghiệp vụ
                    if (success != "") {
                        turnOnNoftification(true, success);
                        $("#txtDate_Receive").val(date);
                        $("#txtTime_Receive").val(time);
                    }
                    if (error != "") {
                        turnOnNoftification(false, error);
                        $("#txtDate_Receive").val("");
                        $("#txtTime_Receive").val("");
                    }
                    
                    // alert("date: "+ date +"\ntime: "+ time +"\nsuccess: "+ success +"\nerror: "+ error);
                });
            }
        });

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

// Trả xe
        // Gửi dữ liệu đi
        $("#txtCardID_Return").blur(function(){
            var cardID = $("#txtCardID_Return").val();
            $.ajax({
                url: "NhanTraXe-action-autoCheckCardType.php",
                type: "post",
                dataType: "html",
                data: {
                    cardID
                }
            }).done(function(result){
                clearFormReturn();
                const row = JSON.parse(result);
                $("#txtType_Return").val(row.type);
                $("#txtLicensePlate_Return").val(row.licensePlate);
                $("#btn_submit_Return").prop("disabled", false);
            });
        });

        // Báo lỗi regex form Return
        errorRegexFormReturn();
        // Listen Event: oninput
        function errorRegexFormReturn () {
            txtCardID_Return.oninput = function() {
                checkRegexFormReturn("txtCardID_Return");
            };
        
            txtLicensePlate_Return.oninput = function() {
                checkRegexFormReturn("txtLicensePlate_Return");
            };
        }

        function checkRegexFormReturn (id) {
            var isValid = true;
            var content = $("#txtCardID_Return").val();
            var pattern = "^[1-9]\\d{3,}$";
            var text = content;
            if (text.match(pattern)) {
                $("#errorCardID_Return").html(".");
            }
            else {
                if (id == "txtCardID_Return") {
                $("#errorCardID_Return").html("ID thẻ không hợp lệ");
                }
                isValid = false;
            }
            var content = $("#txtLicensePlate_Return").val();
            var pattern = "^[0-9A-Z ]+-?[0-9A-Z ]+$";
            var text = content;
            if (text.match(pattern)) {
                $("#errorLicensePlate_Return").html(".");
            }
            else {
                if (id == "txtLicensePlate_Return") {
                $("#errorLicensePlate_Return").html("Biển số xe không hợp lệ.");
                }
                isValid = false;
            }
            abledButtonReturn(isValid);
        }

        function abledButtonReturn (isValid) {
            if (isValid == false) {
                $("#btn_submit_Return").prop("disabled", true);
            }
            else {
                $("#btn_submit_Return").prop("disabled", false);
            }
        }

        //
        $("#btn_reset_Return").click(function(){
            clearFormReturn();
        })
        
        // clear Form Return
        function clearFormReturn () {
            $("#errorCardID_Return").html(".");
            $("#errorLicensePlate_Return").html(".");

            abledButtonReturn(true);
        }

    // Gửi dữ liệu vào database
        $("#btn_submit_Return").click(function(event){
            event.preventDefault();
            var cardID = $("#txtCardID_Return").val();
            var licensePlate = $("#txtLicensePlate_Return").val();
            if (cardID == "" || licensePlate == "") {
                if (cardID == "") {
                $("#errorCardID_Return").html("Không được để trống");
                }
                if (licensePlate == "") {
                    $("#errorLicensePlate_Return").html("Không được để trống");
                }
            }
            else {
                var type = $("#txtType_Return").val();
                var areaName = "<?php echo($_GET['areaName']) ?>";
                var vehicleType = "<?php echo($_GET['vehicleType']) ?>";
                $.ajax({
                    url: "TraXe-action.php",
                    type: "post",
                    dataType: "html",
                    data: {
                        cardID, licensePlate, type, areaName, vehicleType
                    }
                }).done(function(result){
                    decode = JSON.parse(result);
                    var date = decode.date;
                    var time = decode.time;
                    var money = decode.money;
                    var success = decode.success;
                    var error = decode.error;
                    
                    // Thông báo lỗi logic nghiệp vụ
                    if (success != "") {
                        turnOnNoftification(true, success);
                        $("#txtDate_Return").val(date);
                        $("#txtTime_Return").val(time);
                        $("#txtMoney_Return").val(money);
                    }
                    if (error != "") {
                        turnOnNoftification(false, error);
                        $("#txtDate_Return").val("");
                        $("#txtTime_Return").val("");
                        $("#txtMoney_Return").val("");
                    }
                    
                    // alert("date: "+ date +"\ntime: "+ time +"\nmoney: "+ money + "\nsuccess: "+ success +"\nerror: "+ error);
                });
            }
        });

    // Trả xe bắt buộc
        // Gửi dữ liệu vào database
        $("#btn_submit_delete").click(function(event){
            event.preventDefault();
            var licensePlate = $("#txtLicensePlate_Return").val();
            if (licensePlate == "") {
                if (licensePlate == "") {
                    $("#errorLicensePlate_Return").html("Không được để trống");
                }
            }
            else {
                var type = $("#txtType_Return").val();
                var areaName = "<?php echo($_GET['areaName']) ?>";
                var vehicleType = "<?php echo($_GET['vehicleType']) ?>";
                $.ajax({
                    url: "TraXeBatBuoc-action.php",
                    type: "post",
                    dataType: "html",
                    data: {
                        licensePlate, type, areaName, vehicleType
                    }
                }).done(function(result){
                    decode = JSON.parse(result);
                    var date = decode.date;
                    var time = decode.time;
                    var money = decode.money;
                    var success = decode.success;
                    var error = decode.error;
                    
                    // Thông báo lỗi logic nghiệp vụ
                    if (success != "") {
                        turnOnNoftification(true, success);
                        $("#txtDate_Return").val(date);
                        $("#txtTime_Return").val(time);
                        $("#txtMoney_Return").val(money);
                    }
                    if (error != "") {
                        turnOnNoftification(false, error);
                        $("#txtDate_Return").val("");
                        $("#txtTime_Return").val("");
                        $("#txtMoney_Return").val("");
                    }
                    
                    // alert("date: "+ date +"\ntime: "+ time +"\nmoney: "+ money + "\nsuccess: "+ success +"\nerror: "+ error);
                });
            }
        });
    }); 
</script>

    <?php
        }
    }
}
?>

