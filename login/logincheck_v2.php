<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db/db-con.php');

$empid = $_POST['empid'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($empid) || empty($password)) {
    echo json_encode(['success' => false, 'error' => 'Please enter both empid and password.']);
    exit();
}

$empid = $conn->real_escape_string($empid);
$password = $conn->real_escape_string($password);
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');

// Check if the user is already logged in another system
$userCheckQuery = "
    SELECT * 
    FROM `user_log` 
    WHERE `emp_id` = '$empid' 
      AND `log_date` = '$currentDate' 
      AND `login_time` IS NOT NULL 
      AND `status_2` = '1' 
      AND `role` NOT IN ('client', 'Admin', 'ceo', 'agency')
";
$userCheckResult = $conn->query($userCheckQuery);

if ($userCheckResult->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'User Login In Other System']);
    exit();
}

// Verify user credentials
$loginQuery = "
    SELECT * 
    FROM userlogin 
    WHERE user_id = '$empid' 
      AND user_password = '$password' 
      AND user_status = 'Active'
";
$loginResult = $conn->query($loginQuery);

if (!$loginResult) {
    echo json_encode(['success' => false, 'error' => 'Database query error: ' . $conn->error]);
    exit();
}

$userData = $loginResult->fetch_assoc();

if ($userData) {
    $_SESSION['username'] = $userData['user_name'];
    $_SESSION['empid'] = $userData['user_id'];
    $_SESSION['password'] = $userData['user_password'];
    $_SESSION['role'] = $userData['user_role'];

    if (in_array($userData['user_role'], ['Admin', 'agency'])) {
        $_SESSION['agent'] = $userData['user_company'];
    }

    // Check if the user's password needs to be changed
    if (in_array($userData['user_role'], ['user', 'TeamLeader', 'QA', 'QaTl'])) {
        $passwordChangeDate = new DateTime($userData['change_date']);
        $currentDatee = new DateTime(date('Y-m-d'));
        $daysSinceChange = $passwordChangeDate->diff($currentDatee)->days;

       if ($daysSinceChange > 90) {
    echo json_encode([
        'success' => false, 
        'error' => 'The Password Is Expired. Please Change Your Password.', 
        'user_id' => $userData['user_id'],
        'user_role' => $userData['user_role']
    ]);
    exit();
}
    }

    // Determine the user role and respond accordingly
    $roleMapping = [
        'Admin' => 'admin',
        'tm' => 'tm',
        'user' => 'user',
        'TeamLeader' => 'TeamLeader',
        'agency' => 'agency',
        'client' => 'client',
        'ceo' => 'ceo',
        'QA' => 'QA',
        'QaTl' => 'QaTl',
        'superadmin' => 'superadmin'
    ];

    $userRole = $roleMapping[$userData['user_role']] ?? null;

    if ($userRole) {
        echo json_encode(['success' => $userRole]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid user role.']);
        exit();
    }

    // Update or insert user log information
    $username = $userData['user_name'];
    $empid = $userData['user_id'];
    $role = $userData['user_role'];
    $team = $userData['Team'];
    $currentTime = date('H:i:s');
    $statusTwo = '1';

     $userLogQuery = "
        SELECT * 
        FROM `user_log` 
        WHERE `username` = '$username' 
          AND `emp_id` = '$empid' 
          AND `log_date` = '$currentDate'
    ";
    $userLogResult = $conn->query($userLogQuery);

    if ($userLogResult->num_rows > 0) {
        // Update existing log entry
        $updateLogQuery = "
            UPDATE `user_log` 
            SET `status_2` = '$statusTwo' 
            WHERE `emp_id` = '$empid' 
              AND `username` = '$username' 
              AND `role` = '$role' 
              AND `log_date` = '$currentDate'
        ";
        $conn->query($updateLogQuery);
    } else {
        // Insert new log entry
        $insertLogQuery = "
            INSERT INTO `user_log` (`username`, `emp_id`, `team_name`, `role`, `log_date`, `login_time`, `status_2`) 
            VALUES ('$username', '$empid', '$team', '$role', '$currentDate', '$currentTime', '$statusTwo')
        ";
        if (!$conn->query($insertLogQuery)) {
            echo json_encode(['success' => false, 'error' => 'User log insertion error: ' . $conn->error]);
            exit();
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid username or password. Please try again.']);
}

$conn->close();
