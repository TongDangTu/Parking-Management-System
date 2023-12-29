<div class="modal show" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa thông tin khu</h4>
                <a type="button" class="close" href="">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form action="Area-edit-action.php" method="POST">
                <div class="modal-body">
                    <div class="row" style="display:block">
                        <div class="col-md-6" style="    min-width: 100%;">
                            <div class="card card-primary" style="box-shadow:none; margin:0;border:0;">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="txtAreaName_Edit">Tên khu</label>
                                        <input type="text" id="txtAreaName_Edit" name="txtAreaName_Edit" class="form-control" value="" readonly required oninvalid="this.setCustomValidity('Không được để trống')"/>
                                        <p id="errorAreaName_Edit" class="errorMessenge">.</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="selectVehicleType_Edit">Loại xe</label>
                                        <select id="selectVehicleType_Edit" name="selectVehicleType_Edit">
                                            <option value="Xe máy">Xe máy</option>
                                            <option value="Ô tô">Ô tô</option>
                                        </select>
                                        <p id="errorVehicleType_Edit" class="errorMessenge">.</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtMaxSize_Edit">Số xe tối đa</label>
                                        <input type="text" id="txtMaxSize_Edit" name="txtMaxSize_Edit" class="form-control" value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                                        <p id="errorMaxSize_Edit" class="errorMessenge">.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="reset" class="btn btn-default" id="btn_reset_edit">Reset</button>
                    <button type="submit" class="btn btn-primary" id="btn_edit">Sửa</button>
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