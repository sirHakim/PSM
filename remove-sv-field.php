<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$bidang = $_POST["id_req"];
$sql = "DELETE FROM bidang_penyelia WHERE id_penyelia = '".$id."' && id_bidang='".$bidang."'";
mysqli_query($link, $sql);
header("location: profile-supervisor.php");
?>