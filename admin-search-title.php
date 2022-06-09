
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
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard Administrator</title>
    <link rel="icon" href="https://ftk.uthm.edu.my/wp-content/uploads/2021/08/mac_touch-icon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="topbar.css">
</head>

<body class="bg-gradient-primary" style="background-color: #C0C0C0;">
<div class="topnav">
  <a href="dashboard-admin.php">Home</a>
  <a href="admin-add-user.php">Add New User</a>
  <a href="admin-search-user.php">Search User</a>
  <a class="active" href="admin-search-title.php">Search Title</a>
  <a href="logout.php">Log Out</a>
</div>
<div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding: 10px;">
  <form action="admin-search-user.php" method="post">
                    <label>Search: </label>
                    <input type="text" name="searchVal" style="width: 300px;" placeholder="Enter title name">
                    <input type="submit" value="Search" name="submit">
                   </form>
</div>
<div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding: 10px;">
                                          <?php 
                                            if(isset($_POST["submit"])){
                                            require_once "config.php";
                                             $mysqli = $link;
                                             $search= $_POST["searchVal"];

                                             }

                                          ?>
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