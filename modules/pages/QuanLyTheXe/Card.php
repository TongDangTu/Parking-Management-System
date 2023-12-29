<?php
  session_start(); 
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
  <title>ADEPRO - Quản lý Thẻ Xe</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css" />
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
      grid-template-columns: 45% 55%;
      row-gap: 3px;

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
        font-size:0.7rem;
    }
  </style>
<?php
    include "../../header-navbar/header.php";
?>
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
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-titl e">Danh sách thẻ xe</h3>
          <div style="margin-left:auto;">
            <div class="input-group rounded">
              <input type="search" id="txtSearch" class="form-control rounded" placeholder="Tìm kiếm theo ID thẻ, Họ và tên, CCCD, Số điện thoại, Biển số xe" aria-label="Search"
                aria-describedby="search-addon"/>
              <button id="btn_seacrch">
                <span class="input-group-text border-0" id="search-addon">
                  <i class="fas fa-search"></i>
                </span>
              </button>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th style="width: 2%">#</th>
                <th style="width: 9.5%">ID thẻ</th>
                <th style="width: 5%">Trạng thái</th>
                <th style="width: 9.5%" class="text-center">Loại thẻ</th>
                <th style="width: 9.5%" class="text-center">Loại xe</th>
                <th style="width: 9.5%" class="text-center">Ngày đăng ký</th>
                <th style="width: 9.5%" class="text-center">Họ và tên</th>
                <th style="width: 9.5%" class="text-center">CCCD khách</th>
                <th style="width: 9.5%" class="text-center">Số điện thoại</th>
                <th style="width: 9.5%" class="text-center">Biển số xe</th>
                <th style="width: 9.5%" class="text-center">
<?php
                  include "Card-add.php";
?>
                </th>
              </tr>
            </thead>
            <tbody>
<?php
              if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql = "SELECT * FROM card LEFT JOIN monthcard ON cardID = monthcardID WHERE (cardID like '%$search%' OR customerName like '%$search%' OR customerIdentityCard like '%$search%' OR phoneNumber like '%$search%' OR licensePlate like '%$search%')  AND (card.display = 1 OR monthcard.display = 1)";
              }
              else {
                $sql = "SELECT * FROM card LEFT JOIN monthcard ON cardID = monthcardID WHERE card.display = 1 OR monthcard.display = 1";
              }
              
              // Create connection
              // $connection = new mysqli($servername, $username, $password, $database);
              // read all row from database table
              $result = $conn->query($sql);

              if (!$result) {
                die("Invalid query: " . $connection->error);
              }

              // phân trang BY TongDangTu
              $sizePage = 10;
              $number_rows = mysqli_num_rows($result);
              $number_pages = ceil($number_rows / $sizePage);
              if (isset($_GET["page"])) {
                $current_page = $_GET["page"];
                if($current_page > $number_pages) {
                  $current_page = $number_pages;
                }
                if($current_page < 1) {
                  $current_page = 1;
                }
              }
              else {
                $current_page = 1;
              }

              $i = 0;
              $row_start = ($current_page - 1) * $sizePage + 1;
              $row_end = $current_page * $sizePage;
              // read data of each row
              while ($row = mysqli_fetch_assoc($result)) {
                $i++;
                if ($i >= $row_start && $i <= $row_end) {
                  ?>  
                  <tr>
                    <td>
                      <?php echo ($i) ?>
                    </td>
                    <td>
                      <?php echo ($row["cardID"]) ?>
                    </td>
                    <td>
                      <?php
                        if($row["status"] == 1) {
                          echo ("Mở");
                        }
                        if($row["status"] == 0) {
                          echo ("Khóa");
                        }
                      ?>
                    </td>
                    <td>
                      <?php echo ($row["type"]) ?>
                    </td>
                    <td>
                      <?php echo ($row["vehicleType"]) ?>
                    </td>
                    <td>
                      <?php echo ($row["date"]) ?>
                    </td>
                    <td>
                      <?php echo ($row["customerName"]) ?>
                    </td>
                    <td>
                      <?php echo ($row["customerIdentityCard"]) ?>
                    </td>
                    <td>
                      <?php echo ($row["phoneNumber"]) ?>
                    </td>
                    <td>
                      <?php echo ($row["licensePlate"]) ?>
                    </td>
                    <td class='project-actions text-center'>
                      <button type="button" class="btn btn-default btn_edit" data-toggle="modal" data-target="#modal" id="btn_edit_<?php echo($row["cardID"]) ?>" data-cardid="<?php echo($row["cardID"]) ?>">
                        <i class="fas fa-solid fa-pen-to-square"></i>
                        Edit
                      </button>
                      
                      <button type="button" class='btn btn-danger btn_delete' data-toggle="modal" data-target="#modalDel" id="btn_delete_<?php echo($row["cardID"]) ?>" data-cardid="<?php echo($row["cardID"]) ?>" data-type="<?php echo($row["type"]) ?>">
                        <i class='fas fa-trash'> </i>
                        Xóa
                      </button>
                    </td>
                  </tr>
<?php
                }
              }
              $conn->close();
