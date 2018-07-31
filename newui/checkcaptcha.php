<?php
session_start(); 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['incaptcha']) && isset($_POST['phone']))
{	
	$incaptcha = $_POST['incaptcha'];
	$phone = $_POST['phone'];
	//if($_SESSION['captcha'] == $incaptcha){
	if('okay' == $incaptcha){
		$sql = "UPDATE account SET regisphone='$phone'";
		$conn->query($sql);
		echo("okay");
	}else{
		echo("Your input captcha is not correct :(");
	}
}

?>