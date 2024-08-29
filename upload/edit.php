<?php

// Include the database connection file
include('db-con.php');

// Function to automatically validate data and return an array of validated values
function autoValidateData($data, &$errorMessages) {
    $Team = autoValidateTeam($data[0], $errorMessages);
    $Agency = autoValidateAgency($data[1], $errorMessages);
    $Location = autoValidateLocation($data[2], $errorMessages);
    $Patient_Name = autoValidatePatientName($data[3], $errorMessages);
    $Phone_Number =($data[4]);
    $Task = autoValidateTask($data[5], $errorMessages);
    $Mrn = autoValidateMRN($data[6], $errorMessages);
    $Assessment_Date = autoValidateDate($data[7], $errorMessages);
    $Dsi = autoValidateDate($data[8], $errorMessages);
    $Dsc = autoValidateDate($data[9], $errorMessages);
    $Assessment_Type = autoValidateAssessmentType($data[10], $errorMessages);
    $Insurance_Type = autoValidateInsuranceType($data[11], $errorMessages);
    $Status = autoValidateStatus($data[12], $errorMessages);
    $User = autoValidateUser($data[13], $errorMessages);
    $Workable = autoValidateWorkable($data[14], $errorMessages);
    $Remarks = autoValidateRemarks($data[15], $errorMessages);
    $url = autoValidateURL($data[16], $errorMessages);
    echo$Phone_Number;
    // Check if any of the fields are empty and return null if so
    if (empty($Team) || empty($Agency) || empty($Location) || empty($Patient_Name) || empty($Phone_Number) || empty($Task) || empty($Mrn) ||
        empty($Assessment_Date) || empty($Dsi) || empty($Dsc) || empty($Assessment_Type) || empty($Insurance_Type) ||
        empty($Status) || empty($User) || empty($Workable) || empty($Remarks) || empty($url)) {
        return null;
    }

    return array(
        $Team, $Agency, $Location, $Patient_Name, $Phone_Number, $Task, $Mrn,
        $Assessment_Date, $Dsi, $Dsc, $Assessment_Type, $Insurance_Type,
        $Status, $User, $Workable, $Remarks, $url
    );
}

// Function to validate and format phone numbers
// function autoValidatePhoneNumber($phoneNumber, &$errorMessages) {
//     // Simple validation for a 10-digit phone number
//     if (!preg_match('/^\d{10}$/', $phoneNumber)) {
//         $errorMessages[] = 'Invalid Phone Number format. Please enter a 10-digit number.';
//         return null;
//     }
//     return $phoneNumber;
// }

// Validation functions for other fields (autoValidateTeam, autoValidateAgency, etc.) remain unchanged

// Main logic starts here
if (isset($_POST['Team'])) {
    // Extract data from the POST request
    $data = array(
        $_POST['Team'], $_POST['Agency'], $_POST['Location'], $_POST['Patient_Name'],
        $_POST['Phone_Number'], $_POST['Task'], $_POST['Mrn'], $_POST['Assessment_Date'],
        $_POST['Dsi'], $_POST['Dsc'], $_POST['Assessment_Type'], $_POST['Insurance_Type'],
        $_POST['Status'], $_POST['User'], $_POST['Workable'], $_POST['Remarks'], $_POST['url']
    );

    // Initialize an array to store error messages
    $errorMessages = array();

    // Initialize a flag to track the success of both queries
    $success = false;

    // Start a database transaction
    mysqli_begin_transaction($conn);

    // Call the autoValidateData function to process and validate the data
    $validatedData = autoValidateData($data, $errorMessages);

    if ($validatedData !== null) {
        // Extract validated data
        list(
            $Team, $Agency, $Location, $Patient_Name, $Phone_Number, $Task, $Mrn,
            $Assessment_Date, $Dsi, $Dsc, $Assessment_Type, $Insurance_Type,
            $Status, $User, $Workable, $Remarks, $url
        ) = $validatedData;

        // Construct SQL queries for update and insert
        $updateQuery = "UPDATE dummydata SET Team='$Team', Agency='$Agency', Location='$Location', Patient_Name='$Patient_Name', Phone_Number='$Phone_Number', Task='$Task', Assessment_Date='$Assessment_Date', Dsi='$Dsi', Dsc='$Dsc', Assessment_Type='$Assessment_Type', Insurance_Type='$Insurance_Type', Status='$Status', User='$User', Workable='$Workable', Remarks='$Remarks', Statustoremove='1' WHERE Mrn='$Mrn'";

        $insertQuery = "INSERT INTO `data` (`Team`, `Agency`, `Location`, `Patient_Name`, `Phone_Number`, `Task`, `Mrn`, `Assessment_Date`, `Dsi`, `Dsc`, `Assessment_Type`, `Insurance_Type`, `Status`, `User`, `Workable`, `Remarks`, `url`)
            VALUES ('$Team', '$Agency', '$Location', '$Patient_Name', '$Phone_Number', '$Task', '$Mrn', '$Assessment_Date', '$Dsi', '$Dsc', '$Assessment_Type', '$Insurance_Type', '$Status', '$User', '$Workable', '$Remarks', '$url')";

        // Execute queries and check for success
        if (mysqli_query($conn, $updateQuery) && mysqli_query($conn, $insertQuery)) {
            // Both queries executed successfully
            $success = true;
        }
    }
 
    // Commit or roll back the transaction based on the success flag
    if ($success) {
        mysqli_commit($conn);
        echo "Record updated and inserted successfully.".$Phone_Number;
    } else {
        mysqli_rollback($conn);
        echo "Error: One or more fields are empty or contain invalid data.";
        // Optionally, you can display the error messages from the $errorMessages array.
    }

    // Close the database connection if you opened it earlier
    mysqli_close($conn);
}
?>
