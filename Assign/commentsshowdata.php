<?php

session_start();

// Database connection details
include('../db/db-con.php');

// Check if file_id is set in the POST request
if(isset($_POST['file_id'])) {
    // Sanitize the input to prevent SQL injection
    $Id = mysqli_real_escape_string($conn, $_POST['file_id']);

    // Prepare and execute the SQL queries
    $coding_comments = "";
    $oasis_comments = "";
    $poc_comments = "";

    $sql_coding = "SELECT `coding_comments` FROM `Codesegement` WHERE `Entry_Id`='$Id'";
    $result_coding = mysqli_query($conn, $sql_coding);
    if ($result_coding && mysqli_num_rows($result_coding) > 0) {
        $row = mysqli_fetch_assoc($result_coding);
        $coding_comments = $row['coding_comments'];
    }

    $sql_oasis = "SELECT `oasis_comments` FROM `oasis` WHERE `Entry_Id`='$Id'";
    $result_oasis = mysqli_query($conn, $sql_oasis);
    if ($result_oasis && mysqli_num_rows($result_oasis) > 0) {
        $row = mysqli_fetch_assoc($result_oasis);
        $oasis_comments = $row['oasis_comments'];
    }

    $sql_poc = "SELECT `poc_comments` FROM `Pocsegement` WHERE `Entry_Id`='$Id'";
    $result_poc = mysqli_query($conn, $sql_poc);
    if ($result_poc && mysqli_num_rows($result_poc) > 0) {
        $row = mysqli_fetch_assoc($result_poc);
        $poc_comments = $row['poc_comments'];
    }

    // Construct the response as JSON
    $response = array(
        "coding_comments" => $coding_comments,
        "oasis_comments" => $oasis_comments,
        "poc_comments" => $poc_comments
    );

    // Output the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle case where file_id is not set
    echo "file_id not provided";
}

?>
