<?php 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
//If it have enough data for processing
if(isset($_POST['data']) && isset($_POST['data2']) )
{
    //Extract the data got
    $data = explode('-', $_POST['data']);
    $data2 = explode('-', $_POST['data2']);
    
	//Saving the new name and position
    $numbers = 3;
    for($i = 0; $i < count($data); $i++){
        $sql = 'UPDATE room SET posi = '.$numbers.', rm_name= "'.$data2[$i].'" WHERE rm_id ='.$data[$i];
		$conn->query($sql);
        $numbers++;
    }
    $conn->close();		
} else{ 
    die('lock');
}

?>