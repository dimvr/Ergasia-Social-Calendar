<?php
/*
 * Σελίδα "Register", δήλωση νέου χρήστη. Προσοχή,
 * αν ο χρήστης είναι συνδεδεμένος ήδη, αυτή η σελίδα σε κάνει redirect
 * στη σελίδα mycalendar.php
 */
require_once( '../libraries/mysql-stuff.php' ); // Εδώ θα χρειαστούν κάποια functions από εδώ.

include( '../template-parts/header.php' );

/*
 * Εδω με τη χρήση του $_POST βλέπουμε αν έχει "ποσταριστεί" η φόρμα.Κοινώς αν έχει πατηθεί το submit και αναλόγως πράττουμε . Η φόρμα
 * κάνει redirection σε αυτο το page από τη στιγμή που το action attribute είναι κενό.
 */

if ( $_POST ) {
	$conn = connect_to_db('localhost','mycalendaruser','myc@lendar','diforozi_mycalendar'); // Συνδεόμαστε στη βάση.

	// Τα πεδία της φόρμας τα παίρνουμε με τον παρακάτω τρόπο μετά το submit.

	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = md5($_POST['password']); // Το password το αποθηκεύουμε σαν md5 hash για κρυπτογράφηση.

	$alert_code    = ''; // Αρχικοποίηση για μετά .
	$alert_message = '';

	$contains_empty = in_array( "", $_POST, true ); // Εαν αυτο δώσει 1 ή true σημαίνει ότι κάτι δεν έχουμε συμπληρώσει.

	if ( $contains_empty == true ) { // Πρώτα ελέγχουμε αν ενα η ολα τα πεδία της φόρμας είναι άδεια.
		$alert_code    = 'warning';
		$alert_message = 'Πρέπει να συμπληρωθούν ολα τα πεδία της φόρμας';

	} elseif ( check_unique_email($conn, $email ) == false ){ // Πλεόν γνωρίζουμε ότι ολα τα πεδία ειναι συμπληρωμένα άρα ελέγχουμε την μοναδικότητα του email.

		$alert_code    = 'danger';
		$alert_message = 'Το email έχει δηλωθεί.';
	}

	else{ // όλα είναι οκ ας βάλουμε τον χρήστη στη βάση.
		$insert = register_new_user($conn,$firstname,$lastname,$email,$username,$password);
		if($insert == false){
			$alert_code    = 'danger';
			$alert_message = 'Κάτι πήγε στραβά.';
		}else{
			$alert_code    = 'success';
			$alert_message = 'Ο νέος χρήστης προστέθηκε επιτυχώς.Παρακαλώ εισέλθετε στην εφαρμογή  <a href="login.php"><b>εδώ</b></a>'; // Τον προτρέπουμε να πάει να συνδεθει στη σελιδα login.php
		}
	}
}
?>

	<body>
	<div class="main-content-container">
		<div class="container">
			<div class="row">
				<div class="col-mg-12">
					<h1>Δημιουργήστε λογαριασμο</h1>
					<h5>
						<a href="login.php">Μήπως έχετε ήδη λογαριασμό;</a>
					</h5>
					<hr/>
					<!--
						Εδώ δημιουργούμε την register form και αντιστοιχίζουμε τα πεδία
						που έχουμε στη βαση με αυτά . Φρόντίζουμε στο name attribute να είναι πεδία
						αντίστοιχα με αυτα στη βάση.
						Στη φόρμα χρησιμοποιούμε Method= Post γιατί θα στείλουμε και κωδικο και δεν θελουμε να
						φαίνεται στο URL όπως και θα γινόταν άν χρησιμοποιούσαμε το GET.
					-->
					<?php
					// Εδώ μας εμφανίζει το alert.
					echo show_alert( $alert_code, $alert_message ); ?>

					<form class="register-form" method="POST" action="">
						<div class="form-group">
							<label for="firstname">Το ονομά σας</label>
							<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Το ονομά σας">
						</div>
						<div class="form-group">
							<label for="firstname">Το επώνυμό σας</label>
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Το επώνυμό σας">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" id="email" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="username">Επιλέξτε usename</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Username">
						</div>
						<div class="form-group">
							<label for="password">Επιλέξτε password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Κωδικος">
						</div>
						<button type="submit" class="btn btn-default">Εγγραφή</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	</body>

<?php
include( '../template-parts/footer.php' );