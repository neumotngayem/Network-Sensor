<?php
$state = $_GET["state"];
if($state == "off"){
	$call = "sudo python ../python/readver12.py > /dev/null 2>&1 &";
	shell_exec($call);
	//echo '<script type="text/javascript"> window.location = "./device.php"</script>';
}else if($state == "on"){
	$call = "sudo killall python";
	shell_exec($call);
	//echo '<script type="text/javascript"> window.location = "./device.php"</script>';
}
	
?>