<?php
session_start();
$field = $_POST["field"];
$id = $_SESSION["username"];
require_once "config.php";
$mysqli = $link;
$sql = ("UPDATE tajuk_pelajar SET id_bidang = '".$field."' WHERE id_pelajar = '".$id."'");
mysqli_query($link, $sql);
header("location: profile-student.php");
?>