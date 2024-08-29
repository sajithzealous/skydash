<?php

 


// Start session and error reporting
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

 include('../db/db-con.php');

// Check if the user session exists
$user = $_SESSION['username'] ?? null;
$Id = intval($_POST['Id']);
$Reason=$_POST['Reason'];
$Comment=$_POST['Comment'];
$emp_id = $_SESSION['empid'];


   $Comment = mysqli_real_escape_string($conn, $Comment);
    $Reason = mysqli_real_escape_string($conn, $Reason);
 
 

// Construct the SQL queries
$query1 = "UPDATE `Codesegementpend` SET `status` = 'NOT-USED' WHERE `Entry_Id` = '$Id' AND `status`='USED'";
$query2 = "UPDATE `oasis_pend` SET `status` = 'NOT-USED' WHERE `Entry_Id` = '$Id' AND `status`='USED'";
$query3 = "UPDATE `Pocsegement_pend` SET `status` = 'NOT-USED' WHERE `Entry_Id` = '$Id' AND `status`='USED'";

// Execute the SQL queries
if ($conn->query($query1) === TRUE && $conn->query($query2) === TRUE && $conn->query($query3) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Records updated successfully";
} else {
    $response['success'] = false;
    $response['error'] = "Error updating records: " . $conn->error;
}



$query = "SELECT * FROM `Main_Data` WHERE `Id` = $Id";
//Update query

 date_default_timezone_set('America/New_York');
     $currentDateTime = date('Y-m-d H:i:s');
  echo $updateQuery = "UPDATE `Main_Data` SET `status` = 'PENDING',`File_Status_Time`= '$currentDateTime' ,`pending_date`='$currentDateTime',`pending_comments`='$Comment',`pending_reason`='$Reason' WHERE `Id` = '$Id'";
    $response = [];

    if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Record updated successfully";
        
    } else {
        $response['success'] = false;
        $response['error'] = "Error updating record: " . $conn->error;
    }

$query_result = $conn->query($query);

