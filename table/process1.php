<?php
 include('../db/db-con.php');

session_start();
$user = $_SESSION['username'];
$empid = $_SESSION['empid'];

$selectedStatuses   = json_decode($_POST["Statuses"]);
$selectedCoder      = json_decode($_POST["Coder"]);


// Check if any statuses or assessment types are selected
if (!empty($selectedStatuses) || !empty($selectedCoder)) {
    // Initialize an empty array to store conditions
    $conditions = array();

    if (!empty($selectedStatuses)) {
        $statusConditions = "Status IN ('" . implode("','", $selectedStatuses) . "')";
        $conditions[] = $statusConditions;
    }

    if (!empty($selectedCoder)) {
        $coderCondition = "coder_emp_id IN ('" . implode("','", $selectedCoder) . "')";
        $conditions[] = $coderCondition;
    }

    // Combine conditions using "AND" or "OR" depending on your needs
    $whereClause = implode(" AND ", $conditions);

    // Define your SQL query
    $query = "SELECT * FROM `Main_Data`";

    // Check if $whereClause is not empty and concatenate it to the query
    if (!empty($whereClause)) {
        // Assuming $user is a string
        $query .= " WHERE $whereClause AND `alloted_team` = '$user' AND `team_emp_id`='$empid'";
    } else {
        // If $whereClause is empty, only add the 'alloted_team' condition
        $query .= " WHERE `alloted_team` = '$user' AND `team_emp_id`='$empid'";
    }
} else {
    // If no filters are selected, get all data
    $query = "SELECT * FROM `Main_Data` WHERE `alloted_team` = '$user' AND `team_emp_id`='$empid'";
}

// Execute the query
$result = $conn->query($query);

if ($result) {
    // Fetch and store the data in an array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Set the response header to JSON
    header('Content-Type: application/json');

    // Encode the data as JSON and send the response
    echo json_encode($data);
} else {
    echo "Query failed: " . $conn->error;
}
