<?php
session_start(); 
//If it have enough data for processing
if(isset($_POST['phone']))
{	  
	//Extract the data got
    $phone = $_POST['phone'];
	$captcha_num = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
	$captcha_num = substr(str_shuffle($captcha_num), 0, 6);
	$_SESSION['captcha'] = $captcha_num;
	$call = "sudo python ../python/sms.py $phone 'CAPTCHA FROM WX-NET host is $captcha_num'";
	shell_exec($call);
	echo($phone);
}else{
	echo("Fail");
}
?>