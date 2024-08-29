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
 


$useralready = "SELECT * FROM `user_log` WHERE `emp_id`='$empid' AND `log_date`='$currentDate' AND `login_time` IS NOT NULL AND `status_2`='1' AND `role` NOT IN ('client', 'Admin','ceo', 'agency')";

$useralreadyresult = $conn->query($useralready);

if ($useralreadyresult->num_rows > 0) {


  echo json_encode(['success' => false, 'error' => 'User Login In Other System']);
} else {

  $query = "SELECT * FROM userlogin WHERE user_id='$empid' AND user_password='$password' AND `user_status` ='Active'";
  $result = $conn->query($query);

  if (!$result) {
    echo json_encode(['success' => false, 'error' => 'Database query error: ' . $conn->error]);
    exit();
  }

  $row = $result->fetch_assoc();

  if ($row) {
    $_SESSION['username'] = $row['user_name'];
    $_SESSION['empid'] = $row['user_id'];
    $_SESSION['password'] = $row['user_password'];
    $_SESSION['role'] = $row['user_role'];

    $user = $row['user_name'];

    if ($row['user_role'] == 'Admin' || $row['user_role'] == 'agency') {
      $_SESSION['agent'] = $row['user_company'];
    }

    switch ($row['user_role']) {
      case 'Admin':
        echo json_encode(['success' => 'admin']);
        break;
      case 'tm':
        echo json_encode(['success' => 'tm']);
        break;
      case 'user':
        echo json_encode(['success' => 'user']);
        break;
      case 'TeamLeader':
        echo json_encode(['success' => 'TeamLeader']);
        break;
      case 'agency':
        echo json_encode(['success' => 'agency']);
        break;
      case 'client':
        echo json_encode(['success' => 'client']);
        break;
      case 'ceo':
        echo json_encode(['success' => 'ceo']);
        break;
      case 'QA':
        echo json_encode(['success' => 'QA']); // Corrected spelling
        break;
      case 'QaTl':
        echo json_encode(['success' => 'QaTl']); // Corrected spelling
        break;
      case 'superadmin':
        echo json_encode(['success' => 'superadmin']); // Corrected spelling
        break;
      default:
        echo json_encode(['success' => false, 'error' => 'Invalid user role.']);
        break;
    }

    $username = $row['user_name'];
    $empid = $row['user_id']; // Added a semicolon here
    $role = $row['user_role'];
    $team = $row['Team']; // Added a semicolon here
    $currentTime = date('H:i:s');
     $statusTwo='1';

    $userlogselect = "SELECT * FROM `user_log` WHERE `username`='$username' AND `emp_id`='$empid' AND `log_date`='$currentDate'";
    $userlogresult = $conn->query($userlogselect);

    if ($userlogresult->num_rows > 0) {

       $userAlreadyQuery = "UPDATE `user_log` SET `status_2`='$statusTwo' WHERE `emp_id`='$empid' AND `username`='$username' AND `role`='$role' AND `log_date`='$currentDate'";
        $userAlreadyResult = $conn->query($userAlreadyQuery);
      
    } else {
      // Code if there are no rows
     
      $query2 = "INSERT INTO `user_log`(`username`, `emp_id`, `team_name`, `role`, `log_date`, `login_time`,`status_2`) VALUES ('$username','$empid','$team','$role','$currentDate','$currentTime', '$statusTwo')";
      $result2 = $conn->query($query2);
      if (!$result2) {
        echo "User log insertion error: " . $conn->error;
      }
    }
  } else {
    echo json_encode(['success' => false, 'error' => 'The username or password you entered is invalid. Please check and try again.']);
  }
}

$conn->close();
