<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_POST["usertype"]=="pelajar"){
        header("location: dashboard-student.php");
    }elseif($_POST["usertype"]=="penyelia"){
        header("location: home-supervisor.php");
    }else{
        header("location: home-coordinator.php");
    }
    exit;
}


// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    //check user
if($_POST["username"]=="admin"){
     $usrtyp = "admin";
     $sql = "SELECT id_penyelaras, nama_penyelaras, kata_laluan,kod_program FROM penyelaras WHERE id_penyelaras = ?";
}elseif($_POST["usertype"]=="pelajar"){
    $usrtyp="pelajar";
    $sql = "SELECT id_pelajar, nama_pelajar, kata_laluan,kod_program FROM pelajar WHERE id_pelajar = ?";
}elseif($_POST["usertype"]=="penyelia"){
    $usrtyp="penyelia";
    $sql = "SELECT id_penyelia, nama_penyelia, kata_laluan,kod_program FROM penyelia WHERE id_penyelia = ?";
}else{
    $usrtyp="penyelaras";
    $sql = "SELECT id_penyelaras, nama_penyelaras, kata_laluan,kod_program FROM penyelaras WHERE id_penyelaras = ?";
}
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = strtoupper($username);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $name, $pwd, $code);
                    if(mysqli_stmt_fetch($stmt)){
                        if(strcmp($password, $pwd)==0){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["name"] = $name;
                            $_SESSION["username"] = $username;
                            $_SESSION["program"] =  $code;       
                            
                            // Redirect user to respective welcome page based on user type
                            if($_POST["usertype"]=="pelajar"){
                                 header("location:profile-student.php");
                            }elseif($usrtyp=="admin"){
                                header("location:dashboard-admin.php");
                            }elseif($_POST["usertype"]=="penyelia"){
                                 header("location:dashboard-supervisor.php");
                            }elseif($_POST["usertype"]=="penyelaras"){
                                 header("location:coordinator-psm-setting.php");
                            }
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SPP Login</title>
    <link rel="icon" href="https://ftk.uthm.edu.my/wp-content/uploads/2021/08/mac_touch-icon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
        .wrapper{ width: 360px; padding-top: 150px;padding-left: 50px; }

        h2,p,label{color: black;}
        h1{ background-color: #0000FF;
            opacity: 0.9;
            border-radius: 5px;
            background-image:background-color: rgba(18,72,120, 0.8);
            font-size: 50px;
            position: absolute;
            top: 0rem; 
            left: 0rem;
            right: 0rem; }
    </style>
</head>
<body style="background-color: #C0C0C0;background-image: url('image/img2.jpg'); background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: 100%;">
    <a style="font-style: none; color: white">
        <h1>Sistem Pemilihan Penyelia PSM FSKTM (SPP UTHM)</h1>
    </a>
    <div class="wrapper" >
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <div style="border-radius: 10px;background-color: #D3D3D3;border-style: solid;border-color: #0000FF;width: 500px;border-width: 10px;">
             <div style ="margin: 20px;">
                 <small>Enter your credentials to log on: </small>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Matric number or staff username..." autocomplete="off" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                
                <input type="password" name="password" placeholder="Password..." class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
            <input type="radio" name="usertype" id="usr1" value="pelajar">
            <label for="flexRadioDefault1" checked>Student</label>
            <input type="radio" name="usertype" id="usr2" value="penyelia">
            <label for="flexRadioDefault1">Supervisor</label>
            <input type="radio" name="usertype" id="usr3" value="penyelaras">
            <label for="flexRadioDefault1">Coordinator</label>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
           
        </form>
             </div>
        </div>
    </div>
</body>
</html>

