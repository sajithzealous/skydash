<?php
// Include database connection file
include('../db/db-con.php');

// Check if the 'Id' parameter is set in the POST request
if(isset($_POST['Id'])) {
    // Sanitize input to prevent SQL injection
    $Id = $conn->real_escape_string($_POST['Id']);

    try {
        // Prepare and execute query to fetch user data based on ID
        $query = "SELECT `timing`, `source`, `cpsccode`, `location`,`precodevalue`, `precodevaluemultiply`, `postcodevalue`, `postcodevaluemultiply`, `additionvalue`, `additionalvaluemultiply`, `User`, `coder_emp_id`, `timestamp` FROM `hhrgcodedata` WHERE `Entry_Id` = '$Id' ORDER BY `timestamp` DESC";
        $queryresult = $conn->query($query);

        // Check if query executed successfully and fetched data
        if($queryresult && $queryresult->num_rows > 0) {
            // Fetch the data
            $querydatashow = $queryresult->fetch_assoc();
            // Return the data as JSON
            echo json_encode($querydatashow);
        } else {
            // Handle the case when no data found for the given ID
            echo json_encode(array('error' => 'No data found for the provided ID.'));
        }
    } catch (Exception $e) {
        // Handle any exceptions
        echo json_encode(array('error' => 'Error: ' . $e->getMessage()));
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    // Handle the case when 'Id' parameter is not set
    echo json_encode(array('error' => 'ID not found.'));
}
?>
