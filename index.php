<!DOCTYPE html>
<html>
<head>
<meta charset ="UTF-8">
<link rel="shortcut icon" href="./img/home.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
<title>Home</title>
</head>

<script src="./js/jquery.js"></script>
<script src="./js/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
</script>

<body body background="./img/back.jpg">
<?php
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "iot";
$sec = 30;
$secmin = 60;
$locaarr = array();
$locaidarr = array();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sqlrm = "SELECT * FROM room ORDER BY posi";
$resultrm = $conn->query($sqlrm);
$chstab = 1;
$tabflg = 0;
$lastposi = 3;
echo "<div class='tabset'>";
if ($resultrm->num_rows > 0) {
	$i = 1;
	while($row = $resultrm->fetch_assoc()) {
		if($i == 1){
			if($row["chk_flg"] == 1){ 
				echo "<form id='checkedtab' class='sttab' action='#' method='post'>";
				$chstab = $row["rm_id"];
			}else{
				echo "<form class='sttab' action='#' method='post'>";
			}
			echo "<input type='text' hidden  name='idselect' value='".$row["rm_id"]."' />";
			echo "<input hidden type='submit' id='tab".$i."' name='submittab'>";
			echo "<label class='lbtab' for='tab".$i."'><img src='./img/fvat.png' width='15' height='15'> ".$row["roomnm"]."</img></label>";			
			echo "</form>";
		}else if($row["rm_id"] ==2 && $row["chk_flg"] == 1){
			$tabflg = 1;
		}else if($row["rm_id"] != 2){
			if($row["chk_flg"] == 1){ 
				echo "<form id='checkedtab' class='sttab' action='#' method='post'>";
				$chstab = $row["rm_id"];				
			}else{
				echo "<form class='sttab' action='#' method='post'>";
			}
			echo "<input type='text' hidden  name='idselect' value='".$row["rm_id"]."' />";
			echo "<input hidden type='submit' id='tab".$i."' name='submittab'>";
			echo "<label class='lbtab' for='tab".$i."'>".$row["roomnm"]."</label>";
			echo "</form>";
			array_push($locaarr,$row["roomnm"]);
			array_push($locaidarr,$row["rm_id"]);
			$lastposi = $row["posi"];
		}
		$i+=1;		
	}	
}
if($tabflg == 0){ 
	echo "<form class='sttab' action='#' method='post'>";
	echo "<input type='text' hidden  name='idselect' value='2' />";
	echo "<input hidden type='submit' id='tab".$i."' name='submittab'>";
	echo "<label class='lbtab' for='tab".$i."'><img src='./img/mana.png' width='15' height='15'> Room manager</label>";
	echo "</form>";
}else{
	echo "<form id='checkedtab' class='sttab' action='#' method='post'>";
	echo "<input type='text' hidden  name='idselect' value='2' />";
	echo "<input hidden type='submit' id='tab".$i."' name='submittab'>";
	echo "<label class='lbtab' for='tab".$i."'><img src='./img/mana.png' width='15' height='15'> Room manager</label>";
	echo "</form>";
}
echo "</div>";

