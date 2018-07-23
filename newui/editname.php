<?php
	$servername = "localhost";
	$username = "root";
	$password = "admin123";
	$dbname = "iot";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	if(isset($_POST['dvid']) && isset($_POST['dvname'])){
		$dvid = $_POST['dvid'];
		$dvname = $_POST['dvname'];
		$sql = "UPDATE home SET device_name = '".$dvname."' WHERE device_id='".$dvid."'";
		$conn->query($sql);
		echo("DONE");
	}else{
		echo("Error");
	}
	$conn->close();
?>