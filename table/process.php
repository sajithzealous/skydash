<?php
session_start();
$agent = $_SESSION['agent'];
$role = $_SESSION['role'];

 include('../db/db-con.php');

$selectedStatuses   = json_decode($_POST["Statuses"]);
$selectedAssessment = json_decode($_POST["Assessment"]);
$selectedAgents     = json_decode($_POST["Agent"]);
$selectedTeam       = json_decode($_POST["Team"]);
$selectedCoder      = json_decode($_POST["Coder"]);


// Check if any statuses or assessment types are selected
if (!empty($selectedStatuses) || !empty($selectedAssessment) || !empty($selectedAgents) || !empty($selectedTeam) || !empty($selectedCoder)) {
    // Initialize an empty array to store conditions
    $conditions = array();

    if (!empty($selectedStatuses)) {
        $statusConditions = "Status IN ('" . implode("','", $selectedStatuses) . "')";
        $conditions[] = $statusConditions;
    }

    if (!empty($selectedAssessment)) {
        $assessmentConditions = "assesment_type IN ('" . implode("','", $selectedAssessment) . "')";
        $conditions[] = $assessmentConditions;
    }

    if (!empty($selectedAgents)) {
        $agentConditions = "agency IN ('" . implode("','", $selectedAgents) . "')";
        $conditions[] = $agentConditions;
    }

    if (!empty($selectedTeam)) {
        $teamCondition = "team_emp_id IN ('" . implode("','", $selectedTeam) . "')";
        $conditions[] = $teamCondition;
    }

    if (!empty($selectedCoder)) {
        $coderCondition = "coder_emp_id IN ('" . implode("','", $selectedCoder) . "')";
        $conditions[] = $coderCondition;
    }

    // Combine conditions using "AND" or "OR" depending on your needs
    $whereClause = implode(" AND ", $conditions);

    // Define your SQL query
    $query = "SELECT * FROM `Main_Data`";
    if (!empty($whereClause)  && $agent !== NULL) {
        $query .= " WHERE $whereClause  AND `Agency` = '$agent'";
    }
    elseif (!empty($whereClause) && $agent == NULL ) {
        $query .= " WHERE $whereClause";
    }
} elseif ($agent == NULL) {
    $query = "SELECT * FROM `Main_Data`";
} elseif($agent !== NULL) {
    // If no filters are selected, get all data
    $query = "SELECT * FROM `Main_Data` WHERE `Agency`='$agent'";
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