if ($query_result) {
    $dataRow = $query_result->fetch_assoc();
    $patientName = $dataRow['patient_name'];
    $mrn = $dataRow['mrn'];
    $assessmentDate = $dataRow['assesment_date'];
    $phone_number = $conn->real_escape_string($dataRow['phone_number']);
    $insurance_type = $conn->real_escape_string($dataRow['insurance_type']);
    $assessment_date = $conn->real_escape_string($dataRow['assesment_date']);
    $assessment_type = $conn->real_escape_string($dataRow['assesment_type']);
    $agency = $conn->real_escape_string($dataRow['agency']);
    $status = "PENDING";
    $Team = $conn->real_escape_string($dataRow['alloted_team']);
    $Coder = $conn->real_escape_string($dataRow['alloted_to_coder']);
    $Team_empid = $conn->real_escape_string($dataRow['team_emp_id']);
    $Coder_empid = $conn->real_escape_string($dataRow['coder_emp_id']);

           $select_query2 = "SELECT * from `Work_Log` where  `entry_id`='$Id' AND `work_start` is not null AND `work_end` is null order by 'timestamp' desc limit 1";

           
            $select_result2 = $conn->query($select_query2);

            if ($select_result2 && $select_result2->num_rows > 0) {
                // Data is retrieved, update the record
                $select_query3 = "UPDATE `Work_Log` SET `work_end`='$currentDateTime' WHERE `entry_id`='$Id' AND `coder_emp_id`='$Coder_empid'AND `work_end` is null ";
                
                // Execute the update query
                $update_result = $conn->query($select_query3);

                if ($update_result) {
                    echo "Work end time updated successfully.";
                } else {
                    echo "Error in update query: " . $conn->error;
                }
            } else {
                echo "No data retrieved from select query or work_start is empty.";
            }
                



    $insert_query = "INSERT INTO `Work_Log` (`entry_id`, `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `status`, `Team`, `Coder`,`team_emp_id`,`coder_emp_id`,`work_start`) VALUES ('$Id', '$patientName', '$mrn', '$phone_number', '$insurance_type', '$assessment_date', '$assessment_type', '$agency', '$status', '$Team', '$Coder','$Team_empid','$Coder_empid', '$currentDateTime')";

    $insert_result = $conn->query($insert_query);
    if ($insert_result) {
        $response['success'] = true;
        $response['message'] = "Pending/WIP Successfully";
    } else {
        $response['success'] = false;
        $response['error'] = "Error inserting data into Work_Log table: " . $conn->error;
    }


    //CODE_SEGEMENT

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = $_POST['code_sege'];

        foreach ($data as $row) {
            $Id = $row['EntryId'];
            $mitems = $row['mitems'];
            $icd = $row['icd'];
            $description = $row['description'];
            $effectivedate = date("m/d/Y", strtotime($row['effectivedate']));
            $eo = $row['eo'];
            $rating = $row['rating'];
            $user = $_SESSION['username'] ?? '';
            $emp_id = $_SESSION['empid'];
            $coderchecked = $row['coderchecked'];
            $agencychecked = $row['agencychecked'];
            $agencyprimarycode=$row['agencyprimarycode'];


            if ($mitems !== '' && $icd !== '' && $description !== '' && $effectivedate !== '' && $eo !== '' && $coderchecked !=='' && $agencychecked !=='' && $agencyprimarycode !== '' ) {
                $sql1 = "INSERT INTO `Codesegementpend`(`Entry_Id`, `Mrn`, `Patient_Name`, `Assessment_Date`, `M-Items`, `ICD-code`, `Description`, `Effective_Date`, `Eo`, `Rating`,`Coderchecked`,`Agencychecked`, `Agencyprimarycode`, `User`, `status`,`coder_emp_id`) 
                VALUES ('$Id','$mrn','$patientName','$assessmentDate','$mitems','$icd','$description','$effectivedate','$eo','$rating','$coderchecked','$agencychecked','$agencyprimarycode','$user','Used','$emp_id')";

                if ($conn->query($sql1) === TRUE) {
                    echo "Inserted";
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {


                echo "code_segement data is empty";
            }
        }
    } else {


        echo "code segement error";
    }

    //OASIS_SEGEMENT

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formDataArray = $_POST['oasis_sege'];

        foreach ($formDataArray as $formData) {

            $mitemValue = $conn->real_escape_string($formData['mitemAttributeValue']);

            // Check if the input is an array before using implode
            $Agency_response = '';
            if (is_array($formData['oasis_inpu1'])) {
                $Agency_response = $conn->real_escape_string(implode(', ', $formData['oasis_inpu1']));
            } else {
                $Agency_response = $conn->real_escape_string($formData['oasis_inpu1']);
            }

            // Similar check for Coder_response
            $Coder_response = '';
            if (is_array($formData['oasis_inpu2'])) {
                $Coder_response = $conn->real_escape_string(implode(', ', $formData['oasis_inpu2']));
            } else {
                $Coder_response = $conn->real_escape_string($formData['oasis_inpu2']);
            }

            $Coder_rationali = $conn->real_escape_string($formData['oasis_inpu3']);

            // Validate data before insertion
            if ($mitemValue !== '' && $Agency_response !== '' && $Coder_response !== '') {
                $sql2 = "INSERT INTO `oasis_pend`(`Entry_id`, `Mrn`, `Patient_Name`, `M_item`, `Agency_response`, `Coder_response`, `Coder_rationali`, `User`, `status`,`coder_emp_id`) 
                  VALUES ('$Id', '$mrn', '$patientName', '$mitemValue', '$Agency_response', '$Coder_response', '$Coder_rationali', '$user', 'Used','$emp_id')";

                if ($conn->query($sql2) === TRUE) {
                    echo $mitemValue;
                } else {
                    echo "no oasis data inserted";
                }
            } else {

                echo "oasis segement has empty data";
            }
        }
    } else {

        echo "oasis segement error";
    }


    //POC_SEGEMENT

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formDataArraypoc = $_POST['poc_sege'];

        foreach ($formDataArraypoc as $formDatapoc) {
            $pocitemValue = $conn->real_escape_string($formDatapoc['pocitemAttributeValue']);

            // Check if the input is an array before using implode
            $Coder_response = '';
            if (is_array($formDatapoc['pocvalue'])) {
                $Coder_response = $conn->real_escape_string(implode(', ', $formDatapoc['pocvalue']));
            } else {
                $Coder_response = $conn->real_escape_string($formDatapoc['pocvalue']);
            }


            // Validate data before insertion
            if ($pocitemValue !== '' && $Coder_response !== '') {
                $sql3 = "INSERT INTO `Pocsegement_pend`(`Entry_id`, `Mrn`, `Patient_Name`, `Poc_item`, `Coder_response`, `User`, `status`,`coder_emp_id`) 
                        VALUES ('$Id', '$mrn', '$patientName', '$pocitemValue', '$Coder_response','$user','Used','$emp_id')";

                if ($conn->query($sql3) === TRUE) {
                    echo "$pocitemValue";
                } else {
                    echo "no poc data inserted ";
                }
            } else {

                echo "poc segement has empty data";
            }
        }
    } else {

        echo "poc segement error";
    }
} else {


    echo "select query wrong";
}


// Close the database connection
$conn->close();
