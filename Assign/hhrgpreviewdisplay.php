<?php

include('../db/db-con.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$Id = $_POST['Id'];

$response = array(); // Initialize an empty array to hold the response data

if ($Id) {
    // First Query
    $query1 = "SELECT * FROM `Main_Data` WHERE `Id`='$Id'";
    $result1 = $conn->query($query1);

    if ($result1 && $result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $response['user_data'] = $row; // Store user data in the response array

        // Second Query
        $query2 = "SELECT `precodevalue`, `precodevaluemultiply`, `postcodevalue`, `postcodevaluemultiply`, `additionvalue`, `additionalvaluemultiply`, `User`, `coder_emp_id` FROM `hhrgcodedata` WHERE `Entry_Id`='$Id'";
        $result2 = $conn->query($query2);

        if ($result2 && $result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $response['codedata'] = $row2; // Store code data in the response array
        } else {
            $response['codedata'] = "No data found for hhrgcodedata with the given ID";
        }
    } else {
        $response['user_data'] = "No user found with the given ID";
    }
}

// Encode the response array as JSON and send it
echo json_encode($response);

?>
