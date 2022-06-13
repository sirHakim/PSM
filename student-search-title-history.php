<?php  
// Initialize the session
session_start();
//Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login-user.php");
    exit;
}
// echo "Today date: ".date('d-m-Y');
?>
<?php
//conn
 require_once "config.php";
 $mysqli = $link;
 //check student request title
 //$sql_check_title = ("SELECT p.id_permintaan,p.id_tajuk_penyelia,p.id_pelajar,t.nama_tajuk,s.nama_penyelia,p.program FROM permintaan_tajuk p, tajuk_penyelia t,penyelia s WHERE p.id_tajuk_penyelia=t.id_tajuk_penyelia && t.id_penyelia=s.id_penyelia && p.id_pelajar='".$_SESSION["username"]."'");
 //$title_check = mysqli_query($link, $sql_check_title);
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
  <a href="student-search-supervisor.php">Search</a>
  <a href="student-search-title-history.php"class="active">Title History</a>
  <a href="password-student.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>

                    <div style="display:flex;flex-direction: row; background-color: #C0C0C0;padding: 10px;">
                     <form action="student-search-title-history.php" method="post">
                      <label>Search by name: </label>
                      <input type="text" name="searchVal" style="width: 300px;" placeholder="Enter title name only">
                      <input type="submit" value="Search" name="title_search">
                     </form>
                    </div>
                    <div style="display:flex;flex-direction: row; background-color: #C0C0C0;padding: 10px;">
                     <form action="student-search-title-history.php" method="post">
                      <label>Search by program: </label>
                      <input type="radio" name="program" id="program" value="BIT">
                      <label for="flexRadioDefault1" checked>BIT</label>
                      <input type="radio" name="program" id="program" value="BIP">
                      <label for="flexRadioDefault1">/ BIP </label>
                      <input type="radio" name="program" id="program" value="BIS">
                      <label for="flexRadioDefault1">/ BIS</label>
                      <input type="radio" name="program" id="program" value="BIM">
                      <label for="flexRadioDefault1">/ BIM</label>
                      <input type="radio" name="program" id="program" value="BIW">
                      <label for="flexRadioDefault1">/ BIW</label>
                      
                      <input type="submit" value="Search" name="program_search">
                     </form>
                    </div>
                    <div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding: 10px;">
                        <?php
                         
                         if(isset($_POST["title_search"])){
                          $sql = "SELECT p.nama_pelajar,st.nama_tajuk,sv.nama_penyelia,p.kod_program FROM sejarah_tajuk st,program pr,pelajar p,penyelia sv WHERE p.id_pelajar=st.id_pelajar && p.kod_program=pr.kod_program && p.id_penyelia=sv.id_penyelia && st.nama_tajuk LIKE '%".$_POST["searchVal"]."%';";
                          $sql_result = mysqli_query($link,$sql);
                            if(mysqli_num_rows($sql_result)!=0){
                               echo '<table border=1 style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Title</td><td>Student</td><td>Supervisor</td><td>Student Program</td></tr></thead>';
                              while($row = mysqli_fetch_array($sql_result)){
                              echo '<tr style="background-color:#87CEFA;"><td>'.$row["nama_tajuk"].'</td><td>'.$row["nama_pelajar"].'</td><td>'.$row["nama_penyelia"].'</td><td style="text-align: center;">'.$row["kod_program"].'</td></tr>';
                            }
                            echo '</table>';
                            }else{
                              echo '<table border=1 style="background-color: white;text-align:center;"><thead><tr><td>No Title Found!</td></tr></thead></table>';
                            }
                          }elseif(isset($_POST["program_search"])){
                          $sql = "SELECT p.nama_pelajar,st.nama_tajuk,pr.kod_program,sv.nama_penyelia FROM sejarah_tajuk st,program pr,pelajar p,penyelia sv WHERE p.id_pelajar=st.id_pelajar && p.id_penyelia=sv.id_penyelia && p.kod_program=pr.kod_program && p.kod_program LIKE '".$_POST["program"]."';";
                          $sql_result = mysqli_query($link,$sql);
                           if(mysqli_num_rows($sql_result)!=0){
                            echo '<table border=1 style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Title</td><td>Student</td><td>Supervisor</td></tr></thead>';
                             while($row = mysqli_fetch_array($sql_result)){
                                echo '<tr style="background-color:#87CEFA;"><td>'.$row["nama_tajuk"].'</td><td>'.$row["nama_pelajar"].'</td><td>'.$row["nama_penyelia"].'</td></tr>';
                            }
                            echo '</table>';
                           }else{
                               echo '<table border=1 style="background-color: white;text-align:center;"><thead><tr><td>No Title Found!</td></tr></thead></table>';
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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</body>

</html>