echo "<div id='content'>";
if($tabflg == 0){ 
	$sql = "SELECT *  FROM home";
	$result = $conn->query($sql);
	$dtflg = 0;
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
		$loca = $row["loca"];
		$fav = $row["fav"];
		if(($chstab == 1 && $fav == 1) || ($chstab == 1 && $loca == 0) || ($loca == $chstab)){ 
			$dtflg = 1;
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
			if($loca == 0){
				echo "<option value='0' selected>Undefine</option>";
			}else{
				echo "<option value='0'>Undefine</option>";
			}
			for($y = 0; $y < count($locaarr); $y++) {
				if($loca == $locaidarr[$y]){
			?>
					<option value="<?php echo $locaidarr[$y]; ?>" selected ><?php echo $locaarr[$y]; ?></option>
			<?php	}else{ ?>
					<option value="<?php echo $locaidarr[$y]; ?>"><?php echo $locaarr[$y]; ?></option>
			p<?php	}
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
	} 

	if($dtflg == 0){
	    $secmin = 10;
	    echo "<div class='ui-widget'>";
	    echo "<div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;' >";
	    echo "<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>";
	    echo "<strong>Sorry! </strong>You don't have any device in here :(</p>";
	    echo "</div>";
	    echo "</div>";

	}

	$conn->close();

}else{
	
	echo "<ul id='sortable'>";
	for($y = 0; $y < count($locaarr); $y++){
?>
		<li data-id="<?php echo $locaidarr[$y] ?>"><span class="sorticon"></span><form action='#' method='post'><input name="dele_id" hidden value="<?php echo $locaidarr[$y] ?>"/><input name="rmID<?php echo $y ?>" value="<?php echo $locaarr[$y] ?>"/><input class ='deroom' onclick="return confirm('Are you sure to delete ?')" type="image" src="./img/delete.png" width="30" height="30" name="submitdelerm"></form></li>
<?php
	}
	echo "</ul>";
	echo "<button id='btnsaverm' type='button' onclick='saveRm()'>Save</button>";
	echo "<form id='fmroom' action='#' method='post'>";
	echo "<input id='rminput' type='text' name='rmadd' required/>";
	echo "<input hidden type='text' name='rmposi' value='".$lastposi."'/>";
	echo "<input id='addrmsm' type='submit' name='submitaddrm' value='Add room' />";
	echo "</form>";
}

if($_POST['submitfav_x'] || $_POST['submitfav_y'] ){
	$selected_dvid = $_POST['dvidselect'];
	$sql = "UPDATE home SET fav = 1 WHERE device_id='".$selected_dvid."'";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
    		echo "<meta http-equiv='refresh' content='0'>";	
	} else {
		echo "<div class='ui-widget'>";
		echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
		echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
		echo "<strong>Alert: </strong>Something went wrong with your device</p>";
		echo "</div>";
		echo "</div>";
	}
	$conn->close();
}else if($_POST['submitopfav_x'] || $_POST['submitopfav_y']){
	$selected_dvid = $_POST['dvidselect'];
	$sql = "UPDATE home SET fav = 0 WHERE device_id='".$selected_dvid."'";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
    		echo "<meta http-equiv='refresh' content='0'>";	
	} else {
    		echo "<div class='ui-widget'>";
		echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
		echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
		echo "<strong>Alert: </strong>Something went wrong with your device</p>";
		echo "</div>";
		echo "</div>";
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
	    	echo "<div class='ui-widget'>";
		echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
		echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
		echo "<strong>Alert: </strong>Something went wrong with your device</p>";
		echo "</div>";
		echo "</div>";
	}
	$conn->close();
	$call = "sudo python ./python/sent.py ".$selected_dvid." ".$selected_val;
	shell_exec($call);
}else if($_POST['submitloca']){
	$selected_val = $_POST['locaselect'];  // Storing Selected Value In Variable
	$selected_dvid = $_POST['dvidselect'];  
	$sql = 'UPDATE home SET loca='.$selected_val.'WHERE device_id="'.$selected_dvid.'"';
	echo $sql;
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
	    	echo "<meta http-equiv='refresh' content='0'>";	
	} else {
    		echo "<div class='ui-widget'>";
		echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
		echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
		echo "<strong>Alert: </strong>Something went wrong with your device</p>";
		echo "</div>";
		echo "</div>";
	}
	$conn->close();
}else if($_POST['submitdele_x'] || $_POST['submitdele_y']){
	$selected_dvid = $_POST['dvidselect'];  
	$sql = "DELETE FROM home WHERE device_id='".$selected_dvid."'";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
	    	echo "<meta http-equiv='refresh' content='0'>";	
	} else {
	        echo "<div class='ui-widget'>";
		echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
		echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
		echo "<strong>Alert: </strong>Something went wrong with your device</p>";
		echo "</div>";
		echo "</div>";
	}
	$conn->close();
}else if($_POST['submittab']){
	$selected_id = $_POST['idselect']; 
	$sql = 'UPDATE room SET chk_flg=0 WHERE chk_flg=1'; 
	$sql2 = 'UPDATE room SET chk_flg=1 WHERE rm_id='.$selected_id;
	$conn = new mysqli($servername, $username, $password, $dbname);
	if (($conn->query($sql) === TRUE) && ($conn->query($sql2) === TRUE)) {
	    	echo "<meta http-equiv='refresh' content='0'>";	
	} else {
	        echo "<div class='ui-widget'>";
		echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
		echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
		echo "<strong>Alert: </strong>Something went wrong with your device</p>";
		echo "</div>";
		echo "</div>";
	}
	$conn->close();
}else if($_POST['submitdelerm_x'] || $_POST['submitdelerm_y']){
	$selected_dvid = $_POST['dele_id'];  
	$sql = "DELETE FROM room WHERE rm_id=".$selected_dvid;
	$sql2 = "UPDATE home SET loca = 0 WHERE loca=".$selected_dvid;
	$conn = new mysqli($servername, $username, $password, $dbname);
	if (($conn->query($sql) === TRUE) && ($conn->query($sql2) === TRUE)) {
	    	echo "<meta http-equiv='refresh' content='0'>";	
	} else {
	   	echo "<div class='ui-widget'>";
		echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
		echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
		echo "<strong>Alert: </strong>Something went wrong with your device</p>";
		echo "</div>";
		echo "</div>";
	}
	$conn->close();
}else if($_POST['submitaddrm']){
	$rm_name = $_POST['rmadd']; 
	$rm_posi = $_POST['rmposi'];
	$sql2 = 'INSERT INTO room (roomnm, posi) VALUES ("'.$rm_name.'", '.$rm_posi.')';
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->query($sql);
	if ($conn->query($sql2) === TRUE) {
	 	echo "<meta http-equiv='refresh' content='0'>";	
	} else {
	    	echo "<div class='ui-widget'>";
		echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
		echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
		echo "<strong>Alert: </strong>Something went wrong with your device</p>";
		echo "</div>";
		echo "</div>";
	}
	$conn->close();
}
echo "</div>";

if($tabflg == 0){ ?>
	<script type='text/javascript'>
    	function reFresh() {
      	window.open(location.reload(true))
	}
    	window.setInterval('reFresh()', <?php echo $secmin."000" ?> );
	</script>
<?php }else{ ?>
	<script>
	function saveRm(){
	    var data = [];
            var data2 = [];

            $("li").each(function(){
                data.push($(this).attr('data-id'));
            })

	    $("li form input").each(function(){
		var name = $(this).attr("name");

		if((name) && name.indexOf("rmID") != -1){
	    		data2.push($(this).val());
		}
	    })

            $.ajax({
                url: 'update.php', 
                dataType: 'text',
                cache: false,
                data: {
		data:  data.join('-'),
		data2: data2.join('-'),
		},                       
                method: 'post',
                success: function(res){ 
                    location.reload();
                }
            });
        }
	</script>
<?php } ?>
</body>
</html>

