<?php
// Include database connection file
include('../db/db-con.php');

// Initialize an empty array to store URLs
$urls = array();

// Check if the 'id' parameter is set in the URL
$userId = $_POST['Id'];

// echo $userId;

// Check if the user ID is set
if ($userId) {
    try {
        // Prepare and execute query to fetch user data based on ID
        $query = "SELECT * FROM `total_case_mix` WHERE `Entry_Id` = ? ORDER BY `Time_stamp` DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $userId); // Bind parameters to the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user data is fetched successfully
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Store user's Total_Case_Mix value
            $Casemix = $row['Total_Case_Mix'];
        }

        echo $Casemix;

        // Close the statement
        $stmt->close();
    } catch (Exception $e) {
        // Handle any exceptions
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    // Handle the case when user ID is not set
    // (This block can be used to redirect, show an error message, or perform any other action)
    // For example:
    echo "User ID not found.";
}
?>
