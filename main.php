<?php 
@session_start();
require (__DIR__).'/botMother/botMother.php';
require (__DIR__).'/config.php';
require (__DIR__)."/lib/md.php";
require (__DIR__)."/lib/obf.php";


function getIp(){
	$ip = $_SERVER['REMOTE_ADDR'];
	if(in_array($ip, array("::1", "0.0.0.0", "127.0.0.1"))){
		$ip = "1.1.1.1";
	}
	return $ip;
}




if(@$_SESSION['countryCode']==""){
	
$api = "http://ip-api.com/json/".getIp()."?fields=countryCode";
$code = "EN";
	
	
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $api);
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($c);
	curl_close($c);
	
	
	
	$data = json_decode($res, true);

	
	if($data){
		$_SESSION['countryCode'] = $data['countryCode'];
		$code = $_SESSION['countryCode'];
	}
	
	

	
	
}else{
	$code = $_SESSION['countryCode'];
}

 
//Countries Codes
$french_arr = array("FR", "MA", "DZ", "TN","CH", "LU");
$english_arr = array("AU", "CA", "GB", "US", "IE", "IN", "MT", "NZ", "ZA","SG","PH");
$de_arr = array("DE", "BE", "AU");
$es_arr = array("ES","AR","BO","CR","EC","GT","MX","PE","PR","PY","SV","VE","UY");
$sweden_arr = array("SE");




$found_lang = false;

if(in_array($code, $french_arr)){
	$found_lang=true;
	$local = "FR";
}elseif(in_array($code, $english_arr)){
	$found_lang=true;
	$local = "EN";
}elseif(in_array($code, $de_arr)){
	$found_lang=true;
	$local = "DE";
}elseif(in_array($code, $es_arr)){
	$found_lang=true;
	$local = "ES";
}

if($found_lang==false){
	$local = "EN";
}





$langs =  file_get_contents((__DIR__).'/lib/global.json');
$global = json_decode($langs, true);

function getLang($d){
	global $local;
	global $global;
	return $global[$local][$d];
}



 
?>