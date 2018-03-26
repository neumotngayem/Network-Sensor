<!DOCTYPE html>
<html>
<head>
<meta charset ="UTF-8">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<title>Home</title>
</head>

<body body background="./img/back.jpg">
<?php
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$sec = 30;
$secmin = 60;
$locaarr = array();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sqlrm = "SELECT * FROM room";
$resultrm = $conn->query($sqlrm);
$chstab;
echo "<div class='tabset'>";
if ($resultrm->num_rows > 0) {
	$i = 1;
	while($row = $resultrm->fetch_assoc()) {
		if($i == 1){
			if($row["chk_flg"] == 1){ 
				echo "<form id='checkedtab' class='sttab' action='#' method='post'>";
			}else{
				echo "<form class='sttab' action='#' method='post'>";
			}
			echo "<input type='text' hidden  name='idselect' value='".$row["rm_id"]."' />";
			echo "<input hidden type='submit' id='tab".$i."' name='submittab'>";
			echo "<label class='lbtab' for='tab".$i."'><img src='./img/fvat.png' width='15' height='15'> ".$row["roomnm"]."</img></label>";			
			echo "</form>";
			$chstab = $row["roomnm"];
		}else{
			if($row["chk_flg"] == 1){ 
				echo "<form id='checkedtab' class='sttab' action='#' method='post'>";
				$chstab = $row["roomnm"];
			}else{
				echo "<form class='sttab' action='#' method='post'>";
			}
			echo "<input type='text' hidden  name='idselect' value='".$row["rm_id"]."' />";
			echo "<input hidden type='submit' id='tab".$i."' name='submittab'>";
			echo "<label class='lbtab' for='tab".$i."'>".$row["roomnm"]."</label>";
			echo "</form>";
			array_push($locaarr,$row["roomnm"]);
		}
		$i+=1;		
	}	
}
echo "</div>";
echo "<div id='content'>"; 
$sql = "SELECT *  FROM home";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$loca = $row["loca"];
	$fav = $row["fav"];
	if(($chstab =='Favorite' && $fav ==1) || ($chstab =='Favorite' && $loca == 'Undefine') || ($loca == $chstab)){ 
		$dvid = $row["device_id"];
		$sec = 	$row["sec"];
		if($sec < $secmin){
			$secmin = $sec;
		}
		echo "<table align='center' background='./img/blue.png'>";
		echo "<tr>";
		echo "<td>";
		echo "<form action='#' method='post'>";
		echo "<input type='text' hidden  name='dvidselect' value='".$dvid."' />";
		if($row["fav"] == 0){
			echo "<input type='image' src='./img/fvbf.png' width='30' height='30' name='submitfav'>";
		}else{
			echo "<input type='image' src='./img/fvat.png' width='30' height='30' name='submitopfav'>";
		}
		echo "</form>";
		echo "</td>";
		echo "<td>";
		echo "<form action='#' method='post'>";
		echo "<select name='secselect'>";
		if($sec == 10){
			echo "<option value='10' selected >10</option>";
		}else{
			echo "<option value='10'>10</option>";
		}	
		if($sec == 20){
			echo "<option value='20' selected >20</option>";
		}else{
			echo "<option value='20'>20</option>";
		}	
		if($sec == 30){
			echo "<option value='30' selected >30</option>";
		}else{
			echo "<option value='30'>30</option>";
		}	
		if($sec == 40){
			echo "<option value='40' selected >40</option>";
		}else{
			echo "<option value='40'>40</option>";
		}	
		if($sec == 50){
			echo "<option value='50' selected >50</option>";
		}else{
			echo "<option value='50'>50</option>";
		}	
		if($sec == 60){
			echo "<option value='60' selected >60</option>";
		}else{
			echo "<option value='60'>60</option>";
		}	
		echo "</select>";
		echo "<input type='text' hidden  name='dvidselect' value='".$dvid."' />";
		echo " <input type='submit' name='submitsec' value='Set update time' />";
		echo "</form>";
		echo "</td>";
		echo "<td>";
		echo "<form action='#' method='post'>";
		echo "<select name='locaselect'>";
		if($loca == null){
			echo "<option value='Undefine' selected>Undefine</option>";
		}else{
			echo "<option value='Undefine'>Undefine</option>";
		}
		for($y = 0; $y < count($locaarr); $y++) {
			if($loca == $locaarr[$y]){
		?>
				<option value="<?php echo $locaarr[$y]; ?>" selected ><?php echo $locaarr[$y]; ?></option>
		<?php	}else{ ?>
				<option value="<?php echo $locaarr[$y]; ?>"><?php echo $locaarr[$y]; ?></option>
		<?php	}
		}
		echo "</select>";
		echo "<input type='text' hidden  name='dvidselect' value='".$dvid."' />";
		echo " <input type='submit' name='submitloca' value='Set location' />";
		echo "</form>";
		echo "</td>";
		echo "<td>";
		echo "<form action='#' method='post'>";
		echo "<input type='text' hidden  name='dvidselect' value='".$dvid."' />";
		?>
		<input onclick="return confirm('Are you sure to delete ?')" type="image" src="./img/delete.png" width="30" height="30" name="submitdele">
		<?php
		echo "</form>";
		echo "</td>";
		echo "</tr>";	
		if($row["type"] == "DHT11"){	       
			echo "<tr>";
			echo "<th><img src='./img/1.png' width='100' height='100'></img><br><br>Device ID</th>";
			echo "<th><img src='./img/2.png' width='100' height='100'></img><br><br>Temparature</th>";
			echo "<th><img src='./img/3.png' width='80' height='100'></img><br><br>Humidity</th>";
			echo "<th><img src='./img/4.png' width='100' height='100'></img><br><br>Time</th>";
			echo "</tr>";
			echo "<tr>";
			echo "<th>".$row["device_id"]."</th>";
			echo "<th>".$row["temp"]."</th>";
			echo "<th>".$row["humi"]."</th>";
			echo "<th>".$row["timestamp"]."</th>";
			echo "</tr>";
			echo "</table>";
		}else if($row["type"] == "TH50K"){	       
			echo "<tr>";
			echo "<th><img src='./img/1.png' width='100' height='100'></img><br><br>Device ID</th>";
			echo "<th colspan='2'><img src='./img/5.png' width='100' height='100'></img><br><br>Water</th>";
			echo "<th><img src='./img/4.png' width='100' height='100'></img><br><br>Time</th>";
			echo "</tr>";
			echo "<tr>";
			echo "<th>".$row["device_id"]."</th>";
			if($row["water"] == 0){
				echo "<th colspan='2'>Yes</th>";
			}else{
				echo "<th colspan='2'>No</th>";
			} 		
			echo "<th>".$row["timestamp"]."</th>";
			echo "</tr>";
			echo "</table>";		
		}	
		echo "</br>";
   	    }
	}	
} else {
    echo "0 results";
}
$conn->close();

