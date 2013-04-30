<?php

$dbcon = null;
$username = "airswoop1";
$password = "kalm";
$host = "localhost";
$database = "colorDB";

if(!$dbcon){
	$dbcon = new mysqli($host, $username, $password, $database);
}
if(!$dbcon){ 
	die('Could not connect: '.mysql_error());
}

?>	