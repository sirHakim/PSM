<?php
session_start();
$_SESSION["pass"] = "no";
$p1 = $_POST["pass1"];
$p2 = $_POST["pass2"];
$id = $_SESSION["username"];
require_once "config.php";
$mysqli = $link;
if(strcmp($p1,$p2)==0){
	$sql = ("UPDATE penyelaras SET kata_laluan = '".$p1."' WHERE id_penyelaras = '".$id."'");
	mysqli_query($link, $sql);
	$_SESSION["pass"] = "yes";
	header("location: password-coordinator.php");	
}else{
	$_SESSION["pass"] = "no";
	header("location: password-coordinator.php");
	
}


?>