<?php
	$host = "uscitp.com";
	$dbusername = "kaiyuany";
	$dbpassword = "yky930816";
	$database = "kaiyuany_amockzon";

	$db = new mysqli($host, $dbusername, $dbpassword, $database);

	if($db->connect_errno){
    	exit("DB Connection Error: " . $mysqli->connect_error);
	}

?>