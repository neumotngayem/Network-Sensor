<?php
	require 'Converter.php';
	use Pdu\Converter;
	$balance = "sudo python ./python/checkbalance.py";
	$return = shell_exec($balance);
	$decode = Converter::toText($return);
	if(!is_null($decode) && $decode != ''){
		echo($decode);
	}else{
		echo("fail");
	}
?>