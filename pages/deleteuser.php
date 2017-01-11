<?php

include('../libraries/application_top.php');

$userID = $_SESSION['systemuser'];
$conn = connect_to_db();
$del=delete_user($conn,$userID);

session_unset();
		
		session_destroy();
		
		header("Location: " . MAIN_PAGE . "");
		
		exit;

?>


