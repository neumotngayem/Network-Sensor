<?php
session_start(); 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['phone'])){
	// Extract data from request
	$phone = $_POST['phone'];
	// If data get from request is "reset"
    if($_POST['phone'] == 'reset'){
		// Get the registered phone number from DB
		$sql = "SELECT regisphone FROM account";
		// Query SQL
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$phone = $row["regisphone"];
		}
	}
	// Close connection
	$conn->close();
	// Generate captcha
	$captcha_num = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
	$captcha_num = substr(str_shuffle($captcha_num), 0, 6);
	// Save generated captcha on session
	$_SESSION['captcha'] = $captcha_num;
	// Send captcha via SMS
	$call = "sudo python ./python/sms.py $phone 'CAPTCHA FROM WX-NET host is $captcha_num'";
	// Execute command on WX-NET host
	shell_exec($call);
}
?>