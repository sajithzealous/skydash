<?php
// Include database connection
include('../db/db-con.php');

// Error reporting setup
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize data array
$data = array();
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'efficiency_report') {

    // Get parameters and sanitize inputs
    $fromdate = isset($_GET['fromdate']) ? mysqli_real_escape_string($conn, $_GET['fromdate']) : '';
    $todate = isset($_GET['todate']) ? mysqli_real_escape_string($conn, $_GET['todate']) : '';
    $teamname = isset($_GET['teamname']) ? mysqli_real_escape_string($conn, $_GET['teamname']) : '';
    $team_id = isset($_GET['team_id']) ? mysqli_real_escape_string($conn, $_GET['team_id']) : '';
    $coderid = isset($_GET['coderid']) ? mysqli_real_escape_string($conn, $_GET['coderid']) : '';
    $status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
    $Agency = isset($_GET['Agency']) ? mysqli_real_escape_string($conn, $_GET['Agency']) : '';

    // Construct the SQL query
    $query = "
    SELECT
        `alloted_to_coder` AS code_name,
        `alloted_team` AS Team_name,
        `coder_emp_id` AS code_id,
        `agency` AS agency,
        SUM(CASE WHEN `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER', 'APPROVED', 'WIP', 'ALLOTED TO QC', 'QA WIP', 'QC COMPLETED', 'PENDING') THEN 1 ELSE 0 END) AS Total_Files,
        SUM(CASE WHEN `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER') THEN 1 ELSE 0 END) AS Assigned,
        SUM(CASE WHEN `status` = 'WIP' THEN 1 ELSE 0 END) AS WIP,
        SUM(CASE WHEN `status` = 'PENDING' THEN 1 ELSE 0 END) AS pnd,
        SUM(CASE WHEN `status` = 'QA WIP' THEN 1 ELSE 0 END) AS QC_WIP,
        SUM(CASE WHEN `status` = 'QC COMPLETED' THEN 1 ELSE 0 END) AS QCCOM,
        SUM(CASE WHEN `status` = 'ALLOTED TO QC' THEN 1 ELSE 0 END) AS allt_qc,
        SUM(CASE WHEN `status` = 'APPROVED' THEN 1 ELSE 0 END) AS approved,
        SEC_TO_TIME(SUM(CASE WHEN `status` = 'APPROVED' THEN TIME_TO_SEC(`total_working_hours`) ELSE 0 END)) AS total_working_hours
    FROM
        `Main_Data`
    WHERE
        `alloted_to_coder` IS NOT NULL 
        AND `alloted_team` IS NOT NULL ";

    // Add conditions based on parameters
    if (!empty($teamname)) {
        $query .= "AND `alloted_team` = '$teamname' ";
    }
    if (!empty($team_id)) {
        $query .= "AND `team_emp_id` = '$team_id' ";
    }
    if (!empty($coderid)) {
        $query .= "AND `coder_emp_id` = '$coderid' ";
    }
    if (!empty($status)) {
        $query .= "AND `status` = '$status' ";
    }
    if (!empty($Agency)) {
        $query .= "AND `agency` = '$Agency' ";
    }

    // Add date range condition
    $query .= "AND `File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'
    GROUP BY
        `alloted_to_coder`, `alloted_team`, `coder_emp_id`, `agency`";

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }
    if (!$stmt->execute()) {
        die("Error executing the query: " . $stmt->error);
    }

    // Fetch the result
    $result = $stmt->get_result();
    if ($result === false) {
        die("Error getting result set: " . $stmt->error);
    }
    $data['efficiency_report'] = $result->fetch_all(MYSQLI_ASSOC);

    // Output JSON
    echo json_encode($data);

} elseif ($action == 'agency_report') {

    // Get parameters and sanitize inputs
    $fromdate = isset($_GET['fromdate']) ? mysqli_real_escape_string($conn, $_GET['fromdate']) : '';
    $todate = isset($_GET['todate']) ? mysqli_real_escape_string($conn, $_GET['todate']) : '';
    $Agency = isset($_GET['selectedAgencies']) ? $_GET['selectedAgencies'] : [];

    // Ensure $Agency is an array and sanitize inputs
    if (!is_array($Agency)) {
        $Agency = [$Agency]; // Convert to array
    }
    $Agency = implode("','", array_map(function($a) use ($conn) { return mysqli_real_escape_string($conn, $a); }, $Agency));

    // Construct the query
    $query = "
        SELECT
            `agency` AS agency,
            SUM(CASE WHEN `status` IN ('NEW','ASSIGNED TO TEAM','ASSIGNED TO CODER', 'REASSIGNED TO CODER', 'APPROVED', 'WIP', 'ALLOTED TO QC', 'QA WIP', 'QC COMPLETED', 'PENDING') THEN 1 ELSE 0 END) AS Total_Files,
            SUM(CASE WHEN `status` = 'ASSIGNED TO CODER' THEN 1 ELSE 0 END) AS Assigned,
            SUM(CASE WHEN `status` = 'WIP' THEN 1 ELSE 0 END) AS WIP,
            SUM(CASE WHEN `status` = 'REASSIGNED TO CODER' THEN 1 ELSE 0 END) AS reassing,
            SUM(CASE WHEN `status` = 'ASSIGNED TO TEAM' THEN 1 ELSE 0 END) AS team,
            SUM(CASE WHEN `status` = 'NEW' THEN 1 ELSE 0 END) AS NEW,
            SUM(CASE WHEN `status` = 'PENDING' THEN 1 ELSE 0 END) AS pnd,
            SUM(CASE WHEN `status` = 'QA WIP' THEN 1 ELSE 0 END) AS QC_WIP,
            SUM(CASE WHEN `status` = 'QC COMPLETED' THEN 1 ELSE 0 END) AS QCCOM,
            SUM(CASE WHEN `status` = 'ALLOTED TO QC' THEN 1 ELSE 0 END) AS allt_qc,
            SUM(CASE WHEN `status` = 'APPROVED' THEN 1 ELSE 0 END) AS approved
        FROM
            `Main_Data`
        WHERE
            (`File_Status_Time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' OR `log_time` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59')";

    // Add agency condition if provided
    if (!empty($Agency)) {
        $query .= " AND `agency` IN ('$Agency')";
    }

    $query .= " GROUP BY `agency`";

    // Execute the query
    $result = $conn->query($query);
    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    // Fetch the data
    $data['agency_report'] = $result->fetch_all(MYSQLI_ASSOC);

    // Output JSON
    echo json_encode($data);
}




elseif ($action == 'login_details') {
    // Get parameters and sanitize inputs
    $fromdate = isset($_GET['fromdate']) ? mysqli_real_escape_string($conn, $_GET['fromdate']) : '';
    $todate = isset($_GET['todate']) ? mysqli_real_escape_string($conn, $_GET['todate']) : '';
    $teamname = isset($_GET['teamname']) ? mysqli_real_escape_string($conn, $_GET['teamname']) : '';
    $codername = isset($_GET['codername']) ? mysqli_real_escape_string($conn, $_GET['codername']) : '';
    $coderid = isset($_GET['coderid']) ? mysqli_real_escape_string($conn, $_GET['coderid']) : '';

    // Construct the SQL query
    $query = "
        SELECT `username`, `emp_id`, `team_name`, `log_date`, `login_time`, `logout_time`
        FROM `user_log`
        WHERE `role`='user'
    ";

    // Add conditions based on parameters
    if (!empty($codername)) {
        $query .= " AND `username` = '$codername'";
    }
    if (!empty($coderid)) {
        $query .= " AND `emp_id` = '$coderid'";
    }
    if (!empty($fromdate) && !empty($todate)) {
        $query .= " AND `log_date` BETWEEN '$fromdate' AND '$todate'";
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }
    if (!$stmt->execute()) {
        die("Error executing the query: " . $stmt->error);
    }

    // Fetch the result
    $result = $stmt->get_result();
    if ($result === false) {
        die("Error getting result set: " . $stmt->error);
    }
    $data['login_details'] = $result->fetch_all(MYSQLI_ASSOC);

    // Output JSON
    echo json_encode($data);
}















// Close the database connection
$conn->close();
?>
