<?php
session_start(); 
include('db/db-con.php');

// Retrieve session data
$user = $_SESSION['username'];
$emp_id = $_SESSION['empid'];
$action =$_GET['action'];

// Retrieve agency name
$agency_query = "SELECT `agency_name` FROM `Agent` WHERE `client_name`='$user' AND `client_id`='$emp_id'";
$agency_result = $conn->query($agency_query);

// Check if agency result exists and fetch all agency names
$agencies = array();
if ($agency_result && $agency_result->num_rows > 0) {
    while ($agencyData = $agency_result->fetch_assoc()) {
        $agencies[] = $agencyData['agency_name'];
    }
} else {
    // Handle error if no agencies found
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Error: No agencies found for the user.']);
    exit;
}


 
// Retrieve default value from hppscodevalue table
$STDPDGM = "SELECT `National` FROM `hppscodevalue` LIMIT 1";
$dft = $conn->query($STDPDGM);

// Check if query was successful
if($dft) {
    // Fetch the default value
    $default = $dft->fetch_assoc()['National'];
} else {
    // Handle query error
    $default = ""; // Set a default value or handle error accordingly
}

if($action=='mrn_search'){
 
if (isset($_GET['fromdate']) && isset($_GET['todate']) && isset($_GET['mrn'])) {
    // Retrieve fromdate and todate from the GET request
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    $mrn = $_GET['mrn'];

    // Create comma-separated list of agency names
    $agency_name = implode("','", $agencies);

    // Construct SQL query
    $sql = "SELECT `Id`,`agency`, `patient_name`, `mrn`, `insurance_type`, `assesment_type`, `assesment_date`, `status`, `pending_comments`, `pending_reason` ,`totalcasemixagency`,`totalcasemix` FROM `Main_Data` WHERE `agency` IN ('$agency_name') AND `mrn`='$mrn' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";

    // Execute SQL query
    $run = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($run) {
        // Fetch all rows as associative arrays
        $results = mysqli_fetch_all($run, MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $results]);
    } else {
        // Handle query error
        echo json_encode(['success' => false, 'error' => 'Query error: ' . mysqli_error($conn)]);
    }
} 
}

else if($action=='patient_search'){
 
if (isset($_GET['fromdate']) && isset($_GET['todate']) && isset($_GET['patient'])) {
    // Retrieve fromdate and todate from the GET request
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    $patient = $_GET['patient'];

     $patient = mysqli_real_escape_string($conn, $patient);

    // Create comma-separated list of agency names
    $agency_name = implode("','", $agencies);

    // Construct SQL query
    $sql = "SELECT `Id`,`agency`, `patient_name`, `mrn`, `insurance_type`, `assesment_type`, `assesment_date`, `status`, `pending_comments`, `pending_reason` ,`totalcasemixagency`,`totalcasemix` FROM `Main_Data` WHERE `agency` IN ('$agency_name') AND `patient_name`LIKE '%$patient%' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";

    // Execute SQL query
    $run = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($run) {
        // Fetch all rows as associative arrays
        $results = mysqli_fetch_all($run, MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $results]);
    } else {
        // Handle query error
        echo json_encode(['success' => false, 'error' => 'Query error: ' . mysqli_error($conn)]);
    }
} 
}

else if($action=='status_search'){
 
if (isset($_GET['fromdate']) && isset($_GET['todate']) && isset($_GET['status'])) {
    // Retrieve fromdate and todate from the GET request
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    $status = $_GET['status'];

 

    // Create comma-separated list of agency names
    $agency_name = implode("','", $agencies);

    // Construct SQL query
    $sql = "SELECT `Id`,`agency`, `patient_name`, `mrn`, `insurance_type`, `assesment_type`, `assesment_date`, `status`, `pending_comments`, `pending_reason` ,`totalcasemixagency`,`totalcasemix` FROM `Main_Data` WHERE `agency` IN ('$agency_name') AND `status`= '$status' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";

    // Execute SQL query
    $run = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($run) {
        // Fetch all rows as associative arrays
        $results = mysqli_fetch_all($run, MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $results]);
    } else {
        // Handle query error
        echo json_encode(['success' => false, 'error' => 'Query error: ' . mysqli_error($conn)]);
    }
} 
}

else if($action=='all_report'){
 
if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
    // Retrieve fromdate and todate from the GET request
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];

 

    // Create comma-separated list of agency names
    $agency_name = implode("','", $agencies);

    // Construct SQL query
    $sql = "SELECT `Id`,`agency`, `patient_name`, `mrn`, `insurance_type`, `assesment_type`, `assesment_date`, `status`, `pending_comments`, `pending_reason` ,`totalcasemixagency`,`totalcasemix` FROM `Main_Data` WHERE `agency` IN ('$agency_name') AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";

    // Execute SQL query
    $run = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($run) {
        // Fetch all rows as associative arrays
        $results = mysqli_fetch_all($run, MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $results]);
    } else {
        // Handle query error
        echo json_encode(['success' => false, 'error' => 'Query error: ' . mysqli_error($conn)]);
    }
} 
}
 

 

else if (isset($_GET['message']) && isset($_GET['mrnCellValue'])) {
    // Retrieve fromdate and todate from the GET request
    $message = $_GET['message'];
    $mrnCellValue = $_GET['mrnCellValue'];

    // Create comma-separated list of agency names
    $agency_name = implode("','", $agencies);

    // Construct SQL query
    $sql = "UPDATE `Main_Data` SET `client_comments`='$message' WHERE `mrn`= '$mrnCellValue' AND `agency`=('$agency_name')";

    // Execute SQL query
    $run = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($run) {
        // Fetch all rows as associative arrays
        
        $results = mysqli_fetch_all($run, MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $results]);
    } else {
        // Handle query error
        echo json_encode(['success' => false, 'error' => 'Query error: ' . mysqli_error($conn)]);
    }
} else {
    // Handle missing fromdate or todate in the GET request
    echo json_encode(['success' => false, 'error' => 'fromdate and/or todate not set in GET request']);
}





















?>

 
