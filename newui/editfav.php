<?php
	$servername = "localhost";
	$username = "root";
	$password = "admin123";
	$dbname = "iot";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	if(isset($_POST['dvid']) && isset($_POST['fav'])){
		$dvid = $_POST['dvid'];
		$fav = $_POST['fav'];
		if($fav == '0'){
			$sql = "UPDATE home SET fav = 1 WHERE device_id='".$dvid."'";
			if ($conn->query($sql) === TRUE) {
				echo("Success");
			}else{
				echo("Error");
			}
		}else{
			$sql = "UPDATE home SET fav = 0 WHERE device_id='".$dvid."'";
			if ($conn->query($sql) === TRUE) {
				echo("Success");
			}else{
				echo("Error");
			}
		}
	}else{
		echo("Error");
	}
	$conn->close();
?>