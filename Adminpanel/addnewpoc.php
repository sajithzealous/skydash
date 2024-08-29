<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

     include('../db/db-con.php');


        $sql = "SELECT * FROM `pocitemsshow` WHERE 1";
        $result = $conn->query($sql);
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['pocjson'] = str_replace(array("\r", "\n"), '', $row['pocjson']); // Clean the 'json' field
                $data[] = $row;
            }
        }
        // Output JSON data
        header('Content-Type: application/json');
        echo json_encode($data, true);
        exit();
    // Close the database connection
    $conn->close();

?>
