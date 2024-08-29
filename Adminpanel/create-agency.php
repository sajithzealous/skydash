<?php
    include('../db/db-con.php');
      session_start();
    $action = $_GET['action'];
    $res = [];
    $dateTime = date('Y-m-d H:i:s');


$user = $_SESSION['username'] ?? null;
$userid = $_SESSION['empid'] ?? '';
$role = $_SESSION['role'] ?? '';

  if ($action == 'create') {
    $username = $_GET['username'];
    $password = $_GET['password'];
    $emp_id = $_GET['emp_id'];
    $user_status = $_GET['user_status'];
    $user_role = $_GET['user_role'];
    $client_id = isset($_GET['client_id']) ? $_GET['client_id'] : ''; // Assuming client_id is optional

    // Check if user with the same emp_id exists
    $sql_check = mysqli_query($conn, "SELECT * FROM `userlogin` WHERE user_id = '$emp_id'");
    if (mysqli_fetch_assoc($sql_check)) {
        $res['status'] = 'Available'; // User/agency already exists
    } else {
        // Insert into userlogin table (if password is provided)
        if ($password != "") {
            $sql1 = "INSERT INTO `userlogin`(`user_name`, `user_password`, `user_id`, `user_role`, `user_status`, `created_date`) 
                     VALUES ('$username','$password','$emp_id','$user_role','$user_status','$dateTime')";
            $result1 = mysqli_query($conn, $sql1);
        } else {
            $result1 = true; // No password provided, skip userlogin insert
        }

        // Insert into Agent table
        if ($user_role == 'agency') {

            $sqlselectusername = mysqli_query($conn, "SELECT `user_name` FROM `userlogin` WHERE `user_id`='$client_id'");
            $row = mysqli_fetch_assoc($sqlselectusername);
            $username = $row['user_name'];



            $sql2 = "INSERT INTO `Agent`(`agency_name`, `client_name`, `client_id`, `agency_status`, `created_date`) 
                     VALUES ('$emp_id','$username','$client_id','active','$dateTime')";
        } else {
            $sql2 = "INSERT INTO `Agent`(`agency_name`, `client_name`, `client_id`, `agency_status`, `created_date`) 
                     VALUES ('$emp_id','$username','$emp_id','active','$dateTime')";
        }
        $result2 = mysqli_query($conn, $sql2);

        // Check both query results
        if ($result1 && $result2) {
            $res['status'] = 'Ok'; // Both inserts successful
        } else {
            $res['status'] = 'Error'; // One or both inserts failed
        }
    }
}

    else if($action == 'upload_csv')
    {

    }
else if ($action == 'update_status') {
    // Retrieve parameters from the request
    $row_id = $_GET['row_id'];
    $status = $_GET['status'];
    $emp_id = $_GET['emp_id'];

    // Update user status in the userlogin table
    mysqli_query($conn, "UPDATE `userlogin` SET `user_status`='$status' WHERE id = '$row_id'");

    // Update agency status in the Agent table
    mysqli_query($conn, "UPDATE `Agent` SET `agency_status`='$status' WHERE client_id = '$emp_id'");

    // Prepare the response
    $res['status'] = 'Ok';


    $fromtable = 'Agent';
 
            $insertQuery = "INSERT INTO `Ai-log`(`source_Id`, `from-table`, `status`, `user_name`, `emp_id`, `role`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($insertQuery);
            $stmt_log->bind_param("isssss", $row_id, $fromtable, $status, $user, $userid, $role);
            $stmt_log->execute();

            if ($stmt_log->errno) {
                $res['status'] = 'Error';
                $res['message'] = 'Database error: ' . $stmt_log->error;
            }


}

    else if($action == 'get_active_count')
    {
        $sql = mysqli_query($conn, "SELECT SUM(CASE WHEN user_status = 'Active' AND user_role ='client' THEN 1 ELSE 0 END) AS total_active, SUM(CASE WHEN user_status = 'In-Active' AND user_role ='client' THEN 1 ELSE 0 END) AS total_inactive, SUM(CASE WHEN user_role ='client' THEN 1 ELSE 0 END) AS total_user FROM `userlogin`");
        $get_user = mysqli_fetch_assoc($sql);
        // print_r($get_user);
        $res['data'] = $get_user;
        

        $res['status'] = 'Ok';
    }
    else
    {
        $res['status'] = 'Invalid Request';
    }

    echo json_encode($res);
?>