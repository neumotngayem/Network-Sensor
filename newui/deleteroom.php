<?php
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['rmid'])){
	$rmid = $_POST['rmid'];  
	$sql = "DELETE FROM room WHERE rm_id=".$rmid;
	if ($conn->query($sql) === TRUE) {
	    echo "Deleted";	
	} else {
		echo("Opps Error");
	}
}else{
	echo("Opps Error");
}
$conn->close();
?>