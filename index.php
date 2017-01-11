<?php
include('libraries/application_top.php');
/*
 * Η αρχική σελίδα της εφαρμογής είναι αυτό το αρχείο.
 */
include(INDEX_HEADER); 
?>
<!-- <body> cc moved to header-->
	<div class="main-content-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Καλώς ορίσατε στην εφαρμογή DDA Calendar.</h1>
					<h2>Never lose an event!</h2>
					<p><a title="Μετάβαση στην εφαρμογή του ημερολογίου" href="<?php echo NEW_CALENDAR_PAGE; ?>"><img alt="logo" width="280" src="images/logo.png"></a></p>
				</div>
			</div>
		</div>
	</div>
<?php
include(INDEX_FOOTER);
include(INDEX_APPLICATION_BOTTOM_SCRIPT);
?>