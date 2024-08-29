<?php
include 'logsession.php';
session_start();
include('../db/db-con.php');

$action = $_GET['action'];

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
    // Handle error if no agencies found
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Error: No agencies found for the user.']);
    exit;
}

// Check if fromdate and todate parameters are set
if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];

    // Construct the SQL query
    $agency_names = implode("','", $agencies);
    $sql = "SELECT `Id`,`alloted_team`, `agency`, `patient_name`, `phone_number`, `mrn`, `status`, `alloted_to_coder`, `insurance_type`, `assesment_type`, `assesment_date`,`totalcasemix`
          FROM Main_Data WHERE  `status`='APPROVED'
            AND `agency` IN ('$agency_names')
           AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";

    // Execute the SQL query
    $result = $conn->query($sql);

    // Fetch the data
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
} else {
    // Handle error if fromdate or todate parameters are missing
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Error: Missing parameters.']);
    exit;
}
?>
