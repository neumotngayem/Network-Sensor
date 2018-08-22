<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// If it have enough data for processing
if(isset($_POST['username']) && isset($_POST['password'])){
	// Extract data from request
	// Escape variables for security
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	// MD5 encryption
	$md5pass = md5($password);
	// Check the login info
	$sql = "SELECT 1 FROM account WHERE user='$username' AND pass='$md5pass'";
	// Query SQL
	$result = $conn->query($sql);
	if ( $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$login = $row['1'];
		// If login info get from DB is null, return fail status
		if(is_null($login)){
			
			echo("<p><strong>Sorry! </strong>Your login info is incorrect<i class='far fa-frown'></i></p>");
		}else{ // If login info get from DB is exist, return succes status, write username on the session
			echo('login');
			$_SESSION['user_id'] = $username;
		}
	}else{ // If login info get from DB is not exist, return fail status
		echo("<p><strong>Sorry! </strong>Your enter login info is incorrect <i class='far fa-frown'></i></p>");
	}
	// Close connection
	$conn->close();
}
?>