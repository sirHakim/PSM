<?php
 require_once "config.php";
// Initialize the session
session_start();
//Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login-user.php");
    exit;}
    //conn
 $staffId = $_SESSION["username"];
 $mysqli = $link;
 $query = ("SELECT*FROM penyelia");
 $result = mysqli_query($link,$query);
 while($r = mysqli_fetch_array($result)){
  $limit = $r["had"];
 }
 $msg = "";
 ?>
 <?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["submit"])){
    if(empty(trim($_POST["limitSV"]))){
      echo'<script>alert("Field is empty, enter number of student.")</script>';
    }else{
      $input = $_POST["limitSV"];
      if(is_numeric($input)){
        $limit = (int)$input;
        $id = $_SESSION["username"];
        require_once "config.php";
        $mysqli = $link;
        $sql = ("UPDATE penyelia SET had = ".$limit."");
        mysqli_query($link, $sql);
        echo'<script>alert("Student limit updated.")</script>';
      }else{
        echo'<script>alert("Limit must be an integer")</script>';
      }
    }
  }
  }
?>  
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard Coordinator</title>
    <link rel="icon" href="https://ftk.uthm.edu.my/wp-content/uploads/2021/08/mac_touch-icon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="topbar.css">
</head>

<body class="bg-gradient-primary" style="background-color: #C0C0C0;">
<div class="topnav">
  <a href="profile-coordinator.php">Profile</a>
  <a class="active" href="coordinator-psm-setting.php">PSM Setting</a>
  <a href="coordinator-search-title.php">Search</a>
  <a href="coordinator-search-title-history.php">Title History</a>
  <a href="coordinator-generate-report.php">Generate Report</a>
  <a href="password-coordinator.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>      
<div style="background-color: #C0C0C0;border-left: 5px solid #0000FF;border-right: 5px solid #0000FF;border-bottom: 5px solid #0000FF;padding-bottom: 10px;margin-bottom: 20px;">
<form action="coordinator-psm-setting.php" method="post">
<h2 style = "margin-top: 1px;"><span>Set Supervise Limit For All Lecture</span></h2>
<label>Student limit for all supervisor:</label>
<?php

 echo '<input type="text" name="limitSV" value="'.$limit.'"> <button type="submit" name = "submit">Set New Limit</button>';
?>  
</form>
</div>    
<div style="background-color: #C0C0C0;border-left: 5px solid #0000FF;border-right: 5px solid #0000FF;border-bottom: 5px solid #0000FF;padding-bottom: 10px;">
<h2 style = "margin-top: 10px;"><span>Set Supervise Limit by Lecture</span></h2>
<form action = "coordinator-psm-setting.php" method="post">
  <label>Name/Staff Id :</label><input type="text" name="bysv"> <input type="submit" name="submitSV" value = "Search Supervisor">
</form> 
<?php
require_once "config.php";
$mysqli = $link;
if(isset($_POST["submitSV"])){
  $sv_list  = "SELECT * FROM penyelia WHERE kod_program LIKE '".$_SESSION["program"]."' AND id_penyelia LIKE '%".$_POST["bysv"]."%' OR nama_penyelia LIKE '%".$_POST["bysv"]."%'";
  $sv_result = mysqli_query($link,$sv_list);
 echo '<table border="2" style="background-color: white; text-align:center; margin-top:10px;"><thead><tr><td>Staff Id</td><td>Supervisor Name</td><td>Supervise Limit</td><td>Update Limit</td></tr></thead>';
while($row = mysqli_fetch_array($sv_result)){
    echo '<tr><form action = "coordinator-psm-setting.php" method="post">
    <td><input type="hidden" name="svid" value = "'.$row["id_penyelia"].'">'.$row["id_penyelia"].'</td>
    <td>'.$row["nama_penyelia"].'</td>
    <td><input type="text" name="newLimit" value = "'.$row["had"].'" style = "text-align : center;"></td>
    <td><input type="submit" name="svlimit" value = "Update"></td>
    </form></tr>';
}
echo '</table>';
}
?> 
<?php
  if(isset($_POST["svlimit"])){
  $limits = $_POST["newLimit"];
  $ids = $_POST["svid"];
  if(empty(trim($limits))){
    echo'<script>alert("Field is empty, enter number of student.")</script>';
  }else{
    if(is_numeric($limits)){
      $sqls = ("UPDATE penyelia SET had = ".$limits." WHERE id_penyelia = '".$ids."'");
      if(mysqli_query($link, $sqls)){
        echo'<script>alert("Supervise limit is set to '.$limits.' for supervisor id: '.$ids.'")</script>';
      }
    }else{
      echo'<script>alert("Limit must be an integer")</script>';
    }
  }
  
}
?>

</div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/select2-1.js"></script>
    <script src="assets/js/select2-2.js"></script>
    <script src="assets/js/select2-3.js"></script>
    <script src="assets/js/select2-4.js"></script>
    <script src="assets/js/select2-5.js"></script>
    <script src="assets/js/select2-6.js"></script>
    <script src="assets/js/select2.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>