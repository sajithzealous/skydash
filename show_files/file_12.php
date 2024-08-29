 
 <?php
 
   include 'logsession.php';
  session_start(); 
 include('../db/db-con.php');


 $agency= $_SESSION['agent'];
// Create connection

 

if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];

    if($agency){
        $sql = "SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_date`,`assesment_type`,`qc_person`,`totalcasemix`FROM Main_Data WHERE `status`='APPROVED' AND qc_person IS NULL AND `agency` = '$agency' AND  `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
    }
 else{
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`pending_comments`,`pending_date`,`pending_reason`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_date`,`assesment_type`,`qc_person`,`totalcasemix`FROM Main_Data WHERE `status`='APPROVED' AND qc_person IS NULL  AND  `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
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

 
}
 
 

 
 
?>

 
 
