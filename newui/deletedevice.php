<?php 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['dvid']) && isset($_POST['dvtype']))
{
    //Extract the data got
    $dvid = $_POST['dvid'];
	$dvtype = $_POST['dvtype'];
    $sql = "UPDATE home set loca_id = 0 WHERE device_id = '$dvid'";
	$sql2 = "";
	if($dvtype == "DHT11"){
		$sql2 = "DELETE FROM dht11 WHERE device_id = '$dvid'";
	}else if($dvtype == "MC52"){
		$sql2 = "DELETE FROM mc52 WHERE device_id = '$dvid'";
	}else if($dvtype == "MQ135"){
		$sql2 = "DELETE FROM mq135 WHERE device_id = '$dvid'";
	}
	
	if (($conn->query($sql) === TRUE) && ($conn->query($sql2) === TRUE)) {
		echo("Deleted");
	} else{ 
		echo("Opps Error");
	}
$conn->close();	
}
?>