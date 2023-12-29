      <div class="modal show" id="modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Sửa thông tin tài khoản</h4>
              <a type="button" class="close" href="Account.php">
                <span aria-hidden="true">&times;</span>
               </a>
            </div>
            <form method="post" action="Account_edit_be.php?currentpage=<?php echo $currentpage; ?>&pagesize=<?php echo $pagesize; ?>">
              <div class="modal-body">
                <div class="row" style="display:block">
                  <div class="col-md-6" style="    min-width: 100%;">
                    <div class="card card-primary"style="box-shadow:none; margin:0;">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="inputUser">Tên tài khoản</label>
                          <input
                            type="text"
                            id="inputUser_Edit"
                            class="form-control"
                            value=""
                            name="txtuser_edit"
                            readonly
                          />
                          <p class="errorMessenge" id="erMUserE"></p>
                        </div>
                        <div class="form-group">
                          <label for="inputName">Họ tên</label>
                          <input
                            type="text"
                            id="inputName_Edit"
                            class="form-control"
                            value=""
                            name="txtname_edit"
                          />
                          <p class="errorMessenge" id="erMNameE"> </p>
                        </div>
                        <div class="form-group">
                          <label for="selectChucVu">Chức vụ</label>
                          <select name="slpos_edit" id="selectChucVu_Edit">
                            <option value="Nhân viên">Nhân viên</option>
                            <option value="Admin">Admin</option>
                          </select>
                          <p class="errorMessenge" id="erMPosE"> </p>
                        </div>
                        <div class="form-group">
                          <label for="inputName">Căn cước công dân</label>
                          <input
                            type="text"
                            id="inputCCCD_Edit"
                            class="form-control"
                            value=""
                            name="txtidcard_edit"
                          />
                          <p class="errorMessenge" id="erMIdE"> </p>
                        </div>
                        <div class="form-group">
                          <label for="inputName">Ngày sinh</label>
                          <input
                            type="date"
                            id="inputBday_Edit"
                            class="form-control"
                            name="txtdate_edit"
                            required oninvalid="this.setCustomValidity('Không được để trống')" oninput="this.setCustomValidity('')"
                          />
                          <p class="errorMessenge" id="erMDateE"> </p>
                            <!--có thể set value/min max tùy theo yêu cầu:  value="2077-01-01" min="2018-01-01" max="2018-12-31" -->
                        </div>
                        <div class="form-group">
                          <label for="selectChucVu" >Giới tính</label>
                          <select name="slsex_edit" id="selectGioiTinh_Edit">
                          <option value="1">Nam</option>
                          <option value="0">Nữ</option>
                          </select>
                          <p class="errorMessenge" id="erMSexE"> </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <input type="reset" class="btn btn-default" data-dismiss="modal" value="Reset"/>
                <input type="submit" class="btn btn-primary" id="submitEditAccount" value="Sửa"/>
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

