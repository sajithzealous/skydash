<?php
session_start();

include('../db/db-con.php');

if (isset($_POST['formData'])) {
    $formData = json_decode($_POST['formData'], true);

    // Check if all required data is provided
    if (isset($formData['userid'], $formData['password'], $formData['cpassword'], $formData['userrole'])) {
        $userid = $conn->real_escape_string($formData['userid']);
        $newPassword = $conn->real_escape_string($formData['password']);
        $cpassword = $conn->real_escape_string($formData['cpassword']);
        $userrole = $conn->real_escape_string($formData['userrole']);

        // Ensure the new password and confirmation password match
        if ($newPassword !== $cpassword) {
            echo json_encode(['success' => false, 'error' => 'New password and confirm password do not match']);
            exit();
        }

        // Retrieve the current password from the database
        $selectQuery = "SELECT `user_password` FROM `userlogin` WHERE `user_id`='$userid' AND `user_status`='Active'";
        $result = $conn->query($selectQuery);

        // Check if the user exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['user_password'];

            // Ensure the new password is different from the current password
            if ($newPassword !== $storedPassword) {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                // Set the timezone and get the current date
                date_default_timezone_set('America/New_York');
                $currentDate = date('Y-m-d');

                // Update the user's password and record the date of change
                $updateQuery = "UPDATE `userlogin` SET `user_password`='$newPassword', `hash_password`='$hashedPassword', `change_date`='$currentDate' WHERE `user_id`='$userid' AND `user_status`='Active'";

                if ($conn->query($updateQuery) === TRUE) {
                    echo json_encode(['success' => true, 'message' => 'Password updated successfully', 'user_role' => $userrole]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Update failed: ' . $conn->error]);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'New password cannot be the same as the old password']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'User not found or inactive']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Incomplete form data']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No form data received']);
}

$conn->close();
?>
