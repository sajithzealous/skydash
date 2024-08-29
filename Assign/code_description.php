<?php
// Database credentials
 include('../db/db-con.php');

// Check if 'icd' and 'gender' are set in the POST parameters
if (isset($_POST['icd'], $_POST['gender'])) {
    $icd = $_POST['icd'];
    $gender = $_POST['gender'];

    // Establish a database connection
    

    // Sanitize user input to prevent SQL injection
    $icd = $conn->real_escape_string($icd);
    $gender = $conn->real_escape_string($gender);

    // Prepare the SQL statement based on gender value
    if ($gender === 'male' || $gender === 'female') {
        $query = "SELECT * FROM `Codedescription` WHERE `ICD-10-code` = '$icd' AND (`Category`= '$gender' OR `Category`= '')";
    } else{
        $query = "SELECT * FROM `Codedescription` WHERE `ICD-10-code` = '$icd'";
    }

    // Execute the query
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $description = $row['Description'];
            $jsonResponse = json_encode(array('description' => $description));
            echo $jsonResponse;
        } else {
            echo json_encode(array('error' => 'No Data Given ICD Code Or Check Gender'));
        }
    } else {
        echo json_encode(array('error' => 'Query execution error: ' . $conn->error));
    }

    // Close the database connection
    $conn->close();
} else {
    // Output a message if 'icd' or 'gender' is not provided in the POST parameters
      echo json_encode(array('error' => 'ICD code or gender is not provided.'));
}
?>
