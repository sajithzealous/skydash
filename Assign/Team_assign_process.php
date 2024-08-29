<?php
 include('../db/db-con.php');
date_default_timezone_set('America/New_York');


session_start();
$user = $_SESSION['username'];

if (isset($_POST['File_Id'])) {

    $Ids = explode(',', $_POST['File_Id']);  // Split the string of IDs into an array
    $Coder_emp_id = $_POST['coder'];
 
 
    // Define the table names
    $sourceTable = "Main_Data";
    $LogTable = "Work_Log";
    // $destinationTable = "assign";

    // If Assigned Coder Status Changed 
    $AssignedStatus = "ASSIGNED TO CODER";
    // $ReassignedStatus = "REASSIGNED TO CODER";


    $currentDateTime = date('Y-m-d H:i:s'); // Format: Year-Month-Day Hour:Minute:Second

    // Date and Time
    foreach ($Ids as $Id) {
        // Sanitize each ID to prevent SQL injection
        

        $Coder_name = "SELECT `Coders` FROM `coders` WHERE `coder_emp_id`='$Coder_emp_id'";
        $codername= $conn->query($Coder_name);

         

         if ($codername) {
            $codernameRow = $codername->fetch_assoc();
            $currentcodername = $codernameRow['Coders'];
            
          

            $File_Id = mysqli_real_escape_string($conn, $Id);

        // Check if the file is already assigned and to which team
        $select_query = "SELECT `coder_emp_id`,`team_emp_id` FROM `$sourceTable` WHERE `Id`='$File_Id'";
        $coderResult = $conn->query($select_query);

        if ($coderResult) {
            $coderRow = $coderResult->fetch_assoc();
            $currentCoder = $coderRow['coder_emp_id'];
            $currentteam = $coderRow['team_emp_id'];

            if (!$currentCoder) {
                $query = "INSERT INTO `$LogTable`( `entry_id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`, `Team`, `Coder`,`coder_emp_id`,`team_emp_id`) 
                    SELECT `Id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, '$AssignedStatus', '$user','$currentcodername','$Coder_emp_id','$currentteam'
                    FROM `$sourceTable` 
                    WHERE `Id`='$File_Id'";

                $insertResult = $conn->query($query);

                if ($insertResult) {
                    $updateQuery = "UPDATE `$sourceTable` SET `Status` = '$AssignedStatus', `alloted_to_coder` = '$currentcodername',`coder_emp_id` ='$Coder_emp_id',`AssignCoder_date`= '$currentDateTime',`File_Status_Time`='$currentDateTime' WHERE `Id` = '$File_Id'";
                    $updateResult = $conn->query($updateQuery);

                    if ($updateResult) {
                        $response[] = ['success' => true, 'message' => 'The file was successfully assigned by the Coder.'];
                    } else {
                        $response[] = ['success' => false, 'error' => 'Error updating file assignment.'];
                    }
                } else {
                    $response[] = ['success' => false, 'error' => 'Error inserting data into Work_Log table.'];
                }
              } 
              //elseif ($currentCoder === $Coder_emp_id) {
            //     // File is already assigned to the same team
            //     $response[] = ['success' => false, 'error' => 'File already assigned to the same Coder.'];
            // } 








            else {

                $response[] = ['success' => true, 'message' => 'reassign'];
                // $response[] = ['success' => true, 'message' => 'Are you sure you want to reassign the file to a new coder?'];
            }
        } else {
            $response[] = ['success' => false, 'error' => 'Error querying current team from Main_Data table.'];
        }

    }
    else{

        $response[] = ['success' => false, 'error' => 'Coder name not get.']; 
    }
    }

    echo json_encode($response);
}