if($_POST['submitfav_x'] || $_POST['submitfav_y'] ){
	$selected_dvid = $_POST['dvidselect'];
	$sql = "UPDATE home SET fav = 1 WHERE device_id='".$selected_dvid."'";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
    		echo "<meta http-equiv='refresh' content='0'>";	
	} else {
    		echo "Error" . $conn->error;
	}
	$conn->close();
}else if($_POST['submitopfav_x'] || $_POST['submitopfav_y']){
	$selected_dvid = $_POST['dvidselect'];
	$sql = "UPDATE home SET fav = 0 WHERE device_id='".$selected_dvid."'";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
    		echo "<meta http-equiv='refresh' content='0'>";	
	} else {
    		echo "Error" . $conn->error;
	}
	$conn->close();
}else if($_POST['submitsec']){
	$selected_val = $_POST['secselect'];  // Storing Selected Value In Variable
	$selected_dvid = $_POST['dvidselect'];  
	$sql = "UPDATE home SET sec=".$selected_val." WHERE device_id='".$selected_dvid."'";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
	    echo "<meta http-equiv='refresh' content='0'>";	
	} else {
	    echo "Error" . $conn->error;
	}
	$conn->close();
	$call = "sudo python ./sent.py ".$selected_dvid." ".$selected_val;
	echo shell_exec($call);
}else if($_POST['submitloca']){
	$selected_val = $_POST['locaselect'];  // Storing Selected Value In Variable
	$selected_dvid = $_POST['dvidselect'];  
	$sql = 'UPDATE home SET loca="'.$selected_val.'" WHERE device_id="'.$selected_dvid.'"';
	echo $sql;
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
	    echo "<meta http-equiv='refresh' content='0'>";	
	} else {
	    echo "Error" . $conn->error;
	}
	$conn->close();
}else if($_POST['submitdele_x'] || $_POST['submitdele_y']){
	$selected_dvid = $_POST['dvidselect'];  
	$sql = "DELETE FROM home WHERE device_id='".$selected_dvid."'";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
	    echo "<meta http-equiv='refresh' content='0'>";	
	} else {
	    echo "Error" . $conn->error;
	}
	$conn->close();
}else if($_POST['submittab']){
	$selected_id = $_POST['idselect']; 
	$sql = 'UPDATE room SET chk_flg=0 WHERE chk_flg=1'; 
	$sql2 = 'UPDATE room SET chk_flg=1 WHERE rm_id='.$selected_id;
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->query($sql);
	if ($conn->query($sql2) === TRUE) {
	    echo "<meta http-equiv='refresh' content='0'>";	
	} else {
	    echo "Error" . $conn->error;
	}
	$conn->close();
}
echo "</div>";
?>


<script type="text/javascript">
    function reFresh() {
      window.open(location.reload(true))
    }
    window.setInterval("reFresh()",<?php echo $secmin."000" ?>);
</script>

</body>
</html>

