<?php
session_start();

 include('../db/db-con.php');

// Check if the 'Id' parameter is set in the POST request
if (isset($_POST['Id']) && isset($_GET['action'])) {
    // Sanitize the input to prevent SQL injection
    $userId = intval($_POST['Id']);
    $action = $_GET['action'];

    date_default_timezone_set('America/New_York');
    $currentDateTime = date('Y-m-d H:i:s');
    $response = [];

    if ($action == 'insertbreaktime') {
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
                $status = $conn->real_escape_string($row['status']);
                $break_status = "Break_In";
                $Team = $conn->real_escape_string($row['alloted_team']);
                $Coder = $conn->real_escape_string($row['alloted_to_coder']);

                // Insert break time data into Work_Log table
                $insert_query = "INSERT INTO `Work_Log` (`entry_id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`,`Team`,`status`, `Coder`,`break_status`,`brk_in`) VALUES ('$Id', '$patient_name', '$mrn', '$phone_number', '$insurance_type', '$assessment_date', '$assessment_type', '$agency',  '$Team','$status', '$Coder','$break_status', '$currentDateTime')";
                $insert_result = $conn->query($insert_query);
                if ($insert_result) {
                    $response['insert_success'] = true;
                    $response['insert_message'] = "Break Log Successfully Inserted";
                } else {
                    $response['insert_success'] = false;
                    $response['insert_error'] = "Error inserting data into Work_Log table: " . $conn->error;
                }
            }
        } else {
            $response['success'] = false;
            $response['error'] = "No records found for the given ID";
        }
    } else {

        echo "data not inserted";
    }



    if ($action === 'updatebreaktime') {
        // Update break time data in Work_Log table
        $update_query = "UPDATE `Work_Log` SET `brk_out`='$currentDateTime', `break_status`='Break_Out' WHERE `entry_id`='$userId' AND `break_status`='Break_In' AND `brk_in` IS NOT NULL ORDER BY `logtime` DESC LIMIT 1";

        $update_result = $conn->query($update_query);
        if ($update_result) {
            $response['update_success'] = true;
            $response['update_message'] = "Break Log Successfully Updated";
        } else {
            $response['update_success'] = false;
            $response['update_error'] = "Error updating break time in Work_Log table: " . $conn->error;
        }
    } else {
        $response['error'] = "Invalid action";
    }

    echo json_encode($response);

    // Close the connection
    $conn->close();
}
