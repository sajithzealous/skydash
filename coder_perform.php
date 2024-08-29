 <?php
 

   include 'logsession.php';
    include('db/db-con.php');

 
if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
 

    $sql = "SELECT
    `alloted_to_coder` AS code,
    `alloted_team` AS Team,
    COUNT(*) AS Total_Files,
    SUM(CASE WHEN `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER', 'APPROVED', 'WIP', 'ALLOTED TO QC', 'QA WIP', 'QC COMPLETED', 'InProgression', 'PENDING') THEN 1 ELSE 0 END) AS Total_Files_This_Month,
    SUM(CASE WHEN `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER') THEN 1 ELSE 0 END) AS Assingned,
    SUM(CASE WHEN `status` = 'WIP' THEN 1 ELSE 0 END) AS WIP,
    SUM(CASE WHEN `status` = 'InProgression' THEN 1 ELSE 0 END) AS inp,
    SUM(CASE WHEN `status` = 'PENDING' THEN 1 ELSE 0 END) AS pnd,
    SUM(CASE WHEN `status` = 'QA WIP' THEN 1 ELSE 0 END) AS QC,
    SUM(CASE WHEN `status` = 'QC COMPLETED' THEN 1 ELSE 0 END) AS QCCOM,
    SUM(CASE WHEN `status` = 'ALLOTED TO QC' THEN 1 ELSE 0 END) AS Completed,
    SUM(CASE WHEN `status` = 'APPROVED' THEN 1 ELSE 0 END) AS approved
FROM
    Main_Data
WHERE
    `alloted_to_coder` IS NOT NULL 
    AND `alloted_team` IS NOT NULL 
    AND `File_Status_Time` >= '$fromdate 00:00:00' 
    AND `File_Status_Time` <= '$todate 23:59:59' 
GROUP BY
    `alloted_to_coder`, `alloted_team`;

";
}
$result = $conn->query($sql);
   $data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();
 