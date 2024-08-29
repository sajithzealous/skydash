<?php
// Include session handling script
include 'logsession.php';

// Start session
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection script
include('../db/db-con.php');

// Get user ID from cookie
$userId = $_COOKIE['Id'];

// Initialize response array
$response = [];

// SQL query to fetch data related to both "coder" and "QC" (Quality Control)
 $query = "SELECT  *
          FROM (
              SELECT oasis_new.Entry_id,
                     oasis_new.M_item,
                     oasis_new.coder_emp_id,
                     oasis_new.Agency_response,
                     oasis_new.Coder_response,
                     oasis_new.Coder_rationali
              FROM oasis_new 
              WHERE oasis_new.Entry_id = $userId
          ) as q1 
          INNER JOIN (
              SELECT oasis_qc_new.Entry_id,
                     oasis_qc_new.M_item,
                     oasis_qc_new.coder_emp_id,
                     oasis_qc_new.Agency_response AS qc_agency_response,
                     oasis_qc_new.Coder_response AS qc_coder_response,
                     oasis_qc_new.Coder_rationali AS qc_coder_rationali,
                     oasis_qc_new.Error_reason,
                     oasis_qc_new.Error_type 
              FROM oasis_qc_new 
              WHERE oasis_qc_new.Coder_rationali !='Null' AND oasis_qc_new.Entry_id = $userId
          ) as q2 
          ON q2.Entry_id = q1.Entry_id AND q2.M_item = q1.M_item";

// Execute the query
$result = $conn->query($query);

// Check if query executed successfully
if ($result) {
    // Fetch data row by row
    while ($row = $result->fetch_assoc()) {
        // Store retrieved data into response array
        $response[] = [
            'agencydata' => $row['Agency_response'],
            'coderdata' => $row['Coder_response'],
            'Coder_rationali' => $row['Coder_rationali'],
            'qc_agency_response' => $row['qc_agency_response'],// QC data
            'QCCoder_response' => $row['qc_coder_response'], // QC data
            'QCCoder_rationali' => $row['qc_coder_rationali'], // QC data
            'Error_reason' => $row['Error_reason'],
            'Error_type' => $row['Error_type']
        ];
    }
} else {
    // If query execution fails, capture error message
    $response['error'] = "Error executing query: " . $conn->error;
}

// Set response content type to JSON
header('Content-Type: application/json');

// Send JSON response
echo json_encode($response);

?>
