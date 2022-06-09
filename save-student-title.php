<?php
session_start();
$title = $_POST["title"];
$id = $_SESSION["username"];
require_once "config.php";
$mysqli = $link;
$sql = ("UPDATE tajuk_pelajar SET nama_tajuk = '".$title."' WHERE id_pelajar = '".$id."'");
mysqli_query($link, $sql);
header("location: profile-student.php");
?>