<?php
// Start session and error reporting
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

        // Check and update for Codesegment
        if (!empty($codesegment_cmd)) {
            $codesegment_result = $conn->prepare("SELECT * FROM `Codesegement` WHERE `Entry_Id`=? AND `User`=? AND `coder_emp_id` = ?");
            $codesegment_result->bind_param("sss", $fileId, $user, $emp_id);
            $codesegment_result->execute();
            $codesegment_result->store_result();
            if ($codesegment_result->num_rows > 0) {
                $updateCodesegment = $conn->prepare("UPDATE `Codesegement` SET `coding_comments`=? WHERE `Entry_Id`=? AND `User`=? AND `coder_emp_id` = ?");
                $updateCodesegment->bind_param("ssss", $codesegment_cmd, $fileId, $user, $emp_id);
                if (!$updateCodesegment->execute()) {
                    // echo "Error updating Code Segment: " . $conn->error;
                } else {
                    // echo "Code Segment comments updated successfully.<br>";
                    $response = ['success' => true, 'message' => 'Comments updated successfully code.'];
                }
            } else {
                // echo "Entry_Id not found in Code Segment.<br>";
                $response = ['Error' => true, 'message' => 'First, fill in the Code segments fields.'];
            }
            $codesegment_result->close();
        }

        // Check and update for oasis
        if (!empty($oasissegment_cmd)) {
            $oasis_result = $conn->prepare("SELECT * FROM `oasis` WHERE `Entry_Id`=? AND `User`=? AND `coder_emp_id` = ?");
            $oasis_result->bind_param("sss", $fileId, $user, $emp_id);
            $oasis_result->execute();
            $oasis_result->store_result();
            if ($oasis_result->num_rows > 0) {
                $updateOasis = $conn->prepare("UPDATE `oasis` SET `oasis_comments`=? WHERE `Entry_Id`=? AND `User`=? AND `coder_emp_id` = ?");
                $updateOasis->bind_param("ssss", $oasissegment_cmd, $fileId, $user, $emp_id);
                if (!$updateOasis->execute()) {
                    // echo "Error updating Oasis Segment: " . $conn->error;
                } else {
                    // echo "Oasis Segment comments updated successfully.<br>";
                    $response = ['success' => true, 'message' => 'Comments updated successfully oasie.'];
                }
            } else {
                // echo "Entry_Id not found in Oasis Segment.<br>";
                $response = ['Error' => true, 'message' => 'First, fill in the OASIS segments fields.'];
            }
            $oasis_result->close();
        }

        // Check and update for Pocsegement
        if (!empty($poc_cmd)) {
            $poc_result = $conn->prepare("SELECT * FROM `Pocsegement` WHERE `Entry_Id`=? AND `User`=? AND `coder_emp_id` = ?");
            $poc_result->bind_param("sss", $fileId, $user, $emp_id);
            $poc_result->execute();
            $poc_result->store_result();
            if ($poc_result->num_rows > 0) {
                $updatePoc = $conn->prepare("UPDATE `Pocsegement` SET `poc_comments`=? WHERE `Entry_Id`=? AND `User`=? AND `coder_emp_id` = ?");
                $updatePoc->bind_param("ssss", $poc_cmd, $fileId, $user, $emp_id);
                if (!$updatePoc->execute()) {
                    // echo "Error updating POC Segment: " . $conn->error;
                } else {
                    // echo "POC Segment comments updated successfully.<br>";
                    $response = ['success' => true, 'message' => 'Comments updated successfully poc.'];
                }
            } else {
                // echo "Entry_Id not found in POC Segment.<br>";
                $response = ['Error' => true, 'message' => 'First, fill in the POC segments fields.'];
            }
            $poc_result->close();
        }
    } else {
        // echo "Parameters are missing or incorrect.";
        $response = ['Error' => true, 'message' => 'Parameters are missing or incorrect.'];
    }

    echo json_encode($response);
}

 elseif (($_SERVER["REQUEST_METHOD"] == "GET")) {
    if (isset($_GET['file_id'])) {
        $fileId = $_GET['file_id'];
        
          $dob = $_GET["dob"];

if (empty(trim($dob))) {
    $dob1 = 'none'; // Set to 'none' if $_GET["dob"] is empty or contains only spaces
} else {
    $dob1 = date("Y-m-d", strtotime($dob));
}

// Now, you can use $dob1 as needed, either for further processing or saving to the database.

           
        $gender = $_GET["gender"];
        $patientname = $_GET["patientname"];
        $insurancetype = $_GET["insurancetype"];
        $mrn = $_GET["mrn"];
        $agency = $_GET["agency"];
        $assesmentdate = $_GET["assesmentdate"];


        if($assesmentdate!=''){

           $assesmentdate = date('Y-m-d', strtotime($assesmentdate));


        }
        $assesmenttype = $_GET["assesmenttype"];

        // echo $dob;

        $sql = "UPDATE `Main_Data` SET `dob` = '$dob1', `gender` = '$gender',`patient_name`='$patientname',`mrn`='$mrn',`insurance_type`='$insurancetype',`assesment_date`='$assesmentdate',`assesment_type`='$assesmenttype',`agency`='$agency' WHERE `Id`='$fileId'";
        if ($conn->query($sql) === TRUE) {
            echo "Medical Profiles Updated Successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Parameters are missing or incorrect.";
    }
} else {
    echo "Invalid request method.";
}




// Close the database connection
$conn->close();
