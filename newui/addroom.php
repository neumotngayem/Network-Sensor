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
	 	echo $rm_name." Added";	
	} else {
		echo("Opps Error");
	}
}else{
	echo("Opps Error");
}
$conn->close();	
?>