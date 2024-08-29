<?php
// Set up error reporting and display errors for debugging (consider disabling in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and user session files
include('../db/db-con.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Retrieve the 'positionfourdata' from the POST data
$data = $_POST['positionfourdata'] ?? [];

// Validate and sanitize input
$grp1Values = [];
$grp2Values = [];
foreach ($data as $row) {
    $mitems = $row['mitems'] ?? '';
    $icd = $row['icd'] ?? '';

    if (!empty($icd) && !empty($mitems) && $mitems !== "M1021A") {
        // Use prepared statements to avoid SQL injection
        $comorbidityQuery = "SELECT `Comorbidity_group`, `Clinical_group` FROM `Codedescription` WHERE `ICD-10-code` = ?";
        $stmt = $conn->prepare($comorbidityQuery);
        $stmt->bind_param('s', $icd);
        $stmt->execute();

        // Check for errors during the execution of the prepared statement
        if ($stmt->error) {
            // Log the error and return a generic error response
            error_log('Database error: ' . $stmt->error);
            echo json_encode(['success' => false, 'error' => 'Database error']);
            exit;
        }

        $comorbidityQueryResult = $stmt->get_result();

        // Check if there are rows returned
        if ($comorbidityQueryResult->num_rows > 0) {
            $comorbidityQueryValue = $comorbidityQueryResult->fetch_assoc();

            // Extract text and numeric values using regular expression
            $posClinicalGroup = $comorbidityQueryValue['Clinical_group'];
            $posComorbidityGroup = $comorbidityQueryValue['Comorbidity_group'];

            $grp1Values[] = $posComorbidityGroup;
            $grp2Values[] = $posComorbidityGroup;
        }
        // Close the prepared statement
        $stmt->close();
    }
}

$resultArray = [];

if (!empty($grp1Values) && !empty($grp2Values)) {
    $placeholdersGrp1 = implode(",", array_map(function ($value) {
        return "'" . $value . "'";
    }, $grp1Values));

    $placeholdersGrp2 = implode(",", array_map(function ($value) {
        return "'" . $value . "'";
    }, $grp2Values));

    $inClause = "`grp_1` IN ($placeholdersGrp1) AND `grp_2` IN ($placeholdersGrp2)";

    $query = "SELECT * FROM `Comorbidity_grp_high` WHERE $inClause AND `status`='active'";
    $stmt = $conn->prepare($query);

    $stmt->execute();

    $positionfourvalue = $stmt->get_result();
    $rowed = $positionfourvalue->num_rows;

    if ($rowed > 0) {
        // Fetch the result and add it to the result array
        $positionfourvalue_d = $positionfourvalue->fetch_assoc();
        $positionfourvalue_d = "3";
        $resultArray[] = $positionfourvalue_d;
    } 


//     else {
//       foreach ($grp1Values as $grp1ValuesNew) {
//      $query2 = "SELECT * FROM `Comorbidity_grp_low` WHERE  `grp_1` = ? AND `status`='active'";
//     $stmt2 = $conn->prepare($query2);

//     if (!$stmt2) {
//         // Log the error and return a generic error response
//         error_log('Prepare statement error: ' . $conn->error);
//         echo json_encode(['success' => false, 'error' => 'Prepare statement error']);
//         exit;
//     }

//     $stmt2->bind_param('s', $grp1ValuesNew);
//     $stmt2->execute();

//     // Check for errors during the execution of the second prepared statement
//     if ($stmt2->error) {
//         // Log the error and return a generic error response
//         error_log('Database error: ' . $stmt2->error);
//         echo json_encode(['success' => false, 'error' => 'Database error']);
//         exit;
//     }

//     $positionfourvalue = $stmt2->get_result();
//     $rowed = $positionfourvalue->num_rows;

  
// }

//   if ($rowed > 0) {
//         // Fetch the result and add it to the result array
//         $positionfourvalue_d = $positionfourvalue->fetch_assoc();
//         $positionfourvalue_d ="2";
//         $resultArray[] = $positionfourvalue_d;
//     }

// // Output the JSON response



//     }
    else {
    foreach ($grp1Values as $grp1ValuesNew) {
        $query2 = "SELECT * FROM `Comorbidity_grp_low` WHERE `grp_1` = '$grp1ValuesNew' AND `status`='active'";
        $positionfourvalue = $conn->query($query2);

        if (!$positionfourvalue) {
            // Log the error and return a generic error response
            error_log('Query execution error: ' . $conn->error);
            echo json_encode(['success' => false, 'error' => 'Query execution error']);
            exit;
        }

        $rowed = $positionfourvalue->num_rows;

        if ($rowed > 0) {
            // Fetch the result and add it to the result array
            $positionfourvalue_d = $positionfourvalue->fetch_assoc();
            $positionfourvalue_d = "2"; // Not sure why you're setting this to "2"
            $resultArray[] = $positionfourvalue_d;
        }
    }
}

}
 
 $jsonResponse = json_encode($resultArray);
echo $jsonResponse;
// Close the database connection
$conn->close();
?>
