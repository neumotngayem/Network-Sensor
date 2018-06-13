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
	   	echo "<div class='ui-widget'>";
		echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
		echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
		echo "<strong>Alert: </strong>Something went wrong with your device</p>";
		echo "</div>";
		echo "</div>";
	}
	$conn->close();
}else{
	echo "Close";
}
?>