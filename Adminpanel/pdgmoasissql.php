<?php
// Error reporting setup
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('../db/db-con.php');

// Fetch user data
$userData = getUserData($conn);

// Output user data as JSON
header('Content-Type: application/json');
echo json_encode($userData);

// Output user counts
// echo "Active Users: {$userCounts['active_count']}<br>";
// echo "Inactive Users: {$userCounts['inactive_count']}<br>";
// echo "Total Users: {$userCounts['total_count']}<br>";

// Close connection
mysqli_close($conn);

// Function to fetch user data
function getUserData($conn) {
    $sql = "SELECT `Id`, `mitem_name` AS mitemname, `mitem`, `mitem_options` AS mitemoptions, `mitem_values` AS mitemvalue, `client`, `version`, `year`, `status`, `timestamp` FROM `Pdgmoasis` WHERE 1";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    } else {
        return array('error' => mysqli_error($conn));
    }
}

?>