<?php
	function check_login($con)
	{
		if(isset($_SESSION['admin_id']))
		{
			$id = $_SESSION['admin_id'];
			$query = "SELECT * FROM admin WHERE admin_id = '$id' limit 1";
			
			$result = mysqli_query($con,$query);
			if($result && mysqli_num_rows($result)>0)
			{
				$admin_data = mysqli_fetch_assoc($result);
				return $admin_data;
			}
		}
		//redirect to login
		header("Location: adminlogin.php");
		die;
	}
	function random_num($length)
	{
		$text = "";
		if($length < 5)
		{
			$length = 5;
		}
		$len = rand(4,$length);
		
		for ($i=0; $i < $len; $i++)
		{
			$text .= rand(0,9); 
		}
		
		return $text;
	}
	// functions.php

	function getInitialDeposit($con, $reservationId) {
		// Assuming you have a table named 'booktable' with a column 'initial_deposit'
		$query = "SELECT initial_deposit FROM booktable WHERE reservation_id = '$reservationId' LIMIT 1";
	
		$result = mysqli_query($con, $query);
	
		if ($result && mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			return $row['initial_deposit'];
		} else {
			// Default value or handle the case when no initial deposit is found
			return 0;
		}
	}

?>