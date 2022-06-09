<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$note = $_POST["details"];
$sql = "UPDATE tajuk_pelajar SET penerangan_tajuk = '".$note."' WHERE id_pelajar = '".$id."'";
mysqli_query($link, $sql);
header("location: profile-student.php");
?>