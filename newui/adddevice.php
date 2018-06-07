<?php
 $servername = "localhost";
 $username = "root";
 $password = "admin123";
 $dbname = "iot";
 $valueFav = $_POST["star"];
 $valueDvid = $_POST["dvid"];
 $valueDvtype = $_POST["dvtype"];
 $valueRoom = $_POST["room"];
 // Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);
 $sql = "INSERT INTO home (device_id, fav, type, sec, loca_id) VALUES ('$valueDvid', '$valueFav', '$valueDvtype', 30, '$valueRoom')";
 $sqlDelete = "DELETE FROM ack_list WHERE device_id = '$valueDvid'";
 if (($conn->query($sqlDelete) === TRUE) && ($conn->query($sql) === TRUE)) {
    echo($valueDvid." added");
 }else{
	echo("Opps Error");
 }
 $conn->close();
?>