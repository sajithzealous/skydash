<?php
// Start session
session_start();

// Initialize variables with proper sanitization
$emp_id = filter_input(INPUT_SESSION, 'empid', FILTER_SANITIZE_STRING);
$Id = filter_input(INPUT_COOKIE, 'Id', FILTER_SANITIZE_STRING);

// Include database connection
include('../db/db-con.php');

// Check if totalHours is set in POST request
if (isset($_POST['totalHours'])) {
    // Get the total hours from the POST request and sanitize it
    $totalHours = filter_input(INPUT_POST, 'totalHours', FILTER_SANITIZE_STRING);

    // Ensure totalHours is not empty
    if (!empty($totalHours)) {
        // Fetch previous total working hours
        $selectQuery = "SELECT total_working_hours 
                        FROM Main_Data 
                        WHERE Id = '$Id'";

        $result = $conn->query($selectQuery);

        if ($result && $result->num_rows > 0) {
            // Fetch the row
            $row = $result->fetch_assoc();
            $previousHours = $row['total_working_hours'];

            // Convert previous total hours to seconds
            list($prevHours, $prevMinutes, $prevSeconds) = explode(':', $previousHours);
            $prevTotalSeconds = $prevHours * 3600 + $prevMinutes * 60 + $prevSeconds;

            // Convert current total hours to seconds
            list($currHours, $currMinutes, $currSeconds) = explode(':', $totalHours);
            $currentTotalSeconds = $currHours * 3600 + $currMinutes * 60 + $currSeconds;

            // Calculate new total hours in seconds
            $finalTotalSeconds = $prevTotalSeconds + $currentTotalSeconds;

            // Convert total seconds back to HH:MM:SS format
            $finalHours = floor($finalTotalSeconds / 3600);
            $finalMinutes = floor(($finalTotalSeconds - ($finalHours * 3600)) / 60);
            $finalSeconds = $finalTotalSeconds - ($finalHours * 3600) - ($finalMinutes * 60);

            $final = sprintf('%02d:%02d:%02d', $finalHours, $finalMinutes, $finalSeconds);
        } else {
            // If no previous record found, set $final to $totalHours
            $final = $totalHours;
        }

        // Update the total working hours in Main_Data table
        $updateQuery = "UPDATE Main_Data 
                        SET total_working_hours = '$final' 
                        WHERE Id = '$Id'";
        
        // Execute the update query
        if ($conn->query($updateQuery) === TRUE) {
            // If update is successful, prepare success response
            $response['success'] = true;
            $response['message'] = "Total working time updated successfully";
        } else {
            // If update fails, prepare error response
            $response['success'] = false;
            $response['error'] = "Error updating record: " . $conn->error;
        }
    } else {
        // If totalHours is empty, prepare error response
        $response['success'] = false;
        $response['error'] = "Total hours cannot be empty";
    }

    // Send JSON response
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
