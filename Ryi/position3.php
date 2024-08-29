<?php

// Include database connection
include('../db/db-con.php');

// Start the session
session_start();

// Check if the 'totalagencyvalue', 'totalcodervalue', and 'clinicalname' parameters are set in the POST request
if (isset($_POST['totalagencyvalue'], $_POST['totalcodervalue'], $_POST['clinicalname'])) {
    // Assign values from POST parameters to variables
     $totalagencypoints = $_POST['totalagencyvalue'];
     $totalcoderpoints = $_POST['totalcodervalue'];
     $clinicalname = $_POST['clinicalname'];

    // Prepare and execute the SQL query for total agency points
    $queryAgency = "SELECT $clinicalname FROM `Position_3` WHERE `points`='$totalagencypoints'";
    $resultAgency = $conn->query($queryAgency);

    // Prepare and execute the SQL query for total coder points
    $queryCoder = "SELECT $clinicalname FROM `Position_3` WHERE `points`='$totalcoderpoints'";
    $resultCoder = $conn->query($queryCoder);

    // Initialize variables to store response
    $response = array();

    // Check if there are results for total agency points
    if ($resultAgency->num_rows > 0) {
        $position3valueAgency = $resultAgency->fetch_assoc();
        $response['total_agency'] = $position3valueAgency[$clinicalname];
    } else {
        $response['total_agency'] = "No data available for total agency points";
    }

    // Check if there are results for total coder points
    if ($resultCoder->num_rows > 0) {
        $position3valueCoder = $resultCoder->fetch_assoc();
        $response['total_coder'] = $position3valueCoder[$clinicalname];
    } else {
        $response['total_coder'] = "No data available for total coder points";
    }

    // Encode the response as JSON and echo it
    echo json_encode($response);

    // Close the database connection
    $conn->close();
}
?>
