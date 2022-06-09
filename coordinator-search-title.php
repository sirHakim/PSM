
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
 //get profile data
 $query = ("SELECT *FROM penyelaras WHERE id_penyelaras = '".$staffId."'");
 $profile = mysqli_query($link,$query);
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
  <a href="coordinator-psm-setting.php">PSM Setting</a>
  <a class="active" href="coordinator-search-title.php">Search</a>
  <a href="coordinator-search-title-history.php">Title History</a>
  <a href="coordinator-generate-report.php">Generate Report</a>
  <a href="password-coordinator.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>

<div style="height: 80px; background-color: #C0C0C0;padding-top: 10px;display:flex;flex-direction: column;">
 <form action="coordinator-search-title.php" method="post">
  <label>Search: </label>
  <input type="text" name="searchVal" size="50">
  <input type="radio" name="pilihan" value="1">
    <label for="flexRadioDefault1" checked>Student</label>
    <input type="radio" name="pilihan" value="2">
    <label for="flexRadioDefault1">Supervisor</label>
    <input type="radio" name="pilihan"  value="3">
    <label for="flexRadioDefault1">Title</label>
  <button type="submit" name="submit">Search</button>
</form>
</div>

<div style="height: 80px; background-color: #C0C0C0;display:flex;flex-direction: column;">
<?php
require_once "config.php";
$mysqli = $link;
if(isset($_POST["submit"])){
  if(isset($_POST["pilihan"])){
    if($_POST["pilihan"]=="1"){
      echo'<table border=1 style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Matric Number</td><td>Name</td><td>Phone Number</td></tr></thead>';
      $sql_op1 = "SELECT * FROM pelajar WHERE kod_program LIKE '".$_POST["searchVal"]."' OR id_pelajar LIKE '%".$_POST["searchVal"]."%' OR nama_pelajar LIKE '%".$_POST["searchVal"]."%'";
      $sql_op1_result = mysqli_query($link,$sql_op1);
      while($row = mysqli_fetch_array($sql_op1_result)){
        echo '<tr style="background-color:#87CEFA;"><td>'.$row["id_pelajar"].'</td><td>'.$row["nama_pelajar"].'</td><td>'.$row["nombor_telefon"].'</td></tr>';}
        echo '</table>';
    }elseif($_POST["pilihan"]=="2"){
      $sql_op2 = "SELECT * FROM penyelia WHERE kod_program LIKE '".$_POST["searchVal"]."' OR id_penyelia LIKE '%".$_POST["searchVal"]."%' OR nama_penyelia LIKE '%".$_POST["searchVal"]."%'";
      $sql_op2_result = mysqli_query($link,$sql_op2);
      echo'<table border=1 style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Staff Id</td><td>Name</td><td>Phone Number</td></tr></thead>';
      while($row = mysqli_fetch_array($sql_op2_result)){
        echo '<tr style="background-color:#87CEFA;"><td>'.$row["id_penyelia"].'</td><td>'.$row["nama_penyelia"].'</td><td>'.$row["nombor_telefon"].'</td></tr>';
      }
      echo '</table>';
    }elseif($_POST["pilihan"]=="3"){
      echo'<table border=1 style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Title Name</td><td>Title By</td><td>Title Type</td></tr></thead>';
      $mysqli = $link;
      $query_pelajar = ("SELECT p.nama_pelajar,tp.nama_tajuk FROM tajuk_pelajar tp,pelajar p WHERE p.id_pelajar=tp.id_pelajar AND p.kod_program LIKE 'BIT' AND tp.nama_tajuk LIKE '%".$_POST["searchVal"]."%'");
      $student = mysqli_query($link, $query_pelajar);
      $query_sv = ("SELECT p.nama_penyelia,tp.nama_tajuk FROM penyelia p,tajuk_penyelia tp WHERE tp.id_penyelia=p.id_penyelia AND tp.nama_tajuk LIKE '%".$_POST["searchVal"]."%'");
      $sv = mysqli_query($link,$query_sv);

      while($row = mysqli_fetch_array($student)){
        echo'<tr style="background-color:#87CEFA;"><td>'.$row["nama_tajuk"].'</td><td>'.$row["nama_pelajar"].'</td><td>Student Title</td></tr>';
      }
      while($rwsv =  mysqli_fetch_array($sv)){
        echo'<tr style="background-color:#87CEFA;"><td>'.$rwsv["nama_tajuk"].'</td><td>'.$rwsv["nama_penyelia"].'</td><td>Supervisor Title</td></tr>';
      }
      echo'</table>';
    }else{

    }
  }else{
    echo '<script>alert("Specify the search option.");</script>';
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