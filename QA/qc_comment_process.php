<?php
// Start session and error reporting
session_start();
 

// Check if the user session exists
$user = $_SESSION['username'] ?? null;
$emp_id = $_SESSION['empid'];

// Database connection details
 include('../db/db-con.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['file_id'])) {
        $fileId = $_POST['file_id'];

        // Get comments for each section
        $codesegment_cmd = $_POST['codesegment_cmd'];
        $oasissegment_cmd = $_POST['oasissegment_cmd'];
        $poc_cmd = $_POST['poc_cmd'];

        $codesegment_cmd = $conn->real_escape_string($codesegment_cmd);
         $oasissegment_cmd = $conn->real_escape_string($oasissegment_cmd); 
          $poc_cmd =$conn->real_escape_string($poc_cmd); 

        // Check and update for Codesegmentqc
        if (!empty($codesegment_cmd)) {
            $codesegment_result = $conn->query("SELECT * FROM `Codesegementqc` WHERE `Entry_Id`='$fileId' AND `User`='$user' AND `coder_emp_id` = '$emp_id'");
            if ($codesegment_result->num_rows > 0) {
                $updateCodesegment = "UPDATE `Codesegementqc` SET `coding_comments`='$codesegment_cmd' WHERE `Entry_Id`='$fileId' AND `User`='$user' AND `coder_emp_id` = '$emp_id'";
                if (!$conn->query($updateCodesegment)) {
                    // echo "Error updating Code Segment: " . $conn->error;
                } else {
                    // echo "Code Segment comments updated successfully.<br>";
                    $response = ['success' => true, 'message' => 'Comments updated successfully.'];
                }
            } else {
                // echo "Entry_Id not found in Code Segment.<br>";
                $response = ['Error' => true, 'message' => 'First, fill in the Code segments fields.'];
            }
        }

        // Check and update for oasisqc
        if (!empty($oasissegment_cmd)) {
            $oasis_result = $conn->query("SELECT * FROM `oasisqc` WHERE `Entry_Id`='$fileId' AND `User`='$user'");
            if ($oasis_result->num_rows > 0) {
                $updateOasis = "UPDATE `oasisqc` SET `oasis_comments`='$oasissegment_cmd' WHERE `Entry_Id`='$fileId' AND `User`='$user' AND `coder_emp_id` = '$emp_id'";
                if (!$conn->query($updateOasis)) {
                    // echo "Error updating Oasis Segment: " . $conn->error;
                } else {
                    // echo "Oasis Segment comments updated successfully.<br>";
                    $response = ['success' => true, 'message' => 'Comments updated successfully.'];
                }
            } else {
                // echo "Entry_Id not found in Oasis Segment.<br>";
                $response = ['Error' => true, 'message' => 'First, fill in the OASIS segments fields.'];
            }
        }

        // Check and update for Pocsegementqc
        if (!empty($poc_cmd)) {
            $poc_result = $conn->query("SELECT * FROM `Pocsegementqc` WHERE `Entry_Id`='$fileId' AND `User`='$user' AND `coder_emp_id` = '$emp_id'");
            if ($poc_result->num_rows > 0) {
                $updatePoc = "UPDATE `Pocsegementqc` SET `poc_comments`='$poc_cmd' WHERE `Entry_Id`='$fileId' AND `User`='$user' AND `coder_emp_id` = '$emp_id'";
                if (!$conn->query($updatePoc)) {
                    echo "Error updating POC Segment: " . $conn->error;
                } else {
                    // echo "POC Segment comments updated successfully.<br>";
                    $response = ['success' => true, 'message' => 'Comments updated successfully.'];
                }
            } else {
                // echo "Entry_Id not found in POC Segment.<br>";
                $response = ['Error' => true, 'message' => 'First, fill in the POC segments fields.'];
            }
        }
    } else {
        // echo "Parameters are missing or incorrect.";
        $response = ['Error' => true, 'message' => 'Parameters are missing or incorrect.'];
    }

    echo json_encode($response);
}

// Close the database connection
$conn->close();
