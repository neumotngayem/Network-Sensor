<?php 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['dvid']) && isset($_POST['chgrmid']) )
{
    //Extract the data got
    $dvid = $_POST['dvid'];
    $chgrmid = $_POST['chgrmid'];
    $sql = "UPDATE home SET loca_id = $chgrmid WHERE device_id = '$dvid'";
	if ($conn->query($sql) === TRUE) {
		echo("Changed");
	} else{ 
		echo("Opps Error");
	}
$conn->close();	
}
?>