<?php
include 'logsession.php';
session_start();
include('../db/db-con.php');



$action=$_GET['action'];

if($action=='showquery'){

    if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];

    // Prepare the SQL query
    $sql = "SELECT `Id`, `alloted_team`, `agency`, `patient_name`, `phone_number`, `mrn`, `status`, `alloted_to_coder`, `insurance_type`, `assesment_type`, `assesment_date` 
            FROM Main_Data 
            WHERE `status` = 'NEW' AND `log_time` >= ? AND `log_time` <= ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters to the prepared statement
        $fromdate .= ' 00:00:00';
        $todate .= ' 23:59:59';
        $stmt->bind_param('ss', $fromdate, $todate);

        // Execute the prepared statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch data and store it in an array
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($data);

        // Close the prepared statement
        $stmt->close();
    } else {
        // Handle SQL preparation error
        echo json_encode(array('error' => 'Failed to prepare the SQL statement.'));
    }

    // Close the database connection
    $conn->close();
} else {
    echo json_encode(array('error' => 'Invalid request. Please provide fromdate and todate.'));
}
}

if ($action == 'updatequery') {
    if (isset($_POST['itemId'], $_POST['promptValue'])) {
        $itemId = $_POST['itemId'];
        $promptValue = $_POST['promptValue'];
        $status = 'ON HOLD'; // Add a semicolon to end the statement
        date_default_timezone_set('America/New_York');
        $currentDateTime = date('Y-m-d H:i:s');

        $promptValue = $conn->real_escape_string($promptValue);

        // Prepare the SQL query
        $sql = "UPDATE `Main_Data` SET `status` = '$status', `mis_comments` = '$promptValue',`File_Status_Time`= '$currentDateTime' WHERE `Id` = '$itemId'";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            // Query executed successfully
            echo json_encode("Success");
        } else {
            // Error in executing the query
           echo json_encode("Error");
        }

        // Close the connection
        $mysqli->close();
    } else {
        // Handle the case where either itemId or promptValue is not set
        // You might want to add error handling or logging here
    }
} else {
    // Handle the case where $action is not 'updatequery'
    // You might want to add error handling or logging here
}

?>


 
 
