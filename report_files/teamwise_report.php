<?php

// Include database connection
include('../db/db-con.php');

 

// Error reporting setup
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize data array
$data = array();
$action = $_GET['action'];

// Check if basic team filtering parameters are provided
if ($action == 'teamstatus') {
    if (isset($_GET['fromdate']) && isset($_GET['todate']) ||isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['teamname']) && isset($_GET['team_id']) && isset($_GET['status'])) {

        

        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';

        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
         $status = $_GET['status'];


         $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');

        // Construct SQL query for basic filtering
        if(empty($fromdate1)&& empty($todate1)){


        $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`,`pending_comments`,`pending_reason`,`pending_date`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`, `totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'
                AND `status` = '$status'";
   }
   else
   {

        $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`,`pending_comments`,`pending_reason`,`pending_date`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`, `totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'
                AND `status` = '$status'";
   }

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    }
} 


else if ($action == 'agency_team') {
    if (isset($_GET['fromdate']) && isset($_GET['todate']) || isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['teamname']) && isset($_GET['team_id']) && isset($_GET['agency'])) {
        
        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $agency = $_GET['agency'];


         $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');


  $agency = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($agency), $conn), $agency));
        // Construct SQL query for basic filtering

       if(empty($fromdate1) && empty($todate1)){

        $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`,`pending_comments`,`pending_reason`,`pending_date`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`, `totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'
               AND `agency` IN('$agency')";
       }
       else{

        $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`,`pending_comments`,`pending_reason`,`pending_date`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`, `totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'
               AND `agency` IN('$agency')";
       }
        

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    }
}
 
 
elseif ($action == 'team_status_agency_report') {
    // Check if all required parameters are set
    if (
        isset($_GET['fromdate'], $_GET['todate'], $_GET['teamname'], $_GET['team_id'], $_GET['status'], $_GET['agency'])
    ) {
        // Get parameters
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $status = $_GET['status'];
        $agency = $_GET['agency'];



        // Sanitize inputs (optional but recommended)
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);
        $teamname = mysqli_real_escape_string($conn, $teamname);
        $team_id = mysqli_real_escape_string($conn, $team_id);
        $status = mysqli_real_escape_string($conn, $status);
        // $agency = mysqli_real_escape_string($conn, $agency);




         $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');


 


         $agency = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($agency), $conn), $agency));

        // Construct SQL query
     $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `pending_comments`, `pending_reason`, `pending_date`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`, `total_working_hours`, `totalcasemix`, `totalcasemixagency`, `file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'
                AND `status` = '$status'
                AND `agency` IN('$agency')";

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            // Process $data as needed (e.g., output or further processing)
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } else {
        echo "Missing required parameters.";
    }
}
 
elseif ($action == 'team') {
    if (isset($_GET['fromdate']) && isset($_GET['todate']) || isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['teamname']) && isset($_GET['team_id'])) {
        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        

          // Indian Time Zone
        $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');

        // Construct SQL query for basic filtering

        if(empty($fromdate1) && empty($todate1)){


        $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`,`pending_comments`,`pending_reason`,`pending_date`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`, `totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'";

          }
          
          else{
             $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`,`pending_comments`,`pending_reason`,`pending_date`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`, `totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'";
          }      

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    }
}

// elseif ($action == 'All') {
//     if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
//         $fromdate1 = $_GET['fromdate'];
//         $todate1 = $_GET['todate'];


       
        
        

//         // Construct SQL query for basic filtering
//         $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`,`pending_comments`,`pending_reason`,`pending_date`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`, `totalcasemix`,`totalcasemixagency`,`file_completed_date`
//                 FROM Main_Data
//                 WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
//                 AND `File_Status_Time` <= '$todate1 23:59:59'";
                

//         // Execute SQL query
//         $result = $conn->query($sql);

