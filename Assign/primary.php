<?php
// Include database connection
include('../db/db-con.php');

// Start session
session_start();

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize variables
$Id = '';
$user = $_SESSION['username'] ?? null;
$emp_id = $_SESSION['empid'] ?? '';
$Id = $_COOKIE['Id'] ?? '';

// Check if 'code' is set in the POST parameters
if (isset($_POST['code'])) {
    $icd = $_POST['code'];

    // Sanitize user input to prevent SQL injection
    $icd = $conn->real_escape_string($icd);

    // Prepare and execute the query
    $query = "SELECT Description FROM Codedescription WHERE `ICD-10-code`='$icd' AND Diagnosis_type ='Primary'";
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $description = $row['Description'];
            echo json_encode(array('description' => $description));
        } else {
            echo json_encode(array('error' => 'No primary ICD Code'));
        }
    } else {
        echo json_encode(array('error' => 'Query execution error: ' . $conn->error));
    }
} 


 // DELETED MITEM CODE SAVE  START HERE


// Check if 'mitem' and 'icdValue' are set in the POST parameters
else if (isset($_POST['mitem']) && isset($_POST['icdValue'])) {
    // Assigning values from POST
    $mitem = $_POST['mitem'];
    $icdValue = $_POST['icdValue'];

    // Sanitize user input to prevent SQL injection
    $mitem = $conn->real_escape_string($mitem);
    $icdValue = $conn->real_escape_string($icdValue);

    // Prepare and execute the query to update `Codesegement` table
    $query1 = "UPDATE `Codesegement` SET `code_status`='delete' WHERE `Entry_Id`='$Id' AND `M-Items`='$mitem' AND `ICD-code`='$icdValue'";
    $result1 = $conn->query($query1);

    // Check if the update was successful
    if ($result1) {
        // If successful, respond with success message
        echo json_encode(array('success' => 'Deleted'));
        
        // Fetching Mrn for the given Entry_Id from `Codesegement` table
        $query2 = "SELECT `Mrn` FROM `Codesegement` WHERE `Entry_Id`='$Id'";
        $result2 = $conn->query($query2);

        // Checking if the query to fetch Mrn was successful
        if ($result2 && $result2->num_rows > 0) {
            $dataRow = $result2->fetch_assoc();
            $mrn = $dataRow['Mrn'];

            // Inserting deleted M-Items data into `deleted_Mitems` table
            $insertQuery = "INSERT INTO `deleted_Mitems`(`Entry_Id`, `Mrn`, `mitem`, `icd_code`, `user_name`, `emp_id`) VALUES ('$Id','$mrn','$mitem','$icdValue','$user','$emp_id')";
            $insertResult = $conn->query($insertQuery);

            // Checking if the insertion was successful
            if ($insertResult) {
                // If successful, you may want to log this success or handle it appropriately
            } else {
                echo json_encode(array('error' => 'Error inserting data into `deleted_Mitems` table: ' . $conn->error));
            }
        } else {
            echo json_encode(array('error' => 'Error fetching `Mrn` from `Codesegement` table: ' . $conn->error));
        }
    } else {
        echo json_encode(array('error' => 'Query execution error: ' . $conn->error));
    }
}

 // DELETED MITEM CODE SAVE  END HERE

 else {
    // Handle case where 'mitem' or 'icdValue' is not set in POST data
    echo json_encode(array('error' => 'Required parameters are missing in the request.'));
}

 