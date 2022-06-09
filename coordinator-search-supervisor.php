
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
    <link rel="stylesheet" href="topbar.css">
</head>

<body class="bg-gradient-primary" style="background-color: #C0C0C0;">
<div class="topnav">
  <a href="profile-coordinator.php">Profile</a>
  <a href="coordinator-psm-setting.php">PSM Setting</a>
  <a href="coordinator-search-title.php">Search Title</a>
  <a href="coordinator-search-student.php">Search Student</a>
  <a class="active" href="coordinator-search-supervisor.php">Search Supervisor</a>
  <a href="coordinator-search-title-history.php">Title History</a>
  <a href="coordinator-generate-report.php">Generate Report</a>
  <a href="password-coordinator.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>
<div style="height: 80px; background-color: #C0C0C0;padding-top: 10px;">
<label>Search: </label><input type="text" name="search" placeholder="Enter supervisor name or staff id " size="50"> <button type="submit">Search</button>
</div>
<div style="height: 80px; background-color: #C0C0C0;">
<table></table>
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