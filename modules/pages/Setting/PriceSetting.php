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
        if (($_SESSION['position']) == "Nhân viên") {
            header("Location: /DoAnWeb/index-employee.php");
        }
        else {
?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <title>ADEPRO - Setting</title>

                <!-- jQuery -->
                <script src="../../plugins/jquery/jquery.min.js"></script>
                <!-- Bootstrap 4 -->
                <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- Google Font: Source Sans Pro -->
                <link rel="stylesheet"
                    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
                <!-- Font Awesome -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

            </head>

            <body>
                <style>
<?php
                    include "../../../guessIndex.css";
                    include "../../../bootstrap.css";
                    include "../../../connection.php";
?>
                    th,
                    td {
                        text-align: center !important;
                    }

                    .form-group {
                        display: grid;
                        grid-template-columns: 40% 50%;
                        gap: 10px;
                    }

                    label {
                        margin-top: auto;
                        margin-bottom: auto;
                    }

                    .page-link {
                        padding: 10px !important;
                    }

                    .errorMessenge {
                        display: block;
                        color: red;
                        grid-column-start: 2;
                        text-align: left;
                        margin-bottom: 0;
                        font-size: 0.7rem;
                    }

                    .card {
                        padding:0 0 10px 0;
                    }
                    
                    .cardType {
                        padding: 10px;
                        margin-left: 20px;
                    }
                    
                    .inputForm {
                        width: 30%;
                        min-width: 200px;
                        margin-left: auto;
                        margin-right: auto;
                    }

                    .submit {
                        padding: 10px !important;
                        margin-right: 10px;
                    }

                    /* .form-group label{
                  width:200px;
                } */
                </style>
                <?php include "../../header-navbar/header-admin.html" ?>
<?php
                    if (isset($_SESSION['error'])) {
                        if ($_SESSION['error'] != "") {
?>
                            <div id="error_box" class="alert alert-danger alert-dismissible fade show" style="position: sticky;top: 8vh;width: 100%; z-index:1; text-align: center;">
                                <strong>Thất bại! </strong><span id="error"><?php echo($_SESSION['error']) ?></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
<?php
                            // $_SESSION['error'] = "";
                            unset($_SESSION['error']);
                        }
                    }
                    else {
                        if (isset($_SESSION['success'])) {
                            if ($_SESSION['success'] != "") {
?>
                            <div id="error_box" class="alert alert-success alert-dismissible fade show" style="position: sticky;top: 8vh;width: 100%; z-index:1; text-align: center;">
                                <strong>Thành công! </strong><span id="error"><?php echo($_SESSION['success']) ?></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
<?php
                            // $_SESSION['success'] = "";
                            unset($_SESSION['success']);
                            }
                        }
                    }
?>
                <main style="margin-top: 10vh">

                    <section class="content" style=" margin:auto; max-width:95%;">
                        <form class="card" action="PriceSetting-action.php" method="POST">
                            <div class="card-header">
                                <h3 class="card-titl e">Biểu phí dịch vụ ADEPRO</h3>
                            </div>
                            <h3 class="cardType">Thẻ thường</h3>
                            <div class="card-body p-0">
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%">Loại phương tiện</th>
                                            <th style="width: 20%">Giá dịch vụ</th>
                                        </tr>
                                    </thead>
<?php
                                        // Create connection
                                        // $connection = new mysqli($servername, $username, $password, $database);
                                        // read all row from database table
                                        $sql = "SELECT * FROM pricelist WHERE display = 1 ORDER BY priceListID DESC";
                                        $result = $conn->query($sql);

                                        if (!$result) {
                                            die("Invalid query: " . $conn->error);
                                        }

                                        $motor = 0;
                                        $car = 0;
                                        $motorMonth = 0;
                                        $carMonth = 0;
                                        if (mysqli_num_rows($result) > 0) {
                                            $row = $result->fetch_assoc();
                                            $motor = $row["motor"];
                                            $car = $row["car"];
                                            $motorMonth = $row["motorMonth"];
                                            $carMonth = $row["carMonth"];
                                        }

?>
                                    <tbody>
                                        <tr>
                                            <td>Xe máy</td>
                                            <td><input class='text-center form-control inputForm' id="numberMotor" type='number' name="numberMotor" step="1000" min="0" required oninvalid="this.setCustomValidity('Không được để trống. Làm tròn đến hàng nghìn')" oninput="this.setCustomValidity('')" value="<?php echo ($motor) ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Ô tô</td>
                                            <td><input class='text-center form-control inputForm' id="numberCar" type='number' name="numberCar" step="1000" min="0" required oninvalid="this.setCustomValidity('Không được để trống. Làm tròn đến hàng nghìn')" oninput="this.setCustomValidity('')" value="<?php echo ($car) ?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h3 class="cardType">Thẻ tháng</h3>
                                <div class="card-body p-0">
                                    <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%">Loại phương tiện</th>
                                                <th style="width: 20%">Giá dịch vụ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Xe máy</td>
                                                <td><input class='text-center form-control inputForm' id="numberMotorMonth" type='number' name="numberMotorMonth" step="1000" min="0" required oninvalid="this.setCustomValidity('Không được để trống. Làm tròn đến hàng nghìn')" oninput="this.setCustomValidity('')" value="<?php echo($motorMonth) ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Ô tô</td>
                                                <td><input class='text-center form-control inputForm' id="numberCarMonth" type='number' name="numberCarMonth" step="1000" min="0" required oninvalid="this.setCustomValidity('Không được để trống. Làm tròn đến hàng nghìn')" oninput="this.setCustomValidity('')" value="<?php echo($carMonth) ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- <input class="right submit btn btn-primary" id="btnSave" type="submit" value="Lưu"> -->
                                    <button type="button" class='right submit btn btn-primary' data-toggle="modal" data-target="#modalConfirm" id="btnSave">
                                        Lưu
                                    </button>
                                    <div class="modal show" id="modalConfirm">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Xác nhận</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row" style="display:block">
                                                    <label>Bạn có chắc chắn với sự thay đổi này?</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <input class="btn btn-secondary" id="btnConfirmYes" type="submit" value="Có">
                                                <!-- <a class="btn btn-secondary" id="btnConfirmYes">Có</a> -->
                                                <button class="btn btn-primary" data-dismiss="modal" aria-label="Close">Không</button>
                                            </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                </div>
                            </div>
                        </form>
                        <!-- /.card-body -->
                </section>
                <?php $conn->close(); ?>
            </main>
            <?php
                // include "../../feedback-btn.html" ?>
                <?php include "../../footer.html" ?>
            </body>
            </html>
<?php
        }
    }
}
?>

<script>
    $(document).ready(function(){
        setTimeout(function(){
            $("#error_box").hide();
        }, 3000);
    });
</script>