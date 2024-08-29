<?php
    include('../db/db-con.php');
      session_start();

    $action = $_GET['action'];
    $res = [];
    $dateTime = date('Y-m-d H:i:s');


        $user = $_SESSION['username'] ?? null;
        $emp_id = $_SESSION['empid'] ?? '';
        $role = $_SESSION['role'] ?? '';


    if($action == 'create')
    {
        $Pendingreason = $_GET['Pendingreason'];
        $PendingreasonStatus = $_GET['PendingreasonStatus'];

        if($PendingreasonStatus =='Active'){


            $PendingreasonStatus ='active';


        }
    

        $sql = mysqli_query($conn, "SELECT * FROM `Pendingreason` WHERE `Pendingreason` = '$Pendingreason'");
        if ($check = mysqli_fetch_assoc($sql)) 
        {
            $res['status'] = 'Available';
        } 
        else 
        {
           $sql1 = "INSERT INTO `Pendingreason`(`Pendingreason`, `status`, `created_time`) VALUES ('$Pendingreason','$PendingreasonStatus','$dateTime')";

            // Execute SQL queries
            $result1 = mysqli_query($conn, $sql1);


            // Check if both queries were successful
            if ($result1) {
                $res['status'] = 'Ok'; 
            } else {
                $res['status'] = 'Error'; 
            }
                }

    }
    else if ($action == 'update_status') {
            // Retrieve parameters from the request
            $row_id = $_GET['row_id'];
            $status = $_GET['status'];



            // Update user status in the userlogin table
            mysqli_query($conn, "UPDATE `Pendingreason` SET `status`='$status' WHERE id = '$row_id'");

            // Prepare the response
            $res['status'] = 'Ok';


            $fromtable = 'Pendingreason';
 
            $insertQuery = "INSERT INTO `Ai-log`(`source_Id`, `from-table`, `status`, `user_name`, `emp_id`, `role`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($insertQuery);
            $stmt_log->bind_param("isssss", $row_id, $fromtable, $status, $user, $emp_id, $role);
            $stmt_log->execute();

            if ($stmt_log->errno) {
                $res['status'] = 'Error';
                $res['message'] = 'Database error: ' . $stmt_log->error;
            }
    }

    else if($action == 'get_active_count')
    {
        $sql = mysqli_query($conn, "SELECT 
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS total_active, 
            SUM(CASE WHEN status = 'In-Active' THEN 1 ELSE 0 END) AS total_inactive, 
            COUNT(*) AS total 
            FROM 
                `Pendingreason`;
            ");
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