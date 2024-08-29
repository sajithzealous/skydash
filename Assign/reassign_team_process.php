<?php
 include('../db/db-con.php');
date_default_timezone_set('America/New_York');



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

    $response = [];

    foreach ($Ids as $Id) {
        $File_Id = mysqli_real_escape_string($conn, $Id);

          $Getname = "SELECT `team_name` FROM `team` WHERE `team_emp_id`='$Team_empid'";
         $AssignTeam = $conn->query($Getname);

          if($AssignTeam){
         $teamname = $AssignTeam->fetch_assoc();
         $team_name = $teamname['team_name'];



        // Reassign the file to a new team
        $select_query1 = "SELECT `alloted_team` FROM `$sourceTable` WHERE `Id`='$File_Id'";
        $teamResult1 = $conn->query($select_query1);

        if ($teamResult1) {

            $teamRow = $teamResult1->fetch_assoc();
            $previousTeam = $teamRow['alloted_team'];

            $updateQuery = "UPDATE `$sourceTable` SET `Status`='$ReassignedStatus',`previousAllocateTeam` = '$previousTeam', `alloted_team`='$team_name',`team_emp_id`='$Team_empid',`AssignTeam_date`='$currentDateTime', `File_Status_Time`='$currentDateTime' WHERE `Id`='$File_Id'";
            $updateResult = $conn->query($updateQuery);
        }

        if ($updateResult) {
            $response[] = ['success' => true, 'message' => 'The file was successfully reassigned to a new team.'];

            $query = "INSERT INTO `$LogTable`( `entry_id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`, `Team`,`team_emp_id`) 
            SELECT `Id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`,'$team_name','$Team_empid'
            FROM `$sourceTable` 
            WHERE `Id`='$File_Id'";

        $insertResult = $conn->query($query);
        } else {
            $response[] = ['success' => false, 'error' => 'Error reassigning the file to a new team.'];
        }
    }
}

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Invalid request']); // Placeholder message
}
