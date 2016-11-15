<?php
//if($_SESSION['loggedin'] != true):
	//header('Location: http://easymail.gr/lina/prod/' );
//endif;
/*
 * Σελίδα mycalendar.php
 * Εδώ αν δεν είμαι logged μου κάνει redirect στην σελιδα σύνδεση
 */
include( '../template-parts/header.php' ); ?>

	<body>
	<div class="main-content-container">
		<div class="container">
			<div class="row">
				<div class="col-mg-12">
					<h1>Το ημερόλόγιο των events μου.</h1>
					<div id="calendar"></div>
				</div>
			</div>
		</div>
	</div>
	</body>

<?php
include( '../template-parts/footer.php' );