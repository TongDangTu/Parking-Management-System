<div class="modal show" id="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Sửa thông tin thẻ xe</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="Card-edit-action.php?page=<?php echo($current_page) ?><?php if (isset($_GET['search'])) { $search = $_GET['search']; echo("&search=". $_GET['search']);} ?>" method="POST">
        <div class="modal-body">
          <div class="row" style="display:block">
            <div class="col-md-6" style="    min-width: 100%;">
              <div class="card card-primary" style="box-shadow:none; margin:0;">
                <div class="card-body">
                  <div class="form-group">
                    <label for="txtCardID_Edit">ID thẻ</label>
                    <input type="text" id="txtCardID_Edit" name="txtCardID_Edit" readonly value="" />
                    <p id="errorID_Edit" class="errorMessenge">.</p>
                  </div>
                  <div class="form-group">
                    <label for="selectStatus_Edit">Trạng thái</label>
                    <select id="selectStatus_Edit" name="selectStatus_Edit" value="" >
                      <option value="1">Mở</option>
                      <option value="0">Khóa</option>
                    </select>
                    <p id="errorStatus_Edit" class="errorMessenge">.</p>
                  </div>
                  <div class="form-group">
                    <label for="selectVehicleType_Edit">Loại xe</label>
                    <select id="selectVehicleType_Edit" name="selectVehicleType_Edit" value="">
                      <option value="Xe máy">Xe máy</option>
                      <option value="Ô tô">Ô tô</option>
                    </select>
                    <p id="errorVehicleType_Edit" class="errorMessenge">.</p>
                  </div>
                  <div class="form-group">
                    <label for="selectType_Edit">Loại thẻ</label>
                    <select id="selectType_Edit" name="selectType_Edit" value="">
                      <option value="Thường">Thường</option>
                      <option value="Tháng">Tháng</option>
                    </select>
                    <p id="errorType_Edit" class="errorMessenge">.</p>
                  </div>
                  <div class="form-group">
                    <label for="txtDate_Edit">Ngày đăng ký</label>
                    <input type="date" id="txtDate_Edit" class="inputForMonthCard-Edit" name="txtDate_Edit" value="" min="2000-01-01" max="2099-12-31" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                    <p id="errorDate_Edit" class="errorMessenge">.</p>
                  </div>
                  <div class="form-group">
                    <label for="txtCustomerName_Edit">Tên khách hàng</label>
                    <input type="text" id="txtCustomerName_Edit" class="inputForMonthCard-Edit" name="txtCustomerName_Edit" value="" required oninvalid="this.setCustomValidity('Không được để trống')" oninvalid="this.setCustomValidity('Không được để trống')"/>
                    <p id="errorCustomerName_Edit" class="errorMessenge">.</p>
                  </div>
                  <div class="form-group">
                    <label for="txtCustomerIdentityCard_Edit">CCCD khách</label>
                    <input type="text" id="txtCustomerIdentityCard_Edit" class="inputForMonthCard-Edit" name="txtCustomerIdentityCard_Edit" value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                    <p id="errorCustomerIdentityCard_Edit" class="errorMessenge">.</p>
                  </div>
                  <div class="form-group">
                    <label for="txtPhoneNumber_Edit">Số điện thoại</label>
                    <input type="text" id="txtPhoneNumber_Edit" class="inputForMonthCard-Edit" name="txtPhoneNumber_Edit" value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                    <p id="errorPhoneNumber_Edit" class="errorMessenge">.</p>
                  </div>
                  <div class="form-group">
                    <label for="txtLicensePlate_Edit">Biển số xe</label>
                    <input type="text" id="txtLicensePlate_Edit" class="inputForMonthCard-Edit" name="txtLicensePlate_Edit" value="" required oninvalid="this.setCustomValidity('Không được để trống')"/>
                    <p id="errorLicensePlate_Edit" class="errorMessenge">.</p>
                  </div>
                  <div class="form-group">
                    <label for=""></label>
                    <div class="form-group">
                      <input type="checkbox" name="checkboxExtend_Edit" id="checkboxExtend_Edit" value="on"><span>Gia hạn</span>
                    </div>
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
