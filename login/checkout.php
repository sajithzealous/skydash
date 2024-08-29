<?php
session_start();

 include('../db/db-con.php');
if (isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    
    date_default_timezone_set('America/New_York');
    
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');

    $query = "SELECT * FROM userlogin WHERE user_name='$username' AND user_password='$password' AND user_status ='Active'";
    $result = $conn->query($query);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $row = $result->fetch_assoc();
    $empid = $row['user_id'];

    $userlogselect = "UPDATE `user_log` SET `logout_time` = '$currentTime', `status`='P' WHERE `username`='$username' AND `emp_id`='$empid' AND `log_date`='$currentDate' AND `login_time` IS NOT NULL";
    //$userlogselect = "UPDATE `user_log` SET `logout_time` = '$currentTime', `status`='P' WHERE `username`='$username' AND `emp_id`='$empid' AND `log_date`='$currentDate'";

    $userlogresult = $conn->query($userlogselect);

    if (!$userlogresult) {
        die("Update failed: " . $conn->error);
    }

    if ($userlogresult->num_rows > 0) {
        echo " ";
    } 
    else {
          echo "done";
    }
} else {
    // One or more session variables are not set
    echo "Session variables are not set";
}

// Note: $response is not defined in your code, so I'm commenting out the following line
// echo json_encode($response);
?>
