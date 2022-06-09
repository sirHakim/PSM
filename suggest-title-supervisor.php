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
                    if(isset($_POST["title"])){
                      $id = $_SESSION["username"];
                      $tajuk = $_POST["title"];
                      $sql = "DELETE FROM tajuk_penyelia WHERE id_tajuk_penyelia = '".$tajuk."'";
                      mysqli_query($link, $sql);
                    }
                    ?>

<?php
//conn
 require_once "config.php";
 $mysqli = $link;
 $staffId = $_SESSION["username"];
//get supervisor suggest title
$sql_suggest = ("SELECT *from tajuk_penyelia where id_penyelia='".$staffId."'");
$suggest_result = mysqli_query($link,$sql_suggest);
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
  <a href="profile-supervisor.php">Profile</a>
  <a class="active" href="suggest-title-supervisor.php">Suggest Title</a>
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
                                    <div class="card card-1" style="height: 80px; background-color: #C0C0C0;">
                    <h3>Suggest New PSM Title</h3>
                    
                    <form action="suggest-title-supervisor.php" method="post">
                      <label>Title Name:</label>
                      <input type="text" name="input_title" style="width: 500px;" placeholder="Enter new title"> <input type="submit" name="submit"class="btn btn-primary" value="Add New Title">
                    </form>
                    <?php
                    $id = $_SESSION["username"];
                    $tajuk = $_POST["input_title"];
                    $check_title = "SELECT *FROM tajuk_penyelia WHERE nama_tajuk LIKE '%".$tajuk."%'";
                    $check_student = "SELECT *FROM tajuk_pelajar WHERE nama_tajuk LIKE '%".$tajuk."%'";
                      if(isset($_POST["submit"])){
                        if(mysqli_num_rows(mysqli_query($link,$check_title))==0 AND mysqli_num_rows(mysqli_query($link,$check_student))==0){
                        $sql = "INSERT INTO tajuk_penyelia (id_penyelia, nama_tajuk) VALUES ('".$id."', '".$tajuk."')";
                        mysqli_query($link, $sql);
                        header("location: suggest-title-supervisor.php");
                        }else{
                          echo '<script>alert("Suggest Title has been used.");</script>';
                        }
                      }
                    ?>
                    
                    </div> 

                    <div class="card card-1" style="display:flex;flex-direction: column; background-color: #C0C0C0;padding-bottom: 10px;">
                    <table border="2" style="background-color: white">
                      <thead>
                        <tr><td colspan="3" style="background-color: #dd4b39;"><h3 style=" text-align: center;">My Suggest Title</h3></td></tr>
                        <tr style="background-color:#000080;color:white;">
                          <td>PSM Title</td>
                          <td>Update</td>
                        </tr>
                      </thead>
                      <?php
                        if(mysqli_num_rows($suggest_result)!=0){
                          while($row = mysqli_fetch_array($suggest_result)){
                          echo ' <form action="suggest-title-supervisor.php" method="post">
                            <tr style="background-color:#87CEFA;"> <td>'.$row["nama_tajuk"].'</td>
                            <td><button type="submit" name="title" value="'.$row["id_tajuk_penyelia"].'">Remove Title</button></td>
                            </tr></form>
                          ';
                        }
                        }elseif(mysqli_num_rows($suggest_result)==0){
                            echo '<tr style="background-color:#87CEFA;"><td colspan="3">Please create a new suggetion title for PSM.</td></tr>';}
                      ?>
                    </table>                    </div> 
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