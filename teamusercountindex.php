<?php
session_start();
include('db/db-con.php');

$username=$_SESSION['username'];
$empid=$_SESSION['empid'];
// echo $empid;

// Fetch total users
$query_total_users = "SELECT COUNT(*) AS total_users FROM `userlogin` WHERE `user_role` IN('user')";
$result_total_users = mysqli_query($conn, $query_total_users);
$row_total_users = mysqli_fetch_assoc($result_total_users);
$total_users = $row_total_users['total_users'];

// Fetch total users teamleader wise

$query_active_users = "SELECT COUNT(*) AS active_users FROM `coders` WHERE `team_emp_id` = '$empid' AND `category` = 'coder' AND `status` = 'Active'";
$result_active_users = mysqli_query($conn, $query_active_users);
$row_active_users = mysqli_fetch_assoc($result_active_users);
$active_users = isset($row_active_users['active_users']) ? $row_active_users['active_users'] : 0;


//Fetch Live Coders Data Team Wise

$current_date = date('Y-m-d');

$query_users = "
    SELECT `emp_id`
    FROM `user_log`
    WHERE `status_2` = '1'
      AND `log_date` = '$current_date'
      AND `role` = 'user'
";
$result_users = mysqli_query($conn, $query_users);

if ($result_users) {

    $emp_ids = [];
    while ($row = mysqli_fetch_assoc($result_users)) {
        $emp_ids[] = $row['emp_id'];
    }

    $emp_ids_str = implode("', '", $emp_ids);

    $query_count = "
        SELECT COUNT(*) AS coder_count
        FROM `coders`
        WHERE `coder_emp_id` IN ('$emp_ids_str') 
          AND `team_emp_id` = '$empid'
    ";

    $result_count = mysqli_query($conn, $query_count);

    if ($result_count) {
        $count_row = mysqli_fetch_assoc($result_count);
        $coder_count = isset($count_row['coder_count']) ? $count_row['coder_count'] : 0;
    } else {
        // Print the error if the query failed
        echo "Error fetching coder count: " . mysqli_error($conn);
    }
} else {
    // Print the error if the query failed
    echo "Error fetching users: " . mysqli_error($conn);
}

?>

 <style>
        .rewww {
            border: 1px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 10px;
            background-image: linear-gradient( 96.5deg,  rgba(39,103,187,1) 10.4%, rgba(16,72,144,1) 87.7% );


        }
       .rewww:hover {
            transform: rotate(3deg) translateY(-5px);
            box-shadow: 12px 12px 12px rgba(39,103,187,1);
        }
         .data-title {
            font-size: 1.1rem;
            color: white;
        }
        .data-text {
            font-size: 2rem;
            color:white;
        }
        .icon {
            font-size: 2rem;
            color: white;
            margin-bottom: 10px;
        }
     
      .card-body {
            padding: 20px;
        }
        .row {
            margin-left: -5px;
            margin-right: -5px;
        }
        .col-md-4, .col-md-3 {
            padding-left: 5px;
            padding-right: 5px;
        }
</style>


    
        <div class="row mt-4">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card position-relative">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Team User Status</h3>
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-users"></i></div>
                                        <h5 class="card-title" style="color:white">Total Coders</h5>
                                        <h2 class="card-text data-text"><?php echo $total_users; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-4">
                                        <div class="card rewww">
                                            <div class="card-body">
                                                <div class="icon"><i class="fas fa-laptop-code"></i></div>
                                                <h5 class="card-title" style="color:white">Team Coders</h5>
                                                <h3 class="card-text data-text"><?php echo $active_users; ?></h3>
                                            </div>
                                        </div>
                            </div>

                            <div class="col-md-4 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-laptop-code"></i></div>
                                        <h5 class="card-title"style="color:white">Team Live Coders</h5>
                                        <h3 class="card-text data-text"><?php echo $coder_count ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



 
