<?php
include('../libraries/application_top.php');

	session_start();
	
	if (!isset($_SESSION['systemuser'])) {
		
		header("Location: " . MAIN_PAGE . "");
		
	} else if(isset($_SESSION['systemuser'])!="") {
		
		header("Location: " . MAIN_PAGE . "");
		
	}
	
	if (isset($_GET['logout'])) {
		
		$conn  = connect_to_db();
		$sql = "UPDATE users SET users_logged_in = '0' WHERE users_id = " . $_SESSION['systemuser'] . "";
		mysqli_query($conn,$sql);
		
	    unset($_SESSION['systemuser']);
        unset($_SESSION['username']);
        unset($_SESSION['firstname']);
        unset($_SESSION['lastname']);
        unset($_SESSION['email']);
		
		session_unset();
		
		session_destroy();
		
		header("Location: " . MAIN_PAGE . "?");
		
		exit;
	}
		
include(APPLICATION_BOTTOM_SCRIPT);
	
?>
