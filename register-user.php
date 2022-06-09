<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login-employee.php");
    exit;
}
?>
<?ph
<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT employeeID FROM employee WHERE employeeUsername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO employee (employeeUsername, employeePassword, employeeName, employeePhone ) VALUES (?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password,$param_name,$param_Phone);
            
            //input normal
            $name = strtoupper($_POST["name"]);
            $phone = trim($_POST["phone"]);
            $username = trim($_POST["username"]);
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_name = $name;
            $param_Phone = $phone;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login-employee.php");
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
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Register Employee</title>
    <link rel="icon" href="https://image.flaticon.com/icons/png/512/595/595604.png">
    <link rel="stylesheet" href="Customer Registration.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .topnav {
  overflow: hidden; 
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: white;
}

.topnav a.active {
  background-color: #04AA6D;
  color: white;
}

#btnBook {
  font-size:  25px;
}

#btnDate {
  font-size:  25px;
}

#btnPaid {
  font-size:  25px;
}

#btnBar {
  font-size:  25px;
}

</style>
</head>

<body>
    <div class="topnav" style="position: absolute ;top:0px; ;width:100%;">
  <a href="admin.php">Home</a>
  <a href="admin-time.php">Time</a>
  <a href="admin-sales.php">Sales</a>
  <a href="admin-employee.php">Employee</a>
  <a href="register-employee.php" class="active">Register Employee</a>
  <a href="admin-customer.php">Customer</a>
  <a href="admin-change-password.php">Change Password</a>
  <a href="logout-employee.php">Log Out</a>
</div>
<div>
    <div class="container">
    <div class="title">Employee Registration</div> 
    <div class="content">
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Full Name</span>
                    <input name="name" type="text" placeholder="Enter employee name" required>  
                </div>
                <div class="input-box">
                    <span class="details">Phone Number</span>
                    <input name="phone" type="tel" placeholder="Enter employee phone number" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{7-8}" required>
                    <small>Format: 01X-XXXYYYY</small>  
                    
                </div>
                <div class="input-box">
                    <span class="details">Username</span>
                    <input name="username" type="text" placeholder="Enter employee username" required>
                    
                </div>
                <div class="input-box">
                    <span class="details">Password</span>
                    <input name="password" type="password" placeholder="Enter employee password" required>
                </div>
                <div class="input-box">
                    <span class="details">Confirm Password</span>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Enter employee password" required>
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            
            <div class="button">
                <input type="submit" value="submit">
            </div>
        </form>
        </div>
    </div>
</body>
</html>