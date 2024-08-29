<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// Include database connection
require_once('../db/db-con.php'); 

 $action =$_GET['action'];
// echo $action;
 $empid = $_SESSION['empid'];

if ($action == 'createdata') {
    // Read JSON data from request body
    $data = file_get_contents("php://input");
    $formData = json_decode($data, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO `assessmentform` (`title`, `date`, `time`, `form_json`, `status`, `published`, `created_by`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) { 
            $formJson = json_encode($formData['questions']);
            $status = 'Active';
            $published = 'Yes';

            // Ensure $empid is defined somewhere in your code
            $stmt->bind_param("sssssss", $formData['title'], $formData['date'], $formData['time'], $formJson, $status, $published, $empid);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "New record created successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    }
}

else if ($action == 'showdata') {
    // SQL query to select all records from the assessmentform table
    $sql = "SELECT * FROM `assessmentform` Where 1";
    if ($result = $conn->query($sql)) {
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "No active records found"]);
        }
        $result->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Query error: " . $conn->error]);
    }
} 

else if ($action == 'showformdata') {
    if (isset($_POST['id']) && isset($_POST['teamdata']) && isset($_POST['coderdata'])) {
        $formId = $_POST['id'];
        $teamData = $_POST['teamdata'];
        $coderData = $_POST['coderdata'];
        $empid = $_SESSION['empid'];

        // Convert the team data array to a comma-separated string
        $teamNames = implode(",", $teamData);
        // Extract the last part of the team string after the last space
        $teamId = substr($teamNames, strrpos($teamNames, ' ') + 1);

        // Iterate through each coder and check if they are already assigned
        foreach ($coderData as $coder) {
            list($name, $coderEmpId) = explode(' - ', $coder);

            // Check if the coder is already assigned to this form
            $sqlSelect = "SELECT `Id` FROM `assessmentformassigneddata` WHERE `form_id` = ? AND `assigned_coder_empid` = ?";
            if ($stmtSelect = $conn->prepare($sqlSelect)) {
                $stmtSelect->bind_param("ss", $formId, $coderEmpId);
                $stmtSelect->execute();
                $stmtSelect->store_result();

                // If a record exists, return an error message
                if ($stmtSelect->num_rows > 0) {
                    echo json_encode(["status" => "error", "message" => "The Assessment Is Already Assigned To The Coder"]);
                    $stmtSelect->close();
                    break; // Exit the loop if any coder is already assigned
                } else {
                    // Construct the SQL insert statement
                    $stmtSelect->close();
                    $sqlInsert = "INSERT INTO `assessmentformassigneddata` (`form_id`, `assigned_coder_empid`, `team_name`, `form_assigned_by`) VALUES (?, ?, ?, ?)";

                    if ($stmtInsert = $conn->prepare($sqlInsert)) {
                        $stmtInsert->bind_param("ssss", $formId, $coderEmpId, $teamId, $empid);
                        if ($stmtInsert->execute()) {
                            echo json_encode(["status" => "success", "message" => "The Assessment Form Assigned"]);
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error: " . $stmtInsert->error]);
                        }
                        $stmtInsert->close();
                    } else {
                        echo json_encode(["status" => "error", "message" => "Prepare error: " . $conn->error]);
                    }
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Select prepare error: " . $conn->error]);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing POST parameters"]);
    }
}



else if ($action == 'showcoderform') {
    $empid = $_SESSION['empid'];
    $Id=$_POST['Id'];

    // Define the SQL query with placeholders
    $sqlSelect = "SELECT af.`time`, af.`title`,af.`form_json`,af.`Id`
                  FROM `assessmentform` as af
                  JOIN `assessmentformassigneddata` as afd
                  ON af.`Id` = afd.`form_id`
                  WHERE afd.`status` = 'Active' AND afd.`Id`='$Id'
                  AND afd.`assigned_coder_empid` = ?";
    if ($selectStmt = $conn->prepare($sqlSelect)) {
        $selectStmt->bind_param("s", $empid);

        if ($selectStmt->execute()) {
            $result = $selectStmt->get_result();
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(["status" => "success", "data" => $data]);
            $result->free();
        } else {
            // Return an error if the query execution fails
            echo json_encode(["status" => "error", "message" => "Query execution error: " . $selectStmt->error]);
        }

        // Close the prepared statement
        $selectStmt->close();
    } else {
        // Return an error if the statement preparation fails
        echo json_encode(["status" => "error", "message" => "Statement preparation error: " . $conn->error]);
    }
}

else if($action == 'activea'){

    if(isset($_POST['status'])){

    $status=$_POST['status'];

    $sql = mysqli_query($conn, "SELECT * FROM `assessmentformassigneddata` WHERE `assigned_coder_empid` = '$empid'  AND `status` = 'Active' ORDER BY `Id` DESC");
     
    if ($sql) {
        $data = [];
        while($row=mysqli_fetch_assoc($sql)){
            $data[] = $row;

        }
        echo json_encode(["status" => "success", "data" => $data]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . mysqli_error($conn)]);
    }
   }
        
}


