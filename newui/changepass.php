<?php 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['passnew']) && isset($_POST['repassnew']) )
{
    //Extract the data got
    $passnew = $_POST['passnew'];
    $repassnew = $_POST['repassnew'];
	
	if($passnew != $repassnew){
		die("Reenter password is not match");
	}
	
	$md5pass = md5($passnew);
    $sql = "UPDATE account SET pass='$md5pass'";
	if ($conn->query($sql) === TRUE) {
		echo("okay");
	}else{
		 echo("Opps Error");
	}

} else{ 
    echo("Opps Error");
}
$conn->close();	
?>