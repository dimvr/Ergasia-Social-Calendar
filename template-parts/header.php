<?php
/*
 * Ξεκινάμε το session σε ΟΛΗ την εφαρμογή. Αυτό γιατί πάντα ελέγχουμε άν είμαστε συνδεδεμένοι η όχι.
 * Η μόνη "σελίδα" που το session θα καταστραφεί είναι το logout.php
 */
session_start();
$server = 'http://easymail.gr/lina/prod'; //Μεταβλητή με το root domain της εφαρμογής.
?>
<!DOCTYPE html>
<html>
<head>
	<title>Your Calendar</title>
	<link rel="stylesheet" href="<?php echo $server; ?>/assets/CSS/Bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="<?php echo $server; ?>/assets/CSS/Bootstrap/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" href="http:////cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.min.css"/>

	<link rel="stylesheet" href="<?php echo $server; ?>/assets/CSS/main-styles.css"/>
	<script
		src="https://code.jquery.com/jquery-1.12.4.min.js"
		integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
		crossorigin="anonymous"></script>
</head>
<div class="top-bar-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<h2><a href="<?php echo $server; ?>">Your Calendar</a></h2>
			</div>
			<div class="col-lg-8">
				<ul class="register-links pull-right">
					<li><a href="<?php echo $server; ?>/pages/how-it-works.php">Πώς λειτουργεί</a></li>
					<li><a href="#">Σχετικά με εμάς</a></li>
					<li><a href="<?php echo $server; ?>/pages/login.php">Σύνδεση</a></li>
					<li><a href="<?php echo $server; ?>/pages/register.php">Εγγραφή</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>