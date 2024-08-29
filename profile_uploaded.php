<?php
include('db/db-con.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action=$_GET['action'];
$emp_id = $_SESSION['empid'];

if($action=='pic'){

    // Check if a file was uploaded
    if(isset($_FILES['file'])) {
        // File upload directory
        $targetDir = "profilepic/";

        // Generate a unique filename to avoid overwriting existing files
        $fileName = uniqid() . "_" . basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;



        // Check if file is an actual image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
            // Move uploaded file to the desired directory
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                // Prepare and execute SQL query to update profile picture in the database
                $sql = "UPDATE `userlogin` SET `profile_pic` = '$targetFilePath' WHERE `user_id` = '$emp_id'";

                // Execute query
                $result = $conn->query($sql);
                
                if($result) {
                    echo "Profile picture updated successfully!";
                } else {
                    echo "Failed to update profile picture.";
                }
            } else {
                echo "Failed to upload file.";
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        echo "No file uploaded.";
    }
}
else{
    echo "notwork";
}
?>
