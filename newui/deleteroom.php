<?php
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['rmid']) && isset($_POST['rmidmove']) ){
	$rmid = $_POST['rmid']; 
	$rmidmove = $_POST['rmidmove'];
	$sql = "DELETE FROM room WHERE rm_id=".$rmid;
	$sql2 = "";
	if($rmidmove == "deleteall"){
		$sql2 = "DELETE FROM home WHERE loca_id=".$rmid;	
	}else{
		$sql2 = "UPDATE home SET loca_id=$rmidmove WHERE loca_id=".$rmid;	
	}
	if (($conn->query($sql) === TRUE) && ($conn->query($sql2) === TRUE)) {
	    echo "Deleted";	
	} else {
		echo("Opps Error");
	}
}else{
	echo("Opps Error");
}
$conn->close();
?>