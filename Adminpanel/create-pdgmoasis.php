<?php
    include('../db/db-con.php');

    $action = $_GET['action'];
    $res = [];
    $dateTime = date('Y-m-d H:i:s');


    if($action == 'create')
    {
        $Grpone = $_GET['Grpone'];
        $Year = $_GET['Year'];
        $status = $_GET['status'];

        $sql = mysqli_query($conn, "SELECT * FROM `Comorbidity_grp_low` WHERE `grp_1`='$Grpone' AND `status`='$status' AND `active_year`='$Year'");
        if ($check = mysqli_fetch_assoc($sql)) 
        {
            $res['status'] = 'Available';
        } 
        else 
        {
           $sql1 = "INSERT INTO `Comorbidity_grp_low`(`grp_1`, `status`, `active_year`, `timestamp`) VALUES ('$Grpone','$status','$Year','$dateTime')";

 

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
    mysqli_query($conn, "UPDATE `Pdgmoasis` SET `status`='$status' WHERE Id = '$row_id'");

    // Prepare the response
    $res['status'] = 'Ok';
}

    else if($action == 'get_active_count')
    {
        $sql = mysqli_query($conn, "SELECT 
    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS total_active, 
    SUM(CASE WHEN status = 'In-Active' THEN 1 ELSE 0 END) AS total_inactive, 
    COUNT(*) AS total 
FROM 
    `Pdgmoasis`;
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