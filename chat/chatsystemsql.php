<?php
session_start();
include('../db/db-con.php');

$role = $_SESSION['role'];
$empID = $_SESSION['empid'];
$username = $_SESSION['username'];

$action = isset($_GET['action']) ? $_GET['action'] : '';

$res = [];

if ($action == 'showingmessage') {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';



    $sqlshowingmessage = "SELECT `profile_pic`, `user_name` FROM `userlogin` WHERE `user_id`='$user_id'";

      $result=mysqli_query($conn,$sqlshowingmessage);


        $get_user = mysqli_fetch_assoc($result);
        $res['data'] = $get_user;
   
    }

    echo json_encode($res);
?>
