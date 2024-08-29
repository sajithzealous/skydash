<?php
include 'logsession.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db/db-con.php');

  $userId = $_COOKIE['Id'];

// $userId = 10106;


$action = isset($_GET['action']) ? $_GET['action'] : '';

$response = []; // Initialize an array to store the response

if ($action == 'Codesegement' || $action == 'oasis' || $action ==  'Pocsegement') {
    fetchData($action, $userId);
} else {
    $response['error'] = "Invalid action specified";
}


// Function to fetch data based on the action
function fetchData($action, $userId)
{
    global $servername, $username, $password, $dbname, $response;

    if ($userId) {
        try {
            // Create a connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            //   //CODER-PREVIWE 

            if ($action == 'Codesegement') {


                // Check the connection
                if ($conn->connect_error) {
                    $response['error'] = "Connection failed: " . $conn->connect_error;
                } else {
 
 $query ="SELECT * 
FROM `Codesegement` 
WHERE `Entry_Id` = '$userId' 
  AND `code_status` IS NULL 
  AND `Coderchecked`='Coder'
ORDER BY `M-Items`";



                    
                    $result = $conn->query($query);

                    // Fetch user data
                    if ($result) {
                        $response['data'] = [];
                        while ($row = $result->fetch_assoc()) {
                            $response['data'][] = $row; // Wrap the result in an array
                        }
                    } else {
                        $response['error'] = "Error executing query: " . $conn->error;
                    }

                    // Close the connection
                    $conn->close();
                }
            }

         //OASIS-PREVIWE CODE 
                else if ($action == 'oasis') {


                // Check the connection
                if ($conn->connect_error) {
                    $response['error'] = "Connection failed: " . $conn->connect_error;
                } else {
                    // Example query to fetch user data
                   $query = "SELECT * FROM `" . $action . "` WHERE `Entry_Id` = $userId AND `Agency_response`!=`Coder_response` AND `code_status` IS NULL ";
                    $result = $conn->query($query);

                    // Fetch user data
                    if ($result) {
                        $response['data'] = [];
                        while ($row = $result->fetch_assoc()) {
                            $response['data'][] = $row; // Wrap the result in an array
                        }
                    } else {
                        $response['error'] = "Error executing query: " . $conn->error;
                    }

                    // Close the connection
                    $conn->close();
                }
            }




           //POC-PREVIWE CODE 
            else {

                // Example query to fetch user data
                $query = "SELECT * FROM `" . $action . "` WHERE `Entry_Id` = $userId AND `code_status` IS NULL";



                $result = $conn->query($query);

                // Fetch user data
                if ($result) {
                    $response['data'] = [];
                    while ($row = $result->fetch_assoc()) {
                        $response['data'][] = $row; // Wrap the result in an array
                    }
                } else {
                    $response['error'] = "Error executing query: " . $conn->error;
                }

                // Close the connection
                $conn->close();
            }
        } catch (Exception $e) {
            $response['error'] = "Error: " . $e->getMessage();
        }
    } else {
        $response['error'] = "User ID not found in cookies";
    }



    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}





