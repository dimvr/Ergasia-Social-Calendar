<?php
// Σελίδα header.php - Δημιουργεί το επάνω μέρος της σελίδας : Μενού πλοήγησης
?>
<!DOCTYPE html>
<html>
<head>
	<title>DDA Calendar</title>	
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo MAIN_PAGE; ?>assets/CSS/Bootstrap/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" href="<?php echo MAIN_PAGE; ?>assets/CSS/main-styles.css"/>
	<?php echo "\n".'<link rel="stylesheet" type="text/css" media="screen" href="' . CALENDAR_CSS . '">'."\n"; ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo MAIN_PAGE; ?>assets/JS/jquery.nicescroll.min.js"></script>    	
</head>
<body>
<div class="top-bar-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<h2><a href="<?php echo MAIN_PAGE; ?>"><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;DDA Calendar</a></h2>				
			</div>
			<div class="col-lg-8">
				<ul class="register-links pull-right">	
            <li class="dropdown"> 
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-info-sign"></span>&nbsp;Πληροφορίες		  
			  &nbsp;<span class="caret"></span></a>
		      <ul class="dropdown-menu">					
                 <li><a title="Δείτε πως λειτουργεί η εφαρμογή Your Calendar" href="<?php echo HOW_IT_WORKS_PAGE; ?>"><span class="glyphicon glyphicon-book"></span>&nbsp;Πώς λειτουργεί</a></li>
				 <li><a title="Πληροφορίες για την ομάδα εργασίας" href="<?php echo ABOUT_US_PAGE; ?>"><span class="glyphicon glyphicon-book"></span>&nbsp;Σχετικά με εμάς</a></li>
				 </ul>	
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;
			  <?php
              if(user_is_loged()){			  
			  echo '' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . '';			  
			  ?>
			  &nbsp;<span class="caret"></span></a>
		      <ul class="dropdown-menu">
			    <li><a href="<?php echo NEW_CALENDAR_PAGE; ?>"><span class="glyphicon glyphicon-calendar"></span>&nbsp;Το Ημερολόγιό μου</a></li>
				<li><a href="<?php echo REPLACE_PAGE; ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;Ο Λογαριασμός μου</a></li>
                <li><a href="<?php echo LOGOUT_PAGE; ?>?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Αποσύνδεση</a></li>
				<li><span style="font-size:9px;font-weight:bold;color:navy"><?php echo $_SESSION['email']; ?></span></li>
              </ul>
			  <?php }else{ 
			  echo 'Σύνδεση ή Εγγραφή';			  
			  ?>
			  &nbsp;<span class="caret"></span></a>
		      <ul class="dropdown-menu">
                <li><a href="<?php echo LOGIN_PAGE; ?>"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Σύνδεση</a></li>
				<li><a href="<?php echo REGISTER_PAGE; ?>"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Εγγραφή</a></li>
              </ul>	
			  <?php } ?>
            </li>
			  <?php
			    $uolconn   = connect_to_db();
			    $uolquery  = "SELECT * FROM users ORDER BY users_logged_in DESC";
		        $uolresult = mysqli_query($uolconn,$uolquery);
		        $uolcount  = mysqli_num_rows($uolresult);
				
				$uolcquery  = "SELECT * FROM users WHERE users_logged_in = '1'";
		        $uolcresult = mysqli_query($uolconn,$uolcquery);
		        $uolccount  = mysqli_num_rows($uolcresult);
			  ?>
            <li class="dropdown"> 
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-list-alt"></span>&nbsp;Χρήστες (Συνδεδεμένοι <?php echo $uolccount; ?>)			  
			  &nbsp;<span class="caret"></span></a>
		      <ul class="dropdown-menu">
                <?php
				       for($i=0; $i<$uolcount; $i++)
					   {
					       $uolrow = mysqli_fetch_assoc($uolresult);
						   if($uolrow['users_logged_in'] == '1'){
                             echo '<li><a title="' . $uolrow['firstname'] . ' ' . $uolrow['lastname'] . '" href="#"><span style="color:green" class="glyphicon glyphicon-eye-open"></span>&nbsp;' . $uolrow['username'] . '</a></li><br>'; 					   
                           }else{
							 echo '<li><a title="' . $uolrow['firstname'] . ' ' . $uolrow['lastname'] . '" href="#"><span style="color:red" class="glyphicon glyphicon-eye-close"></span>&nbsp;' . $uolrow['username'] . '</a></li><br>';  
						   }
					   }  
				?>
              </ul>	
            </li>	
          </ul>
			</div>
		</div>
	</div>
</div>