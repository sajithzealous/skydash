<?php
// Check if the 'action' parameter is set in the GET request, otherwise default it to an empty string
$action = $_GET['action'] ?? '';

// Include database connection
include('../db/db-con.php');

// Function to sanitize input
function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim(strip_tags($input)));
}

// Initialize response arrays
$agencyResponse = [];
$coderResponse = [];
$coderRationali = [];
$header = [];

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

                if ($status == 'QA WIP') {
                    // Assuming 'QA WIP' condition, proceed with further queries
                    $sqldatanew = "SELECT * FROM `oasis_qc_new` WHERE `Entry_id` = $Id";
                    $sqldataresult = $conn->query($sqldatanew);

                    if ($sqldataresult->num_rows > 0) {
                        while ($row = $sqldataresult->fetch_assoc()) {
                            // Store data from the row into response arrays
                            $agencyResponse[] = $row['Agency_response'];
                            $coderResponse[] = $row['Coder_response'];
                            $coderRationali[] = $row['Coder_rationali'];
                            $header[] = $row['header'];
                        }
                    } else {
                        // If no data found in 'oasis_qc_new', fallback to 'oasis_new'
                        $sqldatanew = "SELECT * FROM `oasis_new` WHERE `Entry_id` = $Id";
                        $sqldataresult = $conn->query($sqldatanew);

                        if ($sqldataresult->num_rows > 0) {
                            while ($row = $sqldataresult->fetch_assoc()) {
                                // Store data from the row into response arrays
                                $agencyResponse[] = $row['Agency_response'];
                                $coderResponse[] = $row['Coder_response'];
                                $coderRationali[] = $row['Coder_rationali'];
                                $header[] = $row['header'];
                            }
                        } else {
                            // If still no data found, fallback to a different table
                            $sql = "SELECT * FROM `ggmitemjson`";
                            $result = $conn->query($sql);

                            // If there are rows returned by the query, process them
                            if ($result) {
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        // Store data from the row into response arrays
                                        $agencyResponse[] = $row['json'];
                                        $coderResponse[] = $row['json'];
                                        $coderRationali[] = $row['json'];
                                        // Assuming 'header' is from this table as well
                                        $header[] = $row['header'];
                                    }
                                }
                            } else {
                                // Handle database error
                                echo "Error executing query: " . $conn->error;
                            }
                        }
                    }
                } else {
                    // Handle other status conditions if needed
                    echo "Status condition not handled.";
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
    'header' => $header
];

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

// If no data was found or action was not 'statusdata', return 404
http_response_code(404);
exit();
?>
