<?php
session_start();
$user = $_SESSION['username'];
$role = $_SESSION['role'];
$emp_id = $_SESSION['empid'];

include('../db/db-con.php');

// Function to fetch data based on user role and pagination
function fetchData($conn, $sql, $role)
{
    $result = $conn->query($sql);
    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add the role information to each fetched row
            $row['role'] = $role;
            $data[] = $row;
        }
    }

    return $data;
}

// Get pagination parameters
// $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
// $length = isset($_GET['length']) ? intval($_GET['length']) : 10;
// $start = ($page - 1) * $length;

$length=$_GET['length'];
$start=$_GET['start'];
$search=$_GET['search']['value'];
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 0;

// Debugging statements to log pagination parameters
error_log("Page: " . $page);
error_log("Length: " . $length);
error_log("Start: " . $start);

// Total records
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM `Main_Data`";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecordsRow = $totalRecordsResult->fetch_assoc();
$totalRecords = $totalRecordsRow['total'];

// Debugging statement to log total records
error_log("Total Records: " . $totalRecords);

$data = array();
if ($user == 'admin') {
    // Fetch data for admin
    $sql = "SELECT * FROM `Main_Data` LIMIT $start, $length";
    $data = fetchData($conn, $sql, 'admin');
} elseif ($role == 'TeamLeader') {
    // Fetch data for team leader
    if($search=='') {
        // If no search query is provided, fetch all data
        $sql = "SELECT * FROM `Main_Data` WHERE `alloted_team`='$user' AND `team_emp_id` = '$emp_id' AND `status` IN('APPROVED') LIMIT $start, $length";
        $data = fetchData($conn, $sql, 'TeamLeader');
    } else {
        // If a search query is provided, filter data based on search query
        $search = mysqli_real_escape_string($conn, $search); // Escape special characters
        $sql = "SELECT * FROM `Main_Data` WHERE `alloted_team`='$user' AND `team_emp_id` = '$emp_id' AND `status` IN('APPROVED') AND (
            `Id` LIKE '%$search%' OR 
            `patient_name` LIKE '%$search%' OR 
            `mrn` LIKE '%$search%' OR 
            `insurance_type` LIKE '%$search%' OR 
            `assesment_date` LIKE '%$search%' OR 
            `assesment_type` LIKE '%$search%' OR 
            `agency` LIKE '%$search%' OR 
            `url` LIKE '%$search%' OR 
            `priority` LIKE '%$search%' OR 
            `status` LIKE '%$search%' OR 
            `AssignTeam_date` LIKE '%$search%' OR 
            `alloted_to_coder` LIKE '%$search%' OR 
            `coder_emp_id` LIKE '%$search%' OR 
            `AssignCoder_date` LIKE '%$search%' OR 
            `File_Status_Time` LIKE '%$search%' OR 
            `file_completed_date` LIKE '%$search%' OR 
            `qc_person` LIKE '%$search%' OR 
            `qc_person_emp_id` LIKE '%$search%' OR 
            `qc_date` LIKE '%$search%' OR 
            `qc_completed_date` LIKE '%$search%' OR 
            `file_status` LIKE '%$search%' OR 
            `client_comments` LIKE '%$search%' OR 
            `agency_comments` LIKE '%$search%' OR 
            `coder_comments` LIKE '%$search%' OR 
            `mis_comments` LIKE '%$search%' OR 
            `pending_comments` LIKE '%$search%' OR 
            `pending_date` LIKE '%$search%' 

        ) LIMIT $start, $length";
        $data = fetchData($conn, $sql, 'TeamLeader');
    }
}
 elseif ($role == 'QA') {
    // Fetch data for QA
    $sql = "SELECT * FROM `Main_Data` WHERE `qc_person`='$user' AND `qc_person_emp_id` = '$emp_id' AND `status` IN('APPROVED') LIMIT $start, $length";
    $data = fetchData($conn, $sql, 'QA');
} elseif ($role == 'QaTl') {
    // Fetch data for QaTl
    $sql = "SELECT * FROM `Main_Data` WHERE `qc_team`='$user' AND `qc_team_emp_id` = '$emp_id' AND `status` IN('APPROVED') LIMIT $start, $length";
    $data = fetchData($conn, $sql, 'QaTl');
} else {
    // Fetch data for coder
    $sql = "SELECT * FROM `Main_Data` WHERE `alloted_to_coder`='$user' AND `coder_emp_id` = '$emp_id' AND `status` IN('APPROVED') LIMIT $start, $length";
    $data = fetchData($conn, $sql, 'Coder');
    $_SESSION['table_data'] = $data;
}

// Debugging statement to log fetched data count
error_log("Fetched Data Count: " . count($data));

// Return data as JSON
$response = array(
    "draw" => $draw,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords, // Adjust this if you apply any filters
    "data" => $data
);

header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
