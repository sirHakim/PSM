
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
 //check student request title
 // $sql_check_title = ("SELECT p.id_permintaan,p.id_tajuk_penyelia,p.id_pelajar,t.nama_tajuk,s.nama_penyelia FROM permintaan_tajuk p, tajuk_penyelia t,penyelia s WHERE p.id_tajuk_penyelia=t.id_tajuk_penyelia && t.id_penyelia=s.id_penyelia && p.id_pelajar='".$_SESSION["username"]."'");
 // $title_check = mysqli_query($link, $sql_check_title);
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
  <a class="active" href="dashboard-coordinator.php">Home</a>
  <a href="profile-coordinator.php">Profile</a>
  <a href="coordinator-psm-setting.php">PSM Setting</a>
  <a href="coordinator-search-title.php">Search Title</a>
  <a href="coordinator-search-student.php">Search Student</a>
  <a href="coordinator-search-supervisor.php">Search Supervisor</a>
  <a href="coordinator-search-title-history.php">Title History</a>
  <a href="coordinator-generate-report.php">Generate Report</a>
  <a href="password-coordinator.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>
<div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding-bottom: 10px;">
<?php
 require_once "config.php";
 $mysqli = $link;
 $query = ("SELECT p.nama_penyelia,pb.id_permintaan,pb.nama_bidang,pb.status FROM penyelia p,permintaan_bidang pb WHERE p.id_penyelia=pb.id_penyelia");
 $result = mysqli_query($link,$query);
 if(mysqli_num_rows($result)!=0){
  echo'<table border="2" style="background-color: white">
<thead><tr><td colspan="3" style="background-color: #C0C0C0;"><h3 style=" text-align: center;"><span>New Area of Interest Request</span></h3></td></tr><tr><td>Supervisor Name</td><td>Area name</td><td>Approve/Reject</td></tr></thead>';
  while($row = mysqli_fetch_array($result)){
    if($row["status"]==0){
      echo'<tr><td>'.$row["nama_penyelia"].'</td><td>'.$row["nama_bidang"].'</td><td><button>Approve</button><button>Reject</button></td></tr>';
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