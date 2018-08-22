<?php
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['ssid']) && isset($_POST['pwssid']) )
{
    //Extract the data got
    $ssid = $_POST['ssid'];
    $pwssid = $_POST['pwssid'];
    $sql = "UPDATE account SET ssid = '$ssid' , pwssid= '$pwssid'";
	$conn->query($sql);
	$conn->close();
	shell_exec("sudo wpa_cli set_network 0 ssid '\"$ssid\"'");
	shell_exec("sudo wpa_cli set_network 0 psk '\"$pwssid\"'");
	shell_exec("sudo wpa_cli save_config");
	shell_exec("sudo reboot");
	echo("reboot");
}	
?>
