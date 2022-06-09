
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

 if(isset($_POST["submit"])){
  if(empty(trim($_POST["phoneNumber"]))){
    echo '<script>alert("Phone number is empty.");</script>';
  }else{
    if(is_numeric($_POST["phoneNumber"])){
      $sql = "UPDATE penyelaras set nombor_telefon='".$_POST["phoneNumber"]."' WHERE id_penyelaras LIKE '".$_SESSION["username"]."'";
      if(mysqli_query($link,$sql)){
        echo '<script>alert("Phone number is updated.");</script>';
      }else{
        echo '<script>alert("Cannot Update!");</script>';
      }
    }else{
      echo '<script>alert("Phone number must be integer");</script>';
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
    <link rel="stylesheet" href="assets/css/Beautiful-Time-Picker.css">
    <link rel="stylesheet" href="topbar.css">
</head>

<body class="bg-gradient-primary" style="background-color: #C0C0C0;">
<div class="topnav">
  <a class="active" href="profile-coordinator.php">Profile</a>
  <a href="coordinator-psm-setting.php">PSM Setting</a>
  <a href="coordinator-search-title.php">Search</a>
  <a href="coordinator-search-title-history.php">Title History</a>
  <a href="coordinator-generate-report.php">Generate Report</a>
  <a href="password-coordinator.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>
                  <div style="background-color: #C0C0C0;border-left: 5px solid #0000FF;border-right: 5px solid #0000FF;border-bottom: 5px solid #0000FF;padding-bottom: 10px;">
                                          <h2><span>Personal Details</span></h2>
                    <table>
                      <form action="profile-coordinator.php" method="post">
                    <?php
                    $sql_profile = "SELECT *FROM penyelaras WHERE id_penyelaras = '". $staffId."'";
                    $my_profile = mysqli_query($link,$sql_profile);
                    while($row = mysqli_fetch_array($my_profile)){
                      echo '<tr><td>Coordinator Name</td><td>:'.$row["nama_penyelaras"].'</td></tr>';
                      echo'<tr><td>Coordinator Id</td><td>:'.$row["id_penyelaras"].'<input type="hidden" name="cid" value="'.$row["id_penyelaras"].'"></td></tr>';
                      echo'<tr><td>Program Code</td><td>:'.$row["kod_program"].'</td></tr>';
                      echo'<tr><td>Phone Number</td><td>:<input type="text" name="phoneNumber" value="'.$row["nombor_telefon"].'">';
                    }
                    ?>
                    <button type="submit" value="update" name="submit">Update</button></td></tr>
                  </form>
                    </table>

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