﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
	$con=mysqli_connect("localhost","root","","calendar");
	mysqli_set_charset($con, "utf8");
	$onoma = $_POST['onoma'];
	$epitheto = $_POST['epitheto'];
	$imgennisis = $_POST['imgennisis'];
	$filo = $_POST['filo'];
	$mail = $_POST['mail'];
	$username = $_POST['username'];
	$password = $_POST['password'];


	$sql = "INSERT INTO user(onoma, epitheto, imgennisis, filo, mail, username, kodikos) VALUES('$onoma', '$epitheto', '$imgennisis', '$filo', '$mail', '$username', '$password');";

	$res = mysqli_query($con,$sql);
	/* mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'"); */
	if($res){
		echo '<script language="javascript">alert("Η καταχώρηση νέου χρήστη έγινε με επιτυχία."); document.location="index.php";</script>';
	}
	else{
		echo '<script language="javascript">alert("Υπήρξε πρόβλημα. Προσπαθήστε ξανά."); document.location="index.php";</script>';
	}
?>
</body>
</html>