?>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <!-- phân trang -->
<?php
        if ($number_pages > 1) {
?>
        <div aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <li class="page-item ">
              <a class="page-link" href="?page=1<?php if (isset($_GET['search'])) { $search = $_GET['search']; echo("&search=". $_GET['search']);} ?>"><<</a>
            </li>
            <li class="page-item ">
              <a class="page-link" href="?page=<?php echo(($current_page-1)) ?><?php if (isset($_GET['search'])) { $search = $_GET['search']; echo("&search=". $_GET['search']);} ?>"><</a>
            </li>
<?php
            if ($current_page > 3) {
?>
              <b style="margin-top: 7px;"> . . . </b>
<?php
            }
            for ($i = 1; $i <= $number_pages; $i++) {
              if (abs($i - $current_page) <= 2) {
                if ($i == $current_page) {
?>
                  <li class="page-item"><a class="page-link" href="?page=<?php echo($i) ?><?php if (isset($_GET['search'])) { $search = $_GET['search']; echo("&search=". $_GET['search']);} ?>" style="background-color: #ccc;"><?php echo($i) ?></a></li>
<?php
                }
                else {
?>
                  <li class="page-item"><a class="page-link" href="?page=<?php echo($i) ?><?php if (isset($_GET['search'])) { $search = $_GET['search']; echo("&search=". $_GET['search']);} ?>"><?php echo($i) ?></a></li>
<?php
                }
              }
            }
            if ($number_pages - $current_page > 2) {
?>
              <b style="margin-top: 7px;"> . . . </b>
<?php
            }
?>
            <li class="page-item">
              <a class="page-link" href="?page=<?php echo(($current_page+1)) ?><?php if (isset($_GET['search'])) { $search = $_GET['search']; echo("&search=". $_GET['search']);} ?>">></a>
            </li>
            <li class="page-item">
              <a class="page-link" href="?page=<?php echo($number_pages) ?><?php if (isset($_GET['search'])) { $search = $_GET['search']; echo("&search=". $_GET['search']);} ?>">>></a>
            </li>
          </ul>
        </div>
<?php
        }
?>
      </div>
      <!-- /.card -->
    </section>
  </main>
  <?php
  // include "../../feedback-btn.html" ?>
  <?php include "../../footer.html" ?>
  <?php include "Card-edit.php" ?>
  <?php include "Card-delete.php" ?>


  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
</body>

<?php 
    }
  }
?>

