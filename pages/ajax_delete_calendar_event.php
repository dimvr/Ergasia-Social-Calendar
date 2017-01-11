<?php

include('../libraries/application_top.php');

if(!empty($_POST['dlEventsID'])){
	
header('Content-Type: text/html; charset=utf-8');

$events_id  = $_POST['dlEventsID'];

$conn = connect_to_db();
		 
// ΔΙΑΓΡΑΦΗ ΑΠΟ ΤΟΝ ΠΙΝΑΚΑ events		 
$sql = "DELETE FROM events WHERE events_id = " . $events_id . "";
mysqli_query($conn, $sql);

// ΔΙΑΓΡΑΦΗ ΑΠΟ ΤΟΝ ΠΙΝΑΚΑ events_alerts
$sql = "DELETE FROM events_alerts WHERE events_alerts_events_id = " . $events_id . "";
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