<?php 
require 'main.php';

$log = "VISIT FROM ".$_SERVER['REMOTE_ADDR']."\n";
$fp = fopen("logs.txt", "a");
fwrite($fp, $log);
fclose($fp);


header("location: auth/index.php");

?>