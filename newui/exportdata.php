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
$option = $_GET['dayopt'];
$filenm = "report_".$dvid."_".date('mdY_Hi', time()).".txt";
$sql = "SELECT temp, humi, timestamp FROM dht11 WHERE device_id='$dvid' AND timestamp > date_sub(now(), interval ".$option." day)";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$writes.="Device id: " . $dvid. " - Temp: " . $row["temp"]. " - Humi: " . $row["humi"]. " - Timestamp: " . $row["timestamp"]."\n";
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