 
 <?php
 

   include 'logsession.php';
   include('db/db-con.php');
 

if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];

    $sql = "SELECT (SELECT COUNT(status) FROM Main_Data WHERE `status`='NEW' AND `log_time` >= '$fromdate 00:00:00' AND `log_time` <= '$todate 23:59:59') as New, (SELECT COUNT(status) FROM Main_Data WHERE `status`='ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as completed,
        (SELECT COUNT(status) FROM Main_Data WHERE `status`='WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as processing,
        (SELECT COUNT(status) FROM Main_Data WHERE `status`='QA WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as qcwip,
        (SELECT COUNT(status) FROM Main_Data WHERE `status`='ON HOLD' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as InProgression,
        (SELECT COUNT(status) FROM Main_Data WHERE `status`='APPROVED' AND qc_person IS NOT NULL AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as approved,
        (SELECT COUNT(status) FROM Main_Data WHERE `status`='APPROVED' AND qc_person IS NULL AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as approveddirect,
        (SELECT COUNT(status) FROM Main_Data WHERE `status`='QC COMPLETED' AND qc_person IS NULL AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as qc,
        (SELECT COUNT(status) FROM Main_Data WHERE `status`='PENDING' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as Pendding,
        (SELECT COUNT(status) FROM Main_Data WHERE (`status`='ASSIGNED TO TEAM' OR `status`='REASSIGNED TO TEAM') AND `AssignTeam_date` >= '$fromdate 00:00:00' AND `AssignTeam_date` <= '$todate 23:59:59') as ass_team,
        (SELECT COUNT(status) FROM Main_Data WHERE `status`='QC COMPLETED' AND qc_person IS NOT NULL AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59') as qccompleted,
        (SELECT COUNT(status) FROM Main_Data WHERE (`status`='REASSIGNED TO CODER' OR `status`='ASSIGNED TO CODER')AND `AssignCoder_date` >= '$fromdate 00:00:00' AND `AssignCoder_date` <= '$todate 23:59:59') as assigned";

    $run = mysqli_query($conn, $sql);

    if ($run) {
        // Fetch the result as an associative array
        $result = mysqli_fetch_assoc($run);
        echo json_encode($result);
    } else {
         echo "QUERY ERROR: " . mysqli_error($conn);
    }
}
 
?>
       

 
 
