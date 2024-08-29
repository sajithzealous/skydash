<?php

session_start();
$user = $_SESSION['username'];
$role = $_SESSION['role'];
$empid = $_SESSION['empid'];

 include('../db/db-con.php');

// Function to fetch data based on user role
function fetchData($conn, $sql, $role)
{
    $result = $conn->query($sql);
    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add the role information to each fetched row
            $row['role'] = $role;
            $data[] = $row;
        }
    }

    return $data;
}

// Create connection


$data = array();

if ($user == 'admin') {
    // Fetch data for admin
    $sql = "SELECT * FROM `Main_Data`";
    $data = fetchData($conn, $sql, 'admin');
} elseIf ($role == 'TeamLeader') {
    // Fetch data for team leader
     $sql = "SELECT * FROM `Main_Data` WHERE `alloted_team`='$user' AND  `team_emp_id`= '$empid' AND `status` IN ('ALLOTED TO QC','QA WIP','ASSIGNED TO QC CODER','REASSIGNED TO QC CODER' 'QC COMPLETED')";
    $data = fetchData($conn, $sql, 'TeamLeader');
     
}
else{
    // Fetch data for team leader
     $sql = "SELECT * FROM `Main_Data` WHERE `alloted_to_coder`='$user' AND  `coder_emp_id`= '$empid' AND `status` IN ('ALLOTED TO QC')";
    $data = fetchData($conn, $sql,'Coder');
     $_SESSION['table_data'] = $data;
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();

