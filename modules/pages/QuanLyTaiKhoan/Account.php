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

<?php
//phân trang,search
    include "../../../connection.php";
    if(isset($_GET['search'])){
      $search=$_GET['search'];
      $sql_count = "select * from Account where display=1 and (userName like '%$search%' or name like '%$search%' or identityCard like '%$search%') ";
    }else{
    $sql_count = "select * from Account where display=1";
    }
    $pagesize=5;
    $d = mysqli_query($conn,$sql_count);
    $count=$d->num_rows;
    $ps = ceil($count/$pagesize);
    if(!isset($_GET['currentpage'])){
      $_GET['currentpage'] = 1;
    }
    if($_GET['currentpage']<1){
      $_GET['currentpage'] = 1;
    }
    if($_GET['currentpage'] > $ps){
      $_GET['currentpage'] = $ps;
    }
    $currentpage = $_GET['currentpage'];
    if(!isset($_GET['stt'])){
      $_GET['stt'] = 1;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ADEPRO - Quản lý Thẻ Xe</title>

    <!-- Google Font: Source Sans Pro -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="../../plugins/fontawesome-free/css/all.min.css"
    />
  </head>
  <body>
  <style>
<?php
    include "../../../guessIndex.css";
    include "../../../bootstrap.css";
?>
    th,td{
      text-align:center !important;
    }
    .form-group{
      display:grid;
      grid-template-columns: 40% 50%;
  gap: 10px;
    }
    .page-link{
      padding:10px !important;
    }
    /* .form-group label{
      width:200px;
    } */
    .errorMessenge {
        display: block;
        color: red;
        grid-column-start: 2;
        text-align: left;
        margin-bottom: 0;
        font-size:0.7rem;
    }
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
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-titl e">Danh sách tài khoản</h3>
             <div style="margin-left:auto;">
             <div class="input-group rounded">
                <input type="text" id="txtSearchAcc" name="txttimkiem_acc" class="form-control rounded" placeholder="Tìm kiếm theo Tên tài khoản, Họ và tên, CCCD" aria-label="Search" aria-describedby="search-addon" />
                <button class="input-group-text border-0" id="searchAddon">
                  <i class="fas fa-search"></i>
                </button>
              </div></div>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped projects">
                <thead>
                  <tr>
                    <th style="width: 1%">STT</th>
                    <th style="width: 10%">Tên tài khoản</th>
                    <th style="width: 10%">Mật khẩu</th>
                    <th style="width: 20%" class="text-center">Họ Tên</th>
                    <th style="width: 8%" class="text-center">Chức vụ</th>
                    <th style="width: 10%" class="text-center">CCCD</th>
                    <th style="width: 10%" class="text-center">Ngày sinh</th>
                    <th style="width: 8%" class="text-center">Giới tính</th>
                    <th style="width: 15%" class="text-center">
                    <?php
                    include "Account-add.php";
                    ?>
                  </th>
                  </tr>
                </thead>
                <tbody>
                <?php
                        // Create connection
              // $connection = new mysqli($servername, $username, $password, $database);
                    // read all row from database table
                if(isset($_GET['search'])){
                      $search=$_GET['search'];
                      if($currentpage<1){
                        $currentpage = 1;}
                        else{ $currentpage; }
                      $sql_limit = "select * from Account where display=1 and (userName like '%$search%' or name like '%$search%' or identityCard like '%$search%') limit " . ($currentpage-1)*$pagesize .",".$pagesize;
                }
                else{
                  $sql_limit = "select * from Account where display=1 limit ". ($currentpage-1)*$pagesize .",".$pagesize;
                }
                  $result = $conn->query($sql_limit);
                  $emp = $result->num_rows;
                    if (!$result) {
                die("Invalid query: " . $connection->error);
              }

                    // read data of each row
                    $s=$_GET['stt'];
              while($row = $result->fetch_assoc()) {
                if($row["display"]==1){
?>
                          <tr>
                            <td><?php echo($s) ?></td>
                            <td><?php echo($row["userName"]) ?></td>
                            <td><?php echo($row["password"]) ?></td>
                            <td><?php echo($row["name"]) ?></td>
                            <td><?php echo($row["position"]) ?></td>
                            <td><?php echo($row["identityCard"]) ?></td>
                            <td><?php echo($row["birth"]) ?></td>
                            <td>
                              <?php
                                if($row["sex"] == 1) {
                                  echo ("Nam");
                                }
                                if($row["sex"] == 0) {
                                  echo ("Nữ");
                                }
                              ?>
                            </td>
                            <td class='project-actions text-center'>
                              <button type="button" class="btn btn-default btnEditAccount" data-toggle="modal" data-target="#modal" data-user="<?php echo $row['userName']; ?>" data-stt="<?php echo $s; ?>">
                              <i class="fas fa-pen"></i>Edit
                              </button>
                              <button type='button' class='btn btn-danger btn_delete'  data-toggle='modal' data-target='#modalDel' data-user="<?php echo $row['userName']; ?>">
                                <i class='fas fa-trash'> </i>
                                Xóa
                              </button>
                            </td>
                        </tr>
<?php
                        $s++;
                }
              }
            
          

                    $conn->close();
                    
?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
<?php                    
                    if($ps!=1){ 
?>
                    <div aria-label="Page navigation">
                      <ul class="pagination justify-content-center">
                      <li>
                          <a class="page-link" href="Account.php?currentpage=1&stt=1"&search=<?php 
                            if(isset($_GET['search'])){
                              $search = $_GET['search'];
                              echo $search;
                            }
                          ?>>First</a>
                        </li>
                        <li class="page-item ">
                          <a class="page-link" href="Account.php?currentpage=<?php if($currentpage>1){ echo ($currentpage-1);}
                          else echo $currentpage;
                          ?>&stt=<?php if($currentpage>1){ echo ($currentpage-2)*$pagesize+1;}
                          else echo 1;
                          ?>&search=<?php 
                            if(isset($_GET['search'])){
                              $search = $_GET['search'];
                              echo $search;
                            }
                          ?>" tabindex="-1">Previous</a>
                        </li>
<?php 
                    if ($currentpage > 3) {
?>
                        <b style="margin-top: 7px;"> . . . </b>
<?php
                    }
                    for($i=1;$i<=$ps;$i++){
                      if(abs($currentpage-$i)<=2){
                        if($i==$currentpage){
?>
                          <li class='page-item'><a class='page-link' style='background-color:#ccc;' href='Account.php?currentpage=<?php echo $i; ?>&stt=<?php echo ($i-1)*$pagesize+1; ?>&search=<?php 
                            if(isset($_GET['search'])){
                              $search = $_GET['search'];
                              echo $search;
                            }
                          ?>'><?php echo $i; ?></a></li>
<?php
                        }
                        else{
?>
                          <li class='page-item'><a class='page-link' href='Account.php?currentpage=<?php echo $i; ?>&stt=<?php echo ($i-1)*$pagesize+1; ?>&search=<?php 
                            if(isset($_GET['search'])){
                              $search = $_GET['search'];
                              echo $search;
                            }
                          ?>'><?php echo $i; ?></a></li>
<?php
                      }}}
                      if ($ps - $currentpage > 2) {
?>
                          <b style="margin-top: 7px;"> . . . </b>
<?php
                      }
?>
                      </li>
                      <li>
                          <a class="page-link" href="Account.php?currentpage=<?php echo ($currentpage+1) ?>&stt=<?php if($currentpage<$ps){ echo ($currentpage)*$pagesize+1;}
                          else
                            echo ($currentpage-1)*$pagesize+1; ?>&search=<?php 
                            if(isset($_GET['search'])){
                              $search = $_GET['search'];
                              echo $search;
                            }
                          ?>">Next</a>
                        </li>
                        <li>
                          <a class="page-link" href="Account.php?currentpage=<?php echo $ps ?>&stt=<?php echo ($ps-1)*$pagesize+1; ?>&search=<?php 
                            if(isset($_GET['search'])){
                              $search = $_GET['search'];
                              echo $search;
                            }
                          ?>">Last</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <?php } ?>
                  <!-- /.card -->
        </section>
      </main>
<?php 
        // include "../../feedback-btn.html" ?>
<?php 
    include "../../footer.html" 
?> 
<?php 
    include "Account-edit.php";
    include "Account_delete_confirm.php";
?>
    <script src="../../plugins/jquery/jquery.min.js"></script>
  </body>
  
<!-- jquery  --> 
<script>
  // gửi dữ liệu từ client -> server thông qua ajax
  $(document).ready(function(){
    var EditAccountArr = $(".btnEditAccount");
    for(var i=0;i<EditAccountArr.length;i++){
      EditAccountArr[i].onclick = function(e){
        var user = $(this).data("user");
        $.ajax({
          url:"Account-edit-be-send.php",
          type:"post",
          dataType:"html",
          data:{
            user
          }
        }).done(function(rs){
          var row = JSON.parse(rs);
          var userName = row.userName;
          var name = row.name;
          var position = row.position;
          var identityCard = row.identityCard;
          var birth = row.birth;
          var sex = row.sex;

          
          $("#inputUser_Edit").val(userName);
          $("#inputName_Edit").val(name);
          $("#inputCCCD_Edit").val(identityCard);
          $("#inputBday_Edit").val(birth);
          // alert(userName +" "+ password +" "+ name +" "+ position +" "+ identityCard +" "+ birth +" "+ sex);
          $("#selectChucVu_Edit option[value='"+ position +"']").prop("selected", true);
          $("#selectGioiTinh_Edit option[value='"+ sex +"']").prop("selected", true);
        });
      };
    }
    var btn_delete_list_acc = $(".btn_delete");
    for (var i = 0; i < btn_delete_list_acc.length; i++) {
      btn_delete_list_acc[i].onclick = function(e)
      {
        var user = $(this).data("user");

        $("#btn_submit_delete_acc").attr("href", "Account_delete_be.php?userName="+ user)
      };
    }
    // lũ dưới nhìn có vẻ dài đấy nhưng thực chất chả khác nhau là mấy,có thể viết 1 function xong dùng cả lũ nhưng thôi,lỡ làm 1 cái r copy đi,xóa đi làm lại hơi mệt
    // edit account tb lỗi
          $id = $us = $na = true;
          $('#inputCCCD_Edit').on('input',function(){
              text = $('#inputCCCD_Edit').val();
              const regex = new RegExp(/^[0-9]{12}$/);
              if(regex.test(text)==false){
                $('#erMIdE').html("Nhập sai định dạng CCCD,phải toàn số");
                $('#submitEditAccount').attr("disabled",true);
                $id = false;
              }
              else{
                $('#erMIdE').html(" ");
                $id=true;
              }
              if($('#inputCCCD_Edit').val() == ""){
                $('#erMIdE').html("CCCD đang để trống");
                $('#submitEditAccount').attr("disabled",true);
                $id = false;
              }
          });
          $('#inputUser_Edit').on('input',function(){
              text = $('#inputUser_Edit').val();
              const regex = new RegExp(/^[a-z0-9_-]{3,16}$/);
              if(regex.test(text)==false){
                $('#erMUserE').html("Nhập sai định dạng User,3-16 kí tự chữ hoặc số,ko chứa kí tự đặc biệt");
                $('#submitEditAccount').attr("disabled",true);
                $us = false;
              }
              else{
                $('#erMUserE').html(" ");
                $us = true;
              }
              if($('#inputUser_Edit').val() == ""){
                $('#erMUserE').html("User đang để trống");
                $('#submitEditAccount').attr("disabled",true);
                $us = false;
              }
          });
          $('#inputName_Edit').on('input',function(){
              text = $('#inputName_Edit').val();
              const regex = new RegExp(/^[ A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ]{1,30}$/);
              if(regex.test(text)==false){
                $('#erMNameE').html("Nhập sai định dạng Tên,ko chứa kí tự đặc biệt,gồm 1-30 kí tự có thể có dấu");
                $('#submitEditAccount').attr("disabled",true);
                $na = false;
              }
              else{
                $('#erMNameE').html(" ");
                $na = true;
              }
              if($('#inputName_Edit').val() == ""){
                $('#erMNameE').html("Tên đang để trống");
                $('#submitEditAccount').attr("disabled",true);
                $na = false;
              }
          });
          // AddAccount thông báo lỗi
          //
          $idA = $usA = $naA = $paA = false;
          $('#inputCCCD').on('input',function(){
              text = $('#inputCCCD').val();
              const regex = new RegExp(/^[0-9]{12}$/);
              if(regex.test(text)==false){
                $('#erMIdA').html("Nhập sai định dạng CCCD,phải toàn số");
                $('#submitAddAccount').attr("disabled",true);
                $idA = false;
              }
              else{
                $('#erMIdA').html(" ");
                $idA=true;
              }
              if($('#inputCCCD').val() == ""){
                $('#erMIdA').html("CCCD đang để trống");
                $('#submitAddAccount').attr("disabled",true);
                $idA = false;
              }
          });
          $('#inputUser').on('input',function(){
              text = $('#inputUser').val();
              const regex = new RegExp(/^[a-z0-9_-]{3,16}$/);
              if(regex.test(text)==false){
                $('#erMUserA').html("Nhập sai định dạng User,3-16 kí tự chữ hoặc số,ko chứa kí tự đặc biệt");
                $('#submitAddAccount').attr("disabled",true);
                $usA = false;
              }
              else{
                $('#erMUserA').html(" ");
                $usA = true;
              }
              if($('#inputUser').val() == ""){
                $('#erMUserA').html("User đang để trống");
                $('#submitAddAccount').attr("disabled",true);
                $usA = false;
              }
          });
          $('#inputPassword').on('input',function(){
              text = $('#inputPassword').val();
              const regex = new RegExp(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/);
              if(regex.test(text)==false){
                $('#erMPassA').html("Nhập sai định dạng Password,tối thiểu 8 kí tự gồm chữ và số ko có kí tự đặc biệt");
                $('#submitAddAccount').attr("disabled",true);
                $paA = false;
              }
              else{
                $('#erMPassA').html(" ");
                $paA = true;
              }
              if($('#inputPassword').val() == ""){
                $('#erMPassA').html("Password đang để trống");
                $('#submitAddAccount').attr("disabled",true);
                $paA = false;
              }
          });
          $('#inputName').on('input',function(){
              text = $('#inputName').val();
              const regex = new RegExp(/^[ A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ]{1,30}$/);
              if(regex.test(text)==false){
                $('#erMNameA').html("Nhập sai định dạng Tên,ko chứa kí tự đặc biệt,gồm 1-30 kí tự có thể có dấu");
                $('#submitAddAccount').attr("disabled",true);
                $naA = false;
              }
              else{
                $('#erMNameA').html(" ");
                $naA = true;
              }
              if($('#inputName').val() == ""){
                $('#erMNameA').html("Tên đang để trống");
                $('#submitAddAccount').attr("disabled",true);
                $naA = false;
              }
          });
          $('.form-control').on('input',function(){
              if($id == true && $us == true && $na == true){
                $('#submitEditAccount').attr("disabled",false);
              }
              else{
                ;
              }
              if($idA == true && $paA == true && $usA == true && $naA == true){
                $('#submitAddAccount').attr("disabled",false);
              }
              else{
                ;
              }
        });
        //|| $('#inputUser').val() == "" || $('#inputName').val() == "" || $('#inputPassword').val() == "" 
        if($('#inputCCCD').val() == ""){
                $('#submitAddAccount').attr("disabled",true);
                $idA == false; 
                $('#erMIdA').html('CCCD đang để trống');
        }
        if($('#inputUser').val() == ""){
                $('#submitAddAccount').attr("disabled",true);
                $usA == false; 
                $('#erMUserA').html('UserName đang để trống');
        }
        if($('#inputPassword').val() == ""){
                $('#submitAddAccount').attr("disabled",true);
                $paA == false; 
                $('#erMPassA').html('Pass đang để trống');
        }
        if($('#inputName').val() == ""){
                $('#submitAddAccount').attr("disabled",true);
                $naA == false; 
                $('#erMNameA').html('Tên đang để trống');
        }
        if($idA == true && $paA == true && $usA == true && $naA == true){
                $('#submitAddAccount').attr("disabled",false);
        }
        else{
                ;
        }
          // $('.form-control').on('input',function(){
          //    fc = $('.form-control').val();
          //    if(fc === ""){
          //       $('.errorMessenge').html("Bạn đang để trống");
          //    }
          // })
<?php
      if (isset($_GET['search'])) {
?>
        $("#txtSearchAcc").val("<?php echo($_GET['search']) ?>");
<?php
      }
?> // ấn nút search
    $("#searchAddon").click(function(){
      var search = $("#txtSearchAcc").val();
      // if (search != "") {
        window.location.href = "Account.php?search="+ search;
        
      // }
    });
  });
</script>

<?php 
      }
    }
  }
?>