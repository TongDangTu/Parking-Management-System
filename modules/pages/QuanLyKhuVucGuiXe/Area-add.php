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
                    <h4 class="modal-title">Thêm khu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="Area-add-action.php" method="POST">
                    <div class="modal-body">
                        <div class="row" style="display:block">
                            <div class="col-md-6" style="min-width: 100%;">
                                <div class="card card-primary" style="box-shadow:none; margin:0;">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="txtAreaName_Add">Tên khu</label>
                                            <input type="text" id="txtAreaName_Add" name="txtAreaName_Add" class="form-control" value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                                            <p id="errorAreaName_Add" class="errorMessenge">.</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="selectVehicleType_Add">Loại xe</label>
                                            <select id="selectVehicleType_Add" name="selectVehicleType_Add">
                                                <option value="Xe máy">Xe máy</option>
                                                <option value="Ô tô">Ô tô</option>
                                            </select>
                                            <p id="errorVehicleType_Add" class="errorMessenge">.</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtMaxSize_Add">Số xe tối đa</label>
                                            <input type="text" id="txtMaxSize_Add" name="txtMaxSize_Add" class="form-control" value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                                            <p id="errorMaxSize_Add" class="errorMessenge">.</p>
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