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
$locaarr = array();
$locaidarr = array();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//Get all the Room in database and sort it with the item position
$sqlrm = "SELECT * FROM room ORDER BY posi";
$resultrm = $conn->query($sqlrm);
//Tab choose ID
$chstab = 1;
//Last room position
$lastposi = 3;
echo "<div class='tabset'>";
if ($resultrm->num_rows > 0) {
	$i = 1;
	while($row = $resultrm->fetch_assoc()) {
		if($i == 1){ //Favorite tab
			if($row["chk_flg"] == 1){ //Check if the tab is selected
				echo "<form id='checkedtab' class='sttab' action='#' method='post'>";
				$chstab = $row["rm_id"];
			}else{
				echo "<form class='sttab' action='#' method='post'>";
			}
			//Show the tab
			echo "<input type='text' hidden  name='idselect' value='".$row["rm_id"]."' />";
			echo "<input hidden type='submit' id='tab".$i."' name='submittab'>";
			echo "<label class='lbtab' for='tab".$i."'><img src='./img/fvat.png' width='15' height='15'> ".$row["rm_name"]."</img></label>";			
			echo "</form>";
		}else if($row["rm_id"] ==2 && $row["chk_flg"] == 1){ //If the Room manager's tab is selected
			$chstab = 2;
		}else if($row["rm_id"] != 2){ //Other user's defined tab
			if($row["chk_flg"] == 1){ 
				echo "<form id='checkedtab' class='sttab' action='#' method='post'>";
				$chstab = $row["rm_id"];				
			}else{
				echo "<form class='sttab' action='#' method='post'>";
			}
			//Show the tab
			echo "<input type='text' hidden  name='idselect' value='".$row["rm_id"]."' />";
			echo "<input hidden type='submit' id='tab".$i."' name='submittab'>";
			echo "<label class='lbtab' for='tab".$i."'>".$row["rm_name"]."</label>";
			echo "</form>";
			//Store the room name
			array_push($locaarr,$row["rm_name"]);
			//Store the room id
			array_push($locaidarr,$row["rm_id"]);
			$lastposi = $row["posi"];
		}
		$i+=1;		
	}	
}
if($chstab != 2){ //If the Room manager's tab is not selected
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
if($chstab != 2){ //If the Room manager's tab is not selected show the Sensor's data
	//Find the min second has been set in device's list 
	$secmin = 60;
	$sql = "SELECT *  FROM home";
	$result = $conn->query($sql);
	//Check flag whether it have any device show
	$dtflg = 0;
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
		$loca = $row["loca_id"];
		$fav = $row["fav"];
		//If the location of the device is Undefine or user define as Favorite it will show in Favorite tab
		//Otherwise it will only show in it's location tab
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
			//Problem with ' in input's value when submit so we have to do like this		
			?>
					<option value="<?php echo $locaidarr[$y]; ?>" selected ><?php echo $locaarr[$y]; ?></option>
			<?php	}else{ ?>
					<option value="<?php echo $locaidarr[$y]; ?>"><?php echo $locaarr[$y]; ?></option>
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
			//Script to show a confirm dialog before you delete this
			?>
			<input onclick="return confirm('Are you sure to delete ?')" type="image" src="./img/delete.png" width="30" height="30" name="submitdele">
			<?php
			echo "</form>";
			echo "</td>";
			echo "</tr>";
			//Change the table style depent on device Type
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

	if($dtflg == 0){ //If no device to show
	    $secmin = 10;
	    echo "<div class='ui-widget'>";
	    echo "<div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;' >";
	    echo "<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>";
	    echo "<strong>Sorry! </strong>You don't have any device in here :(</p>";
	    echo "</div>";
	    echo "</div>";

	}

	$conn->close();
?>	
	<script type='text/javascript'>
		//Script for auto refresh
    	function reFresh() {
      	window.open(location.reload(true))
		}
    	window.setInterval('reFresh()', <?php echo $secmin."000" ?> );
	</script>
<?php
}else{ //Case Room manager's tab selected

	//Show the sortable room list
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
?>
	<script>
	//Script for save the sort room list
	function saveRm(){
	    var data = [];
            var data2 = [];
		
		//Get each li
        $("li").each(function(){
            data.push($(this).attr('data-id'));
        })
		
		//Get each input inside li element
	    $("li form input").each(function(){
		var name = $(this).attr("name");
			// if the input's name contain rmID
			if((name) && name.indexOf("rmID") != -1){
	    		data2.push($(this).val());
			}
	    })
		
		//Push to update.php
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
<?php	
}

if($_POST['submitfav_x'] || $_POST['submitfav_y'] ){ //Submit for make device be favorite
	//Get the submited value
	$selected_dvid = $_POST['dvidselect'];
	$sql = "UPDATE home SET fav = 1 WHERE device_id='".$selected_dvid."'";
	$conn = new mysqli($servername, $username, $password, $dbname);
	//Execute the sql
	if ($conn->query($sql) === TRUE) {
			//refesh page after successfull
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
}else if($_POST['submitopfav_x'] || $_POST['submitopfav_y']){ //Submit for make device be unfavorite
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
}else if($_POST['submitsec']){ //Submit for changing device's refresh time
	$selected_val = $_POST['secselect']; 
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
	//Send the new refesh time to device
	$call = "sudo python ./python/sent.py ".$selected_dvid." ".$selected_val;
	shell_exec($call);
}else if($_POST['submitloca']){ //Submit for changing device's location
	$selected_val = $_POST['locaselect'];
	$selected_dvid = $_POST['dvidselect'];  
	$sql = 'UPDATE home SET loca_id='.$selected_val.' WHERE device_id="'.$selected_dvid.'"';
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
}else if($_POST['submitdele_x'] || $_POST['submitdele_y']){ //Submit for delete the device
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
}else if($_POST['submittab']){ //Submit for changing the tab
	$selected_id = $_POST['idselect']; 
	$sql = 'UPDATE room SET chk_flg=0'; 
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
}else if($_POST['submitdelerm_x'] || $_POST['submitdelerm_y']){ //Submit for delete the room
	$selected_deleid = $_POST['dele_id'];  
	$sql = "DELETE FROM room WHERE rm_id=".$selected_deleid;
	$sql2 = "UPDATE home SET loca_id = 0 WHERE loca_id=".$selected_deleid;
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
}else if($_POST['submitaddrm']){ //Submit for adding room
	$rm_name = $_POST['rmadd']; 
	$rm_posi = $_POST['rmposi'];
	$sql2 = 'INSERT INTO room (rm_name, posi) VALUES ("'.$rm_name.'", '.$rm_posi.')';
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
?>
</body>
</html>

