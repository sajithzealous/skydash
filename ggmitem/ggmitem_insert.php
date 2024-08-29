<?php
// Set default values for variables
$action = $_GET['action'] ?? '';

// Check if the action is 'insert'
if ($action == 'insert') {
    // Ensure errors are displayed for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Include database connection file
    include('../db/db-con.php');

    // Check if form data is submitted
    if (isset($_POST['cardData'])) {
        $Entry_Id = $_POST['Id'];
        $header = $_POST['cardHeader'];
        $formData = $_POST['cardData'];
        $CoderData = $_POST['coderData'];
        $Coderrationail = $_POST['textareadata']; 



              
               $Coderrationail = $conn->real_escape_string($Coderrationail);


        // Encode data as JSON
        $Agency_response = json_encode($formData);
        $Coder_response = json_encode($CoderData);
            if (!empty($Coderrationail)) {
                 $Coder_rationali = $Coderrationail;
            } else if(empty($Coderrationail)) {
               
                 $Coder_rationali = 'Null';
            }
        $status = 'Coder_review';

        // echo $Agency_response;

        // Extract relevant data from header
        $extractedData = '';
        $pattern = '/\(([^)]+)\)/';
        if (preg_match($pattern, $header, $matches)) {
            $extractedData = $matches[1];
            $cardheader = $matches[0];
        }

        // Sanitize and escape data
        $Entry_Id = $conn->real_escape_string($Entry_Id);
        $cardheader = $conn->real_escape_string($cardheader);

        // Fetch patient details
        $query = "SELECT `patient_name`, `mrn`,`alloted_to_coder`,`coder_emp_id` FROM `Main_Data` WHERE `Id` = '$Entry_Id'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $patientName = $conn->real_escape_string($row['patient_name']);
            $mrn = $conn->real_escape_string($row['mrn']);
            $user = $conn->real_escape_string($row['alloted_to_coder']);
            $emp_id = $conn->real_escape_string($row['coder_emp_id']);
                // Check if the record already exists
                $extractedDatasql = "SELECT `M_item` FROM `oasis_new` WHERE `M_item` = '$extractedData' AND `Entry_id` = '$Entry_Id'";
                $extractedDatasqlresult = $conn->query($extractedDatasql);
                $rowsExist = ($extractedDatasqlresult->num_rows > 0);

                if ($rowsExist) {
                    // Update existing record

                     $updateQuery = "UPDATE `oasis_new` SET `Agency_response`='$Agency_response', `Coder_response`='$Coder_response', `Coder_rationali`='$Coder_rationali', `User`='$user', `coder_emp_id`='$emp_id' WHERE `M_item`='$extractedData' AND `Entry_id`='$Entry_Id'";
                    $updateResult = $conn->query($updateQuery);

                    if ($updateResult === TRUE) {
                        $response['success'] = true;
                        $response['data'] = $extractedData;
                        $response['message'] = 'Data Updated Successfully';
                    } else {
                        $response['success'] = false;
                        $response['error'] = 'Update query error: ' . $conn->error;
                    }
                } else {

                        $insertQuery = "INSERT INTO `oasis_new`(`Entry_id`, `Mrn`, `Patient_Name`, `header`, `M_item`, `Agency_response`, `Coder_response`, `Coder_rationali`, `User`, `coder_emp_id`, `status`) VALUES ('$Entry_Id', '$mrn', '$patientName', '$header', '$extractedData', '$Agency_response', '$Coder_response', '$Coder_rationali', '$user', '$emp_id', '$status')";
                        $insertResult = $conn->query($insertQuery);

                        if ($insertResult === TRUE) {
                            $response['success'] = true;
                            $response['data'] = $extractedData;
                            $response['message'] = 'Data Inserted Successfully';
                        } else {
                            $response['success'] = false;
                            $response['error'] = 'Insert query error: ' . $conn->error;
                        }
                }
        } else {
            $response['success'] = false;
            $response['error'] = 'No data found for given Entry Id';
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'No data submitted';
    }

    // Close the database connection
    $conn->close();

    // Output JSON response
    echo json_encode($response);
}
?>
