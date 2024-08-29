<?php

session_start();


$role = $_SESSION['role'];
$empID = $_SESSION['empid'];
$username = $_SESSION['username'];

// $group = $_SESSION['group'];
$today_date = date('Y-m-d');
// echo $today_date;

include('db/db-con.php');



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Add Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">




    <title>Chat</title>


</head>

<style>
        /* General styles */


        .container {
            max-width: 100%;
            margin: 20px 20px;
            padding: 10px;
            background-color: #353389;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Sidebar styles */
        .chat-sidebar {
            background-color: #f8f9fa;
            position: absolute;
            /* margin-left: -20px; */
            /* Adjust as needed */
            width: 100px;
            /* Adjust width as needed */
            height: 100%;
            overflow-y: auto;
            border-radius: 15px;
            /* Enable scrolling for sidebar */
        }

        .chat-sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            background-color: #f8f9fa;
        }

        .chat-sidebar-header .avatar {
            width: 50px;
            height: 50px;
            overflow: hidden;
            border-radius: 50%;
        }

        .chat-sidebar-header .avatar img {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }

        .chat-sidebar-header .dropdown-toggle {
            color: #333;
        }

        .chat-sidebar-header .dropdown-menu {
            min-width: 150px;
        }

        .chat-sidebar-header .nav-link {
            border: none;
            color: #555;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .chat-sidebar-header .nav-link.active {
            background-color: #ffffff;
            border-bottom: 2px solid #007bff;
            color: #007bff;
        }

        .chat-sidebar-header .nav-tabs {
            border-bottom: none;
        }

        .chat-sidebar-header form {
            margin-top: 20px;
        }

        .chat-sidebar-header .input-group {
            width: 100%;
            max-width: 300px;
        }

        .chat-sidebar-header .form-control {
            border-radius: 25px;
        }

        .chat-sidebar-header .input-group-append button {
            border-radius: 25px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
        }

        .chat-sidebar-header .input-group-append button:hover {
            background-color: #0056b3;
        }

        .chat-sidebar-content {
            height: calc(100% - 180px);
            /* Adjust height based on your layout */
            overflow-y: auto;
            /* Enable scrolling for sidebar content */
        }

        .chat-lists {
            padding: 10px;
        }

        .list-group-item {
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f0f0f0;
            /* Hover color */
        }

        .list-group-item .avatar {
            width: 50px;
            height: 50px;
            overflow: hidden;
            border-radius: 50%;
        }

        .list-group-item .avatar img {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }

        .list-group-item h6 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .list-group-item .text-muted {
            font-size: 14px;
        }

        .list-group-item .badge {
            font-size: 12px;
            padding: 5px 10px;
        }

        @media (max-width: 768px) {
            .chat-sidebar {
                margin-left: 0;
                width: 100%;
                height: auto;
            }

            .chat-sidebar-header .nav-tabs {
                flex-wrap: wrap;
            }

            .chat-sidebar-header .nav-tabs .nav-link {
                flex: 1 0 50%;
            }

            .chat-sidebar-content {
                height: auto;
            }
        }

        /* Chat content styles */
        .col-lg-8.chat-content {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            margin-left: -1px;
            /* Adjust as needed */
        }

        /* Empty chat block styles */
        .chat-empty {
            text-align: center;
            padding: 50px 0;
        }

        .chat-empty img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .chat-empty .lead {
            font-size: 1.5rem;
            color: #6c757d;
        }

        .chat-empty .btn-primary.create_new_chat {
            font-size: 1rem;
        }

        /* Chat header styles */
        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #0056b3;
        }

        .chat-header .avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .chat-header .chat_topbar_name {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .chat-header .chat_topbar_role {
            color: #f0ad4e;
        }

        .chat-header ul.nav {
            margin: 0;
        }

        .chat-header ul.nav li {
            display: inline-block;
            margin-right: 10px;
        }

        .chat-header ul.nav li a {
            color: #fff;
        }

        .chat-header ul.nav li a:hover {
            color: #ccc;
        }

        .chat-header .mobile-chat-close-btn {
            display: none;
        }

        /* Messages styles */
        .messages {
            padding: 20px;
            max-height: 400px;
            overflow-y: auto;
        }

        .messages .message-item {
            margin-bottom: 15px;
            clear: both;
        }

        .messages .message-item-content {
            background-color: #f0f0f0;
            padding: 10px 15px;
            border-radius: 10px;
            clear: both;
            max-width: 70%;
            word-wrap: break-word;
        }

        .messages .me .message-item-content {
            background-color: #007bff;
            color: #fff;
        }

        .messages .time {
            display: block;
            clear: both;
            font-size: 0.8rem;
            color: #999;
        }

        .messages .message-item-divider {
            text-align: center;
            margin: 15px 0;
            clear: both;
            font-size: 0.9rem;
            color: #999;
        }

        .messages .message-item-divider span {
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .messages .message-media img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 10px;
        }

        /* Chat footer styles */
        .chat-footer {
            padding: 15px 20px;
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
        }

        .chat-footer input[type="text"] {
            width: calc(100% - 100px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin-right: 10px;
        }

        .chat-footer input[type="file"] {
            display: none;
        }

        .chat-footer .chat-footer-buttons {
            float: right;
        }

        .chat-footer .chat-footer-buttons button {
            margin-left: 5px;
            padding: 8px 15px;
            border-radius: 20px;
            color: #fff;
        }

        .chat-footer .chat-footer-buttons button#attach_btn {
            background-color: #007bff;
            border: 1px solid #007bff;
        }

        .chat-footer .chat-footer-buttons button#attach_btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .chat-footer .chat-footer-buttons button#send_message_btn {
            background-color: #28a745;
            border: 1px solid #28a745;
        }

        .chat-footer .chat-footer-buttons button#send_message_btn:hover {
            background-color: #218838;
            border-color: #218838;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .chat-header .mobile-chat-close-btn {
                display: block;
            }

            .messages {
                max-height: 300px;
            }
        }

        @media (max-width: 767.98px) {
            .container {
                padding: 10px;
            }

            .chat-footer input[type="text"] {
                width: calc(100% - 80px);
            }
        }

        @media (max-width: 575.98px) {
            .chat-footer input[type="text"] {
                width: calc(100% - 70px);
            }
        }
    </style>

