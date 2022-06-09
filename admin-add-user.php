
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
  <a class="active" href="admin-add-user.php">Add New User</a>
  <a href="admin-search-user.php">Search User</a>
  <a href="logout.php">Log Out</a>
</div>
<div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding: 10px;">
    <h1>Add New User</h1>
     <form action="admin-add-user.php" method="post">
        <table>
            <tr><td><label>Full Name</label></td><td>: <input type="text" name="name" style="width: 320px;"autocomplete="off"></td></tr>
            <tr><td><label>User Id</label></td><td>: <input type="text" name="id" style="width: 320px;"autocomplete="off"></td></tr>
            <tr><td><label>Phone Number</label></td><td>: <input type="text" name="phone" style="width: 320px;"autocomplete="off"></td></tr>
            <tr><td><label>Porgram Code</label></td><td>: 
                  <select name="program" id="program" style="width: 320px;font-size: 20px;">
                  <option value="BIT">BIT</option>
                  <option value="BIM">BIM</option>
                  <option value="BIP">BIP</option>
                  <option value="BIS">BIS</option>
                  <option value="BIW">BIW</option>
                  </select></td></tr>
                  <tr><td><label>User Type</label></td><td>:<input type="radio" name="usertype" id="usr1" value="pelajar">
            <label for="flexRadioDefault1" checked>Student</label>
            <input type="radio" name="usertype" id="usr2" value="penyelia">
            <label for="flexRadioDefault1">Supervisor</label>
            <input type="radio" name="usertype" id="usr3" value="penyelaras">
            <label for="flexRadioDefault1">Coordinator</label></td></tr>
            <tr><td></td><td style="text-align: right;"><input type="submit" value="Create New User" name="submit"></td></tr>
        </table>
    </form>
    <?php
require_once "config.php";
$mysqli = $link;
if(isset($_POST["submit"])){
if(empty(trim($_POST["name"])) or empty(trim($_POST["id"])) or empty(trim($_POST["phone"])) or empty(trim($_POST["usertype"]))){
  echo '<a style="background-color: yellow;width:320px;">Please fill up all information to create new user.</a>';
}else{
  //get input from user
  $name = strtoupper($_POST["name"]);
  $id = trim(strtoupper($_POST["id"]));
  $program = $_POST["program"];
  $phone = trim($_POST["phone"]);
  $usertype = $_POST["usertype"];
//insert input to db
  $sql = "INSERT INTO ".$usertype."(id_".$usertype.",nama_".$usertype.",kod_program,nombor_telefon,kata_laluan) VALUES ('".$id."','".$name."','".$program."','".$phone."','uthm');";
 // $status = mysqli_query($link,$sql);

  if(mysqli_query($link,$sql)){
    if($usertype=="pelajar"){
    $sql_title = "INSERT INTO tajuk_pelajar(nama_tajuk,penerangan_tajuk,id_pelajar) VALUES ('-','-','".$id."')";
    mysqli_query($link,$sql_title);
  }
    echo'<a style="background-color: chartreuse;width:130px;">New User Added!</a>';
  }else{
    echo'<a>User id already exits!</a>';
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