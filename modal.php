<?php
 include('db/db-con.php');

// SQL query to select records with empty fields
$selectQuery = "SELECT * FROM `Dummy_Data` WHERE status='NEW' ";

// Prepare and execute the query
$stmt = $conn->prepare($selectQuery);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

// Get the result
$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Output JSON response
header('Content-Type: application/json');
echo json_encode(['success' => true, 'data' => $result]);

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
