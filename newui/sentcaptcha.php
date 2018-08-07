<?php
session_start(); 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['phone']))
{	  
	//Extract the data got
	$phone = $_POST['phone'];
    if($_POST['phone'] == 'reset'){
		$sql = "SELECT regisphone FROM account";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$phone = $row["regisphone"];
		}
	}
	
	$captcha_num = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
	$captcha_num = substr(str_shuffle($captcha_num), 0, 6);
	$_SESSION['captcha'] = $captcha_num;
	$call = "sudo python ../python/sms.py $phone 'CAPTCHA FROM WX-NET host is $captcha_num'";
	shell_exec($call);
}else{
	echo("Fail");
}
?>