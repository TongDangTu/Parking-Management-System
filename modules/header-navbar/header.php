<?php
  if ($_SESSION['position'] == "Nhân viên") {
    include "../../header-navbar/header-employee.html";
  }
  else {
    if ($_SESSION['position'] == "Admin") {
      include "../../header-navbar/header-admin.html";
    }
  }
?>