<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 include('../db/db-con.php');

$userId = $_COOKIE['Id'];


$response = []; // Initialize an array to hold the response


if ($userId) {
    try {
        // Create a connection
    
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
        // Codesegementqc
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Example query to fetch user data
        $qc_query = "SELECT * FROM `Codesegementqc` WHERE `Entry_Id` = ? AND `status`='Qc_review' ORDER BY `M_Item` ";
        $qc_stmt = $conn->prepare($qc_query);

        // Bind parameters and execute query
        $qc_stmt->bind_param('i', $userId);
        $qc_stmt->execute();
        $qc_result = $qc_stmt->get_result();

        // Fetch user data
        $qc_data = [];

        if ($qc_result->num_rows > 0) {
            while ($qc_row = $qc_result->fetch_assoc()) {

                // Create an associative array for each qc_row
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
        }

        // coding_comments
                $query = "SELECT Codesegementqc.coding_comments, Codesegement.coding_comments AS codercomment
FROM Codesegementqc 
JOIN Codesegement 
ON Codesegementqc.Entry_Id = Codesegement.Entry_Id 
WHERE Codesegementqc.Entry_Id = '$userId' 
AND Codesegementqc.coding_comments IS NOT NULL 
AND Codesegementqc.coding_comments != '' 
LIMIT 1;";
        $result = mysqli_query($conn, $query);

        // Initialize an empty string to hold the comments
        $qc_coding_comments = "";
        $coder_coding_comments = "";

        // Check if the query was successful
        if ($result) {
            // Fetch each row
            while ($row1 = mysqli_fetch_assoc($result)) {
                // Append the coding_comments to the string
                $qc_coding_comments .= $row1['coding_comments'] . "<br>";
                $coder_coding_comments .= $row1['codercomment'] . "<br>"; // Add a line break after each comment
            }
        } else {
            $qc_coding_comments = "Error executing query: " . mysqli_error($conn);
        }

        // Add Codesegementqc data to the response array
           $response['Codesegementqc'] = [
            'data' => $qc_data,
            'coding_comments' => $qc_coding_comments,
            
        ];
         $response['Codesegement'] = [
           
            'codercomment' => $coder_coding_comments
        ];

        // Close the statement and connection
        $qc_stmt->close();

        // Close the connection
        $conn->close();
    } catch (Exception $e) {
        $response['error'] = "Error: " . $e->getMessage();
    }
}
// QC Oasis Segement
if ($userId) {
    try {
        // oasisqc
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Example query to fetch user data
        $qc_query = "SELECT * FROM `oasisqc` WHERE `Entry_Id` = ?";
        $qc_stmt = $conn->prepare($qc_query);

        // Bind parameters and execute query
        $qc_stmt->bind_param('i', $userId);
        $qc_stmt->execute();
        $qc_result = $qc_stmt->get_result();

        // Fetch user data
        $qc_data1 = [];

        if ($qc_result->num_rows > 0) {
            while ($qc_row = $qc_result->fetch_assoc()) {
                // Perform empty check validations for each field

                // Create an associative array for each row
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

                // Append the row data to the $qc_data1 array
                $qc_data1[] = $qc_rowData;
            }
        }

        // oasis_comments
       $query = "SELECT oasisqc.oasis_comments, oasis.oasis_comments AS oasis_codercomment
FROM oasisqc 
JOIN oasis 
ON oasisqc.Entry_Id = oasis.Entry_Id 
WHERE oasisqc.Entry_Id ='$userId'
AND oasisqc.oasis_comments IS NOT NULL 
AND oasisqc.oasis_comments != '' 
LIMIT 1";       
 $result = mysqli_query($conn, $query);

        // Initialize an empty string to hold the comments
        $qc_oasis_comments = "";
        $coder_oasis_comments = "";

        // Check if the query was successful
        if ($result) {
            // Fetch each row
            while ($row1 = mysqli_fetch_assoc($result)) {
                // Append the oasis_comments to the string
                $qc_oasis_comments .= $row1['oasis_comments'] . "<br>";
                $coder_oasis_comments .= $row1['oasis_codercomment'] . "<br>";  // Add a line break after each comment
            }
        } else {
            $qc_oasis_comments = "Error executing query: " . mysqli_error($conn);
        }

        // Add oasisqc data to the response array
       $response['oasisqc'] = [
            'data' => $qc_data1,
            'oasis_comments' => $qc_oasis_comments,
        ];
          $response['oasis'] = [
            
            'oasis_codercomment' => $coder_oasis_comments,
        ];

        // Close the statement and connection
        $qc_stmt->close();

        // Close the connection
        $conn->close();
    } catch (Exception $e) {
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

        // Example query to fetch user data
        $qc_query = "SELECT * FROM `Pocsegementqc` WHERE `Entry_Id` = ?";
        $qc_stmt = $conn->prepare($qc_query);

        // Bind parameters and execute query
        $qc_stmt->bind_param('i', $userId);
        $qc_stmt->execute();
        $qc_result = $qc_stmt->get_result();

        // Fetch user data
        $qc_data2 = [];
        if ($qc_result->num_rows > 0) {
            while ($qc_row = $qc_result->fetch_assoc()) {

                // Create an associative array for each qc_row
                $qc_rowData = [
                    'Id' => $qc_row['Id'],
                    'Poc_item' => $qc_row['Poc_item'],
                    'Poc_coder_response' => $qc_row['Poc_coder_response'],
                    'Poc_qc_response' => $qc_row['Coder_response'],
                    'Error_reason' => $qc_row['Error_reason'],
                    'Error_type' => $qc_row['Error_type'],
                    'Qc_rationali' => $qc_row['Qc_rationali'],
                    'poc_comments' => $qc_row['poc_comments'],
                ];

                // Append the row data to the $qc_data2 array
                $qc_data2[] = $qc_rowData;
            }
        }


        // Close the statement and connection
        $qc_stmt->close();

        // poc_comments

        // Example query to fetch user data
     $query = "SELECT Pocsegementqc.poc_comments, Pocsegement.poc_comments AS coder_poccomment
FROM Pocsegementqc 
JOIN Pocsegement 
ON Pocsegementqc.Entry_Id = Pocsegement.Entry_Id 
WHERE Pocsegementqc.Entry_Id = '$userId' 
AND Pocsegementqc.poc_comments IS NOT NULL 
AND Pocsegementqc.poc_comments != '' 
LIMIT 1;";

        $result = mysqli_query($conn, $query);

        // Initialize an empty string to hold the comments
        $qc_poc_comments = "";
         $coder_poc_comments = "";

        // Check if the query was successful
        if ($result) {
            // Fetch each row
            while ($row1 = mysqli_fetch_assoc($result)) {
                // Append the poc_comments to the string
                $qc_poc_comments .= $row1['poc_comments'] . "<br>";
                $coder_poc_comments .= $row1['coder_poccomment'] . "<br>"; // Add a line break after each comment
            }
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }

        // Add oasisqc data to the response array
        $response['Pocsegementqc'] = [
            'data' => $qc_data2,
            'qc_poc_comments' => $qc_poc_comments
          
        ];
        $response['Pocsegement'] = [
            
            'coder_poccomment' => $coder_poc_comments
        ];

        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
//Notes To Agency 

// if($userId){

//     try{

//        // Create a connection
//         $conn = new mysqli($servername, $username, $password, $dbname);

//         // Check the connection
//         if ($conn->connect_error) {
//             die("Connection failed: " . $conn->connect_error);
//         }


//          $query = "SELECT `Notes_to_agency` FROM `Main_Data` WHERE `Id` = '$userId'";
//         $result = mysqli_query($conn, $query);

//         // Initialize an empty string to hold the comments
//         $qc_Notes_to_agency = "";

//         // Check if the query was successful
//         if ($result) {
//             // Fetch each row
//             while ($row1 = mysqli_fetch_assoc($result)) {
//                 // Append the Notes_to_agency to the string
//                 $qc_Notes_to_agency .= $row1['Notes_to_agency'];// Add a line break after each comment
//             }
//         } else {
//             echo "Error executing query: " . mysqli_error($conn);
//         }

//         // Add oasisqc data to the response array
//         $response['Main_Data'] = [
//             'qc_Notes_to_agency' => $qc_Notes_to_agency,
//         ];

//         $conn->close();



//     }
// catch (Exception $e) {
//         echo "Error: " . $e->getMessage();
//     }

// }




// Return the JSON response
echo json_encode($response);