//         // Check if result is valid and contains data
//         if ($result && $result->num_rows > 0) {
//             while ($row = $result->fetch_assoc()) {
//                 $data[] = $row;
//             }
//         } else {
//             // If no records found, output message
//             echo "No records found.";
//         }
//     }
// }



 
else if ($action == 'All') {
    if ((isset($_GET['fromdate']) && isset($_GET['todate'])) || (isset($_GET['fromdate1']) && isset($_GET['todate1']))) {
        // Ensure these variables are always set to avoid undefined variable errors
        $fromdate1 = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate1 = isset($_GET['todate']) ? $_GET['todate'] : '';
        $fromdate2 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate2 = isset($_GET['todate1']) ? $_GET['todate1'] : '';

        // Indian Time Zone
        $indiaTimeZone = new DateTimeZone('Asia/Kolkata');
        $nyTimeZone = new DateTimeZone('America/New_York');

        // Function to convert date from Indian time to New York time
        function convertToNYTime($date, $timeZone) {
            try {
                $dateTime = new DateTime($date, $timeZone);
                $nyTimeZone = new DateTimeZone('America/New_York');
                $dateTime->setTimezone($nyTimeZone);
                return $dateTime->format('Y-m-d H:i:s');
            } catch (Exception $e) {
                // Handle date conversion errors
                echo "Date conversion error: " . $e->getMessage();
                exit;
            }
        }

        // Convert dates if fromdate1 and todate1 are set
        if (!empty($fromdate1) && !empty($todate1)) {
            $fromdate1Converted = convertToNYTime($fromdate1 . ' 00:00:00', $indiaTimeZone);
            $todate1Converted = convertToNYTime($todate1 . ' 23:59:59', $indiaTimeZone);
        }

        // Construct SQL query based on the provided dates
        if (empty($fromdate2) && empty($todate2)) {
            // SQL query using converted dates fromdate1 and todate1
            $sql = "SELECT `Id`, `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `pending_comments`, `pending_reason`, `pending_date`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`, `total_working_hours`, `totalcasemix`, `totalcasemixagency`, `file_completed_date`, `qc_date`, `qc_completed_date`
                    FROM Main_Data
                    WHERE `AssignCoder_date` >= '$fromdate1Converted' 
                    AND `AssignCoder_date` <= '$todate1Converted'";
        } else {
            // SQL query using dates fromdate2 and todate2 directly
            $sql = "SELECT `Id`, `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `pending_comments`, `pending_reason`, `pending_date`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`, `total_working_hours`, `totalcasemix`, `totalcasemixagency`, `file_completed_date`, `qc_date`, `qc_completed_date`
                    FROM Main_Data
                    WHERE `File_Status_Time` >= '$fromdate2 00:00:00' 
                    AND `File_Status_Time` <= '$todate2 23:59:59'";
        }

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            // Output the data as JSON
          
        } else {
            // If no records found, output message
            echo json_encode(["message" => "No records found."]);
        }
    } else {
        // Handle the case where required parameters are not set
        echo json_encode(["message" => "Required parameters are missing."]);
    }
}


 


 
 
elseif ($action == 'coder') {
    // Check if filtering based on coder is requested
    if (isset($_GET['fromdate']) && isset($_GET['todate']) || isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['teamname']) && isset($_GET['team_id']) && isset($_GET['codername']) && isset($_GET['coderid'])) {

 

        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $codername = $_GET['codername'];
        $coderid = $_GET['coderid'];

           // Indian Time Zone
        $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');

        // Construct SQL query for coder filtering
        if(empty($fromdate1) && empty($todate1)){


        $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`,`pending_comments`,`pending_reason`,`pending_date`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'
                AND `alloted_to_coder` = '$codername'
                AND `coder_emp_id` = '$coderid'";

    }
    else{
        $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`,`pending_comments`,`pending_reason`,`pending_date`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'
                AND `alloted_to_coder` = '$codername'
                AND `coder_emp_id` = '$coderid'";
    }

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } 
} 



elseif ($action == 'coderstatus') {
    // Check if filtering based on coder is requested
    if (isset($_GET['fromdate']) && isset($_GET['todate']) || isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['teamname']) && isset($_GET['team_id']) && isset($_GET['codername']) && isset($_GET['coderid'])&& isset($_GET['status'])) {

      
        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
 
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $codername = $_GET['codername'];
        $coderid = $_GET['coderid'];
        $status = $_GET['status'];


         // Indian Time Zone
        $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');

        // Construct SQL query for coder filtering

        if(empty($fromdate1) && empty($todate1)){


        $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`qc_date`,`qc_completed_date`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'
                AND `alloted_to_coder` = '$codername'
                AND `coder_emp_id` = '$coderid'
                AND `status` = '$status'";

 }

          else{

             $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`qc_date`,`qc_completed_date`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59'
                AND `alloted_team` = '$teamname'
                AND `team_emp_id` = '$team_id'
                AND `alloted_to_coder` = '$codername'
                AND `coder_emp_id` = '$coderid'
                AND `status` = '$status'";
          }      

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } 
}






 elseif ($action == 'teamaudit') {
    if (isset($_GET['fromdate'], $_GET['todate'], $_GET['teamname'], $_GET['team_id'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];

        // Sanitize input to prevent SQL injection
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);
        $teamname = mysqli_real_escape_string($conn, $teamname);
        $team_id = mysqli_real_escape_string($conn, $team_id);

        $sql = "SELECT patient_name, mrn, insurance_type, assesment_date, status, assesment_type, pending_comments, pending_reason, pending_date, agency, alloted_team, alloted_to_coder, coder_emp_id, qc_team, qc_person,qc_team_emp_id,pervious_qc_person,qc_person_emp_id, code_segment_score, oasis_segment_score, poc_segment_score, coder_avrg_score,qc_completed_date,qc_date,AssignCoder_date,file_completed_date
                FROM Main_Data
                WHERE File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'
                AND alloted_team = '$teamname'
                AND team_emp_id = '$team_id'
                AND (status = 'QC COMPLETED' OR status = 'APPROVED')";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "No records found.";
        }
    } 
}


 elseif ($action == 'qaAll_team') {
    if (isset($_GET['fromdate']) && isset($_GET['todate'])) { // Added missing closing parenthesis
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];

        // Sanitize input to prevent SQL injection
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);

        // Prepare the SQL query with parameterized statements to prevent SQL injection
        $sql = "SELECT patient_name, mrn, insurance_type, assesment_date, status, assesment_type, pending_comments, pending_reason, pending_date, agency, alloted_team, alloted_to_coder, coder_emp_id, qc_team, qc_person,qc_team_emp_id,pervious_qc_person,qc_person_emp_id, code_segment_score, oasis_segment_score, poc_segment_score, coder_avrg_score,qc_completed_date,qc_date,AssignCoder_date,file_completed_date
                FROM Main_Data
                WHERE File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'
                AND (status = 'QC COMPLETED' OR status = 'APPROVED')"; // Enclosed OR condition in parentheses

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "No records found.";
        }
    }  
}


 elseif ($action == 'agency_qc') {
    if (isset($_GET['fromdate']) && isset($_GET['todate']) && isset($_GET['agency'])) { // Added missing closing parenthesis
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $agency = $_GET['agency'];

        // Sanitize input to prevent SQL injection
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);

         $agency = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($agency), $conn), $agency));

        // Prepare the SQL query with parameterized statements to prevent SQL injection
        $sql = "SELECT patient_name, mrn, insurance_type, assesment_date, status, assesment_type, pending_comments, pending_reason, pending_date, agency, alloted_team, alloted_to_coder, coder_emp_id, qc_team, qc_person,qc_team_emp_id,pervious_qc_person,qc_person_emp_id, code_segment_score, oasis_segment_score, poc_segment_score, coder_avrg_score,qc_completed_date,qc_date,AssignCoder_date,file_completed_date
                FROM Main_Data
                WHERE File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'
                AND (status = 'QC COMPLETED' OR status = 'APPROVED') AND `agency` IN('$agency')"; // Enclosed OR condition in parentheses

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "No records found.";
        }
    }  
}


