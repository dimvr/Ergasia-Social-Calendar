<?php
/**
 * Το αρχείο αυτό είναι στην ουσία η σύνδεση της βάσης με PHP και μπορούμε να το χρησιμοποιούμε με
 * require_once στις σελίδες που το θέλουμε. Επίσης περιέχει διάφορα απλα functions που σχετίζονται με τη βάση και οχι
 * μόνο.
 */

/*
 * 1. mysqli_connect. Συνδέομαστε με την βάση.
 * Το χρησιμοποιούμε για το register κλπ.
 */
function connect_to_db(
	$server,
	$user,
	$pass,
	$dbname
) {
	$servername = $server;
	$username   = $user;
	$password   = $pass;
	$conn       = mysqli_connect( $servername, $username, $password,$dbname );
		mysqli_set_charset($conn, "utf8");
	if ( ! $conn ) {
		die( "Connection failed: " . mysqli_connect_error() );
	}

	return $conn;
}

/*
 * 2. Κατα τη διαδικασία του register πρέπει να ελέγξουμε άν έχουμε unique
 * email αλλιώς η εγγραφή δεν πραγματοποιείται.
 */
function check_unique_email($conn, $email ) {

	$sql = "SELECT * FROM users WHERE email ='".$email."'";
	$result = mysqli_query($conn,$sql);

	$rows = mysqli_num_rows($result);
	if($rows >= 1){
		return false;
	}else{
		return true; // Είναι μοναδικό το email μας.
	}
}

/*
 * 3. Εδώ εγγράφουμε τον χρήστη στη βάση. Αν γίνουν ολα σωστά τότε θα μας κάνει redirect στο
 * mycalendar.php και θα έχει και loggedin session variable true.
 *
 */
function register_new_user($conn,$firstname ,$lastname, $email, $username, $password) {

	$sql = "INSERT INTO users(firstname, lastname,email, username, password) VALUES('$firstname','$lastname','$email','$username','$password')";

	if (mysqli_query($conn, $sql)) {
		return true;
	} else {
		return false;
	}
}

/*
 * 4. Check login status. Με την function αυτή ελέγχουμε αν είμαστε logged in.
 * Στην ουσια ελέγχουμε τη Session variable $_Session['isloggedin'].
 */
function log_user_in(){

}
/*
 * Alerts. Ανάλογα με το τι δίνουμε , εμφανίζει το αντίστοιχο alert.
 */

function show_alert(
	$alert_code,
	$alert_message
) {
	/*
	 * Το alert code στην ουσία ειναι μία class για το css που μας δίνει το ιδιο το bootstrap πχ danger, info, success
	 */

	if ( $alert_code != '' && $alert_message != '' ):
		$html = '<div class="alert alert-' . $alert_code . ' alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html .= $alert_message . '</div>';

		return $html;
	else:
		return false;
	endif;
}