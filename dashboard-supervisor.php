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
//conn
 require_once "config.php";
 $staffId = $_SESSION["username"];
 $mysqli = $link;
 //check student request title
 $sql_check_title = ("SELECT p.id_permintaan,p.id_tajuk_penyelia,p.id_pelajar,t.nama_tajuk,s.nama_penyelia FROM permintaan_tajuk p, tajuk_penyelia t,penyelia s WHERE p.id_tajuk_penyelia=t.id_tajuk_penyelia && t.id_penyelia=s.id_penyelia && p.id_pelajar='".$_SESSION["username"]."'");
 $title_check = mysqli_query($link, $sql_check_title);
//student request title
 $sql_req_tit = ("SELECT t.nama_tajuk,p.nama_pelajar,p.kod_program,pt.id_permintaan,pt.id_pelajar from pelajar p,tajuk_penyelia t,permintaan_tajuk pt where t.id_penyelia = '".$_SESSION["username"]."' && t.id_tajuk_penyelia=pt.id_tajuk_penyelia && p.id_pelajar=pt.id_pelajar && pt.status IS NULL");
 $rq_rs = mysqli_query($link, $sql_req_tit);
 $sql_req_sv = ("SELECT d.id_permintaan,p.nama_pelajar,t.nama_tajuk,p.id_pelajar,p.kod_program FROM permintaan_diselia d, pelajar p, tajuk_pelajar t WHERE p.id_pelajar=d.id_pelajar AND t.id_pelajar=p.id_pelajar AND status='1' AND d.id_penyelia='".$staffId."'");
 $svrq_res = mysqli_query($link,$sql_req_sv);

 $sql_mystd = ("SELECT pd.id_permintaan,p.id_pelajar,p.nama_pelajar,tp.nama_tajuk,tp.penerangan_tajuk,p.nombor_telefon,p.kod_program,b.nama_bidang FROM pelajar p,tajuk_pelajar tp,bidang b,permintaan_diselia pd WHERE p.id_pelajar=pd.id_pelajar && p.id_pelajar=tp.id_pelajar && b.id_bidang = tp.id_bidang && pd.status=2 && pd.id_penyelia LIKE '".$staffId."' && pd.status LIKE '2'");
 $my_student = mysqli_query($link,$sql_mystd);
 $sql_mystd2 = ("SELECT pj.id_pelajar,pj.nama_pelajar,tpj.nama_tajuk,tpj.penerangan_tajuk,pj.nombor_telefon,pj.kod_program,bd.nama_bidang,sv.nama_penyelia,pt.id_permintaan
FROM pelajar pj,permintaan_tajuk pt,tajuk_penyelia tp,penyelia sv,tajuk_pelajar tpj,bidang bd 
WHERE
  pj.id_pelajar = pt.id_pelajar &&
  tp.id_tajuk_penyelia = pt.id_tajuk_penyelia &&
  tpj.id_pelajar = pt.id_pelajar &&
  tpj.id_pelajar = pj.id_pelajar &&
  bd.id_bidang = tpj.id_bidang &&
  sv.id_penyelia = tp.id_penyelia &&
  sv.id_penyelia LIKE '".$staffId."' &&
  pt.status LIKE '1'");
 $my_student2 = mysqli_query($link,$sql_mystd2);
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
  <a class="active" href="dashboard-supervisor.php">Home</a>
  <a href="profile-supervisor.php">Profile</a>
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

                    <div class="card card-1" style="display:flex;flex-direction: column; background-color: #C0C0C0;padding-bottom: 10px;">
                    <table border=1 style="background-color: white">
                     <thead>
                      <tr><td colspan="4" style="background-color: #dd4b39;"><h3 style=" text-align: center;">Student Request Title</h3></td></tr>
                        <tr style="background-color:#000080;color:white;">
                          <td>Program Code</td>
                          <td>Title Request</td>
                          <td>Student Name</td>
                          <td>Accept/Decline</td>
                        </tr>
                      </thead>
                      <?php
                        if(mysqli_num_rows($rq_rs) !=0){
                          while($row = mysqli_fetch_array($rq_rs)){
                          echo '
                            <tr style="background-color:#87CEFA;"><td align="center">'.$row["kod_program"].'</td><td>'.$row["nama_tajuk"].'</td>
                            <td>'.$row["nama_pelajar"].'</td>
                            <td align="right"><form action="accept-request-title.php" method="post" style="display: inline;"><input type="hidden" name="idp" value="'.$row["id_pelajar"].'">
                            <button style="width:150px;background-color: #4CAF50;" type="submit" name="id_req" value="'.$row["id_permintaan"].'">Accept</button></form>
                            <form action="reject-request-title.php" method="post" style="display: inline;">
                            <button style="width:150px;background-color: #f44336;" type="submit" name="id_req" value="'.$row["id_permintaan"].'">Reject</button></form>
                            </td>
                            </tr>';}
                        }else{
                          if(mysqli_num_rows($rq_rs)==0){
                              echo '<tr style="background-color:#87CEFA;"><td colspan="3" style="text-align:center;">No title request at this moment.</td></tr>';}
                             }
                      ?>
                       </table>
                    </div>

                    <div class="card card-1" style="display:flex;flex-direction: column; background-color: #C0C0C0;padding-bottom: 10px;">
                      <table border=1 style="background-color: white">
                     <thead>
                      <tr><td colspan="4" style="background-color: #dd4b39;"><h3 style=" text-align: center;">Student Request Supervise</h3></td></tr>
                        <tr>
                        <tr style="background-color:#000080;color:white;">
                          <td>Program Code</td>
                          <td>Student Title</td>
                          <td>Student Name</td>
                          <td>Accept/Decline</td>
                        </tr>
                      </thead>
                    <?php
                      if(mysqli_num_rows($svrq_res)!=0){
                        while($row = mysqli_fetch_array($svrq_res)){
                          echo '<tr style="background-color:#87CEFA;"><td align="center">'.$row["kod_program"].'</td><td>'.$row["nama_tajuk"].'</td><td>'.$row["nama_pelajar"].'</td>
                                <td align="right"><form action="accept-request-sv.php" method="post" style="display: inline;"><input type="hidden" name="studentid" value="'.$row["id_pelajar"].'">
                            <button style="width:150px;background-color: #4CAF50;" type="submit" name="id_req" value="'.$row["id_permintaan"].'">Accept</button></form><form action="reject-request-sv.php" method="post" style="display: inline;">
                            <button style="width:150px;background-color: #f44336;" type="submit" name="id_req" value="'.$row["id_permintaan"].'">Reject</button></form></td>
                          </tr>';
                        }
                      }else{
                        echo '<tr style="background-color:#87CEFA;"><td colspan="4" style="text-align:center;">No supervise request at this moment.</td></tr>';
                      }
                    ?>
                    </table>
                    </div>

                    <div class="card card-1" style="display:flex;flex-direction: column; background-color: #C0C0C0;padding-bottom: 10px;">
                      <table border=1 style="background-color: white">
                     <thead>
                      <tr><td colspan="8" style="background-color: #dd4b39;"><h3 style=" text-align: center;">My Student</h3></td></tr>
                        <tr>
                        <tr style="background-color:#000080;color:white;">
                          <td>Id</td>
                          <td>Name</td>
                          <td>Project Title</td>
                          <td>Title details</td>
                          <td>Phone Number</td>
                          <td>Program Code</td>
                          <td>Field</td>
                          <td>Select</td>
                        </tr>
                        <?php
                        if(mysqli_num_rows($my_student)!=0||mysqli_num_rows($my_student2)!=0){
                          while ($row = mysqli_fetch_array($my_student)) {
                            echo '<tr style="background-color:#87CEFA;"><td>'.$row["id_pelajar"].'</td><td>'.$row["nama_pelajar"].'</td><td>'.$row["nama_tajuk"].'</td><td>'.$row["penerangan_tajuk"].'</td><td>'.$row["nombor_telefon"].'</td><td>'.$row["kod_program"].'</td><td>'.$row["nama_bidang"].'</td><td><form action="reject-request-sv.php" method="post" style="display: inline;"><input type="hidden" name="ids" value="'.$row["id_pelajar"].'">
                            <button style="margin:5px;width:150px;background-color: #f44336;" type="submit" name="id_req" value="'.$row["id_permintaan"].'">Remove</button></form><br>
                            <form action="complete-psm-sv.php" method="post"><button style="margin:5px;width:150px;background-color: #7CFC00;" type="submit" name="complete" value="'.$row["id_permintaan"].'">Complete PSM</button></form></td></tr>';
                          }
                          while ($row = mysqli_fetch_array($my_student2)) {
                            echo '<tr style="background-color:#87CEFA;"><td>'.$row["id_pelajar"].'</td><td>'.$row["nama_pelajar"].'</td><td>'.$row["nama_tajuk"].'</td><td>'.$row["penerangan_tajuk"].'</td><td>'.$row["nombor_telefon"].'</td><td>'.$row["kod_program"].'</td><td>'.$row["nama_bidang"].'</td><td><form action="reject-request-title.php" method="post" style="display: inline;"><input type="hidden" name="idk" value="'.$row["id_pelajar"].'">
                            <button style="margin:5px;width:150px;background-color: #f44336;" type="submit" name="id_req" value="'.$row["id_permintaan"].'">Remove</button></form><br>
                            <form action="complete-psm-title.php" method="post"><button style="margin:5px;width:150px;background-color: #7CFC00;" type="submit" name="complete" value="'.$row["id_permintaan"].'">Complete PSM</button></form>
                            </td></tr>';
                          }
                        }else{
                          echo '<tr style="background-color:#87CEFA;"><td colspan="8" style="text-align:center;">Student list empty.</td></tr>';
                        }
                        ?>
                      </thead>
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
