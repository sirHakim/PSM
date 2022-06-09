<?php
session_start();
//Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login-user.php");
    exit;
}
//conn
 require_once "config.php";
 $mysqli = $link;
 //check student request title
 $sql_check_title = ("SELECT s.nombor_telefon,p.id_permintaan,p.id_tajuk_penyelia,p.id_pelajar,t.nama_tajuk,s.nama_penyelia,p.status FROM permintaan_tajuk p, tajuk_penyelia t,penyelia s WHERE p.id_tajuk_penyelia=t.id_tajuk_penyelia && t.id_penyelia=s.id_penyelia && p.id_pelajar='".$_SESSION["username"]."'");
 $title_check = mysqli_query($link, $sql_check_title);
 //check supervisor request
 $sql_sv = ("SELECT p.nombor_telefon,pd.id_permintaan,p.nama_penyelia,p.id_penyelia,pd.status FROM bidang b, penyelia p, bidang_penyelia bp,permintaan_diselia pd WHERE pd.id_penyelia=p.id_penyelia && b.id_bidang=bp.id_bidang && bp.id_penyelia=p.id_penyelia  && pd.id_pelajar='".$_SESSION["username"]."'");
  $sv_check = mysqli_query($link, $sql_sv);
//get supervisor title
$sql_title = ("SELECT tajuk_penyelia.id_tajuk_penyelia,tajuk_penyelia.nama_tajuk,penyelia.nama_penyelia FROM tajuk_penyelia,penyelia where tajuk_penyelia.id_penyelia=penyelia.id_penyelia");
$title = mysqli_query($link, $sql_title);
//search sv match student by field
$sql_supervisor = ("SELECT b.nama_bidang,p.nama_penyelia,p.id_penyelia FROM bidang b, penyelia p, bidang_penyelia bp,tajuk_pelajar tp WHERE b.id_bidang=bp.id_bidang && bp.id_penyelia=p.id_penyelia && b.id_bidang=tp.id_bidang && tp.id_pelajar='".$_SESSION["username"]."'");
$spv = mysqli_query($link, $sql_supervisor);
//search current request sv
$cancel_spv = ("SELECT sv.nama_penyelia,sv.id_penyelia FROM penyelia sv,permintaan_diselia pd WHERE pd.id_penyelia=sv.id_penyelia && pd.id_pelajar='".$_SESSION["username"]."' && pd.status='1'");
$cancel_out = mysqli_query($link,$cancel_spv);
//sv accept request
$sv_confirm_check = ("SELECT p.nama_penyelia FROM permintaan_diselia pd,penyelia p WHERE p.id_penyelia=pd.id_penyelia && id_pelajar = '".$_SESSION["username"]."' && status='2'");
$sv_confirm = mysqli_query($link,$sv_confirm_check);

$title_approve_status = ("SELECT status FROM permintaan_tajuk WHERE id_pelajar LIKE '".$_SESSION["username"]."'");
$sv_approve_status = ("SELECT status FROM permintaan_diselia WHERE id_pelajar LIKE '".$_SESSION["username"]."'");
$get_sql_sv = ("SELECT sv.nombor_telefon,sv.nama_penyelia,tp.nama_tajuk FROM penyelia sv,tajuk_pelajar tp,permintaan_diselia pd WHERE pd.id_penyelia=sv.id_penyelia AND tp.id_pelajar=pd.id_pelajar AND pd.id_pelajar = '".$_SESSION["username"]."'");
$title_status = mysqli_query($link,$title_approve_status);
$sv_status = mysqli_query($link,$sv_approve_status);
$sv_link = mysqli_query($link,$get_sql_sv);
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="topbar.css">
</head>

<body class="bg-gradient-primary" style="background-color: #C0C0C0;">
    <div class="topnav">
  <a href="profile-student.php">Profile</a>
  <a class="active">Home</a>
  <a href="student-search-supervisor.php">Search</a>
  <a href="student-search-title-history.php">Title History</a>
  <a href="password-student.php">Change Password</a>
  <a href="logout.php">Log Out</a>

</div>

<div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding-bottom: 10px;">
                   
