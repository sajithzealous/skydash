<?php
session_start();




$emp_id = $_SESSION['empid'];
// Create connection
 include('../db/db-con.php');

// Check if the 'Id' parameter is set in the POST request
if (isset($_POST['Id'])) {
    // Sanitize the input to prevent SQL injection
    $userId = intval($_POST['Id']);
    
    // // Update status in the 'Main_Data' table
     date_default_timezone_set('America/New_York');
     $currentDateTime = date('Y-m-d H:i:s');
    $updateQuery = "UPDATE `Main_Data` SET `status` = 'WIP',`File_Status_Time`= '$currentDateTime' WHERE `Id` = '$userId'";
    $response = [];

    if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Record updated successfully";
    } else {
        $response['success'] = false;
        $response['error'] = "Error updating record: " . $conn->error;
    }

    // Return response as JSON


    $response = [];

    $select_query = "SELECT * FROM `Main_Data` WHERE `Id` = '$userId'";
    $result = $conn->query($select_query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $Id = $conn->real_escape_string($row['Id']);
            $patient_name = $conn->real_escape_string($row['patient_name']);
            $mrn = $conn->real_escape_string($row['mrn']);
            $phone_number = $conn->real_escape_string($row['phone_number']);
            $insurance_type = $conn->real_escape_string($row['insurance_type']);
            $assessment_date = $conn->real_escape_string($row['assesment_date']);
            $assessment_type = $conn->real_escape_string($row['assesment_type']);
            $agency = $conn->real_escape_string($row['agency']);
            $status = "WIP";
            $Team = $conn->real_escape_string($row['alloted_team']);
            $Coder = $conn->real_escape_string($row['alloted_to_coder']);
            $Team_empid = $conn->real_escape_string($row['team_emp_id']);
            $Coder_empid = $conn->real_escape_string($row['coder_emp_id']);
        }

        $insert_query = "INSERT INTO `Work_Log` (`entry_id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`, `Team`, `Coder`,`work_start`,`team_emp_id`,`coder_emp_id`) VALUES ('$Id', '$patient_name', '$mrn', '$phone_number', '$insurance_type', '$assessment_date', '$assessment_type', '$agency', '$status', '$Team', '$Coder','$currentDateTime','$Team_empid','$Coder_empid')";

        $insert_result = $conn->query($insert_query);
        if ($insert_result) {
            $response['success'] = true;
            $response['message'] = $Id;
        } else {
            $response['success'] = false;
            $response['error'] = "Error inserting data into Work_Log table: " . $conn->error;
        }
    } else {
        $response['success'] = false;
        $response['error'] = "No records found for the given ID";
    }

    echo json_encode($response);

    // Close the connection
    $conn->close();
}
