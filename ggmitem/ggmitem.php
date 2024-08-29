<?php
// Check if the 'action' parameter is set in the GET request, otherwise default it to an empty string
$action = $_GET['action'] ?? '';

// Include database connection
include('../db/db-con.php');

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

// Initialize response arrays
$agencyResponse = [];
$coderResponse = [];
$coderRationali = [];

// If the action is 'statusdata', fetch status based on provided Id
if ($action == 'statusdata') {
    // Check if Id is sent via POST
    if (isset($_POST['Id'])) {
        // Sanitize input
        $Id = sanitizeInput($_POST['Id']);

        // Prepare and execute SQL query
        $searchdata = "SELECT `status` FROM `Main_Data` WHERE `Id` = $Id";
        $searchdataresult = $conn->query($searchdata);

        // Check if query execution was successful
        if ($searchdataresult) {
            // Check if data is found
            if ($searchdataresult->num_rows > 0) {
                $row = $searchdataresult->fetch_assoc();
                $status = $row['status'];

                if ($status == 'WIP' || $status == 'PENDING' || $status == 'INPROGRESSION' || $status ='QA WIP') {
                    $sqldatanew = "SELECT * FROM `oasis_new` WHERE `Entry_id` = $Id";
                    $sqldataresult = $conn->query($sqldatanew);

                    if ($sqldataresult->num_rows > 0) {
                        while ($row = $sqldataresult->fetch_assoc()) {
                            // Store 'json' data from the row into response arrays
                            $agencyResponse[] = $row['Agency_response'];
                            $coderResponse[] = $row['Coder_response'];
                            $coderRationali[] = $row['Coder_rationali'];
                            $header[] = $row['header'];
                        }
                    } else {
                        $sql = "SELECT * FROM `ggmitemjson`";
                        $result = $conn->query($sql);

                        // If there are rows returned by the query, process them
                        if ($result) {
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Store 'json' data from the row into both response arrays
                                    $agencyResponse[] = $row['json'];
                                    $coderResponse[] = $row['json'];
                                    $qcrResponse[] = $row['json'];
                                }
                            }
                        } else {
                            // Handle database error
                            echo "Error executing query: " . $conn->error;
                        }
                    }
                }
            } else {
                // Handle case when no data found
                echo "No data found for Id: $Id";
            }
        } else {
            // Handle database error
            echo "Error executing query: " . $conn->error;
        }
    } else {
        // Handle missing Id parameter
        echo "Id parameter is missing";
    }
}

// Close database connection
$conn->close();

// Format data as JSON
$response = [
    'agencyResponse' => $agencyResponse,
    'coderResponse' => $coderResponse,
    'coderRationali' => $coderRationali,
    'header'=>$header
];

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

// If no data was found or action was not 'statusdata', return 404
http_response_code(404);
exit();
?>
