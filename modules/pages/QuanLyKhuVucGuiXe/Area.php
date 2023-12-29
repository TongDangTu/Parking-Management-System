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
<title>ADEPRO - Quản lý khu vực</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body>
<style>
    <?php include "../../../guessIndex.css";
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
    row-gap: 3px;

    }

    label {
    margin-top: auto;
    margin-bottom: auto;
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
    font-size: 0.7rem;
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
    <div id="error_box" class="alert alert-danger alert-dismissible fade show"
        style="position: sticky;top: 8vh;width: 100%; z-index:1; text-align: center;">
        <strong>Thất bại! </strong><span id="error">
        <?php echo ($_SESSION['error']) ?>
        </span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php
    // $_SESSION['error'] = "";
    unset($_SESSION['error']);
    }
} else {
    if (isset($_SESSION['success'])) {
    if ($_SESSION['success'] != "") {
        ?>
        <div id="error_box" class="alert alert-success alert-dismissible fade show"
        style="position: sticky;top: 8vh;width: 100%; z-index:1; text-align: center;">
        <strong>Thành công! </strong><span id="error">
            <?php echo ($_SESSION['success']) ?>
        </span>
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
        <h3 class="card-titl e">Danh sách khu vực</h3>
        <div style="margin-left:auto;">
            <div class="input-group rounded">
            <input type="search" id="txtSearch" class="form-control rounded"
                placeholder="Tìm kiếm theo tên khu" aria-label="Search"
                aria-describedby="search-addon" />
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
                <th style="width: 5%">#</th>
                <th style="width: 15%">Tên khu</th>
                <th style="width: 15%">Loại xe</th>
                <th style="width: 15%">Số xe tối đa</th>
                <th style="width: 15%" class="text-center">Số xe hiện tại</th>
                <th style="width: 20%" class="text-center">
                <?php
                include "Area-add.php";
                ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql = "SELECT * FROM area WHERE (areaName like '%$search%') AND (area.display = 1)";
            } else {
                $sql = "SELECT * FROM area WHERE area.display = 1";
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
                if ($current_page > $number_pages) {
                $current_page = $number_pages;
                }
                if ($current_page < 1) {
                $current_page = 1;
                }
            } else {
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
                    <?php echo ($row["areaName"]) ?>
                    </td>
                    <td>
                    <?php echo ($row["vehicleType"]) ?>
                    </td>
                    <td>
                    <?php echo ($row["maxSize"]) ?>
                    </td>
                    <td>
                    <?php echo ($row["currentSize"]) ?>
                    </td>
                    <td class='project-actions text-center'>
                    <button type="button" class="btn btn-default btn_edit" data-toggle="modal" data-target="#modal" id="btn_edit_<?php echo ($row["areaName"]) ?>" data-areaname="<?php echo ($row["areaName"]) ?>">
                        <i class="fas fa-solid fa-pen-to-square"></i>
                        Edit
                    </button>

                    <button type="button" class='btn btn-danger btn_delete' data-toggle="modal" data-target="#modalDel" id="btn_delete_<?php echo ($row["areaName"]) ?>" data-areaname="<?php echo ($row["areaName"]) ?>">
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
                <a class="page-link"
                href="?page=1<?php if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    echo ("&search=" . $_GET['search']);
                } ?>">
                <<</a>
            </li>
            <li class="page-item ">
                <a class="page-link"
                href="?page=<?php echo (($current_page - 1)) ?><?php if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    echo ("&search=" . $_GET['search']);
                    } ?>">
                <</a>
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
                    <li class="page-item"><a class="page-link"
                        href="?page=<?php echo ($i) ?><?php if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            echo ("&search=" . $_GET['search']);
                        } ?>"
                        style="background-color: #ccc;"><?php echo ($i) ?></a></li>
                    <?php
                } else {
                    ?>
                    <li class="page-item"><a class="page-link"
                        href="?page=<?php echo ($i) ?><?php if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            echo ("&search=" . $_GET['search']);
                        } ?>"><?php echo ($i) ?></a></li>
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
                <a class="page-link"
                href="?page=<?php echo (($current_page + 1)) ?><?php if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    echo ("&search=" . $_GET['search']);
                    } ?>">></a>
            </li>
            <li class="page-item">
                <a class="page-link"
                href="?page=<?php echo ($number_pages) ?><?php if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    echo ("&search=" . $_GET['search']);
                    } ?>">>></a>
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
<?php include "../../footer.html" ?>
<?php include "Area-edit.php" ?>
<?php include "Area-delete.php" ?>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
</body>

</html>
      <?php
    }
  }
}
?>

