<?php 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['dvid']) && isset($_POST['chgtime']) )
{
	$dvid = $_POST['dvid']; 
	$chgtime = $_POST['chgtime'];  
	$sql = "UPDATE home SET sec=$chgtime WHERE device_id='$dvid'";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
		//Send the new refesh time to device
		$call = "sudo python ./python/sent.py $dvid $chgtime";
		shell_exec($call);
		echo("Changed");
	} else{ 
		echo("Opps Error");
	}
	$conn->close();
}
?>