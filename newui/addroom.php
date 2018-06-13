<?php
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['rmadd'])){
	$rm_name = $_POST['rmadd'];
	$sql1 = 'SELECT MAX(posi) AS maxposi FROM room';
	$maxposi;
	$result = $conn->query($sql1);
	if ( $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$maxposi = $row["maxposi"];
		if(is_null($maxposi)){
			$maxposi = 0;
		}
	}
	$sql2 = 'INSERT INTO room (rm_name, posi) VALUES ("'.$rm_name.'", '.$maxposi.')';
	if ($conn->query($sql2) === TRUE) {
	 	echo "Added";	
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