<?php

    include('../libraries/application_top.php');
	
/*
 * Σελίδα "Register", δήλωση νέου χρήστη. Προσοχή,
 * αν ο χρήστης είναι συνδεδεμένος ήδη, αυτή η σελίδα σε κάνει redirect
 * στη σελίδα new_calendar.php
 */

	if(user_is_loged()){	
	header("Location: " . CALENDAR_PAGE . "");
	exit;	
	}
	
    include(HEADER_MENU);

/*
 * Εδω με τη χρήση του $_POST βλέπουμε αν έχει "ποσταριστεί" η φόρμα.Κοινώς αν έχει πατηθεί το submit και αναλόγως πράττουμε . Η φόρμα
 * κάνει redirection σε αυτο το page από τη στιγμή που το action attribute είναι κενό.
 */

if ( $_POST ) {
	
    $conn = connect_to_db(); // Συνδεόμαστε στη βάση.
	
	// Τα πεδία της φόρμας τα παίρνουμε με τον παρακάτω τρόπο μετά το submit.

    // ΚΑΝΟΥΜΕ sanitization !!!
	$firstname = htmlspecialchars(strip_tags(trim($_POST['firstname'])));
	$lastname  = htmlspecialchars(strip_tags(trim($_POST['lastname'])));
	$email     = htmlspecialchars(strip_tags(trim($_POST['email'])));
	$username  = htmlspecialchars(strip_tags(trim($_POST['username'])));
	// Κρυπτογράφηση κωδικού πρόσβασης
	// ###################################################################
	$password  = htmlspecialchars(strip_tags(trim($_POST['password'])));
    $Salt      = uniqid();
    $Algo      = '6';
    $Rounds    = '5000';
    $CryptSalt = '$' . $Algo . '$rounds=' . $Rounds . '$' . $Salt;
    $password  = crypt($password, $CryptSalt);			
	// ###################################################################					
									
	$alert_code    = ''; // Αρχικοποίηση για μετά .
	$alert_message = '';

	$contains_empty = in_array( "", $_POST, true ); // Εαν αυτο δώσει 1 ή true σημαίνει ότι κάτι δεν έχουμε συμπληρώσει.

	if ( $contains_empty == true ) { // Πρώτα ελέγχουμε αν ενα η ολα τα πεδία της φόρμας είναι άδεια.
	
		$alert_code    = 'warning';
		$alert_message = 'Πρέπει να συμπληρωθούν ολα τα πεδία της φόρμας';

	} elseif ( check_unique_email($conn, $email ) == false ){ // Πλεόν γνωρίζουμε ότι ολα τα πεδία ειναι συμπληρωμένα άρα ελέγχουμε την μοναδικότητα του email.

		$alert_code    = 'danger';
		$alert_message = 'Το email έχει δηλωθεί.';
		
	} elseif ( filter_var($email, FILTER_VALIDATE_EMAIL ) === false){ // ελέγχουμε την ορθότητα του email

		$alert_code    = 'warning';
		$alert_message = 'Το email δεν έχει σωστή μορφή.';
		
	
	} elseif ( check_unique_username($conn, $username ) == false ){ // ελέγχουμε την μοναδικότητα του username.

		$alert_code    = 'danger';
		$alert_message = 'Το username έχει δηλωθεί.';
	}

	else{ // όλα είναι οκ ας βάλουμε τον χρήστη στη βάση.
	
		$insert = register_new_user($conn, $firstname, $lastname, $email, $username, $password);
		
		if($insert == false){
			
			$alert_code    = 'warning';
			$alert_message = 'Κάτι πήγε στραβά.';
			
		}else{
			
			$alert_code    = 'success';
			$alert_message = 'Ο νέος χρήστης προστέθηκε επιτυχώς.Παρακαλώ εισέλθετε στην εφαρμογή  <a href="login.php"><b>εδώ</b></a>'; // Τον προτρέπουμε να πάει να συνδεθει στη σελιδα login.php
		}
	}
}
?>

	<div class="main-content-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Δημιουργήστε λογαριασμό</h1>
					<h5>
						<a href="login.php">Μήπως έχετε ήδη λογαριασμό; Συνδεθείτε ΕΔΩ</a>
					</h5>
					<hr/>
					<!--
						Εδώ δημιουργούμε την register form και αντιστοιχίζουμε τα πεδία
						που έχουμε στη βαση με αυτά . Φρόντίζουμε στο name attribute να είναι πεδία
						αντίστοιχα με αυτα στη βάση.
						Στη φόρμα χρησιμοποιούμε Method= Post γιατί θα στείλουμε και κωδικο και δεν θελουμε να
						φαίνεται στο URL όπως και θα γινόταν άν χρησιμοποιούσαμε το GET.
					-->
					<form class="register-form" method="POST" action="" id="registeruser">					
					<?php
					// Εδώ μας εμφανίζει το alert.
					if ( $_POST ) {
					?>
						<div class="form-group">
            	           <div class="alert alert-<?php echo $alert_code; ?>">
				              <span class="glyphicon glyphicon-info-sign"></span> <?php echo $alert_message; ?>
                          </div>
            	        </div>
					<?php } ?>					
						<div class="form-group">
							<div class="input-group">  
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Όνομα">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Επώνυμο">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
							<input type="email" class="form-control" name="email" id="email" placeholder="Διεύθυνση Email">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" id="username" name="username" placeholder="Όνομα Χρήστη">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" class="form-control" id="password" name="password" placeholder="Κωδικός Πρόσβασης">
							</div>
						</div>
						<div class="form-group">
						<button type="submit" class="btn btn-default">Εγγραφή</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<?php
include(FOOTER);
include(APPLICATION_BOTTOM_SCRIPT);
?>