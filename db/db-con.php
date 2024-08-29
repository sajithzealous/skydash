<?php
$servername = "localhost";
$username   = "zhcadmin";
$password   = "d0m!n$24";
$dbname     = "HCLI";
$port       = "22022";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } else {
//      echo "Connected successfully";
// }
?>
