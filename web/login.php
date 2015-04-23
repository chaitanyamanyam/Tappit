<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_REQUEST['submit'])) {
if (empty($_REQUEST['username']) || empty($_REQUEST['password'])) {
$error = "Username or Password is invalid";
echo "empty";
}
else
{
// Define $username and $password
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = pg_connect(getenv('DATABASE_URL')) or die("Unable to connect to postgre");

// SQL query to fetch information of registerd users and finds user match.
$result = pg_query($connection,"select * from register_page where username='$username' and password='$password'");

$rows = pg_num_rows($result);
if ($rows == 1) {
// Inialize session
session_start();    
$_SESSION['sess_username']=$username; // Initializing Session
header("location: dialogHome.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
}
pg_close($connection); // Closing Connection
}
}
?>