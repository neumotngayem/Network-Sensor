<?php
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// If it have enough data for processing
if(isset($_POST['rmid']) && isset($_POST['rmidmove']) ){
	// Extract data from request
	$rmid = $_POST['rmid']; 
	$rmidmove = $_POST['rmidmove'];
	$sql = "DELETE FROM room WHERE rm_id = $rmid";
	$sql2 = "";
	// If select delete all
	if($rmidmove == "deleteall"){
		$sql2 = "UPDATE home SET loca_id = 0 WHERE loca_id = $rmid";	
	}else{ // Else make all device belong to this room change to selected room
		$sql2 = "UPDATE home SET loca_id = $rmidmove WHERE loca_id= $rmid";	
	}
	// Query SQL
	$conn->query($sql);
	$conn->query($sql2);
	// Close connection
	$conn->close();
}
?>