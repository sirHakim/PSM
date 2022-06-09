<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$sv = $_POST["penyelia"];
$sql = "INSERT INTO permintaan_diselia(id_pelajar,id_penyelia,status) VALUES ('".$id."','".$sv."','1')";
mysqli_query($link, $sql);
header("location: dashboard-student.php");
?>