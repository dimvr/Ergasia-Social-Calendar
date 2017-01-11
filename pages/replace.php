<?php
    include('../libraries/application_top.php');
	
/*
 * Σελίδα "Ο Λογαριασμός μου"
 * Για τροποποίηση των στοιχείων χρήστη ή διαγραφή του λογαριασμού
 */

	if(!user_is_loged()){	
	header("Location: " . LOGIN_PAGE . "");
	exit;	
	}
	
include(HEADER_MENU);

if ( $_POST ) {
	
    $conn = connect_to_db(); // Συνδεόμαστε στη βάση.

	// Τα πεδία της φόρμας τα παίρνουμε με τον παρακάτω τρόπο μετά το submit.

    // ΚΑΝΟΥΜΕ sanitization !!!
	$firstname = htmlspecialchars(strip_tags(trim($_POST['firstname'])));
	$lastname  = htmlspecialchars(strip_tags(trim($_POST['lastname'])));
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
		
	} elseif (check_unique_username2($conn, $username) == false ){ // ελέγχουμε την μοναδικότητα του username.

		$alert_code    = 'danger';
		$alert_message = 'Το username έχει δηλωθεί.';
		
	}else{ // όλα είναι οκ ας τροποποιήσουμε τα στοιχεία του χρήστη στη βάση.
	
		$update = update_user($conn, $firstname, $lastname, $username, $password);
		
		$alert_code    = 'success';
		$alert_message = 'Τα στοιχεία σας τροποποιήθηκαν επιτυχώς.</a>';		
	}
}
?> 

	<div class="main-content-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Ο Λογαριασμός μου</h1>
					<h5>Τροποποίηση των στοιχείων μου ή Διαγραφή του λογαριασμού μου</h5>
					<h5><span style="color:red">ΠΡΟΣΟΧΗ :</span> Αν διαγράψετε το λογαριασμό σας, θα διαγραφούν όλα τα γεγονότα του ημερολογίου σας, μαζί και αυτά που έχετε κοινοποιήσει !</h5>
					<hr/>
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
							<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Όνομα" value="<?php print $_SESSION['firstname']; ?>">
					        </div>
					    </div>
						<div class="form-group">
						    <div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Επώνυμο" value="<?php print $_SESSION['lastname']; ?>">
						    </div>
						</div>
						<div class="form-group">
						    <div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
							<input type="email" class="form-control" name="email" id="email" placeholder="Διεύθυνση Email" value="<?php print $_SESSION['email']; ?> - Προσοχή! Δεν μπορείτε να το τροποποιήσετε." disabled>
						    </div>
						</div>
						<div class="form-group">
						    <div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" id="username" name="username" placeholder="Όνομα Χρήστη" value="<?php print $_SESSION['username']; ?>">
						    </div>
						</div>
						<div class="form-group">
						    <div class="input-group"> 
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" class="form-control" id="password" name="password" placeholder="Νέος Κωδικός Πρόσβασης">
						    </div>
						</div>
		               <div class="btn-group pull-left"> 
		                  <div class="btn-group">
		                     <button type="submit" class="btn btn-warning pull-left">Τροποποίηση</button>
			              </div>
			              <div class="btn-group">
                             <a role="button" class="btn btn-danger pull-left" href="<?php echo DELETEUSER_PAGE; ?>"><span class="glyphicon glyphicon-trash"></span>&nbsp;Διαγραφή Λογαριασμού</a>
                          </div>
						  <div class="btn-group">
                             <a role="button" class="btn btn-success pull-left" href="<?php echo MAIN_PAGE; ?>"><span class="glyphicon glyphicon-remove"></span>&nbsp;Άκυρο</a>
                          </div>
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