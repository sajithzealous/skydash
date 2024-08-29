<?php
 include('../db/db-con.php');

session_start();
$user = $_SESSION['username'];

if (isset($_POST['Id'])) {
    $Ids = explode(',', $_POST['Id']);  // Split the string of IDs into an array
    $Team_empid = $_POST['Team'];


    // Define the table names
    $sourceTable = "Main_Data";
    $LogTable = "Work_Log";
    // If Assigned Coder Status Changed 
    $AssignedStatus = "ASSIGNED TO TEAM";
    $ReassignedStatus = "REASSIGNED TO TEAM";

    // Date and Time
    $currentDateTime = date('Y-m-d H:i:s'); // Format: Year-Month-Day Hour:Minute:Second
    // $validStatuses = ['WIP', 'COMPLETED', 'QC', 'WIPQC', 'QCCOMPLETED', 'APPROVED', 'ASSIGNED TO CODER'];


    foreach ($Ids as $Id) {

        // // Get Teamleader name
         $Getname = "SELECT `team_name` FROM `team` WHERE `team_emp_id`='$Team_empid'";
         $AssignTeam = $conn->query($Getname);

          if($AssignTeam){
         $teamname = $AssignTeam->fetch_assoc();
         $team_name = $teamname['team_name'];
       
 

        // Sanitize each ID to prevent SQL injection
        $File_Id = mysqli_real_escape_string($conn, $Id);

        // Check if the file is already assigned and to which team
        $select_query = "SELECT `team_emp_id` FROM `$sourceTable` WHERE `Id`='$File_Id'";
        $teamResult = $conn->query($select_query);

        if ($teamResult) {
            $teamRow = $teamResult->fetch_assoc();
            $currentTeam = $teamRow['team_emp_id'];

            if (!$currentTeam) {
                $query = "INSERT INTO `$LogTable`(`entry_id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`, `Team`,`team_emp_id`) 
                    SELECT `Id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, '$AssignedStatus', '$team_name','$Team_empid'
                    FROM `$sourceTable` 
                    WHERE `Id`='$File_Id'";

                $insertResult = $conn->query($query);

                if ($insertResult) {
                    $updateQuery = "UPDATE `$sourceTable` SET `Status`='$AssignedStatus', `team_emp_id`='$Team_empid',`alloted_team`='$team_name',`AssignTeam_date`='$currentDateTime',`File_Status_Time`='$currentDateTime' WHERE `Id`='$File_Id'";
                    $updateResult = $conn->query($updateQuery);

                    if ($updateResult) {
                        $response[] = ['success' => true, 'message' => 'The file was successfully assigned by the Team.'];
                    } else {
                        $response[] = ['success' => false, 'error' => 'Error updating file assignment.'];
                    }
                } else {
                    $response[] = ['success' => false, 'error' => 'Error inserting data into Work_Log table.'];
                }
            } 

            // elseif ($currentTeam === $Team_empid) {
            //     // File is already assigned to the same team
            //     $response[] = ['success' => false, 'error' => 'File already assigned to the same team.'];

            //     $validStatuses = ['WIP', 'COMPLETED', 'QA WIP','INPROGRESSION','PENDING', 'QC COMPLETED', 'APPROVED', 'ASSIGNED TO CODER','REASSIGNED TO CODER'];

            //     $select_status_query = "SELECT `status` FROM `Main_Data` WHERE `Id`='$File_Id'";
            //     $status_result = $conn->query($select_status_query);

            //     if ($status_result) {
            //         $row = $status_result->fetch_assoc();
            //         $currentStatus = $row['status'];

            //         if (in_array($currentStatus, $validStatuses)) {
            //             // File is already assigned to a valid status
            //             $response[] = ['success' => false, 'error' => 'File already has a valid status.'];
            //         }
            //     }
            // }
            else {

                $response[] = ['success' => true, 'message' => 'reassign'];
                // $response[] = ['success' => true, 'message' => 'Are you sure you want to reassign the file to a new coder?'];
            }
        }


         else {
            $response[] = ['success' => false, 'error' => 'Error querying current team from Main_Data table.'];
        }

         }
         else{

            $response[] = ['success' => false, 'error' => '  team from   table.'];

         }
    }

    echo json_encode($response);
}
