<?php

session_start();
$user = $_SESSION['username'];
$emp_id = $_SESSION['empid'];
$role = $_SESSION['role'];

// echo $role;
include('../db/db-con.php');

// Function to fetch data based on user role and pagination
function fetchDataWithPagination($conn, $sql, $start, $length, $role)
{
    $sql .= " LIMIT $start, $length";
    $result = $conn->query($sql);
    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['role'] = $role;
            $data[] = $row;
        }
    }

    return $data;
}

// Create connection

$data = array();

if ($role == 'QaTl') {
    // Fetch data for team leader
    $sql = "SELECT * FROM `Main_Data` WHERE `status` IN ('APPROVED', 'QA WIP', 'ASSIGNED TO QC CODER', 'REASSIGNED TO QC CODER', 'QC COMPLETED') AND qc_team_emp_id = '$emp_id'";
} else if($role =='QA') {
    // Fetch data for coder
    $sql = "SELECT * FROM `Main_Data` WHERE `status` IN ('ALLOTED TO QC', 'APPROVED') ORDER BY `Id`";
}

// Pagination parameters
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$length = 10; // Number of records per page
$start = ($page - 1) * $length; // Starting index for pagination

// Fetch data with pagination
$data = fetchDataWithPagination($conn, $sql, $start, $length, $role);

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();
