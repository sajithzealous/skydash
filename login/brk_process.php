<?php
session_start();

 include('../db/db-con.php');

$breakstatuscheck = "SELECT * FROM `Work_Log` WHERE `break_status`='Break_In' AND `brk_out` IS NULL";
$breakresult = $conn->query($breakstatuscheck);

$entries = []; // Initialize the entries array

if ($breakresult) {
    if ($breakresult->num_rows > 0) {

        // Fetching data from the result set
        while ($row = $breakresult->fetch_assoc()) {
            $entries[] = $row; // Store each row in the entries array
        }
    } else {
        // Handle case where no rows are found if needed
    }
} else {
    // Handle the case where the query fails if needed
}

echo json_encode($entries);

