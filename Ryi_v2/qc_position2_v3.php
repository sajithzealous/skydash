<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection file
include('../db/db-con.php');

// Start the session
session_start();

// Initialize response array
$response = array();

// Check if the form data was submitted
if (isset($_POST['Id'])) {
    // Sanitize input to prevent SQL injection
    $Id = $conn->real_escape_string($_POST['Id']);

    // Define variables for checkbox values
    $coderChecked = 'Coder';
    $agencyChecked = 'Agency';
    $mitem = 'M1021A';
    $agencyprimarycode='Primary';

    // Function to fetch clinical group based on ICD code and diagnosis type
    function fetchClinicalGroup($icd, $conn)
    {
        $clinicangroupQuery = "SELECT * FROM `Codedescription` WHERE `ICD-10-code` = ? AND `Diagnosis_type` = 'Primary'";
        $stmt = $conn->prepare($clinicangroupQuery);
        $stmt->bind_param('s', $icd);
        $stmt->execute();
        $clinicangroupResult = $stmt->get_result();

        // Check if any rows are returned
        if ($clinicangroupResult->num_rows > 0) {
            // Fetch the data
            $position2value = $clinicangroupResult->fetch_assoc();

            // Return the result as an associative array
            return [
                'success' => true,
                'Clinicalgroup' => $position2value['Clinical_group'],
            ];
        } else {
            // Return error if no records found
            return ['success' => false, 'error' => 'No records found'];
        }
    }

    // Query to fetch data for coder
    $sqlDataCoder = "SELECT `ICD-code` FROM `Codesegementqc` WHERE `Entry_Id`='$Id' AND `Coderchecked`='$coderChecked' AND `M_Item`='$mitem' AND `Error_type` !='Deleted'";
    $resultCoder = $conn->query($sqlDataCoder);

    // Fetch clinical group for coder if query successful
    if ($resultCoder) {
        $row = $resultCoder->fetch_assoc();
        $icd = $row['ICD-code'];
        $response['coder'] = fetchClinicalGroup($icd, $conn);
    }

    // Query to fetch data for agency
    $sqlDataAgency = "SELECT `ICD-code` FROM `Codesegementqc` WHERE `Entry_Id`='$Id' AND `Agencychecked`='$agencyChecked' AND `Agencyprimarycode`='$agencyprimarycode' AND `Error_type` !='Deleted'";
    $resultAgency = $conn->query($sqlDataAgency);

    // Fetch clinical group for agency if query successful
    if ($resultAgency) {
        $row = $resultAgency->fetch_assoc();
        $icd = $row['ICD-code'];
        $response['agency'] = fetchClinicalGroup($icd, $conn);
    }
}

// Output the response array as JSON
echo json_encode($response);

// Close database connection
$conn->close();

?>
