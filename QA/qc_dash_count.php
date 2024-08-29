<?php
// Start the session
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include necessary files and database connection
 
include '../db/db-con.php';



    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    $emp_id = $_SESSION['empid'];
// Set error reporting for debugging


 
   

    // Process the action
    $action = $_GET['action'];

    if($action == 'qc_count') {
        // Check if fromdate and todate are set in the GET request
        if(isset($_GET['fromdate']) && isset($_GET['todate'])) {
            // Sanitize and retrieve fromdate and todate
            $fromdate = mysqli_real_escape_string($conn, $_GET['fromdate']);
            $todate = mysqli_real_escape_string($conn, $_GET['todate']);

            // Construct the SQL query
            $sql = "SELECT 
                        (SELECT COUNT(status) FROM Main_Data WHERE qc_person_emp_id = '$emp_id' AND qc_person = '$username' AND (status = 'ASSIGNED TO QC CODER' OR status = 'REASSIGNED TO QC CODER') AND File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as New,
                        (SELECT COUNT(status) FROM Main_Data WHERE qc_person_emp_id = '$emp_id' AND qc_person = '$username' AND status = 'QA WIP' AND File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as qa_wip,
                        (SELECT COUNT(status) FROM Main_Data WHERE qc_person_emp_id = '$emp_id' AND qc_person = '$username' AND  qc_person IS NOT NULL AND status = 'QC COMPLETED' AND File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as qc_completed,
                        (SELECT COUNT(status) FROM Main_Data WHERE qc_person IS NULL AND  status = 'QC COMPLETED' AND File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as qcdircmd,
                        (SELECT COUNT(status) FROM Main_Data WHERE qc_person_emp_id = '$emp_id' AND qc_person = '$username' AND status = 'APPROVED' AND File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59') as approved";
            $run = mysqli_query($conn, $sql);

            if($run) {
                // Fetch the result as an associative array
                $result = mysqli_fetch_assoc($run);
                // Encode the result as JSON and output
                echo json_encode($result);
            } else {
                // If query execution fails, output the error message
                echo "QUERY ERROR: " . mysqli_error($conn);
            }
        } else {
            // If fromdate or todate is not set, prompt the user to provide both dates
            echo "Please provide both fromdate and todate";
        }
    }

 else if($action=='qcfile'){
 
if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
 
 
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`qc_person`,`totalcasemix`,`assesment_type`,`assesment_date`FROM Main_Data WHERE `qc_person`='$username' AND `qc_person_emp_id`='$emp_id' AND (status = 'ASSIGNED TO QC CODER' OR status = 'REASSIGNED TO QC CODER') AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 

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
 }


    else if($action=='qcwipfile'){

      if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
 
 
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`qc_person`,`totalcasemix`,`assesment_type`,`assesment_date`FROM Main_Data WHERE `qc_person`='$username' AND `qc_person_emp_id`='$emp_id' AND status = 'QA WIP'  AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 

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

    }

 else if($action=='qccompleted'){

      if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
 
 
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`qc_person`,`totalcasemix`,`assesment_type`,`assesment_date`FROM Main_Data WHERE `qc_person`='$username' AND `qc_person_emp_id`='$emp_id' AND qc_person IS NOT NULL AND status = 'QC COMPLETED'  AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 

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

    }

  else if($action=='directfile'){

      if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
 
 
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`qc_person`,`totalcasemix`,`assesment_type`,`assesment_date`FROM Main_Data WHERE  qc_person IS  NULL AND status = 'QC COMPLETED'  AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 

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

    }

else if($action=='qcappfile'){

      if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
 
 
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`qc_person`,`totalcasemix`,`assesment_type`,`assesment_date`FROM Main_Data WHERE `qc_person`='$username' AND `qc_person_emp_id`='$emp_id' AND status = 'APPROVED'  AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 

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

    }

else if($action=='performance'){

      if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
 
 
    $sql = "SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`qc_person`,`totalcasemix`,`assesment_type`,`assesment_date`FROM Main_Data WHERE `qc_person`='$username' AND `qc_person_emp_id`='$emp_id' AND status = 'APPROVED'  AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";
 

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

    }    
 
?>
