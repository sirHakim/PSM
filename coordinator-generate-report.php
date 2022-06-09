<?php  
// Initialize the session
session_start();
 
//Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login-user.php");
    exit;
}

?>
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
    <title>Dashboard Coordinator</title>
    <link rel="icon" href="https://ftk.uthm.edu.my/wp-content/uploads/2021/08/mac_touch-icon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/css/Beautiful-Time-Picker.css">
    <link rel="stylesheet" href="assets/css/select2.css">
    <link rel="stylesheet" href="topbar.css">
</head>
<body class="bg-gradient-primary" style="background-color: #C0C0C0;">
<div class="topnav">
  <a href="profile-coordinator.php">Profile</a>
  <a href="coordinator-psm-setting.php">PSM Setting</a>
  <a href="coordinator-search-title.php">Search</a>
  <a href="coordinator-search-title-history.php">Title History</a>
  <a class="active" href="coordinator-generate-report.php">Generate Report</a>
  <a href="password-coordinator.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>

<div style="background-color: #C0C0C0; padding-top: 10px;">
  <form action="coordinator-generate-report.php" method="post">
    <label>Select Data:</label>
  <select name="selectData" style="font-size: 20px;">
  <option value="1">Supervisor Details</option>
  <option value="2">Student Details</option>
  <option value="3">Supervisor avilable to supervise</option>
  <option value="4">Student with No Supervisor</option>
</select> 
<input type="submit" name="submit" value="Generate Data">
  </form>                  
</div>
<div id="printContent" style="background-color: #C0C0C0; padding-top: 10px;display:flex;flex-direction: column;">
  <?php
  require_once "config.php";
  $mysqli = $link;
  if(isset($_POST["submit"])){
    $option = $_POST["selectData"];
    //1
    $op1 = "SELECT * FROM penyelia";
    $op1_result = mysqli_query($link,$op1);
    //2
    $op2 = "SELECT *FROM pelajar";
    $op2_result = mysqli_query($link,$op2);
    //3
    $op3 = "SELECT pj.id_penyelia,sv.nama_penyelia,CASE WHEN COUNT(pj.id_penyelia)<sv.had THEN'Available'ELSE'Full'END AS 'ats' ,count(pj.id_penyelia) AS 'ts',sv.had AS 'limit' FROM pelajar pj,penyelia sv WHERE pj.id_penyelia=sv.id_penyelia AND sv.kod_program LIKE '".$_SESSION["program"]."' GROUP BY id_penyelia";
    $op3_result = mysqli_query($link,$op3);
    //4
    $op4 = "SELECT *FROM pelajar WHERE id_penyelia IS NULL AND kod_program LIKE '".$_SESSION["program"]."'";
    $op4_result = mysqli_query($link,$op4);
    if($option=='1'){
      echo '<h1>List of Supervisor for '.$_SESSION["program"].'</h1>';
      echo'<table border="2" style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Staff Id</td><td>Name</td><td>Phone Number</td><td>Supervise Limit</td></tr></thead>';
      while($row = mysqli_fetch_array($op1_result)){
        echo '<tr style="background-color:#87CEFA;"><td>'.$row["id_penyelia"].'</td><td>'.$row["nama_penyelia"].'</td><td>'.$row["nombor_telefon"].'</td><td>'.$row["had"].'</td></tr>';}
      echo'</table>';
    }elseif($option=='2'){
      echo '<h1>List of Student for '.$_SESSION["program"].'</h1>';
      echo'<table border="2" style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Matric Number</td><td>Name</td><td>Phone Number</td><td>Supervisor Id </td></tr></thead>';
      while($row = mysqli_fetch_array($op2_result)){
        echo '<tr style="background-color:#87CEFA;"><td>'.$row["id_pelajar"].'</td><td>'.$row["nama_pelajar"].'</td><td>'.$row["nombor_telefon"].'</td><td>'.$row["id_penyelia"].'</td></tr>';}
      echo'</table>';
    }elseif($option=='3'){
      echo '<h1>List of Supervisor Available to Supervise '.$_SESSION["program"].'</h1>';
      echo'<table border="2" style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Staff Id</td><td>Name</td><td>Availabe to Supervise</td><td>Total Student</td></tr></thead>';
      while($row = mysqli_fetch_array($op3_result)){
        echo '<tr style="background-color:#87CEFA;"><td>'.$row["id_penyelia"].'</td><td>'.$row["nama_penyelia"].'</td><td>'.$row["ats"].'</td><td>'.$row["ts"].'/'.$row["limit"].'</td></tr>';}echo'</table>';
    }elseif($option=='4'){
      if(mysqli_num_rows($op4_result)>0){
        echo '<h1>List of Student Without Supervisor '.$_SESSION["program"].'</h1>';
        echo'<table border="2" style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Matric Number</td><td>Name</td><td>Phone Number</td></tr></thead>';
         while($row = mysqli_fetch_array($op4_result)){
        echo '<tr style="background-color:#87CEFA;"><td>'.$row["id_pelajar"].'</td><td>'.$row["nama_pelajar"].'</td><td>'.$row["nombor_telefon"].'</td></tr>';}
      echo'</table>';
      }else{
        echo '<a>No Data!</a>';
      }
    }else{

    }
  }

  ?>
</div>
<?php
if(isset($_POST["submit"])){
  echo'<br><button onclick="printDivContent()">Print</button>';
}
?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/select2-1.js"></script>
    <script src="assets/js/select2-2.js"></script>
    <script src="assets/js/select2-3.js"></script>
    <script src="assets/js/select2-4.js"></script>
    <script src="assets/js/select2-5.js"></script>
    <script src="assets/js/select2-6.js"></script>
    <script src="assets/js/select2.js"></script>
    <script src="assets/js/theme.js"></script>
    <script type="text/javascript">
      function printDivContent(x) {
  var divElementContents = document.getElementById("printContent").innerHTML;
  var windows = window.open('', '', 'height=400, width=400');
  windows.document.write('<html>');
  windows.document.write(divElementContents);
  windows.document.write('</body></html>');
  windows.document.close();
  windows.print();
}

    </script>
</body>
</html>