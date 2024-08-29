<?php
// Set error reporting
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('../db/db-con.php');

// Get action parameter from GET request
$action = isset($_GET['action']) ? $_GET['action'] : '';

 $person = $_SESSION['username'];
 $person_emp_id =$_SESSION['empid'];
 $person_role= $_SESSION['role'];

// Set default timezone
date_default_timezone_set('America/New_York');

// Get current date and time
$currentDateTime = new DateTime();
$currentDateFormatted = $currentDateTime->format('Y-m-d');
$currentTimeFormatted = $currentDateTime->format('H:i:s');

// Initialize response array
$response = array();

// Check if action is 'getuserdata'
if ($action == 'getuserdata' && $person_role =='TeamLeader') {
    // Construct SQL query
    $sql = "SELECT * FROM `user_log` WHERE `log_date`='$currentDateFormatted' AND `role` IN ('user','QA')";
    
    // Execute query
    $result = $conn->query($sql);
    
    // Check if query executed successfully and returned results
    if ($result && $result->num_rows > 0) {
        // Fetch data from result set
        while ($row = $result->fetch_assoc()) {
            // Store fetched data in variables
            $Id = $row['Id'];
            $username = $row['username'];
            $userempid = $row['emp_id'];
            $userrole = $row['role'];
            $userstatus = $row['status_2'];
            $userlogdate = $row['log_date'];
            $userlogintime = $row['login_time'];
            $userlogouttime = $row['tempoary_logout'];

            // Store fetched data in response array
            $response[] = array(
                'Id' => $Id,
                'date'=>$userlogdate,
                'username' => $username,
                'emp_id' => $userempid,
                'role' => $userrole,
                'status_2' => $userstatus,
                 'logdate' => $userlogdate,
                'logintime' => $userlogintime,
                'logouttime' => $userlogouttime,
            );
        }
    }
}
else if ($action == 'getuserdata' && $person_role =='Admin') {
    // Construct SQL query
     $sql = "SELECT * FROM `user_log` WHERE `log_date`='$currentDateFormatted' AND `role` IN ('user','QA','TeamLeader','QaTl')";
    
    // Execute query
    $result = $conn->query($sql);
    
    // Check if query executed successfully and returned results
    if ($result && $result->num_rows > 0) {
        // Fetch data from result set
        while ($row = $result->fetch_assoc()) {
            // Store fetched data in variables
            $Id = $row['Id'];
            $username = $row['username'];
            $userempid = $row['emp_id'];
            $userrole = $row['role'];
            $userstatus = $row['status_2'];
            $userlogdate = $row['log_date'];
             $userlogintime = $row['login_time'];
              $userlogouttime = $row['tempoary_logout'];

            // Store fetched data in response array
            $response[] = array(
                'Id' => $Id,
                'date'=>$userlogdate,
                'username' => $username,
                'emp_id' => $userempid,
                'role' => $userrole,
                'status_2' => $userstatus,
                'logdate' => $userlogdate,
                'logintime' => $userlogintime,
                'logouttime' => $userlogouttime,
            );
        }
    }
}
else if ($action == 'getuserdata' && $person_role =='QaTl') {
    // Construct SQL query
     $sql = "SELECT * FROM `user_log` WHERE `log_date`='$currentDateFormatted' AND `role` IN ('QA')";
    
    // Execute query
    $result = $conn->query($sql);
    
    // Check if query executed successfully and returned results
    if ($result && $result->num_rows > 0) {
        // Fetch data from result set
        while ($row = $result->fetch_assoc()) {
            // Store fetched data in variables
            $Id = $row['Id'];
            $username = $row['username'];
            $userempid = $row['emp_id'];
            $userrole = $row['role'];
            $userstatus = $row['status_2'];
            $userlogdate = $row['log_date'];
            $userlogintime = $row['login_time'];
            $userlogouttime = $row['tempoary_logout'];

            // Store fetched data in response array
            $response[] = array(
                'Id' => $Id,
                'date'=>$userlogdate,
                'username' => $username,
                'emp_id' => $userempid,
                'role' => $userrole,
                'status_2' => $userstatus,
                'logdate' => $userlogdate,
                'logintime' => $userlogintime,
                'logouttime' => $userlogouttime,
            );
        }
    }
}


// User data update
if ($action == 'updatestatus') {
    // Check if Id is provided
    if (isset($_POST['Id'])) {
        $Id = $_POST['Id'];
        $username=$_POST['username'];
        $userid=$_POST['userid'];
        $userrole=$_POST['userrole'];
        $status = 0;

        // Update user status if Id is provided
        if (!empty($Id)) {
            // Prepare and execute SQL update query
             $sqlUpdateData = "UPDATE `user_log` SET `status_2` = $status, `tempoary_logout` = '$currentTimeFormatted' WHERE `Id` = '$Id'";
            $sqlUpdateResult = $conn->query($sqlUpdateData);

            if ($sqlUpdateResult) {
                // Update successful

                $sqlinsertdata="INSERT INTO `forcelogout_log`(`username`, `emp_id`, `role`, `logoutperson`, `logoutperson_empid`) VALUES ('$username','$userid','$userrole','$person','$person_emp_id')";
                $sqlinsertdataquery =$conn->query($sqlinsertdata);
                $response = array(
                    'success' => true,
                    'message' => 'Status updated successfully.'
                );
            } else {
                // Update failed
                $response = array(
                    'success' => false,
                    'message' => 'Failed to update status.'
                );
            }
        } else {
            // Id not provided
            $response = array(
                'success' => false,
                'message' => 'Id not provided.'
            );
        }
    } else {
        // Id not provided in the POST request
        $response = array(
            'success' => false,
            'message' => 'Id not provided in the request.'
        );
    }
}

// Set response content type
header('Content-Type: application/json');

// Output JSON encoded response
echo json_encode($response);
?>
