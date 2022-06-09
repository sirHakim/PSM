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
 $mysqli = $link;
 //check student request title
 $sql_check_title = ("SELECT p.id_permintaan,p.id_tajuk_penyelia,p.id_pelajar,t.nama_tajuk,s.nama_penyelia FROM permintaan_tajuk p, tajuk_penyelia t,penyelia s WHERE p.id_tajuk_penyelia=t.id_tajuk_penyelia && t.id_penyelia=s.id_penyelia && p.id_pelajar='".$_SESSION["username"]."'");
 $title_check = mysqli_query($link, $sql_check_title);
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
<body class="bg-gradient-primary" style="background-color: #C0C0C0;">
    <div class="topnav">
  <a href="profile-student.php">Profile</a>
  <a href="dashboard-student.php">Home</a>
  <a href="student-search-supervisor.php">Search Supervisor</a>
  <a href="student-search-title.php"class="active">Search Title</a>
  <a href="student-search-title-history.php">Title History</a>
  <a href="password-student.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>

                    <div style="display:flex;flex-direction: row; background-color: #C0C0C0;padding: 10px;">
                     <form action="student-search-title.php" method="post">
                      <label>Search: </label>
                      <input type="text" name="searchVal" style="width: 300px;" placeholder="Enter title name only">
                      <input type="submit" value="Search" name="submit">
                     </form>
                    </div>
                    <div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding: 10px;">
                        <?php
                         if(isset($_POST["submit"])){
                          $mysqli = $link;
                          $sql_search = ("SELECT tp.nama_tajuk,p.nama_penyelia,tp.id_tajuk_penyelia FROM tajuk_penyelia tp,penyelia p WHERE tp.id_penyelia LIKE '%".$_POST["searchVal"]."%' OR nama_tajuk LIKE '%".$_POST["searchVal"]."%' && tp.id_penyelia=p.id_penyelia");
                          $search_result = mysqli_query($link, $sql_search);
                          if(mysqli_num_rows($title_check)!=0){
                            echo '<table border="2" style="background-color: white"><thead><tr><td>Title</td><td>supervisor</td><td>Select</td></tr></thead>';
                            while($row1 = mysqli_fetch_array($title_check)){
                              echo ' <form action="student-cancel-title.php" method="POST">
                                     <tr> 
                                      <td>'.$row1["nama_tajuk"].'</td>
                                      <td>'.$row1["nama_penyelia"].'</td>';
                              echo'   <td><button type="submit" name="title" value="'.$row1["id_permintaan"].'">Cancel Request</button></td>
                                     </tr>
                                     </form>';
                            }
                          }else{
                            if(mysqli_num_rows($search_result)!=0){
                               echo '<table border="2" style="background-color: white"><thead><tr><td>Title</td><td>supervisor</td><td>Select</td></tr></thead>';
                              while($row2 = mysqli_fetch_array($search_result)){
                                echo ' <form action="student-request-title.php" method="post">
                                       <tr> 
                                        <td>'.$row2["nama_tajuk"].'</td>
                                        <td>'.$row2["nama_penyelia"].'</td>
                                        <td><button type="submit" name="title" value="'.$row2["id_tajuk_penyelia"].'">Send Request</button></td>
                                       </tr>
                                       </form>';
                              }
                          }else{
                              echo "<br><a>No result found.</a>";
                           }
                         }
                              echo'</table>';
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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</body>

</html>
<script>  
 $(document).ready( function () {
    $('#tb1').DataTable();
} );
 </script>