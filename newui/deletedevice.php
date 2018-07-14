<?php 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['dvid']))
{
    //Extract the data got
    $dvid = $_POST['dvid'];
    $sql = "DELETE FROM home WHERE device_id = '$dvid'";
	if ($conn->query($sql) === TRUE) {
		echo("Deleted");
	} else{ 
		echo("Opps Error");
	}
$conn->close();	
}
?>