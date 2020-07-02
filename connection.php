<?php
	
	$servername = "localhost";
	$username = "root";
	$password = "";

	// $servername = "localhost";
	// $username = "";
	// $password = "";

	$conn = mysqli_connect($servername, $username, $password);
	if (!$conn) {
		die('Could not connect: ' . mysqli_error($conn));
	}
	
	mysqli_select_db($conn, 'movie-review-db');
?>
