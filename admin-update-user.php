<?php
session_start();
require_once "config.php";
$mysqli = $link;
$id = $_POST["id"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$user = $_SESSION["usertype"];
$old_id = $_POST["old_id"];
 $sql = ("UPDATE ".$user." SET id_".$user." = '".$id."',nama_".$user." = '".$name."', nombor_telefon = '".$phone."', kata_laluan = '".$password."' WHERE id_".$user." = '".$old_id."'");
mysqli_query($link, $sql);
// echo 'Name:'. $name;
// echo 'Id'.$id;
// echo 'Phone'.$phone;
// echo 'Password:'.$password;
// echo 'User Type:'.$user;
// echo 'old id:'.$old_id;

header("location: admin-search-user.php");
?>