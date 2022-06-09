<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id_permintaan = $_POST["complete"];
$nama_tajuk = $id_pelajar = "";
$search_request = ("SELECT pj.id_pelajar,pj.nama_pelajar,tpj.nama_tajuk,tpj.penerangan_tajuk,pj.nombor_telefon,pj.kod_program,bd.nama_bidang,sv.nama_penyelia,pt.id_permintaan
FROM pelajar pj,permintaan_tajuk pt,tajuk_penyelia tp,penyelia sv,tajuk_pelajar tpj,bidang bd 
WHERE
  pj.id_pelajar = pt.id_pelajar &&
  tp.id_tajuk_penyelia = pt.id_tajuk_penyelia &&
  tpj.id_pelajar = pt.id_pelajar &&
  tpj.id_pelajar = pj.id_pelajar &&
  bd.id_bidang = tpj.id_bidang &&
  sv.id_penyelia = tp.id_penyelia &&
  pt.id_permintaan LIKE '".$id_permintaan."'");
  $search_result = mysqli_query($link,$search_request);

while($row = mysqli_fetch_array($search_result)){
	$nama_tajuk = $row["nama_tajuk"];
	$id_pelajar = $row["id_pelajar"];
}
//insert title to table title history
$sql = ("INSERT INTO sejarah_tajuk(id_pelajar,nama_tajuk) VALUES ('".$id_pelajar."','".$nama_tajuk."')");
mysqli_query($link, $sql);
//set status to 4
$update = ("UPDATE permintaan_tajuk SET status='4' WHERE id_permintaan LIKE '".$id_permintaan."'");
mysqli_query($link, $update);
header("location: dashboard-supervisor.php");
?>