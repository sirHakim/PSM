<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$req_id = $_POST["id_req"];
$id_pelajar = $_POST["studentid"];
//$sql = "INSERT INTO bidang_penyelia(id_bidang,id_penyelia) VALUES ('".($bidang)."','".$id."')";
$update_request = "UPDATE permintaan_diselia SET status = '2' WHERE id_permintaan = ".$req_id."";
mysqli_query($link, $update_request);
$update_student = "UPDATE pelajar SET id_penyelia = '".$id."' WHERE id_pelajar = '".$id_pelajar."'";
mysqli_query($link,$update_student);
header("location: dashboard-supervisor.php");
?>