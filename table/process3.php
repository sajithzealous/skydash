<?php
session_start();
$emp_id = $_SESSION['empid'];
$role = $_SESSION['role'];

include('../db/db-con.php');

$selectedAgents = json_decode($_POST["Agent"]);
$selectedCoder = json_decode($_POST["Coder"]);
$selectedStatuses = json_decode($_POST["Status"]);

// Initialize an empty array to store conditions
$conditions = [];

// Check if any filters are selected
if (!empty($selectedStatuses) || !empty($selectedAgents) || !empty($selectedCoder)) {
    // Build conditions based on selected filters
    if (!empty($selectedStatuses)) {
        $statusConditions = "Status IN ('" . implode("','", $selectedStatuses) . "')";
        $conditions[] = $statusConditions;
    }
    if (!empty($selectedAgents)) {
        $agentConditions = "agency IN ('" . implode("','", $selectedAgents) . "')";
        $conditions[] = $agentConditions;
    }
    if (!empty($selectedCoder)) {
        $coderCondition = "qc_person_emp_id IN ('" . implode("','", $selectedCoder) . "')";
        $conditions[] = $coderCondition;
    }
}

// Combine conditions using "AND"
$whereClause = implode(" AND ", $conditions);

// Build the SQL query
$query = "SELECT * FROM `Main_Data`";

if (!empty($whereClause)) {
    // Add WHERE clause if conditions exist
    $query .= " WHERE $whereClause";
    
    // Exclude `qc_team_emp_id`='$emp_id' condition if "ALLOTED TO QC" status is selected
    if (!in_array("ALLOTED TO QC", $selectedStatuses)) {
        $query .= " AND `qc_team_emp_id`='$emp_id'";
    }
} else {
    // No filters selected, only restrict by emp_id unless "ALLOTED TO QC" is selected
    if (!in_array("ALLOTED TO QC", $selectedStatuses)) {
        $query .= " WHERE `qc_team_emp_id`='$emp_id'";
    }
}

// Execute the query
$result = $conn->query($query);

if ($result) {
    // Fetch and store data in an array
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Set response header to JSON
    header('Content-Type: application/json');

    // Encode data as JSON and send the response
    echo json_encode($data);
} else {
    // Return error message if query fails
    echo json_encode(["error" => "Query failed: " . $conn->error]);
}
?>
