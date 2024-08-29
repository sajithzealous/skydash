<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('../db/db-con.php');

// Check if action is set in GET parameters
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Handle new user creation
    if ($action == 'newuser') {
        // Check if all required fields are set
        if (isset($_POST['username'], $_POST['userpassword'], $_POST['userempid'], $_POST['userrole'], $_POST['userorganization'], $_POST['userstatus'])) {
            // Sanitize user input
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $userpassword = mysqli_real_escape_string($conn, $_POST['userpassword']);
            $userempid = mysqli_real_escape_string($conn, $_POST['userempid']);
            $userrole = mysqli_real_escape_string($conn, $_POST['userrole']);
            $userorganization = mysqli_real_escape_string($conn, $_POST['userorganization']);
            $userstatus = mysqli_real_escape_string($conn, $_POST['userstatus']);

            // Check if user ID already exists
            $selectquery = "SELECT `user_id` FROM `userlogin` WHERE `user_id` = '$userempid'";
            $selectresult = $conn->query($selectquery);

            if ($selectresult->num_rows > 0) {
                $response = ['error' => true, 'message' => 'User ID already exists'];
                echo json_encode($response);
            } else {
                // Insert new user data into the database
                $sql = "INSERT INTO `userlogin` (`user_name`, `user_password`, `user_id`, `user_role`, `user_company`, `user_status`) 
                        VALUES ('$username', '$userpassword', '$userempid', '$userrole', '$userorganization', '$userstatus')";

                // Execute SQL query
                if ($conn->query($sql) === TRUE) {
                    $response = ['success' => true, 'message' => 'Created New User Successfully'];
                    echo json_encode($response);
                } else {
                    $response = ['error' => true, 'message' => 'Error: ' . $conn->error];
                    echo json_encode($response);
                }
            }
        } else {
            $response = ['error' => true, 'message' => 'Missing required fields'];
            echo json_encode($response);
        }
    } elseif ($action == 'newagency') {
        // Check if all required fields are set
        if (isset($_POST['agencyname'], $_POST['clientname'], $_POST['clientid'], $_POST['agencystatus'])) {
            // Sanitize user input
            $agencyname = mysqli_real_escape_string($conn, $_POST['agencyname']);
            $clientname = mysqli_real_escape_string($conn, $_POST['clientname']);
            $clientid = mysqli_real_escape_string($conn, $_POST['clientid']);
            $agencystatus = mysqli_real_escape_string($conn, $_POST['agencystatus']);
            
            // Check if user ID already exists
            $selectquery = "SELECT `client_id` FROM `Agent` WHERE `client_id` = '$clientid'";
            $selectresult = $conn->query($selectquery);

            if ($selectresult->num_rows > 0) {
                $response = ['error' => true, 'message' => 'Agency ID already exists'];
                echo json_encode($response);
            } else {
                // Insert new user data into the database
                $sql = "INSERT INTO `Agent`(`agency_name`, `client_name`, `client_id`, `agency_status`) 
                        VALUES ('$agencyname','$clientname','$clientid','$agencystatus')";

                // Execute SQL query
                if ($conn->query($sql) === TRUE) {
                    $response = ['success' => true, 'message' => 'Created New Agency Successfully'];
                    echo json_encode($response);
                } else {
                    $response = ['error' => true, 'message' => 'Error: ' . $conn->error];
                    echo json_encode($response);
                }
            }
        } else {
            $response = ['error' => true, 'message' => 'Missing required fields'];
            echo json_encode($response);
        }
    }
    elseif($action == 'newerrorcodetype'){

                if (isset($_POST['qccodeerrortype'], $_POST['qcerrorcodestatus'])) {
            // Sanitize user input
            $qccodeerrortype = mysqli_real_escape_string($conn, $_POST['qccodeerrortype']);
            $qcerrorcodestatus = mysqli_real_escape_string($conn, $_POST['qcerrorcodestatus']);
            
            // Check if user ID already exists
            $selectquery = "SELECT `qcreason` FROM `Qcreasoncode` WHERE `qcreason` = '$qccodeerrortype'";
            $selectresult = $conn->query($selectquery);

            if ($selectresult->num_rows > 0) {
                $response = ['error' => true, 'message' => 'Qcreasoncode already exists'];
                echo json_encode($response);
            } else {
                // Insert new user data into the database
                $sql = "INSERT INTO `Qcreasoncode`(`qcreason`, `status`) 
                        VALUES ('$qccodeerrortype',' $qcerrorcodestatus')";

                // Execute SQL query
                if ($conn->query($sql) === TRUE) {
                    $response = ['success' => true, 'message' => 'Created New Qcreasoncode Successfully'];
                    echo json_encode($response);
                } else {
                    $response = ['error' => true, 'message' => 'Error: ' . $conn->error];
                    echo json_encode($response);
                }
            }
        } else {
            $response = ['error' => true, 'message' => 'Missing required fields'];
            echo json_encode($response);
        }


    }elseif($action == 'newerroroasistype'){

                if (isset($_POST['qcoasiserrortype'], $_POST['qcoasiscodestatus'])) {
            // Sanitize user input
            $qcoasiserrortype = mysqli_real_escape_string($conn, $_POST['qcoasiserrortype']);
            $qcoasiscodestatus = mysqli_real_escape_string($conn, $_POST['qcoasiscodestatus']);
            
            // Check if user ID already exists
            $selectquery = "SELECT `qcreason` FROM `Qcreasonoasis` WHERE `qcreason` = '$qcoasiserrortype'";
            $selectresult = $conn->query($selectquery);

            if ($selectresult->num_rows > 0) {
                $response = ['error' => true, 'message' => 'Qcreasonoasis already exists'];
                echo json_encode($response);
            } else {
                // Insert new user data into the database
                $sql = "INSERT INTO `Qcreasonoasis`(`qcreason`, `status`) 
                        VALUES ('$qcoasiserrortype','$qcoasiscodestatus')";

                // Execute SQL query
                if ($conn->query($sql) === TRUE) {
                    $response = ['success' => true, 'message' => 'Created New Qcreasonoasis Successfully'];
                    echo json_encode($response);
                } else {
                    $response = ['error' => true, 'message' => 'Error: ' . $conn->error];
                    echo json_encode($response);
                }
            }
        } else {
            $response = ['error' => true, 'message' => 'Missing required fields'];
            echo json_encode($response);
        }


    }elseif($action == 'newerrorpoctype'){

                if (isset($_POST['qcpocerrortype'], $_POST['qcpocstatus'])) {
            // Sanitize user input
            $qcpocerrortype = mysqli_real_escape_string($conn, $_POST['qcpocerrortype']);
            $qcpocstatus = mysqli_real_escape_string($conn, $_POST['qcpocstatus']);
            
            // Check if user ID already exists
            $selectquery = "SELECT `qcreason` FROM `Qcreasonpoc` WHERE `qcreason` = '$qcpocerrortype'";
            $selectresult = $conn->query($selectquery);

            if ($selectresult->num_rows > 0) {
                $response = ['error' => true, 'message' => 'Qcreasonpoc already exists'];
                echo json_encode($response);
            } else {
                // Insert new user data into the database
                $sql = "INSERT INTO `Qcreasonpoc`(`qcreason`, `status`) 
                        VALUES ('$qcpocerrortype',' $qcpocstatus')";

                // Execute SQL query
                if ($conn->query($sql) === TRUE) {
                    $response = ['success' => true, 'message' => 'Created New Qcreasonpoc Successfully'];
                    echo json_encode($response);
                } else {
                    $response = ['error' => true, 'message' => 'Error: ' . $conn->error];
                    echo json_encode($response);
                }
            }
        } else {
            $response = ['error' => true, 'message' => 'Missing required fields'];
            echo json_encode($response);
        }


    }elseif($action == 'pendingreasontype'){

                if (isset($_POST['pendingreason'], $_POST['pendingreasonstatus'])) {
            // Sanitize user input
            $pendingreason = mysqli_real_escape_string($conn, $_POST['pendingreason']);
            $pendingreasonstatus = mysqli_real_escape_string($conn, $_POST['pendingreasonstatus']);
            
            // Check if user ID already exists
            $selectquery = "SELECT `Pendingreason` FROM `Pendingreason` WHERE `Pendingreason` = '$pendingreason'";
            $selectresult = $conn->query($selectquery);

            if ($selectresult->num_rows > 0) {
                $response = ['error' => true, 'message' => 'Pendingreason already exists'];
                echo json_encode($response);
            } else {
                // Insert new user data into the database
                $sql = "INSERT INTO `Pendingreason`(`Pendingreason`, `status`) 
                        VALUES ('$pendingreason',' $pendingreasonstatus')";

                // Execute SQL query
                if ($conn->query($sql) === TRUE) {
                    $response = ['success' => true, 'message' => 'Created New Pendingreason Successfully'];
                    echo json_encode($response);
                } else {
                    $response = ['error' => true, 'message' => 'Error: ' . $conn->error];
                    echo json_encode($response);
                }
            }
        } else {
            $response = ['error' => true, 'message' => 'Missing required fields'];
            echo json_encode($response);
        }


    }

     else {
        $response = ['error' => true, 'message' => 'Invalid action'];
        echo json_encode($response);
    }
} else {
    $response = ['error' => true, 'message' => 'No action specified'];
    echo json_encode($response);
}

// Close database connection
$conn->close();
?>
