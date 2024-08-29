 
 <?php

   include 'logsession.php';
  session_start(); 
   include('../db/db-con.php');
$username = $_SESSION['username'];
$empid = $_SESSION['empid'];
$role = $_SESSION['role'];


 $action= $_GET['action'];

if($action=='assign_qc'){


    if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
  


    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    
    // SQL query when $agency is not set
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`qc_team`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date` FROM Main_Data WHERE `status`='ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 
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


else if($action=='assign_coder'){


    if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
  


    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    
    // SQL query when $agency is not set
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`qc_team`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date`,`qc_person`,`qc_person_emp_id` FROM Main_Data WHERE (status = 'ASSIGNED TO QC CODER' OR status = 'REASSIGNED TO QC CODER') AND qc_team='$username' AND qc_team_emp_id='$empid' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 
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
 
else if($action=='dir_completed'){


 if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
  


    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    
    // SQL query when $agency is not set
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`qc_team`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date`,`qc_person`,`qc_person_emp_id` FROM Main_Data WHERE status = 'QC COMPLETED' AND qc_person IS NULL  AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 
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

else if($action=='approve'){


 if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
  


    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    
    // SQL query when $agency is not set
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`qc_team`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date`,`qc_person`,`qc_person_emp_id` FROM Main_Data WHERE status = 'APPROVED' AND qc_team='$username' AND qc_team_emp_id='$empid' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 
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

else if($action=='wipqc'){


 if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
  


    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    
    // SQL query when $agency is not set
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`qc_team`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date`,`qc_person`,`qc_person_emp_id` FROM Main_Data WHERE status = 'QA WIP' AND qc_team='$username' AND qc_team_emp_id='$empid' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 
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

else if($action=='qc_complete'){


 if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
  


    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    
    // SQL query when $agency is not set
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`qc_team`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type`,`assesment_date`,`qc_person`,`qc_person_emp_id` FROM Main_Data WHERE status = 'QC COMPLETED' AND qc_person IS NOT NULL AND qc_team='$username' AND qc_team_emp_id='$empid' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 
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
 
else if ($action == 'qc_coder_perform') {
    // Check if fromdate and todate are set
    if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
        // Sanitize and assign input values
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];

        // Construct the SQL query
        $sql = "SELECT
                    qc_person AS code,
                    qc_team AS Team,
                    COUNT(*) AS Total_Files,
                    SUM(CASE WHEN status IN ('ASSIGNED TO QC CODER', 'REASSIGNED TO QC CODER', 'APPROVED', 'ALLOTED TO QC', 'QA WIP', 'QC COMPLETED') THEN 1 ELSE 0 END) AS Total_Files_This_Month,
                    SUM(CASE WHEN status IN ('ASSIGNED TO QC CODER', 'REASSIGNED TO QC CODER') THEN 1 ELSE 0 END) AS Assigned,
                    SUM(CASE WHEN status = 'QA WIP' THEN 1 ELSE 0 END) AS QC,
                    SUM(CASE WHEN qc_person IS NOT NULL AND status = 'QC COMPLETED' THEN 1 ELSE 0 END) AS QCCOM,
                    SUM(CASE WHEN status = 'APPROVED' THEN 1 ELSE 0 END) AS Approved
                FROM
                    Main_Data
                WHERE
                    qc_team='$username' AND qc_team_emp_id='$empid'
                    AND File_Status_Time >= '$fromdate 00:00:00' 
                    AND File_Status_Time <= '$todate 23:59:59'
                GROUP BY
                    qc_person, qc_team";

        // Execute the SQL query
        $result = $conn->query($sql);

        // Fetch data into an array
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
}
 

 

?>

 
 
