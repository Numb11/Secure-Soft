<?php
	
	$host = 'localhost';
	$user = "root";
	$pass = '';
	$dbname = 'fakebook';
	
	$conn = mysqli_connect($host,$user,$pass,$dbname);
	
	
	
	if ($conn->connect_error) {
		die("Not Connecting: " . $conn->connect_error);
	

	}

$_SESSION['UserID'] = 1;
?>




