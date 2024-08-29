<?php
// Include your database connection code here
include('db.php');

// Fetch data from the database
$sql = "SELECT * FROM `data`"; // Replace 'your_table' with your actual table name
$result = $con->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
        echo "hello dear";
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$con->close();
?>
