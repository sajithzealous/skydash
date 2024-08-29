<?php
 include('../db/db-con.php');

if (isset($_POST['Id'])) {
    $Id = $_POST['Id'];
    $Mrn_id = $_POST['Mrn'];

    // Define the table names
    $sourceTable = "data";

    // Check if $Mrn_id already exists in the database
    $existingMrn = checkExistingMrn($conn, $Mrn_id);

    $response = array(); // Initialize the response array

    if ($existingMrn) {
        // If Mrn_id already exists, return an error message
        $response['error'] = 'Mrn is already exists in the table';
    } else {
        $sql = "UPDATE `Main_Data` SET `Mrn`='$Mrn_id' WHERE Id = '$Id'";
        $runquery = mysqli_query($conn, $sql);

        if ($runquery) {
            $response['success'] = 'Mrn Updated successfully';
            
            $insert_query3 = "UPDATE `$sourceTable` SET `Mrn` = '$Mrn_id' WHERE `Id` = '$Id'";
            
            $insert_result2 = $conn->query($insert_query3);
            if ($insert_result2) {
            } else {
                $response['error'] = "Error inserting data into $sourceTable: " . $conn->error;
                // echo "Error inserting data into $sourceTable: " . $conn->error;
                exit;
            }
        } else {
            $response['error'] = "Error: " . mysqli_error($conn);
            // echo "Error: " . mysqli_error($conn);
        }
    }

    // Return response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

function checkExistingMrn($conn, $Mrn)
{
    // Check if the provided Mrn already exists in the database
    $checkSql = "SELECT `Mrn` FROM `data` WHERE `Mrn` = '$Mrn'";
    $result = $conn->query($checkSql);

    return $result->num_rows > 0;
}
?>
