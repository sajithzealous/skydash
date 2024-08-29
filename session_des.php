<?php
// Start the session
session_start();
 include('db/db-con.php');
// Retrieve session variables
$username = $_SESSION['username'];
$empid = $_SESSION['empid'];
 $role = $_SESSION['role'];

// Set the timezone
date_default_timezone_set('Asia/Kolkata');

// Get current date and time
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');
$statusTwo = '0';

// Update user logout time and status in the database
 $userAlreadyQuery = "UPDATE `user_log` SET `tempoary_logout`='$currentTime',`logout_time`='$currentTime', `status_2`='$statusTwo' WHERE `emp_id`='$empid' AND `username`='$username' AND `role`='$role' AND `log_date`='$currentDate'";
$userAlreadyResult = $conn->query($userAlreadyQuery);
// Check if any rows were affected by the update
if ($userAlreadyResult === True) {
    // Redirect user to login page
    header("Location: login.php");
}

?>
