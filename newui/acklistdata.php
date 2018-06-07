<table class="table" id="dataTables" width="100%" cellspacing="1">
              <tbody>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "admin123";
	$dbname = "iot";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT device_id, type FROM ack_list";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row

	    while($row = $result->fetch_assoc()) {
?>
                <tr>
				 <form action="adddevice.php" method="post" class="addDevice"> 
                 <td style="text-align: center;"><i class="fa fa-star star<?php echo($row["device_id"]) ?>" style="margin-top: 12px;" onclick="myFunction('star<?php echo($row["device_id"]) ?>')"></i><input class="star<?php echo($row["device_id"]) ?>" type="text" name="star" hidden value="0"/></td>
                 <td style="text-align: center;"><strong>Device ID:</strong><input class="form-control-plaintext" style="width:60px; display: inherit;" type="text" name="dvid" value ="<?php echo($row["device_id"]) ?>" readonly /></td>
                 <td style="text-align: center;"><strong>Device Name:</strong><input class="form-control-plaintext" style="width:60px; display: inherit;" type="text" name="dvtype" value ="<?php echo($row["type"]) ?>" readonly /></td>
                  <td style="text-align: center;">
						<select id="dropdown<?php echo($row["device_id"]) ?>" required name="room" class="bg-warning btn">
							<option value="" selected>Select room</option>
						<?php
							$sqlRm = "SELECT rm_id, rm_name FROM room ORDER BY posi";
							$resultRm = $conn->query($sqlRm);
							if ($resultRm->num_rows > 0) {
								while($rowRm = $resultRm->fetch_assoc()) {
									?>
									<option value="<?php echo($rowRm["rm_id"]) ?>"><?php echo($rowRm["rm_name"]) ?></option>
									<?php
								}
							}
						?>				
						</select>	
                  </td>
                  <td style="text-align:center; "><input type="submit" class="btn bg-primary btn-block" value="Add"/></td>
				  </form>
                </tr>
				
				<script>
					if (sessionStorage.star<?php echo($row["device_id"]) ?>) {
							var check = sessionStorage.star<?php echo($row["device_id"]) ?>;
							document.getElementsByClassName('star<?php echo($row["device_id"]) ?>')[1].setAttribute('value',check)
						    if(check == 0){
								document.getElementsByClassName('star<?php echo($row["device_id"]) ?>')[0].style.color = "black";
							} else {
								document.getElementsByClassName('star<?php echo($row["device_id"]) ?>')[0].style.color = "#ffcc00";
							}
					}
					
					if (sessionStorage.selectItem<?php echo($row["device_id"]) ?>) {
						$('#dropdown<?php echo($row["device_id"]) ?>').val(sessionStorage.selectItem<?php echo($row["device_id"]) ?>);
					}
					
					$('#dropdown<?php echo($row["device_id"]) ?>').change(function() { 
						var dropVal = $(this).val();
						sessionStorage.selectItem<?php echo($row["device_id"]) ?> = dropVal;
					});
				</script>
<?php
		}
	}else{ //If no device to show
		echo "<div class='ui-widget'>";
	    echo "<div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;' >";
	    echo "<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>";
	    echo "<strong>Sorry! </strong>You don't have any device in here :(</p>";
	    echo "</div>";
	    echo "</div>";
	}	
?>
	<tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
	</tbody>
</table>