elseif ($action == 'agency_team_qc') {
    // Check if all required parameters are set
    if (isset($_GET['fromdate'], $_GET['todate'], $_GET['teamname'], $_GET['team_id'], $_GET['agency'])) {  
        // Get parameters
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $agency = $_GET['agency'];

        // Validate and sanitize input
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);
        $teamname = mysqli_real_escape_string($conn, $teamname);
        $team_id = mysqli_real_escape_string($conn, $team_id);

        // Convert agency array to string for IN clause
        $agencyPlaceholders = implode(",", array_fill(0, count($agency), "?"));

        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT patient_name, mrn, insurance_type, assesment_date, status, assesment_type, pending_comments, pending_reason, pending_date, agency, alloted_team, alloted_to_coder, coder_emp_id, qc_team,qc_person,qc_team_emp_id,pervious_qc_person,qc_person_emp_id, code_segment_score, oasis_segment_score, poc_segment_score, coder_avrg_score,qc_completed_date,qc_date,AssignCoder_date,file_completed_date
            FROM Main_Data
            WHERE File_Status_Time BETWEEN ? AND ?
            AND alloted_team = ?
            AND team_emp_id = ? 
            AND (status = 'QC COMPLETED' OR status = 'APPROVED') 
            AND `agency` IN ($agencyPlaceholders)");
        
        // Check if statement preparation succeeded
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("ssss" . str_repeat("s", count($agency)), $fromdate_start, $todate_end, $teamname, $team_id, ...$agency);

        // Set the date range for query
        $fromdate_start = $fromdate . ' 00:00:00';
        $todate_end = $todate . ' 23:59:59';

        // Execute query
        $stmt->execute();

        // Get result set
        $result = $stmt->get_result();

        // Check if records found
        if ($result->num_rows > 0) {
            // Fetch data
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "No records found.";
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Missing required parameters.";
    }
}

 
 
else if ($action == 'coderaudit') {
    if (isset($_GET['fromdate'], $_GET['todate'], $_GET['teamname'], $_GET['team_id'], $_GET['codername'], $_GET['coderid'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $codername = $_GET['codername'];
        $coderid = $_GET['coderid'];

        // Sanitize input to prevent SQL injection
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);
        $teamname = mysqli_real_escape_string($conn, $teamname);
        $team_id = mysqli_real_escape_string($conn, $team_id);
        $codername = mysqli_real_escape_string($conn, $codername);
        $coderid = mysqli_real_escape_string($conn, $coderid);

        $sql = "SELECT patient_name, mrn, insurance_type, assesment_date, status, assesment_type, pending_comments, pending_reason, pending_date, agency, alloted_team, alloted_to_coder, coder_emp_id,qc_team, qc_person,qc_team_emp_id,pervious_qc_person,qc_person_emp_id, code_segment_score, oasis_segment_score, poc_segment_score, coder_avrg_score,qc_completed_date,qc_date,AssignCoder_date,file_completed_date
                FROM Main_Data
                WHERE File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'
                AND alloted_team = '$teamname'
                AND team_emp_id = '$team_id'
                AND alloted_to_coder = '$codername'
                AND coder_emp_id = '$coderid'
                AND (status = 'QC COMPLETED' OR status = 'APPROVED')";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            $error_msg = "No records found.";
        }
    } else {
        $error_msg = "Invalid parameters.";
    }
}

