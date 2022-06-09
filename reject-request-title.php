<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$request_title = $_POST["id_req"];
$id_pelajar = $_POST["idk"];
//$sql = "INSERT INTO bidang_penyelia(id_bidang,id_penyelia) VALUES ('".($bidang)."','".$id."')";
$update_request = "UPDATE permintaan_tajuk SET status = '2' WHERE id_permintaan = ".$request_title."";
mysqli_query($link, $update_request);
$update_student = "UPDATE pelajar SET id_penyelia = NULL WHERE pelajar.id_pelajar = '".$id_pelajar."'";
mysqli_query($link,$update_student);
header("location: dashboard-supervisor.php");
?>