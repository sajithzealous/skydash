<?php

// Start session and error reporting
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user session exists
$user = $_SESSION['username'] ?? null;
$emp_id = $_SESSION['empid'];

// Database connection details
 include('../db/db-con.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['chart_id'])) {
        $chart_id = $_POST['chart_id'];
        $commentTextnotes = $_POST['commentTextnotes'];

        $query = "SELECT `patient_name`, `mrn`, `assesment_date` FROM `Main_Data` WHERE `Id` = $chart_id";
        $query_result = $conn->query($query);

        if ($query_result) {
            $dataRow = $query_result->fetch_assoc();

            $patientName = $dataRow['patient_name'];
            $mrn = $dataRow['mrn'];
            $user = $_SESSION['username'] ?? '';


            $sql = "UPDATE `Main_Data` SET `Notes_to_agency`='$commentTextnotes' WHERE `id`='$chart_id' AND `alloted_to_coder`='$user' AND `coder_emp_id`='$emp_id'";

            if ($conn->query($sql) === TRUE) {
                echo "Comments Inserted Successfully";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error executing query: " . $conn->error;
        }
    } else {
        echo "Parameters are missing or incorrect.";
    }
} else {
    echo "Invalid request method.";
}
