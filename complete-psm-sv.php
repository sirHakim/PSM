<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id_permintaan = $_POST["complete"];
$nama_tajuk = $id_pelajar = "";
$search_request = ("SELECT pd.id_permintaan,p.id_pelajar,p.nama_pelajar,tp.nama_tajuk,tp.penerangan_tajuk,p.nombor_telefon,p.kod_program,b.nama_bidang FROM pelajar p,tajuk_pelajar tp,bidang b,permintaan_diselia pd WHERE p.id_pelajar=pd.id_pelajar && p.id_pelajar=tp.id_pelajar && b.id_bidang = tp.id_bidang && pd.status=2 &&  pd.id_permintaan LIKE '".$id_permintaan."'");
  $search_result = mysqli_query($link,$search_request);

while($row = mysqli_fetch_array($search_result)){
	$nama_tajuk = $row["nama_tajuk"];
	$id_pelajar = $row["id_pelajar"];
}
//insert title to table title history
$sql = ("INSERT INTO sejarah_tajuk(id_pelajar,nama_tajuk) VALUES ('".$id_pelajar."','".$nama_tajuk."')");
mysqli_query($link, $sql);
//set status to 4
$update = ("UPDATE permintaan_diselia SET status='4' WHERE id_permintaan LIKE '".$id_permintaan."'");
mysqli_query($link, $update);
header("location: dashboard-supervisor.php");
?>