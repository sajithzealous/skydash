<?php

// Set the session cookie lifetime to 1 hour (3600 seconds)
ini_set('session.cookie_lifetime', 60);

// Set the session garbage collection lifetime to 1 hour (3600 seconds)
ini_set('session.gc_maxlifetime', 60);

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


$user = $_SESSION['username'] ?? null;
$emp_id = $_SESSION['empid'];

 include('../db/db-con.php');

if (isset($_POST['formDataArray'])) {
    $Entry_Id = $_POST['Id'] ?? null; // Ensure 'Id' is being sent in the form data
    $formDataArray = $_POST['formDataArray']; // JSON data

    if ($Entry_Id !== null) {
        $query = "SELECT `patient_name`, `mrn` FROM `Main_Data` WHERE `Id` = $Entry_Id";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $patientName = $conn->real_escape_string($row['patient_name']);
            $mrn = $conn->real_escape_string($row['mrn']);

            foreach ($formDataArray as $formData) {
                $pocitemValue = $conn->real_escape_string($formData['pocitemAttributeValue']);
                $Coder_response = is_array($formData['us1']) ?
                    $conn->real_escape_string(implode(', ', $formData['us1'])) :
                    $conn->real_escape_string($formData['us1']);
                $Error_reason = $formData['pocreason'] ?? '';
                $Error_type = $formData['pocerrortype'] ?? '';
                $Qc_rationali = $formData['pocqcrationaile'] ?? '';
                $status = 'Qc_review';


                if (isset($formData['usVal']) && !empty($formData['usVal'])) {
                    $Qc_response = is_array($formData['usVal']) ? implode(',', $formData['usVal']) : $formData['usVal'];
                } else {
                    $Qc_response = $Coder_response;
                }



                if ($pocitemValue !== '') {


                    $extractedDatasql = "SELECT `Poc_item` FROM `Pocsegementqc` WHERE `Poc_item`= '$pocitemValue' AND `Entry_id` = '$Entry_Id'";
                    $extractedDatasqlresult = $conn->query($extractedDatasql);
                    $rowsExist = $extractedDatasqlresult->num_rows > 0;

                    if ($rowsExist) {
                        $updateQuery = "UPDATE `Pocsegementqc` SET `Poc_coder_response`='$Coder_response', `Coder_response`='$Qc_response',`Error_reason`='$Error_reason', `Error_type`='$Error_type', `Qc_rationali`='$Qc_rationali',`User` = '$user',`coder_emp_id` ='$emp_id' WHERE `Poc_item`='$pocitemValue' AND `Entry_id`='$Entry_Id'";
                        if ($conn->query($updateQuery) === TRUE) {
                            $response['success'] = true;
                            $response['message'] = 'Data updated successfully';
                            // echo json_encode($response);
                        } else {
                            $response['success'] = false;
                            $response['error'] = 'Update query error: ' . $conn->error;
                            // echo json_encode($response);
                        }
                    } else {
                        if ($Qc_response !== '') {
                            $sql = "INSERT INTO `Pocsegementqc`(`Entry_id`, `Mrn`, `Patient_Name`, `Poc_item`, `Poc_coder_response`,`Coder_response`,`Error_reason`,`Error_type`,`Qc_rationali`, `User`,`status`,`coder_emp_id`) 
                                    VALUES ('$Entry_Id', '$mrn', '$patientName', '$pocitemValue','$Coder_response', '$Qc_response','$Error_reason','$Error_type','$Qc_rationali','$user','$status','$emp_id')";

                            if ($conn->query($sql) === TRUE) {
                                $response['success'] = true;
                                $response['message'] = 'Data inserted successfully';
                                // echo json_encode($response);
                            } else {
                                $response['success'] = false;
                                $response['error'] = 'Insert query error: ' . $conn->error;
                                // echo json_encode($response);
                            }
                        } else {
                            $response['success'] = false;
                            $response['error'] = 'Empty data';
                            // echo json_encode($response);
                        }
                    }
                } else {
                    $response['success'] = false;
                    $response['error'] = 'No matching records found for provided ID';
                    // echo json_encode($response);
                }
            }
        } else {
            $response['success'] = false;
            $response['error'] = 'No matching records found for provided ID';
            // echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'Please provide valid ID';
        // echo json_encode($response);
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Please enter valid data';
    // echo json_encode($response);
}
echo json_encode($response);
$conn->close();
