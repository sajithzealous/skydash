 
 <?php

 session_start(); 
   include 'logsession.php';

 
$servername = "localhost";
$username   = "zhcadmin";
$password   = "d0m!n$24";
$dbname     = "HCLI";
$port       = "22022";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
   // die("Connection failed: " . $conn->connect_error);
} else {
   // echo "Connected successfully";
} 

 $agency= $_SESSION['username'];
 
 
 

 if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];

     $sql = "SELECT (SELECT COUNT(status) FROM Main_Data WHERE `status`='NEW' AND `agency`='$agency' AND `log_time` >= '$fromdate 00:00:00' AND `log_time` <= '$todate 23:59:59') as New, 
          (SELECT COUNT(status) FROM Main_Data WHERE `status` IN('WIP', 'ALLOTED TO QC','QA WIP', 'PENDING', 'QC COMPLETED') AND `agency`='$agency' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as wip,
        (SELECT COUNT(status) FROM Main_Data WHERE `status`IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER' ,'ASSIGNED TO TEAM','REASSIGNED TO TEAM') AND `agency`='$agency' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as assign,
         
        (SELECT COUNT(status) FROM Main_Data WHERE `status`='APPROVED' AND `agency`='$agency' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as approved";

    $run = mysqli_query($conn, $sql);

  if ($run) {
        // Fetch the result as an associative array
        $result = mysqli_fetch_assoc($run);
        echo json_encode($result);
    } else {
         echo "QUERY ERROR: " . mysqli_error($conn);
    }
}
 



 
 
?>

 
 
