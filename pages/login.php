<?php
/*
 * Σελίδα "Login", σύνδεση του χρήστη στο συστημα.
 * Εαν είναι ήδη συνδεδεμένος , κάνει redirect στο mycalendar.php page.
 */
include( '../template-parts/header.php' ); ?>
	<body>
	<div class="main-content-container">
		<div class="container">
			<div class="row">
				<div class="col-mg-12">
					<h1>Συνδεθείτε </h1>
					<form class="login-form" method="POST" action="">
						<div class="form-group">
							<label for="username">usename</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Username">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Κωδικος">
						</div>
						<button type="submit" class="btn btn-default">Σύνδεση</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	</body>

<?php
include( '../template-parts/footer.php' );