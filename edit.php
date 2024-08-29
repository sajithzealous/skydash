<?php
include 'logsession.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
 include('db/db-con.php');

// Function to automatically validate data and return an array of validated values
function autoValidateData($data, &$errorMessages) {
    // Validate individual fields using respective functions
    $Patient_Name = autoValidatePatientName($data[0]);
    $Mrn = autoValidateMRN($data[1]);
    $Phone_Number = isValidPhoneNumber($data[2]); 
    $Insurance_Type = autoValidateInsuranceType($data[3]);
    $Assessment_Date = autoValidateDate($data[4]);
    $Assessment_Type = autoValidateAssessmentType($data[5]);
    $Agency = autoValidateAgency($data[6]);
    $url = autoValidateURL($data[7]);
    $Priority = autoValidatePriority($data[8]);
    $Status = "New";

    // Check for empty fields
    if (empty($Patient_Name) || empty($Mrn) || empty($Phone_Number) || empty($Insurance_Type) || empty($Assessment_Date) || empty($Assessment_Type) || empty($Agency) || empty($url)) {
        return null;
    }

    // Return validated data
    return array(
        'patient_name' => $Patient_Name,
        'mrn' => $Mrn,
        'phone_number' => $Phone_Number, // Return original phone number
        'insurance_type' => $Insurance_Type,
        'assesment_date' => $Assessment_Date,
        'assesment_type' => $Assessment_Type,
        'agency' => $Agency,
        'url' => $url,
        'priority' => $Priority,
        'status' => $Status,
    );
}

// Other validation functions remain unchanged

function autoValidatePatientName($patientName) {
    return ucwords(strtolower(preg_replace('/\s+/', ' ', str_replace(',', '', $patientName))));
}

function autoValidateMRN($mrn) {
    return $mrn;
}

function isValidPhoneNumber($phoneNumber) {
    // Remove non-numeric characters
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
    
    // Check if the length is 10
    if (strlen($phoneNumber) === 10) {
        return $phoneNumber;
    } else {
        // Return false or an indication that the phone number is invalid
        return false;
    }
}


function autoValidateInsuranceType($insuranceType) {
    return ucwords(strtolower(preg_replace('/\s+/', ' ', str_replace(',', '', $insuranceType))));
}

function autoValidateAssessmentType($assesmentType) {
    return ucwords(strtolower(preg_replace('/\s+/', ' ', str_replace(',', '', $assesmentType))));
}

function autoValidateDate($assessmentDate) {

$assessmentDate = strtotime( $assessmentDate );
$assessmentDate = date( 'Y-m-d', $assessmentDate );
    return $assessmentDate;
}


function autoValidateAgency($agency) {
    return strtoupper($agency);
}

// function autoValidateURL($url) {
//     if (filter_var($url, FILTER_VALIDATE_URL) === false) {
//         return ""; 
//     } else {
//         return $url; 
//     }
// }

function autoValidateURL($url) {
     return $url; 
    
}


function autoValidatePriority($priority) {
    return $priority;
}

function autoValidateStatus($status) {
    return $status;
}


// Main logic starts here
if (isset($_POST['Id'])) {
    // Extract data from the POST request
    $Id = $_POST['Id']; 
    $Patient_Name = $_POST['Patient_Name']; 
    $Mrn = $_POST['Mrn']; 
    $Phone_Number = $_POST['Phone_Number'];
    $Insurance_Type = $_POST['Insurance_Type']; 
    $Assessment_Date = $_POST['Assessment_Date']; 
    $Assessment_Type = $_POST['Assessment_Type']; 
    $Agency = $_POST['Agency'];
    $url = $_POST['Url']; 
    $Priority = $_POST['Priority']; 
    $Status = $_POST['Status'];

    // Initialize an array to store error messages
    $errorMessages = array();

    // Collect the data into an array
    $data = array(
        $Patient_Name, $Mrn, $Phone_Number, $Insurance_Type,
        $Assessment_Date, $Assessment_Type, $Agency, $url, $Priority, $Status
    );

    // Start a database transaction
    mysqli_begin_transaction($conn);

    // Call the autoValidateData function to process and validate the data
    $validatedData = autoValidateData($data, $errorMessages);

   if ($validatedData !== null) {
    // Extract validated data
    extract($validatedData);

    // Construct SQL queries for update and insert
    $updateQuery = "UPDATE `Dummy_Data` SET `patient_name`='$patient_name', `mrn`='$mrn', `phone_number`='$phone_number', `insurance_type`='$insurance_type', `assesment_date`='$assesment_date', `assesment_type`='$assesment_type', `agency`='$agency', `url`='$url', `priority`='$priority', `status`='Updated' WHERE `id`='$Id'";

    $insertQuery = "INSERT INTO `Main_Data`(`patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `url`, `priority`, `status`)
        VALUES ('$patient_name', '$mrn', '$phone_number', '$insurance_type', '$assesment_date', '$assesment_type', '$agency', '$url', '$priority', '$status')";

    // Execute queries and check for success
    if (mysqli_query($conn, $updateQuery) && mysqli_query($conn, $insertQuery)) {
        // Both queries executed successfully
        mysqli_commit($conn);
        $response = array('success' => true, 'message' => 'Record updated and inserted successfully.');
    } else {
        // Rollback if there's an error
        mysqli_rollback($conn);
        $response = array('error' => false, 'message' => 'Failed to update and insert records.');
    }
} else {
    $response = array('error' => false,'message' => 'One or more fields are empty or contain invalid data.');
}

// Return the response as JSON
echo json_encode($response);


    // Close the database connection
    mysqli_close($conn);
}
?>
