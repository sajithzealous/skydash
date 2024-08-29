<?php
session_start();
// Include database connection
include('../db/db-con.php');

// Error reporting setup
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize data array
$response = array();

$username = $_SESSION['username'];
$empid = $_SESSION['empid'];
$role = $_SESSION['role'];

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Check if basic team filtering parameters are provided
if ($action == 'files_count') {
    if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];

        $sql = "SELECT 
            (SELECT COUNT(status) FROM Main_Data WHERE status = 'ALLOTED TO QC' AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as allot_qc, 
            (SELECT COUNT(status) FROM Main_Data WHERE qc_team='$username' AND qc_team_emp_id='$empid' AND (status = 'ASSIGNED TO QC CODER' OR status = 'REASSIGNED TO QC CODER') AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as assign_qc,
            (SELECT COUNT(status) FROM Main_Data WHERE status = 'QC COMPLETED' AND qc_person IS NULL AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as qc_direct_cmd,
            (SELECT COUNT(status) FROM Main_Data WHERE qc_team='$username' AND qc_team_emp_id='$empid' AND status = 'QA WIP' AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as qcwip,
            (SELECT COUNT(status) FROM Main_Data WHERE qc_team='$username' AND qc_team_emp_id='$empid' AND status = 'QC COMPLETED' AND qc_person IS NOT NULL AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as qc_cmd,
            (SELECT COUNT(status) FROM Main_Data WHERE qc_team='$username' AND qc_team_emp_id='$empid' AND status = 'APPROVED' AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as approved";

        $run = mysqli_query($conn, $sql);

        if ($run) {
            // Fetch the result as an associative array
            $result = mysqli_fetch_assoc($run);
            $response['success'] = true;
            $response['data'] = $result;
        } else {
            $response['success'] = false;
            $response['error'] = "QUERY ERROR: " . mysqli_error($conn);
        }
    } else {
        $response['success'] = false;
        $response['error'] = "Missing parameters: fromdate or todate";
    }
} else {
    $response['success'] = false;
    $response['error'] = "Invalid action";
}

// Send JSON response
echo json_encode($result);
