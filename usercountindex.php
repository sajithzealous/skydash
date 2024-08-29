<?php
include('db/db-con.php');

// Fetch total users
$query_total_users = "SELECT COUNT(*) AS total_users FROM `userlogin` WHERE `user_role` IN('user','TeamLeader','QA','QaTl')";
$result_total_users = mysqli_query($conn, $query_total_users);
$row_total_users = mysqli_fetch_assoc($result_total_users);
$total_users = $row_total_users['total_users'];

// Fetch active users
$query_active_users = "SELECT COUNT(*) AS active_users FROM `userlogin` WHERE `user_status` = 'active' AND `user_role` IN('user','TeamLeader','QA','QaTl')";
$result_active_users = mysqli_query($conn, $query_active_users);
$row_active_users = mysqli_fetch_assoc($result_active_users);
$active_users = $row_active_users['active_users'];

// Fetch inactive users
$query_inactive_users = "SELECT COUNT(*) AS inactive_users FROM `userlogin` WHERE `user_status` = 'inactive' AND `user_role` IN('user','TeamLeader','QA','QaTl')";
$result_inactive_users = mysqli_query($conn, $query_inactive_users);
$row_inactive_users = mysqli_fetch_assoc($result_inactive_users);
$inactive_users = $row_inactive_users['inactive_users'];

// Fetch role-based counts
$query_role_counts = "SELECT `user_role`, COUNT(*) AS role_count FROM `userlogin` WHERE `user_role` IN('user','TeamLeader','QA','QaTl') GROUP BY `user_role`";
$result_role_counts = mysqli_query($conn, $query_role_counts);
$role_counts = [];
while ($row = mysqli_fetch_assoc($result_role_counts)) {
    $role_counts[$row['user_role']] = $row['role_count'];
}

// Fetch today's logins
$current_date = date('Y-m-d');
$query_today_logins = "SELECT `role`, COUNT(*) AS login_count FROM `user_log` WHERE `log_date` = '$current_date' AND `status_2`='1' GROUP BY `role`";
$result_today_logins = mysqli_query($conn, $query_today_logins);
$today_logins = [];
while ($row = mysqli_fetch_assoc($result_today_logins)) {
    $today_logins[$row['role']] = $row['login_count'];
}
?>

 <style>
        .rewww {
            border: 1px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 10px;
            background: radial-gradient(274px at 7.4% 17.9%, rgb(44 69 209) 0.3%, rgb(94 65 179) 90.5%);

        }
       .rewww:hover {
            transform: rotate(3deg) translateY(-5px);
            box-shadow: 12px 12px 12px rgb(126, 87, 194,2);
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


    
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card position-relative">
                    <div class="card-body">
                        <h3 class="text-center mb-4">User Login Status</h3>
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-users"></i></div>
                                        <h5 class="card-title" style="color:white">Total Users</h5>
                                        <h2 class="card-text data-text"><?php echo $total_users; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-user-check"></i></div>
                                        <h5 class="card-title"style="color:white">Active Users</h5>
                                        <h2 class="card-text data-text"><?php echo $active_users; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-user-times"></i></div>
                                        <h5 class="card-title"style="color:white">Inactive Users</h5>
                                        <h2 class="card-text data-text"><?php echo $inactive_users; ?></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-laptop-code"></i></div>
                                        <h5 class="card-title" style="color:white">Coders</h5>
                                        <h3 class="card-text data-text"><?php echo isset($role_counts['user']) ? $role_counts['user'] : 0; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-users-cog"></i></div>
                                        <h5 class="card-title "style="color:white">Team Leaders</h5>
                                        <h3 class="card-text data-text"><?php echo isset($role_counts['TeamLeader']) ? $role_counts['TeamLeader'] : 0; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-user-shield"></i></div>
                                        <h5 class="card-title"style="color:white">QA Coders</h5>
                                        <h3 class="card-text data-text"><?php echo isset($role_counts['QA']) ? $role_counts['QA'] : 0; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-shield-alt"></i></div>
                                        <h5 class="card-title"style="color:white">QA Team Leaders</h5>
                                        <h3 class="card-text data-text"><?php echo isset($role_counts['QaTl']) ? $role_counts['QaTl'] : 0; ?></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-laptop-code"></i></div>
                                        <h5 class="card-title"style="color:white">Live Coders</h5>
                                        <h3 class="card-text data-text"><?php echo isset($today_logins['user']) ? $today_logins['user'] : 0; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-users-cog"></i></div>
                                        <h5 class="card-title"style="color:white">Live Team Leaders</h5>
                                        <h3 class="card-text data-text"><?php echo isset($today_logins['TeamLeader']) ? $today_logins['TeamLeader'] : 0; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-user-shield"></i></div>
                                        <h5 class="card-title"style="color:white">Live QA Coders</h5>
                                        <h3 class="card-text data-text"><?php echo isset($today_logins['QA']) ? $today_logins['QA'] : 0; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-4">
                                <div class="card rewww">
                                    <div class="card-body">
                                        <div class="icon"><i class="fas fa-shield-alt"></i></div>
                                        <h5 class="card-title"style="color:white">Live QA Team Leaders</h5>
                                        <h3 class="card-text data-text"><?php echo isset($today_logins['QaTl']) ? $today_logins['QaTl'] : 0; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



 
