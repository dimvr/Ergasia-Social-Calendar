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

function connect_to_db() { // cc
	$conn  = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
             mysqli_set_charset($conn, "utf8");		
	if ( ! $conn ) {
		die( "Η σύνδεση με τον διακομιστή της βάσης δεδομένων απέτυχε : " . mysqli_connect_error() );
	}
	return $conn;
}

/*
 * 2. Κατα τη διαδικασία του register πρέπει να ελέγξουμε άν έχουμε unique
 * email αλλιώς η εγγραφή δεν πραγματοποιείται.
 */
function check_unique_email($conn, $email ) {

	$sql    = "SELECT * FROM users WHERE email = '" . $email . "'";
	$result = mysqli_query($conn,$sql);
	$rows   = mysqli_num_rows($result);
	
	if($rows >= 1){
		
		return false;
		
	}else{
		
		return true; // Είναι μοναδικό το email μας.
		
	}
}

/*
 * 2a. Κατα τη διαδικασία του register πρέπει να ελέγξουμε άν έχουμε unique
 * username αλλιώς η εγγραφή δεν πραγματοποιείται.
 */
function check_unique_username($conn, $username ) {

	$sql    = "SELECT * FROM users WHERE username = '" . $username . "'";
	$result = mysqli_query($conn,$sql);
	$rows   = mysqli_num_rows($result);
	
	if($rows >= 1){
		
		return false;
		
	}else{
		
		return true; // Είναι μοναδικό το username μας.
		
	}
}
function check_unique_username2($conn, $username ) {

	$sql    = "SELECT * FROM users WHERE username = '" . $username . "' AND username != '" . $_SESSION['username'] . "'";
	$result = mysqli_query($conn,$sql);
	$rows   = mysqli_num_rows($result);
	
	if($rows >= 1){
		
		return false;
		
	}else{
		
		return true; // Είναι μοναδικό το username μας.
		
	}
}

/*
 * 3. Εδώ εγγράφουμε τον χρήστη στη βάση. Αν γίνουν ολα σωστά τότε θα μας κάνει redirect στο
 * mycalendar.php και θα έχει και loggedin session variable true.
 *
 */
function register_new_user($conn,$firstname ,$lastname, $email, $username, $password) {

	$sql = "INSERT INTO users(firstname, lastname, email, username, password) VALUES('" . $firstname . "', '" . $lastname . "', '" . $email . "', '" . $username . "', '" . $password . "')";

	if (mysqli_query($conn, $sql)) { // Αν τρέξει επιτυχώς το query μας δίνει true, οπότε επιστρέφουμε true (return true)
		return true;
	} else {
		return false;
	}
}
function update_user($conn, $firstname ,$lastname, $username, $password) {

	$sql = "UPDATE users SET firstname='" . $firstname . "', lastname='" . $lastname . "', username='" . $username . "', password='" . $password . "' WHERE users_id ='" . $_SESSION['systemuser'] . "'";

	mysqli_query($conn,$sql);
	
	$_SESSION['username']   = $username;
	$_SESSION['firstname']  = $firstname;
	$_SESSION['lastname']   = $lastname;
}

function delete_user($conn,$userID) {
	
	$sql="DELETE FROM users WHERE users_id = " . $userID . "";
	mysqli_query($conn,$sql);
	
	$sql="DELETE FROM events WHERE events_users_id = " . $userID . "";
	mysqli_query($conn,$sql);
	
	$sql="DELETE FROM events_alerts WHERE events_alerts_users_id = " . $userID . "";
	mysqli_query($conn,$sql);	
}

/*
 * 4. Check login status. Με την function αυτή ελέγχουμε αν είμαστε logged in.
 * Στην ουσια ελέγχουμε τη Session variable $_SESSION['systemuser'].
 */

function user_is_loged(){ // cc  
 
	 if ( isset($_SESSION['systemuser']) && $_SESSION['systemuser']!='' ) {
		 
		 return true;
		 
	 }else{
		 
		 return false; 
	 }
}

function user_is_not_loged(){ // cc  
    	  
	 if ( !isset($_SESSION['systemuser']) || $_SESSION['systemuser']=='' ) {
		 
		 header("Location: " . LOGIN_PAGE . "");		 
		 
	 }
}