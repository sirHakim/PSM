<?php
session_start();
$phone = $_POST["phone"];
$id = $_SESSION["username"];
require_once "config.php";
$mysqli = $link;
$sql = ("UPDATE penyelia SET nombor_telefon = '".$phone."' WHERE id_penyelia = '".$id."'");
mysqli_query($link, $sql);
header("location: profile-supervisor.php");
?>