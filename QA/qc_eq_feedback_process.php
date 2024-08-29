<?php
session_start();

 include('../db/db-con.php');
// Check if the 'Id' parameter is set in the POST request
if (isset($_POST['Id'])) {
    // Sanitize the input to prevent SQL injection
    $userId = intval($_POST['Id']);
    $emp_id = $_SESSION['empid'];

    //Update status in the 'Main_Data' table
    date_default_timezone_set('America/New_York');
    $currentDateTime = date('Y-m-d H:i:s');
    $updateQuery = "UPDATE `Main_Data` SET `status` = 'EQ Feedback',`File_Status_Time`= '$currentDateTime' WHERE `Id` = '$userId'";
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

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $Id = $conn->real_escape_string($row['Id']);
        $patient_name = $conn->real_escape_string($row['patient_name']);
        $mrn = $conn->real_escape_string($row['mrn']);
        $phone_number = $conn->real_escape_string($row['phone_number']);
        $insurance_type = $conn->real_escape_string($row['insurance_type']);
        $assessment_date = $conn->real_escape_string($row['assesment_date']);
        $assessment_type = $conn->real_escape_string($row['assesment_type']);
        $agency = $conn->real_escape_string($row['agency']);
        $status = "EQ Feedback";
        $Team = $conn->real_escape_string($row['qc_team']);
        $Team_emp_id = $conn->real_escape_string($row['qc_team_emp_id']);
        $Coder = $conn->real_escape_string($row['qc_person']);
        $Coder_emp_id = $conn->real_escape_string($row['qc_person_emp_id']);


       $select_query2 = "SELECT * from `Work_Log` where  `entry_id`='$Id' AND `work_start` is not null AND `work_end` is null order by 'timestamp' desc limit 1";

           
            $select_result2 = $conn->query($select_query2);

            if ($select_result2 && $select_result2->num_rows > 0) {
                // Data is retrieved, update the record
                $select_query3 = "UPDATE `Work_Log` SET `work_end`='$currentDateTime' WHERE `entry_id`='$Id' AND `coder_emp_id`='$Coder_empid'AND `work_end` is null ";
                
                // Execute the update query
                $update_result = $conn->query($select_query3);

                if ($update_result) {
                
                } else {
                    
                }
            } else {
            
            }

                


        $insert_query = "INSERT INTO `Work_Log` (`entry_id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`, `Team`, `Coder`,`team_emp_id`,`coder_emp_id`,`work_start`,) VALUES ('$Id', '$patient_name', '$mrn', '$phone_number', '$insurance_type', '$assessment_date', '$assessment_type', '$agency', '$status', '$Team', '$Coder','$Team_emp_id','$Coder_emp_id','$currentDateTime')";

        $insert_result = $conn->query($insert_query);

        if ($insert_result) {
            $response['success'] = true;
            $response['message'] = "Completed Successfully";
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
