<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['username']) && isset($_POST['password'])){
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$md5pass = md5($password);
	$sql = "SELECT 1 FROM account WHERE user='$username' AND pass='$md5pass'";
	$result = $conn->query($sql);
	if ( $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$login = $row['1'];
		if(is_null($login)){
			echo('fail');
		}else{
			echo('login');
			$_SESSION['user_id'] = $username;
		}
	}else{
		echo('fail');
	}
}else{
	echo "fail";
}
$conn->close();
?>