<?php
header("Content-Type: application/json; charset=UTF-8");
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$dvid = $_GET['dvid'];


$sql = "SELECT co2,co,ethanol,toluene,acetone FROM home WHERE device_id='$dvid' ";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	$row = $result->fetch_assoc();
	echo(json_encode($row));
} 
$conn->close();
?>