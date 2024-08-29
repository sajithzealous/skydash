<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user = $_SESSION['username'] ?? null;

 $emp_id = $_SESSION['empid'];
$Id = $_COOKIE['Id'] ?? '';
 include('../db/db-con.php');

if (isset($_POST['formDataArray'])) {
    $Entry_Id = $_POST['Id'] ?? null; // Ensure 'Id' is being sent in the form data
    $formDataArray = $_POST['formDataArray']; // JSON data

    if ($Entry_Id !== null) {
        $query = "SELECT `patient_name`, `mrn` FROM `Main_Data` WHERE `Id` = '$Entry_Id'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $patientName = $row['patient_name'];
            $mrn = $row['mrn'];

            foreach ($formDataArray as $formData) {
                $cardheader=$formData['cardheader'];
                $mitemValue = $formData['mitemAttributeValue'] ?? '';
                $Coder_response = is_array($formData['us2']) ? implode(', ', $formData['us2']) : $formData['us2'];
                $Agency_response = is_array($formData['us1']) ? implode(', ', $formData['us1']) : $formData['us1'];
                $Coder_rationali = $formData['us3'];
                $status = 'Coder_review';

                // echo $mitemValue;

                $extractedData = '';
                $pattern = '/\(([^)]+)\)/';
                if (preg_match($pattern, $mitemValue, $matches)) {
                    $extractedData = $matches[1];

                    if ($extractedData !== '') {
                        $extractedDatasql = "SELECT `M_item` FROM `oasis` WHERE `M_item` = '$extractedData' AND `Entry_id` = '$Entry_Id'";
                        $extractedDatasqlresult = $conn->query($extractedDatasql);
                        $rowsExist = ($extractedDatasqlresult->num_rows > 0);

                        if ($rowsExist) {
                            $updateQuery = "UPDATE `oasis` SET `code_status`=Null,`Agency_response`=?, `Coder_response`=?, `Coder_rationali`=?, `User`=?, `coder_emp_id`=? WHERE `M_item`=? AND `Entry_id`=?";

// Prepare the statement
$stmt = $conn->prepare($updateQuery);

// Bind parameters to the statement
$stmt->bind_param("sssssss", $Agency_response, $Coder_response, $Coder_rationali, $user, $emp_id, $extractedData, $Entry_Id);

// Execute the statement
if ($stmt->execute()) {
    $response['success'] = true;
    $response['data'] = $extractedData;
    $response['message'] = 'Oasis Data Updated Successfully';
} else {
    $response['success'] = false;
    $response['error'] = 'Update query error: ' . $stmt->error;
}

// Close the statement
$stmt->close();
                        } else {
    if ($Agency_response !== '' && $Coder_response !== '' && $Coder_response !== null && $Agency_response !== null ) {
        // Prepare the SQL statement with placeholders
        $insertQuery = "INSERT INTO `oasis`(`Entry_id`, `Mrn`, `Patient_Name`, `header`, `M_item`, `Agency_response`, `Coder_response`, `Coder_rationali`, `User`, `status`, `coder_emp_id`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare the statement
        $stmt = $conn->prepare($insertQuery);
        
        // Bind parameters to the statement
        $stmt->bind_param("sssssssssss", $Entry_Id, $mrn, $patientName, $cardheader, $extractedData, $Agency_response, $Coder_response, $Coder_rationali, $user, $status, $emp_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['data'] = $extractedData;
            $response['message'] = 'Oasis Data Inserted Successfully';
        } else {
            $response['success'] = false;
            $response['error'] = 'Insert query error: ' . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = 'Empty data fields';
    }
}

                    } else {
                        $response['success'] = false;
                        $response['error'] = 'No data found within parentheses';
                        // echo json_encode($response);
                    }
                }
            }
        } else {
            $response['success'] = false;
            $response['error'] = 'No matching records found for provided ID';
            // echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'Please provide a valid ID';
        // echo json_encode($response);
    }
}

 // DELETED MITEM CODE  START HERE

 else if (isset($_POST['oasismitem'])) {
    // Assigning values from POST
    $mitem = $_POST['oasismitem'];
  

    // Sanitize user input to prevent SQL injection
    $mitem = $conn->real_escape_string($mitem);
 

    // Prepare and execute the query to update `Codesegement` table
    $query1 = "UPDATE `oasis` SET `code_status`='delete' WHERE `Entry_Id`='$Id' AND `M_item`='$mitem'";
    $result1 = $conn->query($query1);

    // Check if the update was successful
    if ($result1) {
        // If successful, respond with success message
        $response['success'] ='Deleted';
        
        // Fetching Mrn for the given Entry_Id from `Codesegement` table
        $query2 = "SELECT `Mrn` FROM `oasis`WHERE `Entry_Id`='$Id'";
        $result2 = $conn->query($query2);

        // Checking if the query to fetch Mrn was successful
        if ($result2 && $result2->num_rows > 0) {
            $dataRow = $result2->fetch_assoc();
            $Mrn = $dataRow['Mrn'];

            // Inserting deleted M-Items data into `deleted_Mitems` table
            $insertQuery = "INSERT INTO `deleted_Mitems`(`Entry_Id`, `Mrn`, `mitem`,`user_name`, `emp_id`) VALUES ('$Id','$Mrn','$mitem','$user','$emp_id')";
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
 // DELETED MITEM CODE  END HERE
 else {
    $response['success'] = false;
    $response['error'] = 'Oasis Empty Data Not Insertted';
    // echo json_encode($response);
  }
echo json_encode($response);
$conn->close();
?>
