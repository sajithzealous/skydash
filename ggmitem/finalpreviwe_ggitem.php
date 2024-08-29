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

// Define the default table name
$tableName = 'oasis_qc_new';

// SQL query to fetch data related to both "coder" and "QC" (Quality Control)
 $query = "SELECT `Agency_response`, `Coder_response`, `Coder_rationali` 
          FROM `oasis_qc_new` 
          WHERE `Coder_rationali` != 'Null'
          AND `Entry_id` = $userId";

// Execute the query
$result = $conn->query($query);

// Check if query executed successfully
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch data row by row
        while ($row = $result->fetch_assoc()) {
            // Store retrieved data into response array
            $response[] = [
                'agencydata' => $row['Agency_response'],
                'coderdata' => $row['Coder_response'],
                'Coder_rationali' => $row['Coder_rationali']
            ];
        }
    } else {
        // If no rows were returned, try the alternative table
        $tableName = 'oasis_new';

        $query = "SELECT `Agency_response`, `Coder_response`, `Coder_rationali` 
                  FROM `oasis_new` 
                  WHERE `Coder_rationali` != 'Null'
                  AND `Entry_id` = $userId";

        // Execute the alternative query
        $result_alt = $conn->query($query);

        if ($result_alt) {
            // Check if any rows were returned
            if ($result_alt->num_rows > 0) {
                // Fetch data row by row
                while ($row = $result_alt->fetch_assoc()) {
                    // Store retrieved data into response array
                    $response[] = [
                        'agencydata' => $row['Agency_response'],
                        'coderdata' => $row['Coder_response'],
                        'Coder_rationali' => $row['Coder_rationali']
                    ];
                }
            } else {
                // If both queries fail to return any rows
                $response['error'] = "No data found in both tables.";
            }
        } else {
            // If alternative query fails, capture error message
            $response['error'] = "Error executing alternative query: " . $conn->error;
        }
    }
} else {
    // If initial query fails, capture error message
    $response['error'] = "Error executing query: " . $conn->error;
}

// Set response content type to JSON
header('Content-Type: application/json');

// Send JSON response
echo json_encode($response);
?>
