 

<?php
$servername = "localhost";
$dbusername   = "zhcadmin";
$dbpassword   = "d0m!n$24";
$database     = "HCLI";
$port       = "22022";
 
 $connect = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
