<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$tajuk = $_POST["title"];
$sql = "DELETE FROM permintaan_tajuk WHERE id_pelajar = '".$id."'";
mysqli_query($link, $sql);
header("location: dashboard-student.php");
?>