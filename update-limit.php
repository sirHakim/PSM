<?php
session_start();
$limit = $_POST["limitSV"];
$id = $_SESSION["username"];
require_once "config.php";
$mysqli = $link;
$sql = ("UPDATE penyelia SET had = ".$limit."");
mysqli_query($link, $sql);
header("location: coordinator-psm-setting.php");
?>