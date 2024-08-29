<?php

session_start();
$user = $_SESSION['username'];
$role = $_SESSION['role'];
$emp_id = $_SESSION['empid'];

include('../db/db-con.php');

if ($action ='reallocationcomments') { // Use == for comparison, not =

    // Check if Id and message are set in the POST data
    if (isset($_POST['Id'], $_POST['message'])) {
        $Id = $_POST['Id'];
        $message = $_POST['message'];

        // Update the `Main_Data` table with the provided message
        $updatecodingcomments = "UPDATE `Main_Data` SET `coder_comments` ='$message' WHERE `Id`= '$Id'";

        // Execute the SQL query
        $updatemessageresult = $conn->query($updatecodingcomments);

        // Check if the query was successful
        if ($updatemessageresult) {
            $data = 'Reallocation comments updated';
        } else {
            $data = 'Error: ' . $conn->error; // Provide error message
        }
    } else {
        $data = 'Error: Id and message not provided'; // Handle missing data
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}

?>