else if ($action == 'updateformdata') {
    if (isset($_POST['status']) && isset($_POST['id'])) {
        $status = $_POST['status'];
        $id = $_POST['id'];

      
        $status = ($status == 'Active') ? 'In-Active' : 'Active';

        if($status=='Active'){

            $publisheddata='Yes';
        }else{

            $publisheddata='No';
        }

    
        if (!empty($id)) {
            $sql = mysqli_query($conn, "UPDATE `assessmentform` SET `status`='$status', `published` = '$publisheddata'WHERE `Id`='$id'");


            if ($sql) {
                echo json_encode(["status" => "success", "message" => "Record updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update record."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid ID provided."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Required parameters missing."]);
    }
}


else if ($action == 'coderformdata') {
    // Get the posted data from the AJAX request
    $coderDataJson = $_POST['coderData'] ?? '';
    $totalMarks = $_POST['totalMarks'] ?? 0;
    $titleData = $_POST['titledata'] ?? '';
    $newTimeData = $_POST['newtimedata'] ?? '';
    $formId = $_POST['formid'] ?? '';

    // Decode the JSON data
    $coderData = json_decode($coderDataJson, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle JSON decode errors
        echo json_encode([
            "status" => "error", 
            "message" => "Error decoding JSON: " . json_last_error_msg()
        ]);
        exit;
    }

    // Retrieve the employee ID from the session
    $empId = $_SESSION['empid'] ?? '';
    $team = ''; // Placeholder for team; modify as needed
    $submittedDate = date("Y-m-d H:i:s"); // Get the current date and time

    // Escape the data to prevent SQL injection
    $answer = mysqli_real_escape_string($conn, $coderDataJson);
    $systemMark = mysqli_real_escape_string($conn, $totalMarks);

    // Check if a record already exists for this form ID and employee ID
    $selectSql = "
        SELECT * FROM assesmentanswerdata 
        WHERE fomrid = '$formId' 
        AND coder_empid = '$empId' 
        AND answer IS NOT NULL
    ";
    
    $result = mysqli_query($conn, $selectSql);

    if (mysqli_num_rows($result) > 0) {
        // If record exists, update it
        $updateSql = "
            UPDATE assesmentanswerdata 
            SET answer = '$answer', systemmark = '$systemMark' 
            WHERE fomrid = '$formId' 
            AND coder_empid = '$empId' 
            AND answer IS NOT NULL
        ";

        if (mysqli_query($conn, $updateSql)) {
            echo json_encode([
                "status" => "success", 
                "message" => "Record updated successfully."
            ]);
        } else {
            echo json_encode([
                "status" => "error", 
                "message" => "Failed to update record: " . mysqli_error($conn)
            ]);
        }
    } else {
        // If no record exists, insert a new one
        $insertSql = "
            INSERT INTO assesmentanswerdata (
                fomrid, 
                answer, 
                systemmark, 
                coder_empid, 
                team, 
                submitted_date,
                coder_time,
                status
            ) VALUES (
                '$formId', 
                '$answer', 
                '$systemMark', 
                '$empId', 
                '$team', 
                '$submittedDate', 
                '$newTimeData',
                'Not-Evaluated'
            )
        ";

        if (mysqli_query($conn, $insertSql)) {
            echo json_encode([
                "status" => "success", 
                "message" => "Record inserted successfully."
            ]);
        } else {
            echo json_encode([
                "status" => "error", 
                "message" => "Failed to insert record: " . mysqli_error($conn)
            ]);
        }
    }

    // Update the assessment form assignment status
    $updateStatusSql = "
        UPDATE assessmentformassigneddata 
        SET status = 'In-Active' 
        WHERE form_id = '$formId' 
        AND assigned_coder_empid = '$empId' 
        AND status = 'Active'
    ";

    if (mysqli_query($conn, $updateStatusSql)) {
        echo json_encode([
            "status" => "success", 
            "message" => "Status updated successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Failed to update status: " . mysqli_error($conn)
        ]);
    }
}


else if ($action == 'coderformdetails') {
    // SQL query to select all records from the assessmentform table
    $sql = "SELECT * FROM `assessmentformassigneddata` Where 1";
    if ($result = $conn->query($sql)) {
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "No active records found"]);
        }
        $result->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Query error: " . $conn->error]);
    }
} 


