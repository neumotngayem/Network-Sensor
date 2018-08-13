<?php
session_start(); 
//If it have enough data for processing
if(isset($_POST['phone']))
{	  
	//Extract the data got
    $phone = $_POST['phone'];
	$call = "sudo python ./python/call.py $phone";
	$return = shell_exec($call);
	if(strpos($return, '+CIEV: "CALL"') != false ){
		$return = "okay";
	}else{
		$return = "fail";
	}
	echo($return);
}else{
	echo("Fail");
}
?>