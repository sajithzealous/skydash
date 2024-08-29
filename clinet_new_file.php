<?php
session_start();

include 'logsession.php';
include 'db/db-con.php';

// Retrieve session variables
$user = $_SESSION['username'];
$emp_id = $_SESSION['empid'];

// Retrieve agency name
$agency_query = "SELECT `agency_name` FROM `Agent` WHERE `client_name`='$user' AND `client_id`='$emp_id'";
$agency_result = $conn->query($agency_query);

// Check if agency result exists and fetch all agency names
$agencies = array();
if ($agency_result && $agency_result->num_rows > 0) {
    while ($agencyData = $agency_result->fetch_assoc()) {
        $agencies[] = $agencyData['agency_name'];
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Error: Check Agency Name.']);
    exit; // Handle error gracefully or exit the script
}

// Check for valid GET parameters
if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
 

$sql = "SELECT
            (SELECT COUNT(status) 
             FROM Main_Data 
             WHERE `status`='NEW' 
               AND `agency` IN ('" . implode("','", $agencies) . "') 
               AND `log_time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as New,
            (SELECT COUNT(status) 
             FROM Main_Data 
             WHERE `status` IN ('WIP', 'ALLOTED TO QC', 'QC', 'InProgression', 'QA WIP', 'PENDING', 'QC COMPLETED') 
               AND `agency` IN ('" . implode("','", $agencies) . "') 
               AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as processing,
            (SELECT COUNT(status) 
             FROM Main_Data 
             WHERE `status`='APPROVED' 
               AND `agency` IN ('" . implode("','", $agencies) . "') 
               AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as completed,
            (SELECT COUNT(status) 
             FROM Main_Data 
             WHERE `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER' ,'ASSIGNED TO TEAM','REASSIGNED TO TEAM') 
               AND `agency` IN ('" . implode("','", $agencies) . "') 
               AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as assigned";

 
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
