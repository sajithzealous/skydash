<?php
session_start();

include('../db/db-con.php');

if (isset($_POST['formData'])) {
    $formData = json_decode($_POST['formData'], true);
    
    // Fixed typo: $formData instead of $fromData
    if (isset($formData['userid'], $formData['password'], $formData['cpassword'], $formData['userrole'])) {
        $userid = $conn->real_escape_string($formData['userid']);
        $password = $conn->real_escape_string($formData['password']);
        $cpassword = $conn->real_escape_string($formData['cpassword']);
        $userrole = $conn->real_escape_string($formData['userrole']);
   
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Set the timezone and get the current date
        date_default_timezone_set('America/New_York');
        $currentDate = date('Y-m-d');

        // Update the user's password and record the date of change
        $updateQuery = "UPDATE `userlogin` SET `user_password`='$password', `hash_password`='$hashedPassword', `change_date`='$currentDate' WHERE `user_id`='$userid' AND `user_status`='Active'";
        
        if ($conn->query($updateQuery) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully', 'user_role' => $userrole]); // Moved 'user_role' inside the array
        } else {
            echo json_encode(['success' => false, 'error' => 'Update failed: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Incomplete form data']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No form data received']);
}

$conn->close();
?>
