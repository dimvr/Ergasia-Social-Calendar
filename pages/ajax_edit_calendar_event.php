<?php

include('../libraries/application_top.php');

if(!empty($_POST['ajaxEventID']) && !empty($_POST['ajaxEditTitle']) && !empty($_POST['ajaxEditTime']) && !empty($_POST['ajaxEditDescription'])){

header('Content-Type: text/html; charset=utf-8');

$events_id           = trim($_POST['ajaxEventID']);
$events_title        = trim($_POST['ajaxEditTitle']);
$events_time         = trim($_POST['ajaxEditTime']);
$events_description  = trim($_POST['ajaxEditDescription']);

$conn = connect_to_db();		 
		 
$sql = "UPDATE events 
        SET    events_title       = '" . $events_title       . "',
               events_time        = '" . $events_time        . "',
               events_description = '" . $events_description . "' 
        WHERE  events_id          =  " . $events_id          . "";

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
