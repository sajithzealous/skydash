<?php

// Include database connection
include('../db/db-con.php');

// Start the session
session_start();

// Check if the 'totalagencyvalue', 'totalcodervalue', and 'clinicalname' parameters are set in the POST request
if (isset($_POST['totalAgencyValues'], $_POST['totalCoderValues'], $_POST['clinicalGroupNamecoder'],$_POST['clinicalGroupNameagency'])) {
    // Assign values from POST parameters to variables
     $totalagencypoints = $_POST['totalAgencyValues'];
     $totalcoderpoints = $_POST['totalCoderValues'];
     $clinicalnameagency = $_POST['clinicalGroupNameagency'];
     $clinicalnamecoder = $_POST['clinicalGroupNamecoder'];


    // Prepare and execute the SQL query for total agency points
     $queryAgency = "SELECT $clinicalnameagency FROM `Position_3` WHERE `points`='$totalagencypoints'";
    $resultAgency = $conn->query($queryAgency);

    // Prepare and execute the SQL query for total coder points
     $queryCoder = "SELECT $clinicalnamecoder FROM `Position_3` WHERE `points`='$totalcoderpoints'";
    $resultCoder = $conn->query($queryCoder);

    // Initialize variables to store response
    $response = array();

    // Check if there are results for total agency points
    if ($resultAgency->num_rows > 0) {
        $position3valueAgency = $resultAgency->fetch_assoc();
        $agencyvalue =  $position3valueAgency[$clinicalnameagency];

        
             if ($agencyvalue == "LOW") {
                $response['total_agency'] = "A";
              } else if ($agencyvalue == "MEDIUM") {
                $response['total_agency'] = "B";
              } else if ($agencyvalue == "HIGH") {
                $response['total_agency'] = "C";
              }
    } 



    else {
        $response['total_agency'] = "No data available for total agency points";
    }

    // Check if there are results for total coder points
    if ($resultCoder->num_rows > 0) {
        $position3valueCoder = $resultCoder->fetch_assoc();
        $codervalue= $position3valueCoder[$clinicalnamecoder];
        if ($codervalue == "LOW") {
                $response['total_coder'] = "A";
              } else if ($codervalue == "MEDIUM") {
                $response['total_coder'] = "B";
              } else if ($codervalue == "HIGH") {
                $response['total_coder'] = "C";
              }
    } else {
        $response['total_coder'] = "No data available for total coder points";
    }

    // Encode the response as JSON and echo it
    echo json_encode($response);

    // Close the database connection
    $conn->close();
}
?>
