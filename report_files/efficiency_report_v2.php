<?php
// Include database connection
include('../db/db-con.php');

// Error reporting setup
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize data array
$data = array();
$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($action == 'login_details') {
    // Get parameters and sanitize inputs
    $fromdate = isset($_GET['fromdate']) ? mysqli_real_escape_string($conn, $_GET['fromdate']) : '';
    $todate = isset($_GET['todate']) ? mysqli_real_escape_string($conn, $_GET['todate']) : '';
    $teamname = isset($_GET['teamname']) ? mysqli_real_escape_string($conn, $_GET['teamname']) : '';
    $codername = isset($_GET['codername']) ? mysqli_real_escape_string($conn, $_GET['codername']) : '';
    $coderid = isset($_GET['coderid']) ? mysqli_real_escape_string($conn, $_GET['coderid']) : '';

    // Construct the SQL query
    $query = "
        SELECT `username`, `emp_id`, `team_name`, `log_date`, `login_time`, `logout_time`
        FROM `user_log`
        WHERE `role`='user'
    ";

    // Add conditions based on parameters
    if (!empty($codername)) {
        $query .= " AND `username` = '$codername'";
    }
    if (!empty($coderid)) {
        $query .= " AND `emp_id` = '$coderid'";
    }
    if (!empty($fromdate) && !empty($todate)) {
        $query .= " AND `log_date` BETWEEN '$fromdate' AND '$todate'";
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }
    if (!$stmt->execute()) {
        die("Error executing the query: " . $stmt->error);
    }

    // Fetch the result
    $result = $stmt->get_result();
    if ($result === false) {
        die("Error getting result set: " . $stmt->error);
    }

    // Initialize array to store total working hours for each employee
    $employeeHours = [];

    // Process each row and calculate total working hours
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['logout_time'])) {
            $loginTime = new DateTime($row['log_date'] . ' ' . $row['login_time']);
            $logoutTime = new DateTime($row['log_date'] . ' ' . $row['logout_time']);
            $interval = $logoutTime->diff($loginTime);

            $totalWorkingHours = ($interval->h * 3600) + ($interval->i * 60) + $interval->s; // Convert to seconds

            // Group working hours by employee
            if (!isset($employeeHours[$row['emp_id']])) {
                $employeeHours[$row['emp_id']] = [
                    'username' => $row['username'],
                    'emp_id' => $row['emp_id'],
                    'team_name' => $row['team_name'],
                    'total_working_hours' => 0
                ];
            }

            // Accumulate total working hours
            $employeeHours[$row['emp_id']]['total_working_hours'] += $totalWorkingHours;
        }
    }

    // Format total working hours for each employee (convert seconds to HH:MM:SS)
    foreach ($employeeHours as &$employee) {
        $totalSeconds = $employee['total_working_hours'];
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        $employee['total_working_hours'] = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    // Output JSON
    echo json_encode(['login_details' => array_values($employeeHours)]);
}

// Close the database connection
$conn->close();
?>
