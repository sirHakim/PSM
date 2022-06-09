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
 require_once "config.php";
 $set_sv="5";
 $mysqli = $link;
 $sql_sv = ("SELECT pd.id_permintaan,p.nama_penyelia,p.id_penyelia,pd.status,pd.id_pelajar FROM penyelia p,permintaan_diselia pd WHERE pd.id_penyelia=p.id_penyelia && pd.id_pelajar LIKE'".$_SESSION["username"]."'");
  $sv_check = mysqli_query($link, $sql_sv);
?>
<?php
//conn
 require_once "config.php";
 $mysqli = $link;
 //check student request title
 $sql_check_title = ("SELECT p.id_permintaan,p.id_tajuk_penyelia,p.id_pelajar,t.nama_tajuk,s.nama_penyelia,p.status FROM permintaan_tajuk p, tajuk_penyelia t,penyelia s WHERE p.id_tajuk_penyelia=t.id_tajuk_penyelia && t.id_penyelia=s.id_penyelia && p.id_pelajar='".$_SESSION["username"]."'");
 $title_check = mysqli_query($link, $sql_check_title);
//check status
 $sql_status_sv = "SELECT * FROM permintaan_diselia WHERE id_pelajar LIKE '".$_SESSION["username"]."'";
 $status_sv = mysqli_query($link,$sql_status_sv);
 if(mysqli_num_rows($status_sv)){
            while($inside = mysqli_fetch_array($status_sv)){
                $set_sv = $inside["status"];
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
  <a href="profile-student.php">Profile</a>
  <a href="dashboard-student.php">Home</a>
  <a href="student-search-supervisor.php"class="active">Search</a>
  <a href="student-search-title-history.php">Title History</a>
  <a href="password-student.php">Change Password</a>
  <a href="logout.php">Log Out</a>

</div>
                  <div style="display:flex;flex-direction: row; background-color: #C0C0C0;padding: 10px;">
                   <form action="student-search-supervisor.php" method="post">
                    <label>Search: </label>
                    <input type="text" name="searchVal" style="width: 300px;" placeholder="Enter supervisor name or id">
                    <input type="radio" name="pilihan" value="1">
                      <label for="flexRadioDefault1">Supervisor</label>
                      <input type="radio" name="pilihan"  value="2">
                      <label for="flexRadioDefault1">Title</label>
                    <input type="submit" value="Search" name="submit">
                   </form>
                  </div>
<div style="display:flex;flex-direction: column; background-color: #C0C0C0;padding: 10px;">
<?php 
if(isset($_POST["submit"])){
  require_once "config.php";
  $mysqli = $link;
  $search=$_POST["searchVal"];
  if(isset($_POST["pilihan"])){
    if($_POST["pilihan"]=="1"){
      $sql_search = ("SELECT *FROM penyelia WHERE id_penyelia LIKE '%".$search."%' OR nama_penyelia LIKE '%".$search."%' OR kod_program LIKE '%".$search."%'");
      $search_result = mysqli_query($link, $sql_search);
      if(mysqli_num_rows($title_check)!=0){
        echo '<table border =1 style="background-color: white;text-align: center;"><thead>
           <tr style="background-color:#000080;color:white;"><td>Id Staff</td>
           <td>Name</td>
           <td>Program</td>
           <td>Phone Number</td>
           <td>Select</td></tr></thead><tbody>';
      while($row = mysqli_fetch_array($search_result)){
         echo '<form action="student-cancel-supervisor.php" method="post">
               <tr style="background-color:#87CEFA;"><td>'.$row["id_penyelia"].'</td>
               <td>'.$row["nama_penyelia"].'</td>
               <td>'.$row["kod_program"].'</td>
               <td>'.$row["nombor_telefon"].'</td>';
               
                  //echo'<td><button type="submit" name="penyelia" value="'.$row["id_penyelia"].'" style="margin:auto;display:block;">Cancel Current Request</button></td></tr></form>';
                  echo'<td><label style="color:#FF0000;font-size:15px;">*Cancel Current Request at Home page to send new request</label></td></tr></form>';
                
      }
      echo '</tbody>';
      echo '</table>';
      }else{
  if(mysqli_num_rows($sv_check)!=0){
    if(mysqli_num_rows($search_result)!=0){
      echo '<table border =1 style="background-color: white;text-align: center;"><thead>
           <tr style="background-color:#000080;color:white;"><td>Id Staff</td>
           <td>Name</td>
           <td>Program</td>
           <td>Phone Number</td>
           <td>Select</td></tr></thead><tbody>';
      while($row = mysqli_fetch_array($search_result)){
         echo '<form action="student-cancel-supervisor.php" method="post">
               <tr style="background-color:#87CEFA;"><td>'.$row["id_penyelia"].'</td>
               <td>'.$row["nama_penyelia"].'</td>
               <td>'.$row["kod_program"].'</td>
               <td>'.$row["nombor_telefon"].'</td>';
               if($set_sv=="2"){
                echo'<td>No Option</td></tr></form>';
               }else{
                if($set_sv == "1"){
                  //echo'<td><button type="submit" name="penyelia" value="'.$row["id_penyelia"].'" style="margin:auto;display:block;">Cancel Current Request</button></td></tr></form>';
                  echo'<td><label style="color:#FF0000;font-size:15px;">*Cancel Current Request at Home page to send new request</label></td></tr></form>';
                }else{
                  echo'</form><td><form action = "student-request-supervisor.php" method="post"><button type="submit" name="penyelia" value="'.$row["id_penyelia"].'" style="margin:auto;display:block;">Send Request</button></td></tr></form>';
                }
               }
      }
      echo '</tbody>';
      echo '</table>';
    }else{
      echo'<a>No result found.</a>';
      }
}else{
  if(mysqli_num_rows($search_result)!=0){
    echo '<table border=1 style="background-color: white;text-align: center;"><thead>
          <tr style="background-color:#000080;color:white;"><td>Id Staff</td>
          <td>Name</td>
          <td>Program</td>
          <td>Phone Number</td>
          <td>Select</td></tr></thead>';
    while($row = mysqli_fetch_array($search_result)){
      echo '<form action="student-request-supervisor.php" method="post">
            <tr style="background-color:#87CEFA;"><td>'.$row["id_penyelia"].'</td>
            <td>'.$row["nama_penyelia"].'</td>
            <td>'.$row["kod_program"].'</td>
            <td>'.$row["nombor_telefon"].'</td>
            <td><button type="submit" name="penyelia" value="'.$row["id_penyelia"].'" style="margin:auto;display:block;">Send Request</button></td></tr></form>';
    }
   }else{
    echo'<a>No result found.</a>';
     }
}
      }
    }elseif($_POST["pilihan"]=="2"){

      $sql_search = ("SELECT tp.nama_tajuk,p.nama_penyelia,tp.id_tajuk_penyelia FROM tajuk_penyelia tp,penyelia p WHERE (p.nama_penyelia LIKE '%".$_POST["searchVal"]."%' OR tp.nama_tajuk LIKE '%".$_POST["searchVal"]."%') AND tp.id_penyelia=p.id_penyelia");
                          $search_result = mysqli_query($link, $sql_search);
                          if(mysqli_num_rows($title_check)!=0){
                            echo '<table border=1 style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Title</td><td>supervisor</td><td>Select</td></tr></thead>';
                            while($row1 = mysqli_fetch_array($search_result)){
                              echo ' <form action="student-cancel-title.php" method="POST">
                                     <tr style="background-color:#87CEFA;"> 
                                      <td>'.$row1["nama_tajuk"].'</td>
                                      <td>'.$row1["nama_penyelia"].'</td>';
                              echo'   <td><label style="color:#FF0000;font-size:15px;">*Cancel Current Request at Home page to send new request</label></td>
                                     </tr>
                                     </form>';
                            }
                          }elseif(mysqli_num_rows($sv_check)!=0){
                            echo '<table border="2" style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Title</td><td>supervisor</td><td>Select</td></tr></thead>';
                              while($row2 = mysqli_fetch_array($search_result)){
                                echo ' <form action="student-request-title.php" method="post">
                                       <tr style="background-color:#87CEFA;"> 
                                        <td>'.$row2["nama_tajuk"].'</td>
                                        <td>'.$row2["nama_penyelia"].'</td>';
                                        echo'<td><label style="color:#FF0000;font-size:15px;">*Cancel Current Request at Home page to send new request</label></td></tr></form>';  
                              }

                          }else{
                            if(mysqli_num_rows($search_result)!=0){
                               echo '<table border="2" style="background-color: white"><thead><tr style="background-color:#000080;color:white;"><td>Title</td><td>supervisor</td><td>Select</td></tr></thead>';
                              while($row2 = mysqli_fetch_array($search_result)){
                                echo ' <form action="student-request-title.php" method="post">
                                       <tr style="background-color:#87CEFA;"> 
                                        <td>'.$row2["nama_tajuk"].'</td>
                                        <td>'.$row2["nama_penyelia"].'</td>';
                                        if($set_sv=="2"){
                                          echo'<td>No Option</td></tr></form>';
                                        }else{
                                          echo '<td><button type="submit" name="title" value="'.$row2["id_tajuk_penyelia"].'">Send Request</button></td>
                                       </tr>
                                       </form>';
                                        }
                              }
                          }else{
                              echo "<br><a>No result found.</a>";
                           }
                         }
                              echo'</table>';
    }
  }else{
    echo '<script>alert("Select search type");</script>';
  }
  }

                                          ?>
                                      </table>
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
