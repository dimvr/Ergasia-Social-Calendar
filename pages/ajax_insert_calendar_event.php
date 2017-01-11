<?php

include('../libraries/application_top.php');

if(!empty($_POST['ajaxUserID']) && !empty($_POST['ajaxDate'])){

header('Content-Type: text/html; charset=utf-8');

$events_users_id           = trim($_POST['ajaxUserID']);
$events_users_name         = trim($_POST['ajaxUserName']);
$events_date               = trim($_POST['ajaxDate']);
$events_time               = trim($_POST['ajaxTime']);
$events_title              = trim($_POST['ajaxTitle']);
$events_description        = trim($_POST['ajaxDescription']);
$events_datetime_inserted  = ''.date('Y-m-d H:i:s').'';
		 
$conn = connect_to_db();
		 
$sql = "INSERT INTO events(events_users_id, 
                           events_users_name, 
						   events_date, 
						   events_time, 
						   events_title, 
						   events_description, 
						   events_datetime_inserted
						   ) 
						   VALUES('".$events_users_id."',
						          '".$events_users_name."',
								  '".$events_date."',
								  '".$events_time."',
								  '".$events_title."',
								  '".$events_description."',
								  now()
								  )";

if (mysqli_query($conn, $sql)) {
	echo '1';
	} else {
	echo '0';
	}
	
}else{
		
header("Location: " . MAIN_PAGE . "");
exit;
	
}	
		
?>
