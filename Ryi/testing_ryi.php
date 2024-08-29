<?php
// Include database connection file
include('../db/db-con.php');
$action=$_GET['action'];
// Start session to access session variables
session_start();



if($action=='mitemdata'){

// Check if Id is posted
if(isset($_POST['Id'])) {
    // Sanitize the input
    $Id = $_POST['Id'];

    // Value to check for deletion
    $value = "Deleted";

    // SQL query to select data
    $sqlSelectData = "SELECT `M_Item`,`ICD-code`,`Error_type` FROM `Codesegementqc` WHERE `Error_type` != '$value' AND `Entry_Id` = '$Id'";
    
    // Execute the query
    $sqlSelectDataResult = $conn->query($sqlSelectData);

    // Initialize an array to store all fetched data
    $data = array();

    // Check if there are rows returned
    if ($sqlSelectDataResult->num_rows > 0) {
        // Fetch and store all data
        while ($row = $sqlSelectDataResult->fetch_assoc()) {
            // Store both M-Items and ICD-code
            $data[] = array(
                'mitems' => $row['M_Item'],
                'icd' => $row['ICD-code']
            );
        }

        // Construct the response array
        $response = array(
            'success' => true,
            'data' => $data
        );

        // Encode and output as JSON
        echo json_encode($response);
    }
}

}

// Close the database connection
$conn->close();
?>

