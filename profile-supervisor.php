<?php  
// Initialize the session
session_start();
//Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login-user.php");
    exit;
}
date_default_timezone_set('Asia/Kuala_Lumpur');
// echo "Today date: ".date('d-m-Y');
?>
<?php
                                              require_once "config.php";
                                              $mysqli = $link;
                                              if(isset($_POST["anf"])){
                                                $id = $_SESSION["username"];
                                                $field = ucwords($_POST["field"]);
                                                $sql_check = "SELECT *FROM bidang WHERE nama_bidang LIKE '%".$field."%'";
                                                
                                                if(mysqli_num_rows(mysqli_query($link,$sql_check))==0){

                                                  $new_title = "INSERT INTO bidang(nama_bidang) VALUES ('".$field."')";
                                                  mysqli_query($link, $new_title);

                                                  $search_id = "SELECT *FROM bidang WHERE nama_bidang='".$field."'";
                                                  $search_result = mysqli_query($link, $search_id);

                                                  $field_id = "";
                                                  while($row = mysqli_fetch_array($search_result)){
                                                    $field_id = $row["id_bidang"];
                                                      }

                                                  $insert_field = "INSERT INTO bidang_penyelia(id_bidang,id_penyelia) VALUES ('".$field_id."','".$id."') ";
                                                  mysqli_query($link,$insert_field);

                                                }else{
                                                  echo '<script>alert("Input field already in the list.");</script>';
                                                }
                                                
                                              }
                                              ?>
<?php
//conn
 require_once "config.php";
 $mysqli = $link;
 $staffId = $_SESSION["username"];
//get supervisor suggest title
$sql_profile = ("SELECT *from penyelia where id_penyelia='".$staffId."'");
$profile_result = mysqli_query($link,$sql_profile);
//get area of interest
$sql_field = ("SELECT b.nama_bidang,b.id_bidang FROM bidang b,bidang_penyelia p WHERE b.id_bidang=p.id_bidang && id_penyelia='".$staffId."'");
$field_result = mysqli_query($link,$sql_field);

//$sql_get_list = ("SELECT *FROM bidang WHERE  id_bidang not in (SELECT id_bidang FROM bidang_penyelia WHERE id_penyelia='".$staffId."'");
$sql_get_list = ("SELECT *FROM bidang WHERE  id_bidang not in (SELECT id_bidang FROM bidang_penyelia WHERE id_penyelia='".$staffId."') ORDER BY nama_bidang ASC");
$field_list = mysqli_query($link,$sql_get_list);
 ?>
 
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard Supervisor</title>
    <link rel="icon" href="https://ftk.uthm.edu.my/wp-content/uploads/2021/08/mac_touch-icon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/css/Beautiful-Time-Picker.css">
    <link rel="stylesheet" href="assets/css/select2.css">
    <link rel="stylesheet" href="topbar.css">
</head>

<body class="bg-gradient-primary" style="background-color: #C0C0C0;">
    <div class="topnav">
  <a href="dashboard-supervisor.php">Home</a>
  <a class="active" href="profile-supervisor.php">Profile</a>
  <a href="suggest-title-supervisor.php">Suggest Title</a>
  <a href="supervisor-search-title-history.php">Title History</a>
  <a href="password-supervisor.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-1">
                    <div class="card-body p-0">
                        <div class="row">  
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="p-5">
                                    <div class="text-center">
                                        <div style="background-color: #C0C0C0;border-left: 5px solid #0000FF;border-right: 5px solid #0000FF;border-bottom: 5px solid #0000FF;">
                                          <h2><span>Personal Details</span></h2>
                                          <?php
                                            while($row = mysqli_fetch_array($profile_result)){
                                              echo'<label>Name :'.$row["nama_penyelia"].'</label><br>';
                                              echo'<form action="update-phone-sv.php" method="post"><label>Phone Number :</label><input type="text" name="phone" value="'.$row["nombor_telefon"].'"><input type="submit" value="Update" font-size: 20px;"></form>';
                                              echo'<label>Student Limit :'.$row["had"].'</label><br>';
                                              echo'<label>Program Code :'.$row["kod_program"].'</label><br>';
                                            }?>
                                          </div>
                                          <div style="background-color: #C0C0C0;border-left: 5px solid #0000FF;border-right: 5px solid #0000FF;border-bottom: 5px solid #0000FF;padding-bottom: 10px;">
                                            <h2><span>Area of Interest</span></h2>

                                            <form action="add-supervisor-field.php" method="post">
                                                          <label>Add Area of Interest from List:</label><br>
                                                          <select name="field" style="font-size: 20px;">
                                              <?php
                                                  while($r = mysqli_fetch_array($field_list)){
                                                    echo '<option value="'.$r["id_bidang"].'">'.$r["nama_bidang"].'</option>';}
                                              ?>
                                               </select>
                                              <input type="submit" value="Save" name="addnewfield">
                                              </form>
                                              
                                              <form action="profile-supervisor.php" method="POST" style="margin-top: 10px;">
                                                <label>Add New Area of Interest:</label>
                                                <input type="text" name="field" placeholder="Enter new area" style = "margin-bottom: 10px;width: 270px;">
                                                <input type="submit" value="Save" name="anf">
                                              </form>

                                              <h3 style = "margin-bottom: 1px;">Current Area of Interests:</h3>
                                            <table border="2" style="background-color: white;">
                                            <thead>
                                              <tr style="background-color:#000080;color:white;">
                                                <td>My Area</td>
                                                <td>Click to Remove</td>
                                              </tr>
                                            </thead>
                                            <?php
                                            if(mysqli_num_rows($field_result) !=0){
                                              while($row = mysqli_fetch_array($field_result)){
                                                echo'<tr style="background-color:#87CEFA;"><td>'.$row["nama_bidang"].'</td>';
                                                echo'<td><form action="remove-sv-field.php" method="post"><button style="width:150px;background-color: #f44336;" type="submit" name="id_req" value="'.$row["id_bidang"].'">Remove</button></form></td></tr>';  
                                              }
                                            }
                                            ?>
                                          </table>            
                                        </div> 
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
<script>  
 $(document).ready(function(){  
      $('#users').DataTable({
        "order": [[ 1, "asc" ]]
      });  
 });  
 </script>