<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login-user.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Student Home</title>
</head>
<h1>Welcome <?php echo $_SESSION["name"];?></h1>
<h2><a href = "logout.php">Sign Out</a></h2>
<body>
</body>
</html>