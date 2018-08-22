<?php
//write file
function writefile($content, $filenm){
	$myfile = fopen($filenm, "w") or die("Unable to open file! ".$filenm." Ten file");
	fwrite($myfile, $content);
	fclose($myfile);
}

function downloadfile($filenm){
    $len = filesize($filenm); // Calculate File Size
	header('Content-type: text/plain');
    header('Content-Length: '.$len);
    header('Content-Disposition: attachment; filename='.$filenm);
    readfile($filenm);
}

$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$dvid = $_GET['dvid'];
$dvtype = $_GET['dvtype'];
$option = $_GET['dayopt'];
$filenm = "report_".$dvid."_".date('mdY_Hi', time()).".txt";

$sql = "";
if($dvtype == "DHT11"){
	$sql = "SELECT temp, humi, timestamp FROM dht11 WHERE device_id='$dvid' AND timestamp > date_sub(now(), interval ".$option." day)";
}
if($dvtype == "MQ135"){
	$sql = "SELECT device_id, co2, co, ethanol, toluene, acetone, timestamp FROM mq135 WHERE device_id='$dvid' AND timestamp > date_sub(now(), interval ".$option." day)";
}
if($dvtype == "MC52"){
	$sql = "SELECT open, timestamp FROM mc52 WHERE device_id='$dvid' AND timestamp > date_sub(now(), interval ".$option." day)";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		if($dvtype == "DHT11"){
			$writes.="Device id: " . $dvid. " - Temperature: " . $row["temp"]. "°C - Humidity: " . $row["humi"]. "% - Timestamp: " . $row["timestamp"]."\n";
		}
		if($dvtype == "MQ135"){
			$writes.="Device id: ".$dvid." - CO2: ".$row["co2"]." PPM - CO: ".$row["co"]." PPM - Ethanol: ".$row["ethanol"]." PPM - Toluene: ".$row["toluene"]." PPM - Acetone: ".$row["acetone"]." PPM - Timestamp: ".$row["timestamp"]."\n";
		}
		if($dvtype == "MC52"){
			$writes.="Device id: " . $dvid. " - Open state: " . ($row["open"] == 1) ? "Open" : "Close". " - Timestamp: " . $row["timestamp"]."\n";
		}
		writefile($writes, $filenm);
	}
} else {
	$writes="This device haven't has data yet :(";
	writefile($writes, $filenm);
}
$conn->close();
downloadfile($filenm);
unlink($filenm);
?>