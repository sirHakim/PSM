
<?php
 require_once "config.php";
// Initialize the session
session_start();
//Check if the user is already logged in, if yes then #ff4938irect him to welcome page
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
  
  <a href="logout.php" style="float: right;">Log Out</a>
</div>
<div style="display: flex;flex-direction: column;flex-wrap: nowrap;justify-content: space-between;background-color: lightyellow;background-color: #C0C0C0;padding-bottom: 10px;">
    <div style="background-color: #C0C0C0;border-left: 5px solid #0000FF;border-right: 5px solid #0000FF;border-bottom: 5px solid #0000FF;border-top: 5px solid #0000FF;text-align: center;border-radius: 10px;"><h2><span>Add New User</span></h2>
        <form action="dashboard-admin.php" method="post">
        <table style="text-align: left;padding: 10px;">
            <tr>
                <td><label>Full Name</label></td><td>: <input type="text" name="name" style="width: 320px;"autocomplete="off"></td><td><label>User Id</label></td><td>: <input type="text" name="id" style="width: 320px;"autocomplete="off"></td><td><label>Phone Number</label></td><td>: <input type="text" name="phone" style="width: 320px;"autocomplete="off"></td>
            </tr>
            <tr>
                <td><label>Porgram Code</label></td><td>: 
                  <select name="program" id="program" style="width: 320px;font-size: 20px;">
                    <option value="BIT">BIT</option>
                    <option value="BIM">BIM</option>
                    <option value="BIP">BIP</option>
                    <option value="BIS">BIS</option>
                    <option value="BIW">BIW</option>
                  </select></td><td><label>User Type</label></td>
                  <td>:<input type="radio" name="usertype" id="usr1" value="pelajar">
                    <label for="flexRadioDefault1" checked>Student</label>
                    <input type="radio" name="usertype" id="usr2" value="penyelia">
                    <label for="flexRadioDefault1">Supervisor</label>
                    <input type="radio" name="usertype" id="usr3" value="penyelaras">
                    <label for="flexRadioDefault1">Coordinator</label></td><td></td><td style="text-align: right;"><input type="submit" value="Create New User" name="submitnewuser"></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td></td>
            </tr>
        </table>
    </form>
        <?php
require_once "config.php";
$mysqli = $link;
if(isset($_POST["submitnewuser"])){
if(empty(trim($_POST["name"])) or empty(trim($_POST["id"])) or empty(trim($_POST["phone"])) or empty(trim($_POST["usertype"]))){
  echo '<a style="background-color: yellow;width:320px;">Please fill up all information to create new user.</a>';
}else{
  //get input from user
  $name = strtoupper($_POST["name"]);
  $id = strtoupper($_POST["id"]);
  $program = $_POST["program"];
  $phone = $_POST["phone"];
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
    echo'<a>Something went wrong!</a>';
  }
}
}
  ?>
    </div>
</div>
<div style="background-color: #C0C0C0;border-left: 5px solid #0000FF;border-right: 5px solid #0000FF;border-bottom: 5px solid #0000FF;border-top: 5px solid #0000FF;text-align: left;height: relative;border-radius: 10px;overflow: auto;"><h2><span>Search User</span></h2>
        <form action="dashboard-admin.php" method="post" style="padding: 10px;">
                    <label>Search: </label>
                    <input type="text" name="searchVal" style="width: 300px;" placeholder="Enter username or id">
                    <input type="radio" name="usertype" id="usr1" value="pelajar" checked = "checked">
                    <label >Student</label>
                    <input type="radio" name="usertype" id="usr2" value="penyelia">
                    <label >Supervisor</label>
                    <input type="radio" name="usertype" id="usr3" value="penyelaras">
                    <label >Coordinator</label>
                    <input type="submit" value="Search" name="submitsearch">
                   </form>
                    <?php 
                                            if(isset($_POST["submitsearch"])){
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
                                                <td><input type="password" name="password" value = "'.$row["kata_laluan"].'" style="width:150px;"></td>
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