<body>
    <div class="container-scroller">
        <!-- Navbar -->
        <?php include 'include_file/profile.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <?php include 'include_file/sidebar.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="container">

                        <div class="content-body">
                            <!-- Content -->
                            <div class="content" style="padding-top:40px;">
                                <div class="row no-gutters chat-block">
                                    <!-- Chat sidebar -->
                                    <div class="col-lg-4 chat-sidebar">

                                        <!-- Sidebar search -->
                                        <div class="chat-sidebar-header">
                                            <div class="d-flex">
                                                <div class="pr-3">
                                                    <div class="avatar">
                                                        <img src="<?php echo $profile_pic ?>" class="rounded-circle" alt="image">
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="mb-0"><?php echo $empID; ?></p>
                                                    <p class="m-0 small text-muted"><?php echo $role; ?></p>
                                                </div>
                                               <div class="ml-auto">
                                                <div class="notification">
                                                <i class="fa-regular fa-bell"></i>
                                                </div>
                                                    <div class="dropdown">
                                                        <a href="#" data-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="profile.html">Profile</a>
                                                            <a class="dropdown-item" href="user-edit.html">Edit</a>
                                                            <a class="dropdown-item" data-sidebar-target="#settings" href="#">Settings</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Chat search">
                                                    <div class="input-group-append">
                                                        <button class="btn" type="button">
                                                            <i class="ti-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <ul class="nav nav-tabs text-center my-3" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> <i class="fa-solid fa-comments"></i> Chats</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="fa-solid fa-user-group"></i> Groups</button>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- ./ Sidebar search -->

                                        <!-- Chat list -->
                                        <div class="chat-sidebar-content">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                    <div class="chat-lists">
                                                        <div class="list-group list-group-flush">
                                                            <?php
                                                            $sql = mysqli_query($conn, "SELECT user_id, MAX(timestamp) AS last_timestamp, MAX(message) AS message, chat_type
                                                                FROM (
                                                                    SELECT send_to_id AS user_id, timestamp, message, chat_type
                                                                    FROM chat_data
                                                                    WHERE send_by_id = '$empID' AND chat_type = 'Individual'
                                                                    UNION
                                                                    SELECT send_by_id AS user_id, timestamp, message, chat_type
                                                                    FROM chat_data
                                                                    WHERE send_to_id = '$empID' AND chat_type = 'Individual'
                                                                ) AS combined_data
                                                                GROUP BY user_id, chat_type
                                                                ORDER BY last_timestamp DESC");

                                                            while ($get_grp = mysqli_fetch_assoc($sql)) {
                                                                $usr_id = $get_grp['user_id'];
                                                                if ($get_grp['chat_type'] != "Group") {
                                                                    // Fetch user details including profile_pic
                                                                    $query = mysqli_query($conn, "SELECT * FROM `userlogin` WHERE user_id = '$usr_id'");
                                                                    $get_user = mysqli_fetch_assoc($query);
                                                                    $usr_name = $get_user['user_name'];
                                                                    $profile_pic = $get_user['profile_pic']; // Assuming profile_pic is fetched from database
                                                                } else {
                                                                    $usr_name = $get_grp['user_id']; // Assuming group_name here instead of user_id
                                                                    $profile_pic = "assets/media/image/user/man_avatar2.jpg"; // Default image for groups
                                                                }

                                                                // Fetch last message for the user or group
                                                                $query = mysqli_query($conn, "SELECT * FROM `chat_data` WHERE send_by_id = '$usr_id' OR send_to_id = '$usr_id' ORDER BY `id` DESC LIMIT 1");
                                                                $get_last_msg = mysqli_fetch_assoc($query);
                                                            ?>
                                                                <a href="#" class="list-group-item d-flex align-items-center grp_message_row datamessage" data-grp_id="<?php echo $get_grp['user_id']; ?>" data-grp_type="<?php echo $get_grp['chat_type']; ?>" data-chat_name="<?php echo $usr_name; ?>" >
                                                                    <div class="pr-3">
                                                                        <?php
                                                                        // Determine online status
                                                                        $online_mark = 'danger';
                                                                        $chck_on_sql = mysqli_query($conn, "SELECT * FROM `user_log` WHERE log_date = '$today_date' AND emp_id = '$usr_id'");
                                                                        if ($chck_online = mysqli_fetch_assoc($chck_on_sql)) {
                                                                            if ($chck_online['status_2'] == 1) {
                                                                                $online_mark = 'success';
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <div class="avatar avatar-state-<?php echo $online_mark; ?>">
                                                                            <img src="<?php echo $profile_pic; ?>" class="rounded-circle" alt="image">
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-1"><?php echo $usr_name; ?> </h6>
                                                                        <span class="text-muted"><?php echo $get_last_msg['message']; ?></span>
                                                                    </div>
                                                                    <div class="text-right ml-auto d-flex flex-column">
                                                                        <?php
                                                                        // Display unread message count
                                                                        $sql_red = mysqli_query($conn, "SELECT COUNT(*) AS total_unread FROM `chat_data` WHERE send_to_id = '$emp_id' AND send_by_id = '$usr_id' AND read_status = 'Unread'");
                                                                        $get_unread_count = mysqli_fetch_assoc($sql_red);

                                                                        if ($get_unread_count['total_unread'] > 0) {
                                                                            echo '<span class="badge badge-success badge-pill ml-auto mb-2">' . $get_unread_count["total_unread"] . '</span>';
                                                                        }
                                                                        ?>
                                                                        <span class="small text-muted"><?php echo date('H:i A', strtotime($get_grp['last_timestamp'])); ?></span>
                                                                    </div>
                                                                </a>
                                                            <?php
                                                            };
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- ./ Chat list -->

                                    </div>
                                    <!-- ./ Chat sidebar -->

                                    <!-- Chat content -->
                                    <div class="col-lg-8 chat-content no-chat-selected">
                                        <!-- Chat empty block -->
                                        <!-- <div class="chat-empty">
                                            <img src="assets/media/svg/empty_chat.svg" alt="...">
                                            <p class="lead text-muted mt-3">Choose a chat</p>
                                            <button class="btn btn-primary create_new_chat">
                                                <i class="ti-plus mr-2"></i> New Chat
                                            </button>
                                        </div> -->
                                        <!-- ./Chat empty block -->

                                        <!-- Chat header -->
                                        <div class="chat-header">
                                            <div class="d-flex align-items-center">
                                                <div class="pr-3">
                                                    <div class="avatar avatar-state-warning">

                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="mb-0 chat_topbar_name"></p>
                                                    <div class="m-0 small chat_topbar_role"></div>
                                                </div>
                                                <div class="ml-auto">
                                                    <ul class="nav align-items-center">
                                                        <li class="mr-4 d-sm-inline d-none">
                                                            <a href="#" title="Start Video Call" data-toggle="tooltip">
                                                            <i class="fa-solid fa-video"></i>
                                                            </a>
                                                        </li>
                                                        <li class="mr-4 d-sm-inline d-none">
                                                            <a href="#" title="Start Voice Call" data-toggle="tooltip">
                                                            <i class="fa-solid fa-phone"></i>
                                                            </a>
                                                        </li>
                                                        <li class="ml-4 mobile-chat-close-btn">
                                                            <a href="#" class="btn btn-sm btn-danger">
                                                            <i class="fa-solid fa-xmark"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./ Chat header -->

                                        <!-- Messages -->
                                        <div class="messages">
                                            <div class="message-item">
                                                <div class="message-item-content">Hi!</div>
                                                <span class="time small text-muted font-italic">02:30 PM</span>
                                            </div>
                                            <div class="message-item me">
                                                <div class="message-item-content">Lorem ipsum dolor sit amet, consectetur
                                                    adipisicing elit.
                                                    Exercitationem fuga iure iusto libero, possimus quasi quis repellat sint tempora
                                                    ullam!
                                                </div>
                                                <span class="time small text-muted font-italic">Yesterday</span>
                                                </div>

                                        </div>
                                        <!-- ./ Messages -->

                                        <!-- Chat footer -->
                                        <div class="chat-footer">
                                            <div class="d-flex">

                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" placeholder="Write your message" id="cdg_chat_input">
                                                    <input type="file" class="form-control d-none" id="cdg_attach_input">
                                                </div>
                                                <div class="chat-footer-buttons d-flex">
                                                    <!-- <input type="file" name="" id="attachment" hidden> -->
                                                    <button class="btn btn-outline-light" type="button" id="attach_btn" title="Attach files" data-toggle="tooltip">
                                                    <i class="fa-solid fa-file-import"></i>
                                                    </button>
                                                    <button class="btn btn-outline-light d-none" type="button" id="msg_btn" title="Message" data-toggle="tooltip">

                                                    </button>
                                                    <button data-send_to="" class="btn btn-primary" type="submit" id="send_message_btn" data-message_type="text">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./ Chat footer -->
                                    </div>

                                    <!-- ./ Chat content -->
                                </div>
                            </div>
                            <!-- ./ Content -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="chatCreate" tabindex="-1" role="dialog" aria-labelledby="chatCreateTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chatCreateTitle">Create New Chat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 py-4 m-auto" style="width:250px;">
                        <img src="https://logowik.com/content/uploads/images/chat3893.logowik.com.webp" class="text-center" alt="chat">
                    </div>
                    <div class="row">
                        <div class="col-6 type_sec">
                            <div class="form-group">
                                <label for="">Chat Type</label>
                                <select name="" id="chat_type" class="form-control">
                                    <option value="Individual">Individual</option>
                                    <option value="Group">Group</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 mode_sec">
                            <div class="form-group">
                                <label for="">Chat mode</label>
                                <select name="" id="chat_mode" class="form-control">
                                    <option value="Public">Public</option>
                                    <option value="Private">Private</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 group_name_sec d-none">
                            <div class="form-group">
                                <label for="">Group Name</label>
                                <input type="text" name="" id="grp_name" class="form-control">

                            </div>
                        </div>
                        <div class="col-6 group_desc_sec d-none">
                            <div class="form-group">
                                <label for="">Group Description</label>
                                <input type="text" name="" id="grp_desc" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 members_sec">
                            <div class="form-group">
                                <label for="">Choose Member</label>
                                <select name="[]" id="chat_members" class="">
                                    <!-- <option value="">-- Choose Memeber --</option> -->
                                    <?php
                                    $usr = mysqli_query($conn, "SELECT * FROM users WHERE status = 'Active'");
                                    while ($get_usr = mysqli_fetch_assoc($usr)) {

                                    ?>
                                        <option value="<?php echo $get_usr['emp_id']; ?>"><?php echo $get_usr['username']; ?>
                                        </option>
                                    <?php }; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center m-auto">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary" id="create_chat_btn">Create</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <!-- Add jQuery (required for Bootstrap JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Add Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php $random=rand(0000,9999); ?>
    <script src="chat/js/chatsystem.js?<?php echo $random ; ?> "></script>


 
</body>

</html>