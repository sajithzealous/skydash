<?php
 include('../db/db-con.php');

if (isset($_GET['Id'])) {
    $Id = $_GET['Id'];

    // Fetch data from the database
    $sql = "SELECT `Id`, `Patient_Name` FROM `assign` WHERE Id = ?";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the 'id' parameter to the prepared statement
    $stmt->bind_param("i", $Id); // Assuming 'id' is an integer; use "s" for strings

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the data as an associative array
        $rowdata = mysqli_fetch_assoc($result);
        
        // Return the user data as JSON response
        header('Content-Type: application/json');
        echo json_encode($rowdata);
    } else {
        echo json_encode(array('error' => 'No data found for ID: ' . $Id));
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo json_encode(array('error' => 'No ID provided.'));
}
?>


