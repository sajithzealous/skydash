<?php
include 'logsession.php';
session_start();
 include('../db/db-con.php');

$query = "SELECT * FROM `Qcerrortype` WHERE `status` ='active'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['qcerrrotype'];
    }

    // Encode the data as JSON
    $jsonResponse = json_encode($data);

    // Output the JSON data
    echo $jsonResponse;
} else {
    // Output a message if no rows are found
    echo json_encode(array('error' => 'No data found'));
}
?>