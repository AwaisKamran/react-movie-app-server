<?php
	
	/* Local Machine setting */
	$servername = "localhost";
	$username = "root";
	$password = "";

	/* Production setting */
	// $servername = "localhost";
	// $username = "guest_user";
	// $password = "Guest@123";

	$conn = mysqli_connect($servername, $username, $password);
	if (!$conn) {
		die('Could not connect: ' . mysqli_error($conn));
	}
	
	mysqli_select_db($conn, 'community');
?>
