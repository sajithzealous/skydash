<?php
session_start();
$agent = $_SESSION['agent'];

 include('../db/db-con.php');

// $selectedStatuses   = "COMPLETED";
$selectedAgents     = json_decode($_POST["Agent"]);
$selectedCoder      = json_decode($_POST["Coder"]);
$selectedStatuses   = json_decode($_POST["Status"]);


// Check if any statuses or assessment types are selected
if (!empty($selectedStatuses) || !empty($selectedAgents) || !empty($selectedCoder)) {
    // Initialize an empty array to store conditions
    $conditions = array();

    if (!empty($selectedStatuses)) {
        $statusConditions = "Status IN ('" . implode("','", $selectedStatuses) . "')";
        $conditions[] = $statusConditions;
    }
    if (!empty($selectedAgents)) {
        $agentConditions = "agency IN ('" . implode("','", $selectedAgents) . "')";
        $conditions[] = $agentConditions;
    }
 

    if (!empty($selectedCoder)) {
    // Constructing condition for both columns
    $coderCondition = "(qc_person_emp_id IN ('" . implode("','", $selectedCoder) . "') OR coder_emp_id IN ('" . implode("','", $selectedCoder) . "')) AND Status IN('ALLOTED TO QC','APPROVED')";
    $conditions[] = $coderCondition;
}


    // Combine conditions using "AND" or "OR" depending on your needs
    $whereClause = implode(" AND ", $conditions);

    // Define your SQL query
    $query = "SELECT * FROM `Main_Data`";
    if (!empty($whereClause)  && $agent !== NULL) {
        $query .= " WHERE $whereClause  AND `Agency` = '$agent' AND `status`='$selectedStatuses' ";
    }
    elseif (!empty($whereClause) && $agent == NULL ) {
        $query .= " WHERE $whereClause";
    }
} elseif ($agent == NULL) {
    $query = "SELECT * FROM `Main_Data` AND `status`='$selectedStatuses'";
} elseif($agent !== NULL) {
    // If no filters are selected, get all data
    $query = "SELECT * FROM `Main_Data` WHERE `Agency`='$agent' AND `status`='$selectedStatuses'";
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
    echo json_encode ("Query failed: ",$conn->error);
}
