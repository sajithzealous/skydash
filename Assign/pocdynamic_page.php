<?php
$action = $_GET['action'];

if ($action == 'filter') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../db/db-con.php');

    $Id = $_GET['Id'];

    // Prevent SQL Injection (consider using prepared statements)
    $Id = $conn->real_escape_string($Id);

    // Construct the query
    $select = "SELECT `Agency` FROM `Main_Data` WHERE `Id`='$Id' ";
    $selectquery = $conn->query($select);

    if ($selectquery->num_rows > 0) {
        $row = $selectquery->fetch_assoc();
        $agency = $row['Agency'];

        $sql = "SELECT * FROM `pocitems` WHERE 1";
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
    }
    else
    {
        unset($data);
          $data = array();
    }
    
    // Close the database connection
    $conn->close();
}
?>
