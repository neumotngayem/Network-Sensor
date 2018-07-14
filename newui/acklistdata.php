
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
		$i = 0;
	    while($row = $result->fetch_assoc()) {
?>	
				
				<tr>
                 <td style="text-align: center;"><i class="fa fa-star star<?php echo($row["device_id"]) ?>" style="cursor: pointer; margin-top: 12px;" onclick="myFunction('star<?php echo($row["device_id"]) ?>')"></i><input class="star<?php echo($row["device_id"]) ?>" type="text" name="star" hidden value="0"/></td>
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
                  <td style="text-align:center; "><input type='submit' onclick="addRoom('<?php echo($i) ?>')" class="btn bg-primary btn-block" value="Add"/></td>
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
				$i+=1;
		}
	}else{ //If no device to show
?>
	   <p><strong>Sorry! </strong>You don't have any device in here :(</p>
<?php
	}
	$conn->close();
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