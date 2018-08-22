<?php
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// If it have enough data for processing
if(isset($_POST['rmadd'])){
	// Extract data from request
	$rm_name = $_POST['rmadd'];
	// Get the maximum position on room table
	$sql1 = "SELECT MAX(posi) AS maxposi FROM room";
	$maxposi;
	// Query SQL
	$result = $conn->query($sql1);
	if ( $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$maxposi = $row["maxposi"];
		if(is_null($maxposi)){
			$maxposi = 0;
		}
	}
	// Insert the new room
	$sql2 = 'INSERT INTO room (rm_name, posi) VALUES ("'.$rm_name.'", '.$maxposi.')';
	// Query SQL
	$conn->query($sql2);
	// Close connection
	$conn->close();	
}
?>