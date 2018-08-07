<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
<?php
	session_start();
	$dvid = $_GET["dvid"];
	$servername = "localhost";
	$username = "root";
	$password = "admin123";
	$dbname = "iot";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT * FROM home WHERE device_id=$dvid";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		$i = 0;
		$row = $result->fetch_assoc();
?>
      <!-- Detail DHT11's Sensor Data-->
    <div class="card lg-12">
        <div class="card-header" style="text-align: center;">
		<?php
			if(!is_null($_SESSION['user_id'])){
		?>  
		<i class="fa fa-star" id="demo" style="cursor: pointer; color: <?php echo ($row["fav"] == 1) ? "#ffcc00": "black"; ?>;" onclick="editFav('<?php echo($row["device_id"]) ?>', <?php echo($row["fav"]) ?>)"></i><b style="cursor: pointer" data-toggle="modal" data-target="#kbi1"> <?php echo($row["device_name"]); ?></b> 
        <?php
			}else{
		?>
		<i class="fa fa-star" id="demo" style=" color: <?php echo ($row["fav"] == 1) ? "#ffcc00": "black"; ?>;"></i><b> <?php echo($row["device_name"]); ?></b>
		<?php
			}
		?>
		</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="dataTables" width="100%" cellspacing="1">
              <tbody>
				<tr>
				<td colspan='3' style="text-align:center; "><i class="fa fa-clock-o"></i><b> Update on </b><i> <?php echo($row["timestamp"]); ?></i></td>
				<tr>
                <tr>
                  <td style="text-align:center; "><strong>Device ID: <input class="form-control-plaintext" style="width:60px; display: inherit; font-style: italic;" type="text" name="dvid" value ="<?php echo($row["device_id"]); ?>" readonly/></strong></td>
                  <td></td>
                 <td style="text-align:center; "><strong>Device Type: <input class="form-control-plaintext" style="width:60px; display: inherit; font-style: italic;" type="text" name="dvtype" value ="<?php echo($row["type"]); ?>" readonly/></strong></td>
                </tr>
		<?php
		if($row["type"] == "DHT11" ){
			
		?>	
				<tr>
                  <td style="text-align:center; "><strong>Temparature: <input class="form-control-plaintext" style="width:60px; display: inherit; font-style: italic;" type="text" name="" value ="<?php echo($row["temp"]); ?> &#8451" readonly/></strong></td>
                  <td></td>
                 <td style="text-align:center; "><strong>Humidity: <input class="form-control-plaintext" style="width:60px; display: inherit; font-style: italic;" type="text" name="" value ="<?php echo($row["humi"]); ?> %" readonly/></strong></td>
                </tr>		
			    </tbody>
            </table>
		    </div>
        </div>
		<div class="col-lg-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   Temparature and Humidity Line Chart
               </div>
               <!-- /.panel-heading -->
               <div class="panel-body">
                   <div id="morris-area-chart"></div>
               </div>
               <!-- /.panel-body -->
           </div>
           <!-- /.panel -->
        </div>        
		<?php
		$sqlDetail = "SELECT temp, humi, timestamp FROM dht11 WHERE device_id=$dvid AND timestamp > date_sub(now(), interval 5 minute)";
		$resultDetail = $conn->query($sqlDetail);
		$chart_data='';
		$cache_life = '300';
		$timesys = time();
		while($rowDetail = $resultDetail->fetch_assoc()){
				$chart_data .= "{ y: '".$rowDetail['timestamp']."', a: ".$rowDetail['temp'].", b: ".$rowDetail['humi']." }, ";		
		}
		$chart_data = substr($chart_data, 0, -2);
		?>
	<script>
	Morris.Line({
		element: 'morris-area-chart',
		data: [<?php echo $chart_data; ?>],
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Temp', 'Humi'],
		pointFillColors:['#ffffff'],
		pointStrokeColors: ['black'],
		lineColors:['red','blue']
	});
	</script>
	<?php
		}else if($row["type"] == "MC52" ){
	?>		
                <tr>
                   <td style="text-align: center;" colspan="3"  ><i class="fa <?php echo ($row["open"] == 1) ? "fa-door-open" : "fa-door-closed"; ?>" id="" style="font-size: 25px;"></i> <strong> Status: </strong><input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="" value ="<?php echo ($row["open"] == 1) ? "Open" : "Close"; ?>" readonly/></td>                           
				</tr>
              </tbody>
            </table>         
          </div>
        </div>
	<?php		
		}else if($row["type"] == "MQ135" ){
	?>
				<tr>
                    <td style="text-align: center;" colspan="3"  ><i class="fab fa-envira" id="" style="font-size: 25px;"></i><strong> Status:</strong> <input class="form-control-plaintext" style="width:60px; display: inherit;  font-style: italic;" type="text" name="" value ="<?php echo ($row["analog"] >= 100) ? "Bad" : "Okay";?>" readonly/></td>
                </tr>              
                <tr>
                    <td style="text-align:center; "><strong>CO: <input class="form-control-plaintext" style="width:70px; display: inherit; font-style: italic;" type="text"  value ="<?php echo($row["co"]); ?> PPM" readonly/></strong></td>
                    <td style="text-align:center; "><strong>CO2: <input class="form-control-plaintext" style="width:100px; display: inherit; font-style: italic;" type="text"  value ="<?php echo($row["co2"]); ?> PPM" readonly/></strong></td>
                    <td style="text-align:center; "><strong>Ethanol: <input class="form-control-plaintext" style="width:70px; display: inherit; font-style: italic;" type="text"  value ="<?php echo($row["ethanol"]); ?> PPM" readonly/></strong></td>   
                </tr>
                <tr>
					<td style="text-align:center; "><strong>Toluene: <input class="form-control-plaintext" style="width:70px; display: inherit; font-style: italic;" type="text"  value ="<?php echo($row["toluene"]); ?> PPM" readonly/></strong></td>
					<td></td>
                    <td style="text-align:center; "><strong>Acetone: <input class="form-control-plaintext" style="width:70px; display: inherit; font-style: italic;" type="text"  value ="<?php echo($row["acetone"]); ?> PPM" readonly/></strong></td>
                </tr>
              </tbody>
            </table>     
          </div>
        </div>
		<div class="col-lg-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   Air Quality Line Chart
               </div>
               <!-- /.panel-heading -->
               <div class="panel-body">
                   <div id="morris-area-chart"></div>
               </div>
               <!-- /.panel-body -->
           </div>
           <!-- /.panel -->
        </div>        
		<?php
		$sqlDetail = "SELECT co2, co, ethanol, toluene, acetone, timestamp FROM mq135 WHERE device_id=$dvid AND timestamp > date_sub(now(), interval 5 minute)";
		$resultDetail = $conn->query($sqlDetail);
		$chart_data='';
		while($rowDetail = $resultDetail->fetch_assoc()){
				$chart_data .= "{ y: '".$rowDetail['timestamp']."', a: ".$rowDetail['co2'].", b: ".$rowDetail['co'].", c: ".$rowDetail['ethanol'].", d: ".$rowDetail['toluene'].", e: ".$rowDetail['acetone']." }, ";		
		}
		$chart_data = substr($chart_data, 0, -2);
		?>
	<script>
	Morris.Line({
		element: 'morris-area-chart',
		data: [<?php echo $chart_data; ?>],
		xkey: 'y',
		ykeys: ['a', 'b', 'c', 'd', 'e'],
		labels: ['CO2', 'CO', 'Ethanol', 'Toluene', 'Acetone'],
		pointFillColors:['#ffffff'],
		pointStrokeColors: ['black'],
	});
	</script>
	<?php
		}
	?>


	<?php
	}
	?>
	