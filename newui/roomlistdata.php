<?php
	$servername = "localhost";
	$username = "root";
	$password = "admin123";
	$dbname = "iot";
	$rm_id = $_GET["id"];
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT device_id, fav, type, temp, humi, open, co, co2, sec, loca_id, DATE_FORMAT(timestamp, '%H:%i:%s') as time FROM home WHERE loca_id=".$rm_id;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		$i = 0;
		while($row = $result->fetch_assoc()) {
			$sql2 = "SELECT rm_name FROM room where rm_id=".$row["loca_id"];
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();			
			if($row["type"] == "DHT11"){	
?>
	<!-- DV1 -->
	<div class="card mb-3">
        <div style="text-align:center;" class="card-header">
			<i class="fa fa-star" id="demo" style="cursor: pointer; color: <?php echo ($row["fav"] == 1) ? "#ffcc00": "black"; ?>;" onclick="editFav('<?php echo($row["device_id"]) ?>', <?php echo($row["fav"]) ?>)"></i><strong> <?php echo($row2["rm_name"]) ?></strong> 
        </div>
        <div class="card-body bg-success">
            <div class="table-responsive">
            <table class="" id="dataTables" width="100%" cellspacing="1">
              <tbody>
                <tr>
                  <td><i class="fa fa-microchip" id="demo" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit; font-style: italic;" type="text" name="dvid" value ="<?php echo($row["device_id"]) ?>" readonly/></td>
                  <td><i class="fa fa-th" id="demo" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="dvid" value ="<?php echo($row["type"]) ?>" readonly/></td>
                  <td><i class="fa fa-tint" id="" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="" value ="<?php echo($row["humi"]) ?> %" readonly/></td>
                  <td><i class="fa fa-thermometer-quarter" id="" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="" value ="<?php echo($row["temp"]) ?> &#8451" readonly/></td>
                  <td><i class="fa fa-clock-o" id="" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="" value ="<?php echo($row["time"]) ?>" readonly/></td>
                </tr>
              </tbody>
            </table>
            </div>
        </div>
        <div class="card-footer text-muted ">
			<a href="detail.php?dvid=<?php echo($row["device_id"]) ?>">
                <div class="panel-footer" style="color: black">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
		</div>
	</div>
<?php
			}else if($row["type"] == "MC52"){
?>
	<!-- DV2 -->
       <div class="card mb-3">
        <div style="text-align:center;" class="card-header">
			<i class="fa fa-star" id="demo" style="cursor: pointer; color: <?php echo ($row["fav"] == 1) ? "#ffcc00": "black"; ?>;" onclick="editFav('<?php echo($row["device_id"]) ?>', <?php echo($row["fav"]) ?>)"></i><strong> <?php echo($row2["rm_name"]) ?></strong> 
        </div>
        <div class="card-body bg-primary">
            <div class="table-responsive">
            <table class="" id="dataTables" width="100%" cellspacing="1">
              <tbody>
                <tr>
					<td><i class="fa fa-microchip" id="demo" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="dvid" value ="<?php echo($row["device_id"]) ?>" readonly/></td>
					<td><i class="fa fa-th" id="demo" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="dvid" value ="<?php echo($row["type"]) ?>" readonly/></td>
                    <td><i class="fa <?php echo ($row["open"] == 1) ? "fa-door-open" : "fa-door-closed"; ?>" id="" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="" value ="<?php echo ($row["open"] == 1) ? "Open" : "Close"; ?>" readonly/></td>
					<td><i class="fa fa-clock-o" id="" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="" value ="<?php echo($row["time"]) ?>" readonly/></td>
                </tr>
              </tbody>
            </table>
            </div>
        </div>
        <div class="card-footer text-muted ">
			<a href="detail.php?dvid=<?php echo($row["device_id"]) ?>">
				<div class="panel-footer" style="color: black">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
		</div>
		</div>
<?php				
			}else if($row["type"] == "MQ135"){
?>
	<!-- DV3 -->
       <div class="card mb-3">
        <div style="text-align:center;" class="card-header">
			<i class="fa fa-star" id="demo" style="cursor: pointer; color: <?php echo ($row["fav"] == 1) ? "#ffcc00": "black"; ?>;" onclick="editFav('<?php echo($row["device_id"]) ?>', <?php echo($row["fav"]) ?>)"></i><strong> <?php echo($row2["rm_name"]) ?></strong> 
        </div>
       <div class="card-body bg-warning">
            <div class="table-responsive">
            <table class="" id="dataTables" width="100%" cellspacing="1">
              <tbody>
                <tr>
                  <td><i class="fa fa-microchip" id="demo" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="dvid" value ="<?php echo($row["device_id"]) ?>" readonly /></td>
                  <td><i class="fa fa-th" id="demo" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="dvid" value ="<?php echo($row["type"]) ?>" readonly /></td>
                  <td><strong>CO2: <input class="form-control-plaintext" style="padding-top: 10px; width:60px; display: inherit;  font-style: italic;" type="text" name="dvid" value ="<?php echo($row["co2"]) ?> PPM" readonly /></strong></td>
                  <td><strong>CO: <input class="form-control-plaintext" style="padding-top: 10px; width:70px; display: inherit;  font-style: italic;" type="text" name="dvid" value ="<?php echo($row["co"]) ?> PPM" readonly /></strong></td>
                  <td><i class="fa fa-info-circle" id="" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="" value ="Okay" readonly /></td>
                  <td><i class="fa fa-clock-o" id="" style="font-size: 25px;"></i> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="" value ="<?php echo($row["time"]) ?>" readonly /></td>
                </tr>
              </tbody>
            </table>
            </div>
        </div>
        <div class="card-footer text-muted ">
		<a href="detail.php?dvid=<?php echo($row["device_id"]) ?>">
            <div class="panel-footer" style="color: black">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
		</div>
		</div>
<?php
			}
		}
	}else{
		echo("There is no device in here :(");
	}
	$conn->close();
?>