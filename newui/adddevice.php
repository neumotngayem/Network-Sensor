<?php
 $servername = "localhost";
 $username = "root";
 $password = "admin123";
 $dbname = "iot";
 if(isset($_POST['star']) && isset($_POST['dvid']) && isset($_POST['dvtype']) && isset($_POST['room'])){	
	$valueFav = $_POST["star"];
	$valueDvid = $_POST["dvid"];
	$valueDvtype = $_POST["dvtype"];
	$valueRoom = $_POST["room"];
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "INSERT INTO home (device_id, fav, type, sec, loca_id) VALUES ('$valueDvid', '$valueFav', '$valueDvtype', 30, '$valueRoom')";
	$sqlDelete = "DELETE FROM ack_list WHERE device_id = '$valueDvid'";
	if (($conn->query($sqlDelete) === TRUE) && ($conn->query($sql) === TRUE)) {
		echo("<p><strong>$valueDvid </strong>added</p>");
	}else{
		echo("Opps Error");
	}
 }else{
	echo("Opps Error");
 }
 $conn->close();	
?>