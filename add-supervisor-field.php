<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$bidang = $_POST["field"];
$sql = "INSERT INTO bidang_penyelia(id_bidang,id_penyelia) VALUES ('".($bidang)."','".$id."')";
mysqli_query($link, $sql);
header("location: profile-supervisor.php");
?>