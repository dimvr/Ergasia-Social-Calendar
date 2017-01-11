<?php
include('../libraries/application_top.php');
/*
 * Σελίδα "Login", σύνδεση του χρήστη στο συστημα.
 * Εαν είναι ήδη συνδεδεμένος , κάνει redirect στο new_calendar.php page.
 */

 if(!empty($_POST['loginnow']) && $_POST['loginnow']==1){ 
	
 if(!empty($_POST['username']) && !empty($_POST['password'])){

            $error         = false;
		    $usernameError = '';
            $passwordError = '';
			
        $username = htmlspecialchars(strip_tags(trim($_POST['username'])));
		
		if(empty($username)){
			$error = true;
			$usernameError = "Παρακαλούμε εισάγετε Όνομα Χρήστη !";
		}
		
		$password  = htmlspecialchars(strip_tags(trim($_POST['password'])));
		
		if(empty($password)){
			$error = true;
			$passwordError = "Παρακαλούμε εισάγετε Κωδικό Πρόσβασης !";
		}		
	
        if (!$error) {
			
			$conn  = connect_to_db(); // Συνδεόμαστε στη βάση.
			$query = "SELECT users_id, firstname, lastname, email, username, password FROM users WHERE username = '" . $username . "'";
			$res   = mysqli_query($conn,$query);
			$row   = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$count = mysqli_num_rows($res);
			
			$HashedPassword = $row['password'];
			
			if (crypt($password, $HashedPassword) == $HashedPassword) {
			$password_check	= 1;
			}else{
			$password_check	= 0;
			}
			
			if( $count == 1 && $password_check == 1 ) {
				
				$sql = "UPDATE users SET users_logged_in = '1' WHERE users_id = " . $row['users_id'] . "";
				mysqli_query($conn,$sql);
				
				$_SESSION['systemuser'] = $row['users_id'];
				$_SESSION['username']   = $row['username'];
				$_SESSION['firstname']  = $row['firstname'];
				$_SESSION['lastname']   = $row['lastname'];
				$_SESSION['email']      = $row['email'];
				
				header("Location: " . NEW_CALENDAR_PAGE . "");
				
			} else {
				
				$errMSG = "Τα στοιχεία που δώσατε δεν είναι σωστά. Προσπαθήστε ξανά !";
				
			}							
		}	
}else{
		if(empty($username)){
			$usernameError = "Παρακαλούμε εισάγετε Όνομα Χρήστη !";
		}
		if(empty($password)){
			$passwordError = "Παρακαλούμε εισάγετε Κωδικό Πρόσβασης !";
		}
}

}
	if(user_is_loged()){	
	header("Location: " . NEW_CALENDAR_PAGE . "");
	exit;	
	}	
 	
include(HEADER_MENU); 

?>

	<div class="main-content-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<div class="form-group">
            	    <h2>Σύνδεση στο λογαριασμό σας</h2>
                    </div>
        	            <div class="form-group"><hr /></div>
						
                    <?php if (!empty($errMSG) ) { ?>
			
				        <div class="form-group">
            	           <div class="alert alert-danger">
				              <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                          </div>
            	        </div>
                    <?php } ?>		
						<div class="form-group">
						    <div class="input-group">  
							  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span> 
							  <input type="text" class="form-control" id="username" name="username" placeholder="Όνομα Χρήστη" value="<?php echo (!empty($_POST['username']) ?  $_POST['username'] : ''); ?>">
							</div>
							<span class="text-danger"><?php echo (!empty($usernameError) ?  $usernameError : ''); ?></span>
						</div>
						<div class="form-group">
						    <div class="input-group">
							  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							  <input type="password" class="form-control" id="password" name="password" placeholder="Κωδικός Πρόσβασης">
							</div>   
							<span class="text-danger"><?php echo (!empty($passwordError) ?  $passwordError : ''); ?></span>
						</div>
						<div class="form-group">
						<button type="submit" class="btn btn-default">Σύνδεση</button>
						</div>
						<div class="form-group"><hr /></div>
						<div class="form-group">
						<a href="<?php echo REGISTER_PAGE; ?>">Δεν έχετε λογαριασμό ; Δημιουργήστε ΔΩΡΕΑΝ !</a>
						</div>
						<input type="hidden" name="loginnow" value=1>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	      $usernameError = '';
          $passwordError = '';
	?>
<?php
include(FOOTER);
include(APPLICATION_BOTTOM_SCRIPT);
?>