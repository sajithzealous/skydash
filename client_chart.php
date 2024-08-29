
 <?php

    session_start(); 
    include('db/db-con.php');
$user = $_SESSION['username'];
$emp_id = $_SESSION['empid'];

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


$agency_names = implode("','", $agencies);
 
 
// Assuming $conn is your database connection
$query = "SELECT
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS `this_week`,
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE() - INTERVAL 7 DAY, 1) THEN 1 ELSE 0 END) AS `1st_week`,
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE() - INTERVAL 14 DAY, 1) THEN 1 ELSE 0 END) AS `2nd_week`,
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE() - INTERVAL 21 DAY, 1) THEN 1 ELSE 0 END) AS `3rd_week`,
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE() - INTERVAL 28 DAY, 1) THEN 1 ELSE 0 END) AS `4th_week`
FROM
    Main_Data
WHERE
    `status` = 'APPROVED'
    AND `agency` = '$agency_names'
    AND `File_Status_Time` >= CURDATE() - INTERVAL 4 WEEK;";

$result = mysqli_query($conn, $query);

// Initialize an array to hold weekly counts
$weeklyCounts = array_fill(0, 5, 0);

// Fetch and store weekly counts
$row = mysqli_fetch_assoc($result);
$weeklyCounts[0] = intval($row['this_week']);
$weeklyCounts[1] = intval($row['1st_week']);
$weeklyCounts[2] = intval($row['2nd_week']);
$weeklyCounts[3] = intval($row['3rd_week']);
$weeklyCounts[4] = intval($row['4th_week']);

// Close the database connection
 
?>