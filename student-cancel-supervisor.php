<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$sv = $_POST["penyelia"];
$sql = "DELETE FROM permintaan_diselia WHERE id_pelajar = '".$id."'";
mysqli_query($link, $sql);
header("location: dashboard-student.php");
?>