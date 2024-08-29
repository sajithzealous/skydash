<?php
session_start(); 
 
$servername = "localhost";
$username   = "zhcadmin";
$password   = "d0m!n$24";
$dbname     = "HCLI";
$port       = "22022";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);



// Retrieve session data
$user = $_SESSION['username'];
$emp_id = $_SESSION['empid'];
$action =$_GET['action'];

 


 
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

 

    // Construct SQL query
    $sql = "SELECT `Id`,`agency`, `patient_name`, `mrn`, `insurance_type`, `assesment_type`, `assesment_date`, `status`, `pending_comments`, `pending_reason` ,`totalcasemixagency`,`totalcasemix` FROM `Main_Data` WHERE `agency`='$user' AND `mrn`='$mrn' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";

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

   

    // Construct SQL query
    $sql = "SELECT `Id`,`agency`, `patient_name`, `mrn`, `insurance_type`, `assesment_type`, `assesment_date`, `status`, `pending_comments`, `pending_reason` ,`totalcasemixagency`,`totalcasemix` FROM `Main_Data` WHERE `agency`='$user' AND `patient_name`LIKE '%$patient%' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";

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

 

    
    // Construct SQL query
    $sql = "SELECT `Id`,`agency`, `patient_name`, `mrn`, `insurance_type`, `assesment_type`, `assesment_date`, `status`, `pending_comments`, `pending_reason` ,`totalcasemixagency`,`totalcasemix` FROM `Main_Data` WHERE `agency`='$user' AND `status`= '$status' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";

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

 

    

    // Construct SQL query
    $sql = "SELECT `Id`,`agency`, `patient_name`, `mrn`, `insurance_type`, `assesment_type`, `assesment_date`, `status`, `pending_comments`, `pending_reason` ,`totalcasemixagency`,`totalcasemix` FROM `Main_Data` WHERE `agency`='$user' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'";

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
    // $agency_name = implode("','", $agencies);

    // Construct SQL query
    $sql = "UPDATE `Main_Data` SET `agency_comments`='$message' WHERE `mrn`= '$mrnCellValue' AND `agency`='$user'";

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

 
