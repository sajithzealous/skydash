<?php
 include('../db/db-con.php');


//session_varaiables
session_start();
$user = $_SESSION['username'];
$role = $_SESSION['role'];
$empid = $_SESSION['empid'];

// Create connection

if (isset($_POST['File_Id'])) {
    $Ids = explode(',', $_POST['File_Id']);  // Split the string of IDs into an array
     $Coder_emp_id = $_POST['coder'];

    $sourceTable = "Main_Data";
    $LogTable = "Work_Log";
    $ReassignedStatus = "REASSIGNED TO QC CODER";
    $currentDateTime = date('Y-m-d H:i:s');

    $response = [];

    foreach ($Ids as $Id) {

         $Coder_name = "SELECT `Coders` FROM `coders` WHERE `coder_emp_id`='$Coder_emp_id'";
        $codername= $conn->query($Coder_name);

         

         if ($codername) {
            $codernameRow = $codername->fetch_assoc();
            $currentcodername = $codernameRow['Coders'];


        $File_Id = mysqli_real_escape_string($conn, $Id);

        $select_query1 = "SELECT `qc_person`FROM `$sourceTable` WHERE `Id`='$File_Id'";
        $coderResult1 = $conn->query($select_query1);

        if ($coderResult1) {
            $coderRow = $coderResult1->fetch_assoc();
            $previousCoder = $coderRow['qc_person'];

            $updateQuery = "UPDATE `$sourceTable` SET `Status`='$ReassignedStatus', `pervious_qc_person`='$previousCoder', `qc_person`='$currentcodername', `qc_person_emp_id` ='$Coder_emp_id',`AssignCoder_date`='$currentDateTime', `qc_team`='$user',`qc_team_emp_id`='$empid',`File_Status_Time`='$currentDateTime' WHERE `Id`='$File_Id'";
            $updateResult = $conn->query($updateQuery);

            if ($updateResult) {
                $response[] = ['success' => true, 'message' => 'The file was successfully reassigned to a new coder.'];

                $query = "INSERT INTO `$LogTable` (
                    `entry_id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, 
                    `assesment_date`, `assesment_type`, `agency`, `status`, `Team`, `coder`,`team_emp_id`,`coder_emp_id`
                ) 
                SELECT 
                    `Id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, 
                    `assesment_date`, `assesment_type`, `agency`, '$ReassignedStatus', `alloted_team`, '$currentcodername',`team_emp_id`,'$Coder_emp_id'
                FROM `$sourceTable` 
                WHERE `Id`='$File_Id'
                ";

                $insertResult = $conn->query($query);
                if (!$insertResult) {
                    // Capture and display the error message
                    echo "Error: " . $conn->error;
                }
            } else {
                $response[] = ['success' => false, 'error' => 'Error reassigning the file to a new coder.'];
            }
        }
    }
    }

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Invalid request']); // Placeholder message
}
