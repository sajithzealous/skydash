<?php

session_start();
$user = $_SESSION['username'];
$role = $_SESSION['role'];
$emp_id = $_SESSION['empid'];

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
} elseif ($role == 'TeamLeader') {
    // Fetch data for team leader
    $sql = "SELECT * FROM `Main_Data` WHERE `alloted_team`='$user' AND `team_emp_id` = '$emp_id' AND `status`IN('APPROVED')";
    $data = fetchData($conn, $sql, 'TeamLeader');
}elseif($role == 'QA'){
    // Fetch data for coder
    $sql = "SELECT * FROM `Main_Data` WHERE `qc_person`='$user' AND `qc_person_emp_id` = '$emp_id' AND `status`IN('APPROVED')";
    $data = fetchData($conn, $sql, 'QA');
}
 elseif($role == 'QaTl'){
    // Fetch data for coder
    $sql = "SELECT * FROM `Main_Data` WHERE `qc_team`='$user' AND `qc_team_emp_id` = '$emp_id' AND `status`IN('APPROVED')";
    $data = fetchData($conn, $sql, 'QaTl');
}  else {
    // Fetch data for coder
    $sql = "SELECT * FROM `Main_Data` WHERE `alloted_to_coder`='$user' AND `coder_emp_id` = '$emp_id' AND `status`IN('APPROVED')";
    $data = fetchData($conn, $sql, 'Coder');
    $_SESSION['table_data'] = $data;
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();

