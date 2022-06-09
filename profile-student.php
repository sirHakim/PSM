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
//get supervisor title
$id = $_SESSION["username"];
$sql_pelajar = ("SELECT * from pelajar WHERE id_pelajar='".$id."'");
$sql_tajuk_pelajar = ("SELECT a.nama_tajuk,b.nama_bidang, a.penerangan_tajuk from tajuk_pelajar a,bidang b WHERE id_pelajar='".$id."' && a.id_bidang=b.id_bidang");
$sql_bidang = ("SELECT * FROM bidang ORDER BY nama_bidang ASC");
$result1= mysqli_query($link, $sql_pelajar);
$result2= mysqli_query($link, $sql_tajuk_pelajar);
$result3= mysqli_query($link, $sql_bidang);
?>
<?php
                     require_once "config.php";
                      $mysqli = $link;
                      if(isset($_POST["subphone"])){
                        $newPhone = $_POST["phoneNum"];
                        $insert = "UPDATE pelajar SET nombor_telefon='".$newPhone."' WHERE id_pelajar LIKE '".$id."'";
                        if(mysqli_query($link,$insert)){
                          echo '<script>alert("Phone number saved.");</script>';
                          header("refresh:0");
                        }


                      }
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
  <a class="active" href="profile-student.php">Profile</a>    
  <a href="dashboard-student.php">Home</a>
  <a href="student-search-supervisor.php">Search</a>
  <a href="student-search-title-history.php">Title History</a>
  <a href="password-student.php">Change Password</a>
  <a href="logout.php">Log Out</a>
</div>

                    <div style="background-color: #C0C0C0;border-left: 5px solid #0000FF;border-right: 5px solid #0000FF;border-bottom: 5px solid #0000FF;">
                      <h2><span>Personal Details</span></h2>

                    <?php
                        while($row = mysqli_fetch_array($result1)){
                          echo '<form action="profile-student.php" method="post"><table>';
                          echo'<tr><td>Student Name</td><td>: <a style="background:#c5cbd6;">'.$row["nama_pelajar"].'</a></td></tr>';
                          echo'<tr><td>Matrix Number</td><td>: <a style="background:#c5cbd6;">'.$row["id_pelajar"].'</a></td></tr>';
                          echo'<tr><td>Program</td><td>: <a style="background:#c5cbd6;">'.$row["kod_program"].'</a></td></tr>';
                          echo'<tr><td>Phone</td><td>: <input type="text" name="phoneNum" value="'.$row["nombor_telefon"].'" autocomplete="off"> <input type="submit" name="subphone" value="Save"></td></form></tr>';
                          echo '</table>';
                        }
                        echo '</div>';
                        echo '<div style="height:400px;background-color: #C0C0C0;border-left: 5px solid #0000FF;border-right: 5px solid #0000FF;border-bottom: 5px solid #0000FF;">';
                        echo'<h2><span>Project Detail</span></h2>';
                        $tajuk = "-";
                        $bidang = "-";
                        $note = "-";
                        echo'<form action="save-student-title.php" method="post">';
                        while($row = mysqli_fetch_array($result2)){
                          $tajuk = $row["nama_tajuk"];
                          $bidang = $row["nama_bidang"];
                          $note = $row["penerangan_tajuk"];
                        }
                        require_once "config.php";
                        $sql_title_history = ("SELECT *FROM sejarah_tajuk WHERE nama_tajuk LIKE '%".$tajuk."%'");
                        $sql_title_current = ("SELECT *FROM tajuk_pelajar WHERE nama_tajuk LIKE '%".$tajuk."%'");
                        $similar = mysqli_query($link,$sql_title_history);
                        $current_similar = mysqli_query($link,$sql_title_current);
                         if(mysqli_num_rows($similar)==0 OR mysqli_num_rows($current_similar)==0){
                          echo'<label>PSM Title:</label><br><input type="text" name="title" style="width: 40rem;font-size: 20px;" value="'.$tajuk.'""><input type="submit" value="Save" style="margin-left: 10px"></form>';
                         }else{
                          echo'<label>PSM Title:</label><input type="text" name="title" style="width: 40rem;font-size: 20px;" value="'.$tajuk.'""><input type="submit" value="Save" style="margin-left: 10px"><label style="color: red;">*Your title has been used by other student.</label></form>';
                         }
                         
                        echo ' <form action="student-save-note.php" method="post">
                      <label>Title Details:</label><br>
                      <textarea id="dtls" name="details" rows="5" cols="56" style="font-size: 20px;" maxlength="500">'.$note.'</textarea><input type="submit" value="Save" style="margin-left: 10px">
                    </form>';
                    echo'<br><label>My Title Field: <a style="background:#c5cbd6;">'.$bidang.'</a></label><br>'; 
                    ?>
                   <br>

                    <form action="save-student-field.php" method="post">
                                <label>Set New Title Field:</label>
                                <select name="field" style="font-size: 20px;">
                    <?php
                        while($row = mysqli_fetch_array($result3)){
                          echo '
                                  <option value="'.$row["id_bidang"].'">'.$row["nama_bidang"].'</option>';
                        }
                    ?>
                     </select>
                              <input type="submit" value="Save" style="margin-left: 10px;">
                    </form>
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