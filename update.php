<?php 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$conn = new mysqli($servername, $username, $password, $dbname);
if(isset($_POST['data']) && isset($_POST['data2']) )
{
    
    $data = explode('-', $_POST['data']);
    $data2 = explode('-', $_POST['data2']);
    
    $numbers = 3;
    for($i = 0; $i < count($data); $i++){
        $sql = 'UPDATE room SET posi = '.$numbers.', roomnm= "'.$data2[$i].'" WHERE rm_id ='.$data[$i];
	$conn->query($sql);
        $numbers++;
    }
    $conn->close();		
} else{ 
    die('lock');
}

?>