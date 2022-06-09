<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$tajuk = $_POST["title"];
$sql = "INSERT INTO permintaan_tajuk(id_tajuk_penyelia,id_pelajar) VALUES ('".($tajuk)."','".$id."')";
mysqli_query($link, $sql);
header("location: dashboard-student.php");
?>