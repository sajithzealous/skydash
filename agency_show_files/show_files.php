 
 <?php

   include 'logsession.php';
  session_start(); 
   include('../db/db-con.php');


 $agency= $_SESSION['username'];
 
  $action= $_GET['action'];
    
// Create connection

 

if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
  


    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    

   if ($action=='new') {
    // SQL query when $agency is set
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date` FROM Main_Data WHERE `status`='NEW' AND `agency` = '$agency' AND `log_time` >= '$fromdate 00:00:00' AND `log_time` <= '$todate 23:59:59'";
} else if($action=='assign') {
    // SQL query when $agency is not set
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date` FROM Main_Data WHERE `status`IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER' ,'ASSIGNED TO TEAM','REASSIGNED TO TEAM') AND `agency` = '$agency' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
}

else if($action=='wip'){
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date` FROM Main_Data WHERE `status`IN('WIP', 'ALLOTED TO QC','QA WIP', 'PENDING', 'QC COMPLETED') AND `agency` = '$agency' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
}

else if($action=='approved'){
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date` FROM Main_Data WHERE `status`='APPROVED' AND `agency` = '$agency' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
}

 


 
  

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();

 
}
 
 

 
 
?>

 
 