else if ($action == 'agency_team_coder_qc') {
    if (isset($_GET['fromdate'], $_GET['todate'], $_GET['teamname'], $_GET['team_id'], $_GET['codername'], $_GET['coderid'],$_GET['agency'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $codername = $_GET['codername'];
        $coderid = $_GET['coderid'];
        $agency = $_GET['agency'];

        // Sanitize input to prevent SQL injection
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);
        $teamname = mysqli_real_escape_string($conn, $teamname);
        $team_id = mysqli_real_escape_string($conn, $team_id);
        $codername = mysqli_real_escape_string($conn, $codername);
        $coderid = mysqli_real_escape_string($conn, $coderid);
            $agency = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($agency), $conn), $agency));


        $sql = "SELECT patient_name, mrn, insurance_type, assesment_date, status, assesment_type, pending_comments, pending_reason, pending_date, agency, alloted_team, alloted_to_coder, coder_emp_id,qc_team, qc_person,qc_team_emp_id,pervious_qc_person,qc_person_emp_id, code_segment_score, oasis_segment_score, poc_segment_score, coder_avrg_score,qc_completed_date,qc_date,AssignCoder_date,file_completed_date
                FROM Main_Data
                WHERE File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'
                AND alloted_team = '$teamname'
                AND team_emp_id = '$team_id'
                AND alloted_to_coder = '$codername'
                AND coder_emp_id = '$coderid'
                AND `agency` IN('$agency')
                AND (status = 'QC COMPLETED' OR status = 'APPROVED')";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            $error_msg = "No records found.";
        }
    } else {
        $error_msg = "Invalid parameters.";
    }
}
 

 

 
else if ($action == 'teamfeedback') {
    // Check if all required parameters are set
    if (isset($_GET['fromdate'], $_GET['todate'], $_GET['teamname'], $_GET['team_id'], $_GET['Segment'])) {
        // Sanitize input data
        $fromdate = mysqli_real_escape_string($conn, $_GET['fromdate']);
        $todate = mysqli_real_escape_string($conn, $_GET['todate']);
        $teamname = mysqli_real_escape_string($conn, $_GET['teamname']);
        $team_id = mysqli_real_escape_string($conn, $_GET['team_id']);
        $Segment = mysqli_real_escape_string($conn, $_GET['Segment']);

        // Construct SQL query for basic filtering
       $segmentColumns = "";

if ($Segment == 'Pocsegementqc') {
    // If the segment is 'Pocsegementqc'
    $segmentColumns = "Pocsegementqc.Poc_coder_response AS Coder_response, 
                       Pocsegementqc.Coder_response AS Qc_response, 
                       Pocsegementqc.Error_reason, 
                       Pocsegementqc.Error_type, 
                       Pocsegementqc.Qc_rationali,
                       Pocsegementqc.Poc_item AS M_item";
} else if ($Segment == 'Codesegementqc') {
    // If the segment is 'Codesegementqc'
  $segmentColumns = "Codesegementqc.`ICD-code` AS Qc_response,
                      
                       Codesegementqc.Error_reason, 
                       Codesegementqc.Error_type, 
                       Codesegementqc.Qc_rationali,
                       Codesegementqc.M_item";
} else {
    // For any other segment
    $segmentColumns = "$Segment.Coder_response AS Coder_response, 
                       $Segment.Qc_response AS Qc_response, 
                       $Segment.Error_reason, 
                       $Segment.Error_type, 
                       $Segment.Qc_rationali,
                       $Segment.M_item";
}
 

$sql = "SELECT 
            Main_Data.Id,
            Main_Data.alloted_to_coder,
            Main_Data.coder_emp_id,
            Main_Data.patient_name,
            Main_Data.mrn,
            Main_Data.status,
            Main_Data.insurance_type,
            Main_Data.assesment_date,
            Main_Data.assesment_type,
            Main_Data.agency,
            Main_Data.AssignCoder_date,
            Main_Data.qc_person,
            Main_Data.qc_date,
            $segmentColumns
        FROM 
            Main_Data 
        JOIN 
            $Segment ON Main_Data.Id = $Segment.Entry_id
        WHERE 
            Main_Data.File_Status_Time >= '$fromdate 00:00:00' 
            AND Main_Data.File_Status_Time <= '$todate 23:59:59'
            AND Main_Data.alloted_team = '$teamname'
            AND Main_Data.team_emp_id = '$team_id'
            AND ($Segment.Error_type IN ('Added', 'Deleted', 'Modified', 'Other'))";

  $sql; // Printing the SQL query for debugging purposes



        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } else {
        // If any required parameter is missing, output error message
        echo "Missing parameters.";
    }
}

 


