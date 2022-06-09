<?php
session_start();
$limit = $_POST["newLimit"];
$id = $_POST["svid"];
require_once "config.php";
$mysqli = $link;
$sql = ("UPDATE penyelia SET had = ".$limit." WHERE id_penyelia = '".$id."'");
mysqli_query($link, $sql);
// echo 'limit :'.$limit;
// echo '    id'.$id;
header("location: coordinator-psm-setting.php");
?>