<?php
session_start();
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
include('../db/db-con.php');
$action = $_GET['action'];


echo $action;

if ($action == 'codedescriptiontable') {

    echo "arun";

  
        // Define the SQL query
         $sql = "SELECT * FROM `Codedescription` where `Category`='male'";

        // Execute the query
        $result = $conn->query($sql);

        // // Check if the query was successful
        // if ($result !== false) {
        //     // Fetch all rows from the result set
        //     $stock_view_details = $result->fetchAll(PDO::FETCH_ASSOC);
        // } else {
        //     throw new Exception("Query failed");
        // }

        // Encode the result as JSON and output it
        // echo json_encode($stock_view_details);
    } 

?>
