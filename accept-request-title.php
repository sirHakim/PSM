<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_SESSION["username"];
$request_title = $_POST["id_req"];
$new_title = "";
$id_student = "";
$id_pelajar = $_POST["idp"];
//$sql = "INSERT INTO bidang_penyelia(id_bidang,id_penyelia) VALUES ('".($bidang)."','".$id."')";
$update_request = "UPDATE permintaan_tajuk SET status = '1' WHERE id_permintaan = ".$request_title."";
mysqli_query($link, $update_request);

$get_title = "SELECT tp.nama_tajuk,pt.id_pelajar FROM tajuk_penyelia tp, permintaan_tajuk pt WHERE tp.id_tajuk_penyelia=pt.id_tajuk_penyelia && pt.id_permintaan = ".$request_title."";
$title = mysqli_query($link, $get_title);
while($row = mysqli_fetch_array($title)){
	$new_title = $row['nama_tajuk'];
	$id_student = $row['id_pelajar'];
}

$update_student_title = "UPDATE tajuk_pelajar SET nama_tajuk = '".$new_title."',penerangan_tajuk= 'Tajuk Penyelia' WHERE id_pelajar='".$id_student."'";
mysqli_query($link, $update_student_title);
$update_student = "UPDATE pelajar SET id_penyelia = '".$id."' WHERE id_pelajar = '".$id_pelajar."'";
mysqli_query($link,$update_student);

header("location: dashboard-supervisor.php");
?>