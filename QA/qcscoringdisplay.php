<?php
// Error reporting setup
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('../db/db-con.php');

$Id = $_POST['Id'];

if ($Id != "") {
    $sqlselectdata = "SELECT * FROM `qcscoringvalue` WHERE `Entry_Id`='$Id'";
    $sqlselectdataresult = $conn->query($sqlselectdata);

    if ($sqlselectdataresult->num_rows > 0) {
        $row = $sqlselectdataresult->fetch_assoc();
        $response = [
            'code_scoring' => $row['code_scoring'],
            'oasis_scoring' => $row['oasis_scoring'],
            'poc_scoring' => $row['poc_scoring'],
            'qc_code_scoring' => $row['qc_code_scoring'],
            'qc_oasis_scoring' => $row['qc_oasis_scoring'],
            'qc_poc_scoring' => $row['qc_poc_scoring'],
        ];
        echo json_encode($response); // Return data as JSON
    }
}
?>