<script>
  $(document).ready(function () {
// Form Add
    if ($("#selectType_Add").val() == "Tháng") {
      $(".inputForMonthCard_Add").prop('readonly', false);
    }
    if ($("#selectType_Add").val() == "Thường") {
      $(".inputForMonthCard_Add").prop('readonly', true);
      clearFormAddWhenChangeTypeFormMonthToNormal();
    }
    $("#selectType_Add").change(function () {
      if ($(this).val() == "Tháng") {
        $(".inputForMonthCard_Add").prop('readonly', false);
      }
      if ($(this).val() == "Thường") {
        $(".inputForMonthCard_Add").prop('readonly', true);
        clearFormAddWhenChangeTypeFormMonthToNormal();
      }
    });
    // Báo lỗi regex form Add
    errorRegexFormAdd();
    // Listen Event: oninput
    function errorRegexFormAdd () {
      txtCustomerName_Add.oninput = function() {
        checkRegexFormAdd("txtCustomerName_Add");
        this.setCustomValidity('');
      };
  
      txtCustomerIdentityCard_Add.oninput = function() {
        checkRegexFormAdd("txtCustomerIdentityCard_Add");
        this.setCustomValidity('');
      };
  
      txtPhoneNumber_Add.oninput = function() {
        checkRegexFormAdd("txtPhoneNumber_Add");
        this.setCustomValidity('');
      };
  
      txtLicensePlate_Add.oninput = function() {
        checkRegexFormAdd("txtLicensePlate_Add");
        this.setCustomValidity('');
      };
    }

    // Check regex form Add, and display error
    function checkRegexFormAdd (id) {
      var isValid = true;
      var content = $("#txtCustomerName_Add").val();
      var pattern = "^[ A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ]{1,30}$";
      var text = content;
      if (text.match(pattern)) {
        $("#errorCustomerName_Add").html(".");
      }
      else {
        if (id == "txtCustomerName_Add") {
          $("#errorCustomerName_Add").html("Tên chỉ được phép tối đa 30 ký tự.<br>Không được sử dụng ký tự đặc biệt.");
        }
        isValid = false;
      }
      var content = $("#txtCustomerIdentityCard_Add").val();
      var pattern = "^\\d{12}$";
      var text = content;
      if (text.match(pattern)) {
        $("#errorCustomerIdentityCard_Add").html(".");
      }
      else {
        if (id == "txtCustomerIdentityCard_Add") {
          $("#errorCustomerIdentityCard_Add").html("CCCD chỉ bao gồm các chữ số.<br>Bao gồm 12 ký tự.");
        }
        isValid = false;
      }
      var content = $("#txtPhoneNumber_Add").val();
      var pattern = "^0\\d{9}$";
      var text = content;
      if (text.match(pattern)) {
        $("#errorPhoneNumber_Add").html(".");
      }
      else {
        if (id == "txtPhoneNumber_Add") {
          $("#errorPhoneNumber_Add").html("Số điện thoại không hợp lệ.<br>Số điện thoại chỉ bao gồm các chữ số.<br>Bao gồm 10 ký tự.");
        }
        isValid = false;
      }
      var content = $("#txtLicensePlate_Add").val();
      var pattern = "^[0-9A-Z ]+-?[0-9A-Z ]+$";
      var text = content;
      if (text.match(pattern)) {
        $("#errorLicensePlate_Add").html(".");
      }
      else {
        if (id == "txtLicensePlate_Add") {
          $("#errorLicensePlate_Add").html("Biển số xe không hợp lệ.");
        }
        isValid = false;
      }
      abledButtonAdd(isValid);
    }

    // abled button Add
    function abledButtonAdd (isValid) {
      if (isValid == false) {
        $("#btn_add").prop("disabled", true);
      }
      else {
        $("#btn_add").prop("disabled", false);
      }
    }

    // 
    $("#btn_reset_add").click(function(){
      clearFormAddWhenChangeTypeFormMonthToNormal();
    })

    // clear Form Add When Change Type Form Month To Normal
    function clearFormAddWhenChangeTypeFormMonthToNormal () {
      $("#txtCustomerName_Add").val("");
      $("#txtCustomerIdentityCard_Add").val("");
      $("#txtPhoneNumber_Add").val("");
      $("#txtLicensePlate_Add").val("");

      $("#errorCustomerName_Add").html(".");
      $("#errorCustomerIdentityCard_Add").html(".");
      $("#errorPhoneNumber_Add").html(".");
      $("#errorLicensePlate_Add").html(".");

      $(".inputForMonthCard_Add").prop('readonly', true);

      abledButtonAdd(true);
    }

// Form Edit
    // Lấy ID khi click vào Edit bản ghi
    // Lấy data của nút khi click bằng AJAX
    var btn_edit_list = $(".btn_edit");
    for (var i = 0; i < btn_edit_list.length; i++) {
      btn_edit_list[i].onclick = function(e)
      {
        e.preventDefault();   // Không cho phép chuyển trang
        var cardID = $(this).data("cardid");

        $.ajax({
          url: "Card-edit-action-ajax.php",
          type: "post",
          dataType: "html",
          data : {
            cardID
          }
        }).done(function(result){
          const row = JSON.parse(result);
          
          // $("#txtCardID_Edit").val(row.cardID);
          $("#txtCardID_Edit").attr("value",row.cardID);

          $("#selectStatus_Edit option").prop('selected', false);
          $("#selectVehicleType_Edit option").prop('selected', false);
          $("#selectType_Edit option").prop('selected', false);
          $("#selectStatus_Edit option[value='"+ row.status +"']").prop('selected', true);
          $("#selectVehicleType_Edit option[value='"+ row.vehicleType +"']").prop('selected', true);
          $("#selectType_Edit option[value='"+ row.type +"']").prop('selected', true);


          // alert(row.date+ " " +row.customerName+ " " +row.customerIdentityCard+ " " +row.phoneNumber+ " " +row.licensePlate);

          $("#txtDate_Edit").val(row.date);
          $("#txtCustomerName_Edit").val(row.customerName);
          $("#txtCustomerIdentityCard_Edit").val(row.customerIdentityCard);
          $("#txtPhoneNumber_Edit").val(row.phoneNumber);
          $("#txtLicensePlate_Edit").val(row.licensePlate);

          $("#checkboxExtend_Edit").prop("checked", false);

          if ($("#selectType_Edit").val() == "Tháng") {
            $(".inputForMonthCard-Edit").prop('readonly', false);

            $("#errorDate_Edit").html(".");
            $("#errorCustomerName_Edit").html(".");
            $("#errorCustomerIdentityCard_Edit").html(".");
            $("#errorPhoneNumber_Edit").html(".");
            $("#errorLicensePlate_Edit").html(".");
            $("#checkboxExtend_Edit").prop("disabled", false);
            $("#checkboxExtend_Edit").prop("checked", false);
          }
          if ($("#selectType_Edit").val() == "Thường") {
            $(".inputForMonthCard-Edit").prop('readonly', true);
            $("#checkboxExtend_Edit").prop("disabled", true);
            $("#checkboxExtend_Edit").prop("checked", false);
            clearFormEditWhenChangeTypeFormMonthToNormal();
          }
          $("#selectType_Edit").change(function () {
            if ($(this).val() == "Tháng") {
              $(".inputForMonthCard-Edit").prop('readonly', false);
              $("#checkboxExtend_Edit").prop("disabled", false);
              $("#checkboxExtend_Edit").prop("checked", false);
            }
            if ($(this).val() == "Thường") {
              $(".inputForMonthCard-Edit").prop('readonly', true);
              $("#checkboxExtend_Edit").prop("disabled", true);
              $("#checkboxExtend_Edit").prop("checked", false);
              clearFormEditWhenChangeTypeFormMonthToNormal();
            }
          });
        });
      };
    }
    // Báo lỗi regex form Edit  
    errorRegexFormEdit();
    // Listen Event: oninput
    function errorRegexFormEdit () {
      txtDate_Edit.oninput = function() {
        this.setCustomValidity('');
      };

      txtCustomerName_Edit.oninput = function() {
        checkRegexFormEdit("txtCustomerName_Edit");
        this.setCustomValidity('');
      };
  
      txtCustomerIdentityCard_Edit.oninput = function() {
        checkRegexFormEdit("txtCustomerIdentityCard_Edit");
        this.setCustomValidity('');
      };
  
      txtPhoneNumber_Edit.oninput = function() {
        checkRegexFormEdit("txtPhoneNumber_Edit");
        this.setCustomValidity('');
      };
  
      txtLicensePlate_Edit.oninput = function() {
        checkRegexFormEdit("txtLicensePlate_Edit");
        this.setCustomValidity('');
      };
    }
    // Check regex form Edit, and display error
    function checkRegexFormEdit (id) {
      var isValid = true;
      var content = $("#txtCustomerName_Edit").val();
      var pattern = "^[ A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ]{1,30}$";
      var text = content;
      if (text.match(pattern)) {
        $("#errorCustomerName_Edit").html(".");
      }
      else {
        if (id == "txtCustomerName_Edit") {
          $("#errorCustomerName_Edit").html("Tên chỉ được phép tối đa 30 ký tự.<br>Không được sử dụng ký tự đặc biệt.");
        }
        isValid = false;
      }
      var content = $("#txtCustomerIdentityCard_Edit").val();
      var pattern = "^\\d{12}$";
      var text = content;
      if (text.match(pattern)) {
        $("#errorCustomerIdentityCard_Edit").html(".");
      }
      else {
        if (id == "txtCustomerIdentityCard_Edit") {
          $("#errorCustomerIdentityCard_Edit").html("CCCD chỉ bao gồm các chữ số.<br>Bao gồm 12 ký tự.");
        }
        isValid = false;
      }
      var content = $("#txtPhoneNumber_Edit").val();
      var pattern = "^0\\d{9}$";
      var text = content;
      if (text.match(pattern)) {
        $("#errorPhoneNumber_Edit").html(".");
      }
      else {
        if (id == "txtPhoneNumber_Edit") {
          $("#errorPhoneNumber_Edit").html("Số điện thoại không hợp lệ.<br>Số điện thoại chỉ bao gồm các chữ số.<br>Bao gồm 10 ký tự.");
        }
        isValid = false;
      }
      var content = $("#txtLicensePlate_Edit").val();
      var pattern = "^[0-9A-Z ]+-?[0-9A-Z ]+$";
      var text = content;
      if (text.match(pattern)) {
        $("#errorLicensePlate_Edit").html(".");
      }
      else {
        if (id == "txtLicensePlate_Edit") {
          $("#errorLicensePlate_Edit").html("Biển số xe không hợp lệ.");
        }
        isValid = false;
      }
      abledButtonEdit(isValid);
    }
    // abled button Edit
    function abledButtonEdit (isValid) {
      if (isValid == false) {
        $("#btn_edit").prop("disabled", true);
      }
      else {
        $("#btn_edit").prop("disabled", false);
      }
    }
    // 
    $("#btn_reset_edit").click(function(){
      clearFormEditWhenChangeTypeFormMonthToNormal();
    })
    // clear Form Edit When Change Type Form Month To Normal
    function clearFormEditWhenChangeTypeFormMonthToNormal () {
      $("#txtDate_Edit").val("");
      $("#txtCustomerName_Edit").val("");
      $("#txtCustomerIdentityCard_Edit").val("");
      $("#txtPhoneNumber_Edit").val("");
      $("#txtLicensePlate_Edit").val("");
      $("#checkboxExtend_Edit").checked = false;

      $("#errorDate_Edit").html(".");
      $("#errorCustomerName_Edit").html(".");
      $("#errorCustomerIdentityCard_Edit").html(".");
      $("#errorPhoneNumber_Edit").html(".");
      $("#errorLicensePlate_Edit").html(".");

      $(".inputForMonthCard-Edit").prop('readonly', true);

      abledButtonEdit(true);
    }

// Delete
    // Lấy ID khi click vào Delete bản ghi
    var btn_delete_list = $(".btn_delete");
    for (var i = 0; i < btn_delete_list.length; i++) {
      btn_delete_list[i].onclick = function(e)
      {
        var cardID = $(this).data("cardid");
        var type = $(this).data("type");

        $("#btn_submit_delete").attr("href", "Card-delete-action.php?cardID="+ cardID +"&type="+ type)
      };
    }

    
// Search
    <?php
      if (isset($_GET['search'])) {
    ?>
        $("#txtSearch").val("<?php echo($_GET['search']) ?>");
    <?php
      }
    ?>
    $("#btn_seacrch").click(function(){
      var search = $("#txtSearch").val();
      // Redirect bằng javascript
      window.location.href = "Card.php?search="+ search;
    });
  });
</script>