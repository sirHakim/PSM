
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
  <a class="active" href="admin-search-user.php">Search User</a>
  <a href="logout.php">Log Out</a>
</div>
<div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding: 10px;">
 <form action="admin-search-user.php" method="post">
                    <label>Search: </label>
                    <input type="text" name="searchVal" style="width: 300px;" placeholder="Enter username or id">
                    <input type="radio" name="usertype" id="usr1" value="pelajar" checked = "checked">
                    <label >Student</label>
                    <input type="radio" name="usertype" id="usr2" value="penyelia">
                    <label >Supervisor</label>
                    <input type="radio" name="usertype" id="usr3" value="penyelaras">
                    <label >Coordinator</label>
                    <input type="submit" value="Search" name="submit">
                   </form>
</div>
<div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding: 10px;">
                                          <?php 
                                            if(isset($_POST["submit"])){
                                            require_once "config.php";
                                            //Set input
                                             $mysqli = $link;
                                             $search=$_POST["searchVal"];
                                             $usertype = "s";
                                             $usertype = $_POST["usertype"];
                                             $_SESSION["usertype"] = $_POST["usertype"];
                                             //SQL 
                                             $student = "SELECT *FROM pelajar WHERE nama_pelajar LIKE '%".$search."%' OR id_pelajar LIKE '%".$search."%'";
                                             $supervisor = "SELECT *FROM penyelia WHERE nama_penyelia LIKE '%".$search."%' OR id_penyelia LIKE '%".$search."%'";
                                             $coordinator = "SELECT *FROM penyelaras WHERE nama_penyelaras LIKE '%".$search."%' OR id_penyelaras LIKE '%".$search."%'";
                                             // Select Search User
                                             if($usertype == "pelajar"){
                                              //student search
                                              $result = mysqli_query($link,$student);
                                             }elseif($usertype == "penyelia"){
                                              //sv search
                                              $result = mysqli_query($link,$supervisor);
                                             }elseif($usertype == "penyelaras"){
                                              //coordinator search
                                              $result = mysqli_query($link,$coordinator);
                                             }else{
                                              echo'<script>alert("Please select user type before search.")</script>';
                                             }
                                             if(mysqli_num_rows($result)!=0){

                                              echo '<table border="2" style="background-color: white; text-align:center;"><thead><tr><td>User Id</td><td>Name</td><td>Phone Number</td><td>Password</td><td>Update Row Data</td></tr></thead>';
                                              while($row = mysqli_fetch_array($result)){
                                                echo '<tr><form action="admin-update-user.php" method="post">
                                                <td><input type="hidden" name="old_id" value="'.$row["id_".$usertype.""].'"><input type="text" name="id" value = "'.$row["id_".$usertype.""].'" style="width:100px;"></td>
                                                <td><input type="text" name="name" value = "'.$row["nama_".$usertype.""].'" style="width:800px;"></td>
                                                <td><input type="text" name="phone" value = "'.$row["nombor_telefon"].'" style="width:150px;"></td>
                                                <td><input type="text" name="password" value = "'.$row["kata_laluan"].'" style="width:150px;"></td>
                                                <td><input type="submit" value="Update Row" name="update"></td>
                                                </form></tr>';
                                              }
                                              echo'</table>';
                                             }else{
                                              echo'<script>alert("Search not found")</script>';
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