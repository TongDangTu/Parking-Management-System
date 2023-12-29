<?php
    session_start();
    include "../../../connection.php";
    $send = $_POST['user'];
    //$crp = $_GET['currentpage'];
    $_SESSION['txtuser_edit_ajax'] = $send;
    //$_SESSION['crp_edit_ajax'] = $crp;
    $sql = "select * from account where display=1 and userName='". $send ."';";
   // $_SESSION['user_edit']=mysqli_query($conn,$sql);
    $Editarr = array();
    $Edit=mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($Edit)){
        $Editarr['userName'] = $row['userName'];
        $Editarr['name'] = $row['name'];
        $Editarr['position'] = $row['position'];
        $Editarr['identityCard'] = $row['identityCard'];
        $Editarr['birth'] = $row['birth'];
        $Editarr['sex'] = $row['sex'];
    }

    $encode = json_encode($Editarr, JSON_UNESCAPED_UNICODE);
    echo($encode);
?>