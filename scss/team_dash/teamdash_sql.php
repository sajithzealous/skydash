<?php
    $servername = "192.168.200.59";
    $username   = "zeal";
    $password   = "4321";
    $dbname     = "HCLI";

    
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// $action=$_GET['action'];
// if($action=='total_team_count'){
//     total_team_count($connnect); 
    
// }
?>