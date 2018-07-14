<?php
	$log_file = 'start.log';
	$cache_life = '5';
	
	$filemtime = @filemtime($log_file);  // returns FALSE if file does not exist
	if (!$filemtime or (time() - $filemtime >= $cache_life)){
?>
	<button class="btn btn-success" onclick="turnonoff('off')" style="color: black" id='btnconnect'><i class="fas fa-power-off" id="system-state1"> Turn on WX-Net host</i></button>
	<span class="btn bg-danger" style="cursor: default; color: black" id='btnstatus' ><strong>Status: </strong><i>Stopped</i></span>
<?php
	}else{
?>
	<button class="btn bg-danger" onclick="turnonoff('on')" style="color: black" id='btnconnect'><i class="fas fa-power-off" id="system-state1"> Turn off WX-Net host</i></button>
	<span class="btn btn-success" style="cursor: default; color: black" id='btnstatus' ><strong>Status: </strong><i>Running</i></span>
<?php
	}
?>