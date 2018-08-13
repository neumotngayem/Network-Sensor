<?php
session_start(); 
//If it have enough data for processing
if(isset($_POST['phone']) && isset($_POST['mess']))
{	  
	//Extract the data got
    $phone = $_POST['phone'];
	$mess = $_POST['mess'];
	$sms = "sudo python ./python/sms.py $phone '$mess'";
	$return = shell_exec($sms);
	if(strpos($return, '+CMGS:') != false ){
		$return = "okay";
	}else{
		$return = "fail";
	}
	echo($return);
}else{
	echo("Fail");
}
?>