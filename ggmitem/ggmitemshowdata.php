 <?php

 include 'logsession.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../db/db-con.php');

$userId = $_COOKIE['Id'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action=="oasis_new"){
    $query = "SELECT * FROM `oasis_new` WHERE `Entry_id`='$userId' AND `Coder_rationali`!='Null' AND `code_status` IS NULL ";
    $result = $conn->query($query);

    if ($result) {
        $response = [];  //Initialize response array

        while ($row = $result->fetch_assoc()) {
            $agencydata = $row['Agency_response'];
            $coderdata = $row['Coder_response'];
            $Coder_rationali = $row['Coder_rationali'];

            // Append data for each row to the response array
            $response[] = [
                'agencydata' => $agencydata,
                'coderdata' => $coderdata,
                'Coder_rationali' => $Coder_rationali
            ];
        }
    } else {
        $response['error'] = "Error executing query: " . $conn->error;
    }
}


 header('Content-Type: application/json');
     echo json_encode($response);



 ?>


 














 