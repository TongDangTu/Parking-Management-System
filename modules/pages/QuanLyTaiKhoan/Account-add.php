<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
              <h4 class="modal-title">Thêm tài khoản</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
      <form method="post" action="Account_add_be.php">
        <div class="modal-body">
          <div class="row" style="display:block">
            <div class="col-md-6" style="    min-width: 100%;">
              <div class="card card-primary"style="box-shadow:none; margin:0;">
              <div class="card-body">
                  <div class="form-group">
                    <label for="inputUser">Tên tài khoản</label>
                    <input
                      type="text"
                      id="inputUser"
                      class="form-control"
                      value=""
                      name="txtuser_add"
                    />
                    <p class="errorMessenge" id="erMUserA"></p>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword">Mật khẩu</label>
                    <input
                      type="text"
                      id="inputPassword"
                      class="form-control"
                      value=""
                      name="txtpass_add"
                    />
                    <p class="errorMessenge" id="erMPassA"></p>
                  </div>
                  <div class="form-group">
                    <label for="inputName">Họ tên</label>
                    <input
                      type="text"
                      id="inputName"
                      class="form-control"
                      value=""
                      name="txtname_add"
                    />
                    <p class="errorMessenge" id="erMUserA"></p>
                  </div>
                  <div class="form-group">
                    <label for="selectChucVu">Chức vụ</label>
                    <select name="slpos_add">
                    <option value="employee">Nhân viên</option>
                    <option value="admin">Quản lý</option>
                    </select>
                    <p class="errorMessenge" id="erMPosA"></p>
                  </div>
                  <div class="form-group">
                    <label for="inputName">Căn cước công dân</label>
                    <input
                      type="text"
                      id="inputCCCD"
                      class="form-control"
                      value=""
                      name="txtidcard_add"
                    />
                    <p class="errorMessenge" id="erMIdA"></p>
                  </div>
                  <div class="form-group">
                    <label for="inputName">Ngày sinh</label>
                    <input
                      type="date"
                      id="inputBday"
                      class="form-control"
                      name="txtdate_add"
                      required oninvalid="this.setCustomValidity('Không được để trống')" oninput="this.setCustomValidity('')"
                    />
                    <p class="errorMessenge" id="erMDateA"></p>
                      <!--có thể set value/min max tùy theo yêu cầu:  value="2077-01-01" min="2018-01-01" max="2018-12-31" -->
                  </div>
                  <div class="form-group">
                    <label for="selectChucVu">Giới tính</label>
                    <select name="slsex_add">
                    <option value="1">Nam</option>
                    <option value="0">Nữ</option>
                    </select>
                    <p class="errorMessenge" id="erMSexA"></p>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </form>
            <div class="modal-footer justify-content-between">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Reset"/>
              <input type="submit" class="btn btn-primary" id="submitAddAccount" value="Thêm"/>
            </div>
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
<!-- <script src="../../dist/js/adminlte.min.js"></script> -->
</body>
</html>
