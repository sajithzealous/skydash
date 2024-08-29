<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user = $_SESSION['username'] ?? null;
$emp_id = $_SESSION['empid'];
$Id = $_COOKIE['Id'] ?? '';
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
                $status = 'Coder_review';


                if ($pocitemValue !== '') {
                    $extractedDatasql = "SELECT `Poc_item` FROM `Pocsegement` WHERE `Poc_item`= '$pocitemValue' AND `Entry_id` = '$Entry_Id'";
                    $extractedDatasqlresult = $conn->query($extractedDatasql);
                    $rowsExist = $extractedDatasqlresult->num_rows > 0;

                    if ($rowsExist) {
                        $updateQuery = "UPDATE `Pocsegement` SET `Coder_response`='$Coder_response',`User`='$user',`coder_emp_id`='$emp_id' WHERE `Poc_item`='$pocitemValue' AND `Entry_id`='$Entry_Id'";
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
                        if ($Coder_response !== '') {
                            $sql = "INSERT INTO `Pocsegement`(`Entry_id`, `Mrn`, `Patient_Name`, `Poc_item`, `Coder_response`, `User`,`status`,`coder_emp_id`) 
                                    VALUES ('$Entry_Id', '$mrn', '$patientName', '$pocitemValue', '$Coder_response','$user','$status','$emp_id')";
                    
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
} 

 else if (isset($_POST['pocitem']) && isset($_POST['poccode'])) {
    // Assigning values from POST
    $mitem = $_POST['pocitem'];
    $poccode = $_POST['poccode'];
  

    // Sanitize user input to prevent SQL injection
    $mitem = $conn->real_escape_string($mitem);
    $poccode = $conn->real_escape_string($poccode);
 

    // Prepare and execute the query to update `Codesegement` table
    $query1 = "UPDATE `Pocsegement` SET `code_status`='delete' WHERE `Entry_Id`='$Id' AND `Poc_item`='$mitem' AND `Coder_response`='$poccode'";
    $result1 = $conn->query($query1);

    // Check if the update was successful
    if ($result1) {
        // If successful, respond with success message
        $response['success'] ='Deleted';
        
        // Fetching Mrn for the given Entry_Id from `Codesegement` table
        $query2 = "SELECT `Mrn` FROM `Pocsegement`WHERE `Entry_Id`='$Id'";
        $result2 = $conn->query($query2);

        // Checking if the query to fetch Mrn was successful
        if ($result2 && $result2->num_rows > 0) {
            $dataRow = $result2->fetch_assoc();
            $Mrn = $dataRow['Mrn'];

            // Inserting deleted M-Items data into `deleted_Mitems` table
            $insertQuery = "INSERT INTO `deleted_Mitems`(`Entry_Id`, `Mrn`, `mitem`,`icd_code`,`user_name`, `emp_id`) VALUES ('$Id','$Mrn','$mitem','$poccode','$user','$emp_id')";
            $insertResult = $conn->query($insertQuery);

            // Checking if the insertion was successful
            if ($insertResult) {
                // If successful, you may want to log this success or handle it appropriately
            } else {
                $response['error'] = 'Error inserting data into `deleted_Mitems` table: ' . $conn->error;
            }
        } else {
            $response['error'] = 'Error fetching `Mrn` from `Codesegement` table: ' . $conn->error;
        }
    } else {
        $response['error'] = 'Query execution error: ' . $conn->error;
    }
} 

 
else {
    $response['success'] = false;
    $response['error'] = 'Please enter valid data';
    // echo json_encode($response);
}
echo json_encode($response);
$conn->close();
?>