<table id="tb1" border="2" style="background-color: white;"><thead>  
<?php
$st = "";
while($ct = mysqli_fetch_array($title_status)){
$st = $ct["status"];}
if(mysqli_num_rows($sv_check)!=0){
  
}elseif($st=='1' OR $st=='4'){
  echo '<tr><td colspan="2" style="background-color: #C0C0C0;"><h3 style=" text-align: center;">PSM Title Request Accepted</h3></td></tr></thead>';
  while($row = mysqli_fetch_array($title_check)){
    echo '<tr><td>Supervisor Name</td><td>: '.$row["nama_penyelia"].'</td></tr>';
    echo '<tr><td>Supervisor Phone Number</td><td>: '.$row["nombor_telefon"].'</td></tr>';
    echo '<tr><td>Project Title</td><td>: '.$row["nama_tajuk"].'</td></tr>';
    echo '<tr><td>Title Type</td><td>: Project Title by Supervisor</td></tr>';
  }
  
  echo '<tr style="color:#FF0000;font-size:15px;"><td colspan="2">*Contact Supervisor to cancel request</td></tr>';
  //Title Approve
}else{
   echo '<tr><td colspan="3" style="background-color: #dd4b39"><h3 style=" text-align: center;">Suggest Title</h3></td></tr>
         <tr style="background-color:#000080;color:white;">
         <td>PSM Title</td>
         <td>Supervisor</td>
         <td>Select Title</td>
         </tr></thead>';
if(mysqli_num_rows($title_check)!=0){
while($row = mysqli_fetch_array($title_check)){
$status = $row["status"];
if($status==2){
  echo ' <form action="student-cancel-title.php" method="post">
         <tr style="background-color:#87CEFA;"> <td>'.$row["nama_tajuk"].'</td>
         <td>Request rejected</td>';
  echo'<td><button type="submit" name="title" value="'.$row["id_permintaan"].'">Continue</button></td></tr></form>';
}elseif($status==1){
  echo ' <form action="student-cancel-title.php" method="post">
         <tr style="background-color:#87CEFA;"> <td>'.$row["nama_tajuk"].'</td>
         <td>'.$row["nama_penyelia"].'</td>';
  echo'<td style="background-color:#77b55a;">Request Accepted</td></tr></form>';
}else{
  echo ' <form action="student-cancel-title.php" method="post">
         <tr style="background-color:#87CEFA;"> <td>'.$row["nama_tajuk"].'</td>
         <td>'.$row["nama_penyelia"].'</td>';
  echo'<td><button type="submit" name="title" value="'.$row["id_permintaan"].'">Cancel Request</button></td></tr></form>';
      }
    }
}else{
  if(mysqli_num_rows($title)==0){
     echo '<tr><td colspan="3">Sorry, no supervisor title to suggest.</td></tr>';
  }else{
     while($row = mysqli_fetch_array($title)){
        echo ' <form action="student-request-title.php" method="post">
               <tr style="background-color:#87CEFA;"> <td>'.$row["nama_tajuk"].'</td>
               <td>'.$row["nama_penyelia"].'</td>
               <td><button type="submit" name="title" value="'.$row["id_tajuk_penyelia"].'">Send Request</button></td>
               </tr></form>';
                        }
        }
     }
   }
   echo '</table>';
?>
</table></div>
<div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding-bottom: 10px;">
<table border="2" style="background-color: white"><thead>
<?php
$svc = "";
while($sw = mysqli_fetch_array($sv_status)){
  $svc = $sw["status"];
}
if(mysqli_num_rows($title_check)!=0){
  if($svc=='2'){
    echo '<tr><td colspan="2" style="background-color: #C0C0C0;"><h3 style=" text-align: center;">PSM Supervise Request Accepted</h3></td></tr></thead>';
  }
 
}elseif($svc=='2' OR $svc=='4'){
  echo '<tr><td colspan="3" style="background-color:#98FB98;"><h3 style=" text-align: center;">PSM Supervise Request Accepted</h3></td></tr></thead>';
  while($line = mysqli_fetch_array($sv_link)){
      echo '<tr><td style="background-color:#7B68EE;">Superviosr Name</td><td style="background-color:#87CEFA;">: '.$line["nama_penyelia"].'</td></tr>';
      echo '<tr><td style="background-color:#7B68EE;">Superviosr Phone Number</td><td style="background-color:#87CEFA;">: '.$line["nombor_telefon"].'</td></tr>';
      echo '<tr><td style="background-color:#7B68EE;">Project Title</td><td style="background-color:#87CEFA;">: '.$line["nama_tajuk"].'</td></tr>';
      echo '<tr><td style="background-color:#7B68EE;">Title Type</td><td style="background-color:#87CEFA;">: Project Title by Student</td></tr>';
     }
     echo '<tr style="color:#FF0000;font-size:15px;"><td colspan="2">*Contact Supervisor to cancel request</td></tr>';
}else{
  echo '<tr><td colspan="3" style="background-color: #dd4b39"><h3 style=" text-align: center;">Suggest Supervisor</h3></td></tr><tr style="background-color:#000080;color:white;">
        <td>supervisor</td>
        <td>Select supervisor</td></tr></thead>';
if(mysqli_num_rows($cancel_out)!=0){
  while($row = mysqli_fetch_array($cancel_out)){
    echo '<tr style="background-color:#87CEFA;"><form action="student-cancel-supervisor.php" method="post">
          <td>'.$row["nama_penyelia"].'</td>
          <td><button type="submit" name="penyelia" value="'.$row["id_penyelia"].'" style="margin:auto;display:block;">Cancel Request</button></td></tr></form>';}
}else{
  if(mysqli_num_rows($spv)==0){
    echo '<tr><td colspan="3">Sorry, no supervisor in your title field to suggest.</td></tr>';
  }else{
    if(mysqli_num_rows($sv_confirm)==0){
      while($row = mysqli_fetch_array($spv)){
        echo '<tr style="background-color:#87CEFA;"><form action="student-request-supervisor.php" method="post"> 
               <td>'.$row["nama_penyelia"].'</td>
               <td><button type="submit" name="penyelia" value="'.$row["id_penyelia"].'" style="margin:auto;display:block;">Send Request</button></td></tr></form>';
      }
    }else{
      while($row = mysqli_fetch_array($sv_confirm)){
        echo '<form action="student-request-supervisor.php" method="post">
              <td>'.$row["nama_penyelia"].'</td>
              <td style="background-color:#77b55a;">Request Accepted</td></tr></form>';
              }
            }
          }
        }
      }
?>
</table></div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/select2-1.js"></script>
    <script src="assets/js/select2-2.js"></script>
    <script src="assets/js/select2-3.js"></script>
    <script src="assets/js/select2-4.js"></script>
    <script src="assets/js/select2-5.js"></script>
    <script src="assets/js/select2-6.js"></script>
    <script src="assets/js/select2.js"></script>
    <script src="assets/js/theme.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</body>
</html>