else if ($action == 'updatecoderformdata') {
    if (isset($_POST['status']) && isset($_POST['Id'])) {
        $status = $_POST['status'];
        $id = $_POST['Id'];

      
        $status = ($status == 'Active') ? 'In-Active' : 'Active';

    
        if (!empty($id)) {
            $sql = mysqli_query($conn, "UPDATE `assessmentformassigneddata` SET `status`='$status',`status_updatedby`='$empid' WHERE `Id`='$id'");

            if ($sql) {
                echo json_encode(["status" => "success", "message" => "Record updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update record."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid ID provided."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Required parameters missing."]);
    }
}

else if($action == 'manualevaluation'){

    $sql = "SELECT *, af.title, afd.status AS statusdata
                FROM `assesmentanswerdata` AS afd
                JOIN `assessmentform` AS af
                ON afd.`fomrid` = af.`Id`
                WHERE afd.`status` = 'Not-Evaluated'";

    if ($result = $conn->query($sql)) {
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "No active records found"]);
        }
        $result->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Query error: " . $conn->error]);
    }

}


else if($action == 'manualevaluationdata'){

    $sql = "SELECT *, af.title, afd.status AS statusdata
                FROM `assesmentanswerdata` AS afd
                JOIN `assessmentform` AS af
                ON afd.`fomrid` = af.`Id`
                WHERE afd.`status` = 'Not-Evaluated'";

    if ($result = $conn->query($sql)) {
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "No active records found"]);
        }
        $result->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Query error: " . $conn->error]);
    }

}



else if ($action == 'manualmarkupdate') {
    if (isset($_POST['Id']) && isset($_POST['totalMarks'])) {
        $manualmarks = $_POST['totalMarks'];
        $id = $_POST['Id'];
        $date=date('Y-m-d H:m:i');

      
    
        if (!empty($id)) {
            $sql = mysqli_query($conn, "UPDATE `assesmentanswerdata` SET `evaluatemark`='$manualmarks',`evaluatedby`='$empid',`evaluated_date`='$date',`status`='Evaluated' WHERE `Id`='$id'");

            if ($sql) {
                echo json_encode(["status" => "success", "message" => "Record updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update record."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid ID provided."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Required parameters missing."]);
    }
}


else if ($action == 'editformdata') {
    // Check if the 'id' is provided in the POST request
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Proceed only if 'id' is not empty
        if (!empty($id)) {
            // Prepare SQL query to fetch data from 'assessmentform' table using the provided ID
            $sqleditquery = "SELECT * FROM `assessmentform` WHERE `Id` = '$id'";

            // Execute the SQL query
            $result = $conn->query($sqleditquery);
            
            if ($result) {
                // Initialize an array to store the fetched data
                $data = [];

                // Check if any records were found
                if ($result->num_rows > 0) {
                    // Fetch all records and store them in the array
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }

                    // Return success response with the fetched data
                    echo json_encode(["status" => "success", "data" => $data]);
                } else {
                    // Return an error response if no records were found
                    echo json_encode(["status" => "error", "message" => "No active records found"]);
                }

                // Free the result set
                $result->close();
            } else {
                // Return an error response if the query fails
                echo json_encode(["status" => "error", "message" => "Query error: " . $conn->error]);
            }
        } else {
            // Return an error response if 'id' is empty
            echo json_encode(["status" => "error", "message" => "ID cannot be empty."]);
        }
    } else {
        // Return an error response if 'id' is not set in the POST request
        echo json_encode(["status" => "error", "message" => "ID is not provided."]);
    }
}



else if ($action == 'editedform') {
    // Read JSON data from request body
    $data = file_get_contents("php://input");
    $formData = json_decode($data, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        // Extract values from the form data
        $formId = $formData['id'];
        $formTitle = $formData['title'];
        $formTime = $formData['time'];
        $formJson = json_encode($formData['questions']);
        $editedBy = $_SESSION['empid']; // Assuming you're using session to store the editor's ID
        $editedDate = date("Y-m-d H:i:s");

        // Prepare and bind the SQL update statement
        $sqlUpdate = "UPDATE `assessmentform` SET `title`=?, `time`=?, `form_json`=?, `edited_by`=?, `edited_date`=? WHERE `Id`=?";
        if ($stmt = $conn->prepare($sqlUpdate)) {
            $stmt->bind_param("sssssi", $formTitle, $formTime, $formJson, $editedBy, $editedDate, $formId);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Form updated successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Prepare error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    }
}






else {
    // Invalid action error
    echo json_encode(["status" => "error", "message" => "Invalid action: " . htmlspecialchars($action)]);
}
?>
