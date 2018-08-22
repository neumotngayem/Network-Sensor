<?php
session_start(); 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['incaptcha']) && isset($_POST['phone'])){
	// Extract data from request
	$incaptcha = $_POST['incaptcha'];
	$phone = $_POST['phone'];
	
	// If the captcha enter is equal with the captcha saved on the session
	if($_SESSION['captcha'] == $incaptcha){
		// If data get from request is not "reset"
		if($phone != "reset"){
			// Update the registerd phone number on DB
			$sql = "UPDATE account SET regisphone='$phone'";
			// Query SQL
			$conn->query($sql);
			// Return success status
			echo("okay");
		}else{ // Else if data get from request is not "reset"	
			// Reset password to default password
			$resetpass = md5('admin');
			$sql = "UPDATE account SET pass='$resetpass'";
			// Query SQL
			$conn->query($sql);
			// Return success status
			echo("resetokay");
		}
	}else{ // Else if the captcha enter is not equal with the captcha saved on the session
		// Return fail status
		echo("<p><strong>Sorry! </strong>Your enter captcha is incorrect <i class='far fa-frown'></i></p>");
	}
	// Close connection
	$conn->close();
}

?>