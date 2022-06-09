<?php  
// Initialize the session
session_start();
//Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login-user.php");
    exit;
}?>
<?php
//conn
 require_once "config.php";
 $_SESSION["pass"]="";
 $mysqli = $link;
 $msg = $_SESSION["pass"];
 if($msg=="yes"){
    echo '<script language="javascript">';
    echo 'alert("Password change success")';
    echo '</script>';
 }elseif($msg=="no"){
    echo '<script language="javascript">';
    echo 'alert("Password does not match")';
    echo '</script>';
 }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard Student</title>
    <link rel="icon" href="https://ftk.uthm.edu.my/wp-content/uploads/2021/08/mac_touch-icon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="topbar.css">
</head>

<body class="bg-gradient-primary"style="background-color: #C0C0C0;">
<div class="topnav">
  <a href="profile-student.php">Profile</a>
  <a href="dashboard-student.php">Home</a>
  <a href="student-search-supervisor.php">Search</a>
  <a href="student-search-title-history.php">Title History</a>
  <a class="active" href="">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>
                    <div style="height: 200px; background-color: #C0C0C0;">
                    <form action="update-password-student.php" method="post">
                      <label style="margin-top: 10px;">Enter new Password:</label><br>
                      <input type="password" name="pass1" size="25" style="margin-top: 10px;"><br>
                      <label style="margin-top: 10px;">Re-enter New Password:</label><br>
                      <input type="password" name="pass2" size="25" style="margin-top: 10px;"><br>
                      <input type="submit" value="Change Password" style="margin-top: 10px;">
                    </form>
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
<script>  
 $(document).ready(function(){  
      $('#users').DataTable({
        "order": [[ 1, "asc" ]]
      });  
 });  
 </script>