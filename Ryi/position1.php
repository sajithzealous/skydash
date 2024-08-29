<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and user session files
include('../db/db-con.php');


// Start the session
session_start();

// Check if the 'timing' and 'source' parameters are set in the POST request
if (isset($_POST['timing'], $_POST['source'])) {
    // Assign values from POST parameters to variables
    $timing = $_POST['timing'];
    $source = $_POST['source'];

    // Prepare and execute the SQL query
    $query = "SELECT `value` FROM `Position_1` WHERE `source`='$source' AND `timing`='$timing'";
    $result = $conn->query($query);

    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

      if ($row) {
        // Access the 'value' column from the result
        $position1value = $row['value'];

        $position1value=intval($position1value);
        
       
    } else {
        // No matching row found
        echo "No matching record found for the given conditions.";
    }

    // Encode the result as JSON and echo the response
    $jsonResponse = json_encode($position1value);
    echo $jsonResponse;

    // Close the database connection
    $conn->close();
}
?>
