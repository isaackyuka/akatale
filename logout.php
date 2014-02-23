<?php 
session_start();
session_destroy();
$return_url = base64_decode($_GET["return_url"]); //return url
	header('Location:'.$return_url);
?>