<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 include('../db/db-con.php');
$userId = $_COOKIE['Id'];
$emp_id = $_SESSION['empid'];


$response = []; // Initialize an array to hold the response


if ($userId) {
    try {
        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepared statement with placeholder
        $query = "SELECT * FROM `Main_Data` WHERE `Id` = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $main = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                // Create an associative array for each row
                $main_rowData = [
                    'Id' => $row['Id'],
                    'patient_name' => $row['patient_name'],
                    'phone_number' => $row['phone_number'],
                    'mrn' => $row['mrn'],
                    'agency' => $row['agency'],
                    'assesment_date' => $row['assesment_date'],
                    'assesment_type' => $row['assesment_type'],
                    'insurance_type' => $row['insurance_type'],
                    'url' => $row['url'],
                    'alloted_to_coder' => $row['alloted_to_coder'],

                    'qc_person' => $row['qc_person'],
                ];

                // Append the row qc_data to the $qc_data array
                $main[] = $main_rowData;
            }
        }

        // Add Codesegementqc data to the response array
        $response['personal_details'] = [
            'data' => $main,
        ];

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// QC Coding Segement


if ($userId) {
    try {
        // Database connection parameters

        // Codesegementqc data retrieval
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Function to prepare and execute a query
        function executeQuery($conn, $query, $params = null)
        {
            $stmt = $conn->prepare($query);
            if ($stmt === false) {
                die("Error preparing query: " . $conn->error);
            }

            if ($params !== null) {
                $stmt->bind_param(...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            return $result;
        }


        // Example query to fetch user data from Codesegementqc table
        $qc_query = "SELECT * FROM `Codesegementqc` WHERE `Entry_Id` = ? AND `status`='Qc_review' AND `Error_type` != 'Deleted' ORDER BY `M_Item`";
        $qc_result = executeQuery($conn, $qc_query, ['i', $userId]);

        // Fetch user data from Codesegementqc table
        $qc_data = [];

        if ($qc_result->num_rows > 0) {
            while ($qc_row = $qc_result->fetch_assoc()) {
                      $qc_rowData = [
                    'Id' => $qc_row['Id'],
                    'MItems' => $qc_row['M_Item'],
                    'Icd' => $qc_row['ICD-code'],
                    'Description' => $qc_row['Description'],
                    'Effective_Date' => $qc_row['Effective_Date'],
                    'Eo' => $qc_row['Eo'],
                    'Rating' => $qc_row['Rating'],
                    'Reason' => $qc_row['Error_reason'],
                    'Errortype' => $qc_row['Error_type'],
                    'Qcrationaile' => $qc_row['Qc_rationali'],
                ];

                // Append the row qc_data to the $qc_data array
                $qc_data[] = $qc_rowData;
            }
        } else {
            // If no rows found in Codesegementqc, fall back to Codesegement table
            $qc_query = "SELECT * FROM `Codesegement` WHERE `Entry_Id` = ? AND `Coderchecked`='Coder'ORDER BY `M-Items`";
            $qc_result = executeQuery($conn, $qc_query, ['i', $userId]);

            // Fetch user data from Codesegement table
            $qc_data = [];

            if ($qc_result->num_rows > 0) {
                while ($qc_row = $qc_result->fetch_assoc()) {
                    // Create an associative array for each qc_row
                    $qc_rowData = [
                        'Id' => $qc_row['Id'],
                        'MItems' => $qc_row['M-Items'],
                        'Icd' => $qc_row['ICD-code'],
                        'Description' => $qc_row['Description'],
                        'Effective_Date' => $qc_row['Effective_Date'],
                        'Eo' => $qc_row['Eo'],
                        'Rating' => $qc_row['Rating'],
                    ];

                    // Append the row qc_data to the $qc_data array
                    $qc_data[] = $qc_rowData;
                }
            }
        }

   //================================================================ coder and qc comments in codsegment =================================================================
     function getCodingComments($conn, $tableName, $userId) {
    $codingCommentsQuery = "SELECT `coding_comments` FROM `$tableName` WHERE `Entry_Id` = ? AND `coding_comments` IS NOT NULL AND `coding_comments` != '' LIMIT 1";
    $codingCommentsResult = executeQuery($conn, $codingCommentsQuery, ['i', $userId]);

    // Initialize an empty string to hold the comments
    $coding_comments = "";

    // Check if the query was successful
    if ($codingCommentsResult) {
        // Fetch each row
        while ($row = $codingCommentsResult->fetch_assoc()) {
            // Append the coding_comments to the string
            $coding_comments .= $row['coding_comments'] . "<br>"; // Add a line break after each comment
        }
    }

    return $coding_comments;
}

// Get coding comments from Codesegementqc
$qc_coding_comments = getCodingComments($conn, 'Codesegementqc', $userId);

// If no coding comments found in Codesegementqc, fall back to Codesegement table
if (empty($qc_coding_comments)) {
    $qc_coding_comments = getCodingComments($conn, 'Codesegement', $userId);
}

// Add Codesegementqc data to the response array
$response['Codesegementqc'] = [
    'data' => $qc_data,
    'coding_comments' => $qc_coding_comments,
];


// ================================================================ coder and qc comments in codsegment =================================================================

        // Close the main connection
        $conn->close();
    } catch (Exception $e) {
        // Handle exceptions and add an error message to the response array
        $response['error'] = "Error: " . $e->getMessage();
    }
}


// QC Oasis Segement

if ($userId) {
    try {
        // oasisqc database connection parameters
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Example query to fetch user data from oasisqc table
        $qc_query = "SELECT * FROM `oasisqc` WHERE `Agency_response` != `Qc_response` AND`Entry_Id` = ? AND `Error_type` != 'Deleted' ";
        $qc_stmt = $conn->prepare($qc_query);

        // Bind parameters and execute query
        $qc_stmt->bind_param('i', $userId);
        $qc_stmt->execute();
        $qc_result = $qc_stmt->get_result();

        // Fetch user data from oasisqc table
        $qc_data1 = [];

      
        if ($qc_result->num_rows > 0) {
    while ($qc_row = $qc_result->fetch_assoc()) {
       
        if ($qc_row['Agency_response'] !== $qc_row['Qc_response']) {
     
            $qc_rowData = [
                    'Id' => $qc_row['Id'],
                    'M_item' => $qc_row['M_item'],
                    'Agency_response' => $qc_row['Agency_response'],
                    'Coder_response' => $qc_row['Coder_response'],
                    'Qc_response' => $qc_row['Qc_response'],
                    'Coder_rationali' => $qc_row['Coder_rationali'],
                    'Error_reason' => $qc_row['Error_reason'],
                    'Error_type' => $qc_row['Error_type'],
                    'Qc_rationali' => $qc_row['Qc_rationali'],
                    'oasis_comments' => $qc_row['oasis_comments'],
                ];
                 $qc_data1[] = $qc_rowData;
        }
 
       
    }
}
 
        else {
            // If no rows found in oasisqc, fall back to oasis table
            $qc_query = "SELECT * FROM `oasis` WHERE `Entry_Id` = ? ";
            $qc_stmt = $conn->prepare($qc_query);

            // Bind parameters and execute query
            $qc_stmt->bind_param('i', $userId);
            $qc_stmt->execute();
            $qc_result = $qc_stmt->get_result();

            // Fetch user data from oasis table
            $qc_data1 = [];

 

if ($qc_result->num_rows > 0) {
    while ($qc_row = $qc_result->fetch_assoc()) {
        // Check if Agency_response is equal to Qc_response
        if ($qc_row['Agency_response'] !== $qc_row['Coder_response']) {
            // If they are not equal, use the actual row data
            $qc_rowData = [
                'Id' => $qc_row['Id'],
                'M_item' => $qc_row['M_item'],
                'Agency_response' => $qc_row['Agency_response'],
                'Qc_response' => $qc_row['Coder_response'],
                'Coder_rationali' => $qc_row['Coder_rationali'],
                'oasis_comments' => $qc_row['oasis_comments'],
            ];

            // Append the row data to the $qc_data1 array
            $qc_data1[] = $qc_rowData;
        }
    }
}

 }

function getComments($conn, $tableName, $userId, $column) {
    $commentsQuery = "SELECT `$column` FROM `$tableName` WHERE `Entry_Id` = ? AND `$column` IS NOT NULL AND `$column` != '' LIMIT 1";
    $commentsResult = executeQuery($conn, $commentsQuery, ['i', $userId]);

    // Initialize an empty string to hold the comments
    $comments = "";

    // Check if the query was successful
    if ($commentsResult) {
        // Fetch each row
        while ($row = $commentsResult->fetch_assoc()) {
            // Append the comments to the string
            $comments .= $row[$column] . "<br>"; // Add a line break after each comment
        }
    }

    return $comments;
}

// Get oasis comments from oasisqc
$qc_oasis_comments = getComments($conn, 'oasisqc', $userId, 'oasis_comments');

// If no oasis_comments found in oasisqc, fall back to oasis table
if (empty($qc_oasis_comments)) {
    $qc_oasis_comments = getComments($conn, 'oasis', $userId, 'oasis_comments');
}

// Add oasisqc data to the response array
$response['oasisqc'] = [
    'data' => $qc_data1,
    'oasis_comments' => $qc_oasis_comments,
];






        // Close the statement and connection for oasisqc data
        $qc_stmt->close();

        // Close the main connection
        $conn->close();
    } catch (Exception $e) {
        // Handle exceptions and add an error message to the response array
        $response['error'] = "Error: " . $e->getMessage();
    }
}

// QC PocSegement



if ($userId) {
    try {
        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Example query to fetch user data from Pocsegementqc table
        $qc_query = "SELECT * FROM `Pocsegementqc` WHERE `Entry_Id` = ? AND `Error_type` != 'Deleted'";
        $qc_stmt = $conn->prepare($qc_query);

        // Bind parameters and execute query
        $qc_stmt->bind_param('i', $userId);
        $qc_stmt->execute();
        $qc_result = $qc_stmt->get_result();

        // Fetch user data from Pocsegementqc table
        $qc_data2 = [];
        if ($qc_result->num_rows > 0) {
            while ($qc_row = $qc_result->fetch_assoc()) {
                // Create an associative array for each qc_row
                $qc_rowData = [
                    'Id' => $qc_row['Id'],
                    'Poc_item' => $qc_row['Poc_item'],
                    'Coder_response' => $qc_row['Coder_response'],
                    'Error_reason' => $qc_row['Error_reason'],
                    'Error_type' => $qc_row['Error_type'],
                    'Qc_rationali' => $qc_row['Qc_rationali'],
                    'poc_comments' => $qc_row['poc_comments'],
                ];

                // Append the row data to the $qc_data2 array
                $qc_data2[] = $qc_rowData;
            }
        } else {
            // If no rows found in Pocsegementqc, fall back to Pocsegement table
            $qc_query = "SELECT * FROM `Pocsegement` WHERE `Entry_Id` = ? ";
            $qc_stmt = $conn->prepare($qc_query);

            // Bind parameters and execute query
            $qc_stmt->bind_param('i', $userId);
            $qc_stmt->execute();
            $qc_result = $qc_stmt->get_result();

            // Fetch user data from Pocsegement table
            $qc_data2 = [];
            if ($qc_result->num_rows > 0) {
                while ($qc_row = $qc_result->fetch_assoc()) {
                    // Create an associative array for each qc_row
                    $qc_rowData = [
                        'Id' => $qc_row['Id'],
                        'Poc_item' => $qc_row['Poc_item'],
                        'Coder_response' => $qc_row['Coder_response'],
                        'poc_comments' => $qc_row['poc_comments'],
                    ];

                    // Append the row data to the $qc_data2 array
                    $qc_data2[] = $qc_rowData;
                }
            }
        }

        // Close the statement for user data
        $qc_stmt->close();

       // Function to get comments
function Comments($conn, $tableName, $userId, $column) {
    $commentsQuery = "SELECT `$column` FROM `$tableName` WHERE `Entry_Id` = ? AND `$column` IS NOT NULL AND `$column` != '' LIMIT 1";
    $commentsResult = executeQuery($conn, $commentsQuery, ['i', $userId]);

    // Initialize an empty string to hold the comments
    $poccomments = "";

    // Check if the query was successful
    if ($commentsResult) {
        // Fetch each row
        while ($row = $commentsResult->fetch_assoc()) {
            // Append the comments to the string
            $poccomments .= $row[$column] . "<br>"; // Add a line break after each comment
        }
    }

    return $poccomments;
}

$qc_poc_comments =Comments($conn, 'Pocsegementqc', $userId, 'poc_comments');


if (empty($qc_poc_comments)) {
    $qc_poc_comments =Comments($conn, 'Pocsegement', $userId, 'poc_comments');
}

$response['Pocsegementqc'] = [
    'data' => $qc_data2,
    'poc_comments' => $qc_poc_comments,
];

  echo json_encode($response);
        // Close the main connection
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Return the JSON response

