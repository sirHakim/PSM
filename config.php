<?php


/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'remotemysql.com');
define('DB_USERNAME', 'EFH8GAqiK5');
define('DB_PASSWORD', 'qHdrw4PFZD');
define('DB_NAME', 'EFH8GAqiK5');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