else if ($action == 'team_all_feedback') {
    // Check if all required parameters are set
    if (isset($_GET['fromdate'], $_GET['todate'], $_GET['teamname'], $_GET['team_id'], $_GET['Segment'])) {
        // Sanitize input data (better to use prepared statements)
        $fromdate = mysqli_real_escape_string($conn, $_GET['fromdate']);
        $todate = mysqli_real_escape_string($conn, $_GET['todate']);
        $teamname = mysqli_real_escape_string($conn, $_GET['teamname']);
        $team_id = mysqli_real_escape_string($conn, $_GET['team_id']);
        $Segment = mysqli_real_escape_string($conn, $_GET['Segment']);

        // Define and initialize $Pocsegementqc, $Codesegementqc, $oasisqc appropriately

        $sql = "SELECT 
                    Main_Data.Id,
                    Main_Data.alloted_to_coder,
                    Main_Data.coder_emp_id,
                    Main_Data.patient_name,
                    Main_Data.mrn,
                    Main_Data.status,
                    Main_Data.insurance_type,
                    Main_Data.assesment_date,
                    Main_Data.assesment_type,
                    Main_Data.agency,
                    Main_Data.AssignCoder_date,
                    Main_Data.qc_person,
                    Main_Data.qc_date,
                       Pocsegementqc.Poc_coder_response AS Coder_response, 
                       Pocsegementqc.Coder_response AS Qc_response, 
                       Pocsegementqc.Error_reason, 
                       Pocsegementqc.Error_type, 
                       Pocsegementqc.Qc_rationali,
                       Pocsegementqc.Poc_item AS M_item,
                       
                       oasisqc.Coder_response AS Coder_response, 
                       oasisqc.Qc_response AS Qc_response, 
                       oasisqc.Error_reason, 
                       oasisqc.Error_type, 
                       oasisqc.Qc_rationali,
                       oasisqc.M_item
                FROM 
                    Main_Data 
                JOIN 
                    Pocsegementqc ON Main_Data.Id = Pocsegementqc.Entry_id
               
                JOIN
                    oasisqc ON Main_Data.Id = oasisqc.Entry_id
                WHERE 
                    Main_Data.File_Status_Time >= '$fromdate 00:00:00' 
                    AND Main_Data.File_Status_Time <= '$todate 23:59:59'
                    AND Main_Data.alloted_team = '$teamname'
                    AND Main_Data.team_emp_id = '$team_id'
                    AND (Pocsegementqc.Error_type IN ('Added', 'Deleted', 'Modified', 'Other'))
                   
                    AND (oasisqc.Error_type IN ('Added', 'Deleted', 'Modified', 'Other'))";

        // Printing the SQL query for debugging purposes
         $sql;

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            // Process $data array as needed
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } else {
        // If any required parameter is missing, output error message
        echo "Missing parameters.";
    }
}


  









 



 elseif ($action == 'team_with_status_feedback') {
    if (isset($_GET['fromdate']) && isset($_GET['todate']) && isset($_GET['teamname']) && isset($_GET['team_id']) && isset($_GET['status'])&& isset($_GET['Segment'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $status = $_GET['status'];
        $Segment = $_GET['Segment'];

        
     $segmentColumns = "";

        if ($Segment == 'Pocsegementqc') {
            $segmentColumns = "Pocsegementqc.Poc_coder_response AS Coder_response, Pocsegementqc.Coder_response AS Qc_response, Pocsegementqc.Error_reason, Pocsegementqc.Error_type, Pocsegementqc.Qc_rationali";
        } else if ($Segment == 'Codesegementqc') {
            $segmentColumns = " Codesegementqc.Error_reason, Codesegementqc.Error_type, Codesegementqc.Qc_rationali";
        } else {
            $segmentColumns = "$Segment.Coder_response AS Coder_response, $Segment.Qc_response AS Qc_response, $Segment.Error_reason, $Segment.Error_type, $Segment.Qc_rationali";
        }
        // Construct SQL query for basic filtering
        $sql = "SELECT 
    Main_Data.Id,
    Main_Data.alloted_to_coder,
    Main_Data.coder_emp_id,
    Main_Data.patient_name,
    Main_Data.mrn,
    Main_Data.status,
    Main_Data.insurance_type,
    Main_Data.assesment_date,
    Main_Data.assesment_type,
    Main_Data.agency,
    Main_Data.AssignCoder_date,
    Main_Data.qc_person,
    Main_Data.qc_date,
    $segmentColumns
FROM 
    Main_Data 
JOIN 
    $Segment ON Main_Data.Id = $Segment.Entry_id
WHERE 
    Main_Data.File_Status_Time >= '$fromdate 00:00:00' 
    AND Main_Data.File_Status_Time <= '$todate 23:59:59'
    AND Main_Data.alloted_team = '$teamname'
    AND Main_Data.team_emp_id = '$team_id'
    AND ($Segment.Error_type='$status' OR $Segment.Error_type='$status' OR $Segment.Error_type='$status' OR $Segment.Error_type='$status')";

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    }
}


elseif ($action == 'coderfeedback') {
    if (isset($_GET['fromdate']) && isset($_GET['todate']) && isset($_GET['teamname']) && isset($_GET['team_id']) && isset($_GET['codername']) && isset($_GET['coderid'])&& isset($_GET['Segment'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $codername = $_GET['codername'];
        $coderid = $_GET['coderid'];
        $Segment = $_GET['Segment'];


        $segmentColumns = "";

        if ($Segment == 'Pocsegementqc') {
            $segmentColumns = "Pocsegementqc.Poc_coder_response AS Coder_response, Pocsegementqc.Coder_response AS Qc_response, Pocsegementqc.Error_reason, Pocsegementqc.Error_type, Pocsegementqc.Qc_rationali";
        } else if ($Segment == 'Codesegementqc') {
            $segmentColumns = " Codesegementqc.Error_reason, Codesegementqc.Error_type, Codesegementqc.Qc_rationali";
        } else {
            $segmentColumns = "$Segment.Coder_response AS Coder_response, $Segment.Qc_response AS Qc_response, $Segment.Error_reason, $Segment.Error_type, $Segment.Qc_rationali";
        }
        



        // Construct SQL query for basic filtering
     // $sql = "SELECT 
     //        Main_Data.Id,
     //        Main_Data.alloted_to_coder,
     //        Main_Data.coder_emp_id,
     //        Main_Data.patient_name,
     //        Main_Data.mrn,
     //        Main_Data.status,
     //        Main_Data.insurance_type,
     //        Main_Data.assesment_date,
     //        Main_Data.assesment_type,
     //        Main_Data.agency,
     //        Main_Data.AssignCoder_date,
     //        Main_Data.qc_person,
     //        Main_Data.qc_date,
     //       $segmentColumns
     //    FROM 
     //        Main_Data 
     //    JOIN 
     //        $Segment ON Main_Data.Id = $Segment.Entry_id
     //    WHERE 
     //        Main_Data.File_Status_Time >= '$fromdate 00:00:00' 
     //        AND Main_Data.File_Status_Time <= '$todate 23:59:59'
     //        AND Main_Data.alloted_team = '$teamname'
     //        AND Main_Data.team_emp_id = '$team_id'
     //        AND Main_Data.alloted_to_coder = '$codername'
     //        AND Main_Data.coder_emp_id = '$coderid'
     //        AND ($Segment.Error_type='Added' OR $Segment.Error_type='Deleted' OR $Segment.Error_type='Modified' OR $Segment.Error_type='Other')";

     //    // Execute SQL query
     //    $result = $conn->query($sql);

     //    // Check if result is valid and contains data
     //    if ($result && $result->num_rows > 0) {
     //        while ($row = $result->fetch_assoc()) {
     //            $data[] = $row;
     //        }
     //    } else {
     //        // If no records found, output message
     //        echo "No records found.";
     //    }
    }
}


else if ($action == 'coder_with_status_feedback') {
    if (isset($_GET['fromdate']) && isset($_GET['todate']) && isset($_GET['teamname']) && isset($_GET['team_id']) && isset($_GET['codername']) && isset($_GET['coderid'])&& isset($_GET['status'])&& isset($_GET['Segment'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $codername = $_GET['codername'];
        $coderid = $_GET['coderid'];
        $status = $_GET['status'];
        $Segment = $_GET['Segment'];

         $segmentColumns = "";

        if ($Segment == 'Pocsegementqc') {
            $segmentColumns = "Pocsegementqc.Poc_coder_response AS Coder_response, Pocsegementqc.Coder_response AS Qc_response, Pocsegementqc.Error_reason, Pocsegementqc.Error_type, Pocsegementqc.Qc_rationali";
        } else if ($Segment == 'Codesegementqc') {
            $segmentColumns = "  Codesegementqc.Error_reason, Codesegementqc.Error_type, Codesegementqc.Qc_rationali";
        } else {
            $segmentColumns = "$Segment.Coder_response AS Coder_response, $Segment.Qc_response AS Qc_response, $Segment.Error_reason, $Segment.Error_type, $Segment.Qc_rationali";
        }
       
        // $sql1 = mysqli_query($conn, "SELECT * FROM Main_Data md, Codesegementqc cd, oasisqc oa, Pocsegementqc po WHERE cd.timestamp BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' AND md.id = cd.Entry_id AND md.coder_emp_id = '$coderid' AND oa.Entry_id = md.id AND md.id = po.Entry_id AND cd.Error_type NOT_IN ('None', '') AND  ORDER BY cd.M_item ASC");
        // while($getOne = mysqli_fetch_assoc($sql1))
        // {
        //     $data['codesegementqc'][] = $getOne;
        // }
        $falg = 0;
        $sql1 = mysqli_query($conn, "SELECT * FROM Main_Data md, Codesegementqc cd WHERE cd.timestamp BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' AND md.id = cd.Entry_id AND md.coder_emp_id = '$coderid' AND cd.Error_type NOT IN ('None', '') ORDER BY cd.M_item ASC");
        while($getOne = mysqli_fetch_assoc($sql1))
        {
            $flag = 1;
            $data['codesegementqc'][] = $getOne;
        }

        $sql2 = mysqli_query($conn, "SELECT * FROM Main_Data md, oasisqc cd WHERE cd.timestamp BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' AND md.id = cd.Entry_id AND md.coder_emp_id = '$coderid' AND cd.Error_type NOT IN ('None', '') ORDER BY cd.M_item ASC");
        while($getTwo = mysqli_fetch_assoc($sql2))
        {
            $data['oasisqc'][] = $getTwo;
        }

        $sql3 = mysqli_query($conn, "SELECT * FROM Main_Data md, Pocsegementqc cd WHERE cd.timestamp BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' AND md.id = cd.Entry_id AND md.coder_emp_id = '$coderid' AND cd.Error_type NOT IN ('None', '') ORDER BY cd.Poc_item ASC");
        while($getThree = mysqli_fetch_assoc($sql3))
        {
            $data['pocsegementqc'][] = $getThree;
        }

        // Construct SQL query for basic filtering
        // $sql = "SELECT 
        //     Main_Data.Id,
        //     Main_Data.alloted_to_coder,
        //     Main_Data.coder_emp_id,
        //     Main_Data.patient_name,
        //     Main_Data.mrn,
        //     Main_Data.status,
        //     Main_Data.insurance_type,
        //     Main_Data.assesment_date,
        //     Main_Data.assesment_type,
        //     Main_Data.agency,
        //     Main_Data.AssignCoder_date,
        //     Main_Data.qc_person,
        //     Main_Data.qc_date,
        //     $segmentColumns
        // FROM 
        //     Main_Data 
        // JOIN 
        //     $Segment ON Main_Data.Id = $Segment.Entry_id
        // WHERE 
        //     Main_Data.File_Status_Time >= '$fromdate 00:00:00' 
        //     AND Main_Data.File_Status_Time <= '$todate 23:59:59'
        //     AND Main_Data.alloted_team = '$teamname'
        //     AND Main_Data.team_emp_id = '$team_id'
        //     AND Main_Data.alloted_to_coder = '$codername'
        //     AND Main_Data.coder_emp_id = '$coderid'
        //     AND ($Segment.Error_type='$status' OR $Segment.Error_type='$status' OR $Segment.Error_type='$status' OR $Segment.Error_type='$status')";

        // // Execute SQL query
        // $result = $conn->query($sql);

        // // Check if result is valid and contains data
        // if ($result && $result->num_rows > 0) {
        //     while ($row = $result->fetch_assoc()) {
        //         $data[] = $row;
        //     }
        // } else {
        //     // If no records found, output message
        //     echo "No records found.";
        // }
    }
}

elseif ($action == 'mrn_check') {
    if (isset($_GET['fromdate'], $_GET['todate'], $_GET['mrn'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $mrn = $_GET['mrn'];
       

        // Sanitize input to prevent SQL injection
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);
        $mrn = mysqli_real_escape_string($conn, $mrn);
 
         $sql = "SELECT `entry_id`, `patient_name`, `mrn`,`assesment_date`, `assesment_type`, `agency`, `status`, `Team`, `team_emp_id`, `Coder`, `coder_emp_id`,`logtime`FROM `Work_Log`
                WHERE logtime BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'
                AND mrn = '$mrn'";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "No records found.";
        }
    } 
}


elseif ($action == 'mrn_patient') {
    if (isset($_GET['fromdate'], $_GET['todate'], $_GET['mrn'], $_GET['patient'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $mrn = $_GET['mrn'];
        $patient = $_GET['patient'];

        // Sanitize input to prevent SQL injection
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);
        $mrn = mysqli_real_escape_string($conn, $mrn);
        $patient = mysqli_real_escape_string($conn, $patient);
 
         $sql = "SELECT `entry_id`, `patient_name`, `mrn`,`assesment_date`, `assesment_type`, `agency`, `status`, `Team`, `team_emp_id`, `Coder`, `coder_emp_id`,`logtime`FROM `Work_Log`
                WHERE logtime BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'
                AND mrn = '$mrn'
                AND patient_name='$patient'";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "No records found.";
        }
    } 
}

elseif ($action == 'patient_check') {
    if (isset($_GET['fromdate'], $_GET['todate'], $_GET['patient'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $patient = $_GET['patient'];

        // Sanitize input to prevent SQL injection
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);
        $patient = mysqli_real_escape_string($conn, $patient);
 
         $sql = "SELECT `entry_id`, `patient_name`, `mrn`,`assesment_date`, `assesment_type`, `agency`, `status`, `Team`, `team_emp_id`, `Coder`, `coder_emp_id`,`logtime`FROM `Work_Log`
                WHERE logtime BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'
                AND patient_name='$patient'";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "No records found.";
        }
    } 
}



elseif ($action == 'all_log') {
    if (isset($_GET['fromdate'], $_GET['todate'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
 

        // Sanitize input to prevent SQL injection
        $fromdate = mysqli_real_escape_string($conn, $fromdate);
        $todate = mysqli_real_escape_string($conn, $todate);
 
 
         $sql = "SELECT `entry_id`, `patient_name`, `mrn`,`assesment_date`, `assesment_type`, `agency`, `status`, `Team`, `team_emp_id`, `Coder`, `coder_emp_id`,`logtime`FROM `Work_Log`
                WHERE logtime BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "No records found.";
        }
    } 
}

elseif ($action == 'dastatus') {
    // Check if filtering based on coder is requested
    if (isset($_GET['fromdate']) && isset($_GET['todate']) || isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['status'])) {

      
        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
        $status = $_GET['status'];



                   // Indian Time Zone
        $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');

        // Construct SQL query for coder filtering

        if(empty($fromdate1) && empty($todate1)){

          $sql = "SELECT `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `status` = '$status'";
        }
      else {
         
                $sql = "SELECT `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE (`File_Status_Time` BETWEEN '$fromdate1 00:00:00' AND '$todate1 23:59:59' OR `log_time` BETWEEN '$fromdate1 00:00:00' AND '$todate1 23:59:59')
                AND `status` = '$status'";

      }  
  

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } 
}
 
elseif ($action == 'pro_mrn') {
    // Check if filtering based on coder is requested
    if (isset($_GET['fromdate']) && isset($_GET['todate']) || isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['mrn'])) {

        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
        $mrn = $_GET['mrn'];


                   // Indian Time Zone
        $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');

        // Construct SQL query for coder filtering

        if(empty($fromdate1) && empty($todate1)){

              $sql = "SELECT `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `mrn` = '$mrn'";
        }
      
      else{

          $sql = "SELECT `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59'
                AND `mrn` = '$mrn'";
      }

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } 
}
elseif ($action == 'p_name') {
    // Check if filtering based on coder is requested
    if (isset($_GET['fromdate']) && isset($_GET['todate']) || isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['p_name']) ) {

     
        $p_name = $_GET['p_name'];
        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
 
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
        


                   // Indian Time Zone
        $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');

        $p_name = mysqli_real_escape_string($conn, $p_name);

        // Construct SQL query for coder filtering
        if(empty($fromdate1) && empty($todate1)){


        $sql = "SELECT `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `patient_name`like'%$p_name%'";

      }

       else{
         $sql = "SELECT `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59'
                AND `patient_name`like'%$p_name%'";   
       }         

              

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } 
}

elseif ($action == 'agency_full_report') {
    // Check if filtering based on coder is requested
    if (isset($_GET['fromdate']) && isset($_GET['todate']) || isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['agency'])) {

      
        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
        $agency = $_GET['agency'];

               // Indian Time Zone
        $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');
        
        // $agency = mysqli_real_escape_string($conn, $agency);

        $agency = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($agency), $conn), $agency));

        // Construct SQL query for coder filtering
        if(empty($fromdate1) && empty($todate1)){


        $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `agency`IN('$agency')";
        }

        else{

              $sql = "SELECT `Id`,`patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59'
                AND `agency`IN('$agency')";
        }

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } 
}

