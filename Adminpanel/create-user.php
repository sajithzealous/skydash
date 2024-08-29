<?php
include('../db/db-con.php');
session_start();
$action = $_GET['action'];
$res = [];
$dateTime = date('Y-m-d H:i:s');

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user = $_SESSION['username'] ?? null;
$emp_id = $_SESSION['empid'] ?? '';
$role = $_SESSION['role'] ?? '';

// create user data

if ($action == 'create') {
    $username = $_GET['username'];
    $password = $_GET['password'];
    $emp_id = $_GET['emp_id'];
    $user_org = $_GET['user_org'];
    $user_role = $_GET['user_role'];
    $user_team = $_GET['user_team'];
    $user_teamleader = $_GET['user_teamleader'];
    $user_teammanager = $_GET['user_teammanager'];
    $user_operationalmanager = $_GET['user_operationalmanager'];
    $user_status = $_GET['user_status'];

    $sql = mysqli_query($conn, "SELECT * FROM `userlogin` WHERE user_id = '$emp_id'");
    if ($check = mysqli_fetch_assoc($sql)) {
        $res['status'] = 'Available';
    } else {
        mysqli_query($conn, "INSERT INTO `userlogin`(`user_name`, `user_password`, `user_id`, `user_role`, `user_company`, `user_status`, `created_date`, `Team`) VALUES ('$username','$password','$emp_id','$user_role','$user_org','$user_status','$dateTime','$user_team')");

        if ($user_role == 'user' && $user_team != '') {
            if ($user_role == 'user') {
                $user_role = 'coder';
            } else if ($user_role == 'QA') {
                $user_role = 'qc_coder';
            }

            // Initialize variables for the fetched data
            $team_emp_id = null;
            $team_manager_empid = null;
            $operational_manager_empid = null;

            // Fetch team_emp_id based on team leader
            $selectdata = mysqli_query($conn, "SELECT `team_emp_id` FROM `team` WHERE `team_leader_name`='$user_teamleader'");
            if ($selectdata && $getdata = mysqli_fetch_assoc($selectdata)) {
                $team_emp_id = $getdata['team_emp_id'];
            }

            // Fetch team_manager_empid based on team manager
            $selectdata = mysqli_query($conn, "SELECT `team_manager_empid` FROM `team` WHERE `team_manager_name`='$user_teammanager'");
            if ($selectdata && $getdata = mysqli_fetch_assoc($selectdata)) {
                $team_manager_empid = $getdata['team_manager_empid'];
            }

            // Fetch operational_manager_empid based on operational manager
            $selectdata = mysqli_query($conn, "SELECT `operational_manager_empid` FROM `team` WHERE `operational_manager_name`='$user_operationalmanager'");
            if ($selectdata && $getdata = mysqli_fetch_assoc($selectdata)) {
                $operational_manager_empid = $getdata['operational_manager_empid'];
            }


            // Insert into coders table
            $insertquery = "INSERT INTO `coders` (`Coders`, `coder_emp_id`, `Team`, `team_leader_name`, `team_emp_id`, `team_manager_name`, `team_manager_empid`, `operational_manager_name`, `operational_manager_empid`, `status`, `category`, `all_view`) 
                VALUES ('$username', '$emp_id', '$user_team', '$user_teamleader', '$team_emp_id', '$user_teammanager', '$team_manager_empid', '$user_operationalmanager', '$operational_manager_empid', 'active', '$user_role', 'Yes')";

            if (mysqli_query($conn, $insertquery)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $insertquery . "<br>" . mysqli_error($conn);
            }
        }
        $res['status'] = 'Ok';
    }
} else if ($action == 'upload_csv') {
}
// else if($action == 'update_status')
// {
//     $row_id = $_GET['row_id'];
//     $status = $_GET['status'];

//     mysqli_query($conn, "UPDATE `userlogin` SET `user_status`='$status' WHERE id = '$row_id'");

//     $res['status'] = 'Ok';
//     $fromtable='userlogin';

//     $insertQuery = mysqli_query($conn,"INSERT INTO `Ai-log`(`source_Id`, `from-table`, `status`, `user_name`, `emp_id`, `role`) VALUES ('$row_id','$fromtable','$status','$username','$emp_id','$user_role')";
//     $insertResult = $conn->query($insertQuery);


// }


else if ($action == 'update_status') {

    if (isset($_GET['row_id'], $_GET['status'])) {
        $row_id = $_GET['row_id'];
        $status = $_GET['status'];

        $updateQuery = "UPDATE `userlogin` SET `user_status`=? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("si", $status, $row_id);
        $stmt->execute();

        if ($stmt->errno) {
            $res['status'] = 'Error';
            $res['message'] = 'Database error: ' . $stmt->error;
        } else {
            $res['status'] = 'Ok';
            $fromtable = 'userlogin';

            $insertQuery = "INSERT INTO `Ai-log`(`source_Id`, `from-table`, `status`, `user_name`, `emp_id`, `role`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($insertQuery);
            $stmt_log->bind_param("isssss", $row_id, $fromtable, $status, $user, $emp_id, $role);
            $stmt_log->execute();

            if ($stmt_log->errno) {
                $res['status'] = 'Error';
                $res['message'] = 'Database error: ' . $stmt_log->error;
            }
        }
    }
} else if ($action == 'get_active_count') {
    $sql = mysqli_query($conn, "SELECT SUM(CASE WHEN user_status = 'Active' THEN 1 ELSE 0 END) AS total_active, SUM(CASE WHEN user_status = 'In-Active' THEN 1 ELSE 0 END) AS total_inactive, COUNT(*) AS total_user FROM `userlogin`");
    $get_user = mysqli_fetch_assoc($sql);
    // print_r($get_user);
    $res['data'] = $get_user;


    $res['status'] = 'Ok';
} else if ($action == 'get_list') {
    $sql = mysqli_query($conn, "SELECT * FROM `userlogin` WHERE user_status = 'Active'");
    while ($get_user = mysqli_fetch_assoc($sql)) {
        $res['data'][] = $get_user;
    }

    $res['status'] = 'Ok';
} else {
    $res['status'] = 'Invalid Request';
}

echo json_encode($res);