<script>
    $(document).ready(function () {
// Form Add
        // Báo lỗi regex form Add
        errorRegexFormAdd();
        // Listen Event: oninput
        function errorRegexFormAdd () {
            txtAreaName_Add.oninput = function() {
                // alert("Haha");
                checkRegexFormAdd("txtAreaName_Add");
                this.setCustomValidity('');
            };
            
            txtMaxSize_Add.oninput = function() {
                checkRegexFormAdd("txtMaxSize_Add");
                this.setCustomValidity('');
            };
        }
        
        // Check regex form Add, and display error
        function checkRegexFormAdd (id) {
            var isValid = true;
            var content = $("#txtAreaName_Add").val();
            var pattern = "^[A-Z0-9]{1,5}$";
            var text = content;
            if (text.match(pattern)) {
                $("#errorAreaName_Add").html(".");
            }
            else {
                if (id == "txtAreaName_Add") {
                    $("#errorAreaName_Add").html("Tên khu chỉ được phép tối đa 5 ký tự. Chỉ bao gồm chữ cái in hoa và chữ số.");
                }
                isValid = false;
            }
            var content = $("#txtMaxSize_Add").val();
            var pattern = "^\\d{1,}$";
            var text = content;
            if (text.match(pattern)) {
                $("#errorMaxSize_Add").html(".");
            }
            else {
                if (id == "txtMaxSize_Add") {
                    $("#errorMaxSize_Add").html("Số xe tối đa phải là số");
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

        $("#btn_reset_add").click(function(){
            $("#txtAreaName_Add").val("");
            $("#txtMaxSize_Add").val("");

            $("#errorAreaName_Add").html(".");
            $("#errorMaxSize_Add").html(".");

            abledButtonAdd(true);
        });

// Form Edit
        // Lấy ID khi click vào Edit bản ghi
        // Lấy data của nút khi click bằng AJAX
        var btn_edit_list = $(".btn_edit");
        for (var i = 0; i < btn_edit_list.length; i++) {
            btn_edit_list[i].onclick = function(e)
            {
                e.preventDefault();   // Không cho phép chuyển trang
                var areaName = $(this).data("areaname");

                $.ajax({
                url: "Area-edit-action-ajax.php",
                type: "post",
                dataType: "html",
                data : {
                    areaName
                }
                }).done(function(result){
                    const row = JSON.parse(result);
                    $("#txtAreaName_Edit").attr("value",row.areaName);
                    $("#selectVehicleType_Edit option").prop('selected', false);
                    $("#selectVehicleType_Edit option[value='"+ row.vehicleType +"']").prop('selected', true);
                    $("#txtMaxSize_Edit").val(row.maxSize);
                });
            };
        }

        // Báo lỗi regex form Edit
        errorRegexFormEdit();
        // Listen Event: oninput
        function errorRegexFormEdit () {
            txtAreaName_Edit.oninput = function() {
                // alert("Haha");
                checkRegexFormEdit("txtAreaName_Edit");
                this.setCustomValidity('');
            };
            
            txtMaxSize_Edit.oninput = function() {
                checkRegexFormEdit("txtMaxSize_Edit");
                this.setCustomValidity('');
            };
        }
        
        // Check regex form Edit, and display error
        function checkRegexFormEdit (id) {
            var isValid = true;
            var content = $("#txtAreaName_Edit").val();
            var pattern = "^[A-Z0-9]{1,5}$";
            var text = content;
            if (text.match(pattern)) {
                $("#errorAreaName_Edit").html(".");
            }
            else {
                if (id == "txtAreaName_Edit") {
                    $("#errorAreaName_Edit").html("Tên khu chỉ được phép tối đa 5 ký tự. Chỉ bao gồm chữ cái in hoa và chữ số.");
                }
                isValid = false;
            }
            var content = $("#txtMaxSize_Edit").val();
            var pattern = "^\\d{1,}$";
            var text = content;
            if (text.match(pattern)) {
                $("#errorMaxSize_Edit").html(".");
            }
            else {
                if (id == "txtMaxSize_Edit") {
                    $("#errorMaxSize_Edit").html("Số xe tối đa phải là số");
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

        $("#btn_reset_edit").click(function(){
            $("#txtAreaName_Edit").val("");
            $("#txtMaxSize_Edit").val("");

            $("#errorAreaName_Edit").html(".");
            $("#errorMaxSize_Edit").html(".");

            abledButtonEdit(true);
        });

// Delete
        // Lấy areaName khi click vào Delete bản ghi
        var btn_delete_list = $(".btn_delete");
        for (var i = 0; i < btn_delete_list.length; i++) {
            btn_delete_list[i].onclick = function(e)
            {
                var areaName = $(this).data("areaname");

                $("#btn_submit_delete").attr("href", "Area-delete-action.php?areaName="+ areaName);
            };
        }
    });

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
        window.location.href = "Area.php?search="+ search;
        });
</script>