elseif ($action == 'agency_status') {
    // Check if filtering based on coder is requested
    if (isset($_GET['fromdate']) && isset($_GET['todate']) || isset($_GET['fromdate1']) && isset($_GET['todate1']) && isset($_GET['agency'])&& isset($_GET['status'])) {

      
        $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
        $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
        $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
        $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
        $agency = $_GET['agency'];
        $status = $_GET['status'];

              // Indian Time Zone
        $indiaTimeZone = new DateTimeZone('Asia/Kolkata');

        // Convert fromdate from Indian time to New York time
        $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
        $nyTimeZone = new DateTimeZone('America/New_York');
        $fromDateTime->setTimezone($nyTimeZone);
        $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

       


        // Convert todate from Indian time to New York time
        $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
        $toDateTime->setTimezone($nyTimeZone);
        $todateConverted = $toDateTime->format('Y-m-d H:i:s');
        
       $agency = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($agency), $conn), $agency));

        // Construct SQL query for coder filtering
       if(empty($fromdate1) && empty($todate1)){

         $sql = "SELECT `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted'
                AND `agency`IN('$agency')

                AND `status`='$status'";
       }
      else{

         $sql = "SELECT `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`,`pending_comments`,`pending_reason`,`pending_date`,`agency`, `status`, `alloted_team`, `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`,`total_working_hours`,`totalcasemix`,`totalcasemixagency`,`file_completed_date`,`qc_date`,`qc_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59'
                AND `agency`IN('$agency')

                AND `status`='$status'";
      } 
       

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is valid and contains data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // If no records found, output message
            echo "No records found.";
        }
    } 
}





 


else {
    echo "No records found.";
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();

?>
