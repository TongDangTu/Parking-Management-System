<?php

function check_login($conn)
{

	if(isset($_SESSION['identityCard']))
	{

		$id = $_SESSION['identityCard'];
		$query = "select * from Account where identityCard = '$id'";

		$result = sqlsrv_query($conn,$query);
		if($result && sqlsrv_num_rows($result) > 0)
		{

			$user_data = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
			return $user_data;
		}
		else{
			echo "Không có thông tin trên hệ thống";
		}
	}

	//redirect to login
	header("Location: login.php");
	die;

}