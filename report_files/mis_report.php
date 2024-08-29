<?php
include('../db/db-con.php');
$start_date = date('Y-m-01');
$today_date = date('Y-m-d');

if($_GET['start_date'])
{
    $start_date = $_GET['start_date'];
}
if($_GET['end_date'])
{
    $today_date = $_GET['end_date'];
}



// Retrieve default value from hppscodevalue table
$STDPDGM = "SELECT `National` FROM `hppscodevalue` LIMIT 1";
$dft = $conn->query($STDPDGM);

// Check if query was successful
if ($dft) {
    // Fetch the default value
    $default = $dft->fetch_assoc()['National'];
} else {
    // Handle query error
    $default = ""; // Set a default value or handle error accordingly
}

// Assuming $conn is your database connection

// Prepare the SQL query
$sql = "SELECT `Id`, `agency`, `patient_name`, `mrn`, `insurance_type`, `assesment_type`, `assesment_date`, `status`, `alloted_to_coder`, `qc_person`, `qc_person_emp_id`, `coder_emp_id`, `pending_comments`, `pending_reason`, `totalcasemix`, `client_comments`,`log_time` FROM `Main_Data` WHERE `log_time` BETWEEN '$start_date 00:00:00' AND '$today_date 23:59:59'";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    // Handle SQL execution error
    echo json_encode(['success' => false, 'error' => 'SQL execution error: ' . $conn->error]);
} else {
    // Fetch all rows as associative arrays
    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    // Return the data as JSON
    echo json_encode($results);
}
?>
