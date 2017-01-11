<?php

include('../libraries/application_top.php');

if(!empty($_POST['SRajaxEventID']) && !empty($_POST['SRajaxReceiverName']) && !empty($_POST['SRajaxReveiverEmail']) && !empty($_POST['SRajaxEventTitle']) && !empty($_POST['SRajaxEventDescription']) && !empty($_POST['SRajaxEventDateTime'])){

$response_data = '';
	
header('Content-Type: text/html; charset=utf-8');
 
$this_event_id    = $_POST['SRajaxEventID'];
$this_event_title = $_POST['SRajaxEventTitle'];
$this_event_descr = $_POST['SRajaxEventDescription'];
$this_event_date  = $_POST['SRajaxEventDateTime'];
$email_from_email = $_SESSION['email'];
$email_from_name  = '' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . '';
$email_to_email   = trim($_POST['SRajaxReveiverEmail']);
$email_to_name    = trim($_POST['SRajaxReceiverName']);
 
// Πρώτα ελέγχω εάν ο χρήστης προσπαθεί να στείλει κοινοποίηση στον εαυτό του, οπότε δε κάνω καμία ενέργεια

if($email_from_email == $email_to_email){

$response_data .= '<span style="color:red"><b>Δε μπορείτε να κοινοποιήσετε γεγονός στον εαυτό σας !</b></span>';

}else{	
 
$conn = connect_to_db();		 
		 
// Έπειτα ελέγχω εάν το email που δόθηκε αντιστοιχεί σε κάποιον εγγεγραμμένο χρήστη του συστήματος
// ώστε να αντιστοιχίσω το γεγονός με το ID του χρήστη για να εμφανίζεται και στο δικό του ημερολόγιο
		 
$query = "SELECT users_id, firstname, lastname, email FROM users WHERE email = '" . $email_to_email . "'";
$res   = mysqli_query($conn,$query);
$row   = mysqli_fetch_array($res, MYSQLI_ASSOC);
$count = mysqli_num_rows($res);  
  
if($count == 1) {
		
// Ο χρήστης υπάρχει στο σύστημα άρα θα λάβει email και θα γίνει εγγραφή (αν δεν έχει ήδη γίνει) του γεγονότος στο ημερολόγιό του

$response_data .= 'Ο χρήστης ' . $row['firstname'] . ' ' . $row['lastname'] . ' <span style="color:green">είναι εγγεγραμμένος</span> στο MyCalendar<br>';
	
$events_alerts_events_id  = $this_event_id;
$events_alerts_users_id   = $row['users_id'];

$qsquery  = "SELECT events_alerts_events_id, events_alerts_users_id FROM events_alerts WHERE events_alerts_users_id = " . $events_alerts_users_id . " AND events_alerts_events_id = " . $events_alerts_events_id . "";
$qsresult = mysqli_query($conn,$qsquery);
$qscount  = mysqli_num_rows($qsresult);

if($qscount == 0) {

$sql = "INSERT INTO events_alerts(events_alerts_events_id, events_alerts_users_id) VALUES('" . $events_alerts_events_id . "', '" . $events_alerts_users_id . "')";

if (mysqli_query($conn, $sql)) {
	
$response_data .= 'και η εγγραφή στο ημερολόγιό του <span style="color:green">ήταν επιτυχής</span> !<br>';
	
}else{
		
$response_data .= 'αλλά η εγγραφή στο ημερολόγιό του <span style="color:red">δεν ήταν επιτυχής</span> !<br>';
	
}

}else{

$response_data .= 'αλλά το γεγονός <span style="color:red">έχει ήδη εγγραφεί</span> στο ημερολόγιό του !<br>';	
	
}


}else{
	
// Ο χρήστης δεν υπάρχει στο σύστημα και θα λάβει μόνο email για το γεγονός

$response_data .= 'Ο χρήστης '.$email_to_name.' <span style="color:red">δεν είναι εγγεγραμμένος</span> στο MyCalendar !<br>';	

}	
 
require( CLASSES_DIR.'PHPMailerAutoload.php' );

date_default_timezone_set('Europe/Athens'); 

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug   = 0;  //Enable SMTP debugging : 0 = off (for production use), 1 = client messages, 2 = client and server messages
$mail->Debugoutput = 'html';
$mail->Host        = 'smtp.gmail.com';
$mail->Port        = 587;
$mail->CharSet     = 'utf-8';
$mail->SMTPSecure  = 'tls';
$mail->SMTPAuth    = true;
$mail->Username    = "ddanewcalendar@gmail.com";
$mail->Password    = "C@1lend@2r";
$mail->setFrom('' . $email_from_email . '', '' . $email_from_name . '');
$mail->addReplyTo('' . $email_from_email . '', '' . $email_from_name . '');
$mail->addAddress('' . $email_to_email . '', '' . $email_to_name . '');
$mail->Subject = 'Ειδοποίηση από το DDA Calendar για κάποιο γεγονός !';


$mail_bd    = file(EMAIL_TEMPLATES."email_template_share_event.html");

$email_body = '';

foreach ($mail_bd as $line_num => $line)
{
  $CLEAR_LINE = str_replace('$RECEIVERSNAME$',    $email_to_name,         $line);
  $CLEAR_LINE = str_replace('$FIRSTNAME$',        $_SESSION['firstname'], $CLEAR_LINE);
  $CLEAR_LINE = str_replace('$LASTNAME$',         $_SESSION['lastname'],  $CLEAR_LINE);
  $CLEAR_LINE = str_replace('$EVENTTITLE$',       $this_event_title,      $CLEAR_LINE);
  $CLEAR_LINE = str_replace('$EVENTDESCRIPTION$', $this_event_descr,      $CLEAR_LINE);
  $CLEAR_LINE = str_replace('$EVENTDATETIME$',    $this_event_date,       $CLEAR_LINE);
  $email_body .= $CLEAR_LINE;
}

$mail->msgHTML($email_body);
$mail->AltBody = 'Παρακαλούμε χρησιμοποιήστε έναν email client που υποστηρίζει HTML για να δείτε αυτό το μήνυμα';

if (!$mail->send()) {
	
$response_data .= 'Η αποστολή του email προς τον χρήστη "' . ($count == 1 ? $row['firstname'] . ' ' . $row['lastname']  : $email_to_name) . '" <span style="color:red">απέτυχε</span> !';	
} else {
$response_data .= 'Η αποστολή του email <span style="color:green">πραγματοποιήθηκε</span> επιτυχώς προς τον χρήστη "' . ($count == 1 ? $row['firstname'] . ' ' . $row['lastname']  : $email_to_name) . '" !';
}

}
	 
}else{
	
$response_data .= 'Παρακαλούμε συμπληρώστε όλα τα απαιτούμενα πεδία (Ονοματεπώνυμο και Email παραλήπτη)';
	
}

echo $response_data;

?>