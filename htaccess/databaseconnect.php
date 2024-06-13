<?php
$servername = "none";
$database = "none";
$username = "noone";
$password = "noword";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";





?>
