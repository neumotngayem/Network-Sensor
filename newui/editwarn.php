<?php
	$servername = "localhost";
	$username = "root";
	$password = "admin123";
	$dbname = "iot";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	if(isset($_POST['dvid']) && isset($_POST['state']) && isset($_POST['cmpsign1']) && isset($_POST['warntemp']) && isset($_POST['cmpsign2']) && isset($_POST['warnhumi'])){
		$dvid = $_POST['dvid'];
		$state = $_POST['state'];
		$cmpsign1 = $_POST['cmpsign1'];
		$warntemp = $_POST['warntemp'];
		$cmpsign2 = $_POST['cmpsign2'];
		$warnhumi = $_POST['warnhumi'];
		$sql = "";
		if($state == '0' && $cmpsign1 == '-1' ){
			$sql = "UPDATE home SET warn = 1 WHERE device_id='$dvid'";
		}
		if($state == '0' && $warntemp != '-1' && $cmpsign1 != '0' && $cmpsign2 != '0' ){
			$sql = "UPDATE home SET warn = 1, cmpsign1 = $cmpsign1, warntemp = $warntemp, cmpsign2 = $cmpsign2, warnhumi = $warnhumi WHERE device_id='$dvid'";
		}
		if($state == '0' && $cmpsign2 == '0'){
			$sql = "UPDATE home SET warn = 1, cmpsign1 = $cmpsign1, warntemp = $warntemp, cmpsign2 = '0', warnhumi = NULL WHERE device_id='$dvid'";
		}
		if($state == '0' && $cmpsign1 == '0' ){
			$sql = "UPDATE home SET warn = 1, cmpsign1 = '0', warntemp = NULL, cmpsign2 = $cmpsign2, warnhumi = $warnhumi WHERE device_id='$dvid'";
		}		
		if($state == '1'){
			$sql = "UPDATE home SET warn = 0 WHERE device_id='$dvid'";
		}
		$conn->query($sql);
		$conn->close();
	}
?>