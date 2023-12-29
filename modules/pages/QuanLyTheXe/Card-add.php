<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">

  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
  <i class="fa-solid fa-plus"></i>Thêm
  </button>

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Thêm thẻ xe</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="Card-add-action.php" method="POST">
          <div class="modal-body">
            <div class="row" style="display:block">
              <div class="col-md-6" style="    min-width: 100%;">
                <div class="card card-primary" style="box-shadow:none; margin:0;">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="txtCardID_Add">ID thẻ</label>
<!-- php-start -->
                      <input type="text" id="txtCardID_Add" name="txtCardID_Add" readonly value="<?php
                      $sqlQuery = "SELECT MAX(cardID) AS maxCardID FROM card";
                      $result = mysqli_query($conn, $sqlQuery);
                      if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $maxCardID = $row["maxCardID"];
                        $cardID = $maxCardID + 1;
                      } else {
                        $cardID = 1000;
                      }
                      echo ($cardID);
                      ?>" />
                      <p id="errorID_Add" class="errorMessenge">.</p>
<!-- php-end -->
                    </div>
                    <!-- <div class="form-group">
                      <label for="selectStatus">Trạng thái</label>
                      <select id="selectStatus">
                        <option value="1">Mở</option>
                        <option value="0">Khóa</option>
                      </select>
                    </div> -->
                    <div class="form-group">
                      <label for="selectVehicleType_Add">Loại xe</label>
                      <select id="selectVehicleType_Add" name="selectVehicleType_Add">
                        <option value="Xe máy">Xe máy</option>
                        <option value="Ô tô">Ô tô</option>
                      </select>
                      <p id="errorVehicleType_Add" class="errorMessenge">.</p>
                    </div>
                    <div class="form-group">
                      <label for="selectType_Add">Loại thẻ</label>
                      <select id="selectType_Add" name="selectType_Add">
                        <option value="Thường">Thường</option>
                        <option value="Tháng">Tháng</option>
                      </select>
                      <p id="errorType_Add" class="errorMessenge">.</p>
                    </div>
                    <div class="form-group">
                      <label for="inputCustomerName_Add">Tên khách hàng</label>
                      <input type="text" id="txtCustomerName_Add" class="inputForMonthCard_Add"
                        name="txtCustomerName_Add" value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                      <p id="errorCustomerName_Add" class="errorMessenge">.</p>
                    </div>
                    <div class="form-group">
                      <label for="txtCustomerIdentityCard_Add">CCCD khách</label>
                      <input type="text" id="txtCustomerIdentityCard_Add" class="inputForMonthCard_Add"
                        name="txtCustomerIdentityCard_Add" value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                      <p id="errorCustomerIdentityCard_Add" class="errorMessenge">.</p>
                    </div>
                    <div class="form-group">
                      <label for="txtPhoneNumber_Add">Số điện thoại</label>
                      <input type="text" id="txtPhoneNumber_Add" class="inputForMonthCard_Add" name="txtPhoneNumber_Add"
                        value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                      <p id="errorPhoneNumber_Add" class="errorMessenge">.</p>
                    </div>
                    <div class="form-group">
                      <label for="txtLicensePlate_Add">Biển số xe</label>
                      <input type="text" id="txtLicensePlate_Add" class="inputForMonthCard_Add"
                        name="txtLicensePlate_Add" value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                      <p id="errorLicensePlate_Add" class="errorMessenge">.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="reset" class="btn btn-default" id="btn_reset_add">Reset</button>
            <button type="submit" class="btn btn-primary" id="btn_add">Thêm</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>