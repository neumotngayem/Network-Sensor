<?php
	$return = shell_exec("sudo iw dev wlan0 scan | grep SSID");
	$connectssid = shell_exec("iwgetid");
	$index = strpos($connectssid,"ESSID");
	$connectssid = substr($connectssid, $index+7, -2);
	$arrssid = explode("SSID:",$return);
?>
<?php if(empty($connectssid)) {?>
		<div class="form-group">
		<select class="form-control" id="ssidselect">
		<?php
			foreach($arrssid as $ssid){
				$ssid = trim($ssid);
				if(empty($ssid)){
					continue;
				}
		?>
		<option value="<?php echo($ssid) ?>" ><?php echo($ssid) ?></option>
		<?php
			}
		?>
		</select>
		</div>
		<div class="form-group">
		<input name="pwssid" placeholder="Password" type="password" class="form-control"></input>
		</div>
		<div class="btn-group ">
			<button class="btn btn-success" style="color: black" onclick="connectwifi()" ><i class="fa fa-wifi" > Connect</i></button>
			<span id='btwifi' class="btn btn-danger" style="cursor: default; color: black" ><strong>Status: </strong><i id="wifistatus">Disconnect</i></span>	
		</div> 
<?php }else{ ?>
		<div class="form-group">
		<select class="form-control" id="ssidselect" disabled>
			<?php
				foreach($arrssid as $ssid){
					$ssid = trim($ssid);
					if(empty($ssid)){
						continue;
					}
			?>
			<option value="<?php echo($ssid) ?>" <?php echo($ssid == $connectssid ) ? "selected" : ""?> ><?php echo($ssid) ?></option>
			<?php
				}
			?>
		</select>
		</div>
		<div class="form-group">
			<input id="pwssidenter" name="pwssid" placeholder="Password" type="password" class="form-control" value="wxnetsystem" disabled ></input>
		</div>
		<div class="btn-group ">
			<button id='btnconnect' class="btn btn-danger" style="color: black" onclick="disconnectwifi()" ><i id='btnconnectstatus' class="fa fa-wifi" > Disconnect</i></button>
			<span id='btwifi' class="btn btn-success" style="cursor: default; color: black" ><strong>Status: </strong><i id="wifistatus">Connect</i></span>
		</div> 
<?php } ?>