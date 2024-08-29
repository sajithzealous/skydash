<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user = $_SESSION['username'];
$emp_id = $_SESSION['empid'];

 include('../db/db-con.php');




if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$data = $_POST['dataArray'] ?? [];
$Id=$_POST['Id'];

if (empty($data)) {
    echo json_encode(['success' => false, 'error' => 'Empty Data Not Insertted ']);
}


// if (empty($user)) {
//     echo json_encode(['success' => false, 'error' => 'Empty username']);
// }

 
$query1 = "UPDATE `Codesegement` SET `code_status` = 'NOT-USED' WHERE `Entry_Id` = '$Id'";

if ($conn->query($query1) === TRUE) {
    // $response['success'] = true;
    // $response['message'] = "Records updated successfully";
} else {
    // $response['success'] = false;
    // $response['error'] = "Error updating records: " . $conn->error;
}



foreach ($data as $row) {
      $Id = $row['EntryId'];
 
    $mitems = $row['mitems'];
    $icd = $row['icd'];
    $description = $row['description'];
    $effectivedate = !empty($row['effectivedate']) ? date("m/d/Y", strtotime($row['effectivedate'])) : "";
    $eo = $row['eo'];
    $rating = $row['rating'];
    $gender = $row['gender'];
    $status = 'Coder_review';


    // $allowed_chars = "/^[a-zA-Z0-9\s.,!?@#\$%^&*()_\-={}|\\\/;'\":<>[\]]+$/"; 
    

// if (!preg_match($allowed_chars, $description)) {
//     die("Invalid description found!");
// }



    if ($icd != "" && $description != "" && $effectivedate != "") {
        if ($mitems == "M1021A") {
            $primaryDiagnosisQuery = "SELECT `ICD-10-code`, `Clinical_group`,`Clinical_group_name` FROM `Codedescription` WHERE `ICD-10-code`='$icd' AND `Diagnosis_type` ='Primary' ";
            $primaryDiagnosisResult = $conn->query($primaryDiagnosisQuery);
            $isPrimaryDiagnosis = $primaryDiagnosisResult->num_rows > 0;

            if (!$isPrimaryDiagnosis) {
                echo json_encode(['success' => false, 'error' => 'Invalid or non-primary Diagnosis']);
                break;
            }

            if (empty($gender) || !in_array($gender, ['male', 'female', ''])) {
                echo json_encode(['success' => false, 'error' => 'Invalid or empty gender']);
                break;
            }

            $genderQuery = "SELECT `ICD-10-code` FROM `Codedescription` WHERE `ICD-10-code`='$icd' AND (`Category`= '$gender' OR `Category`= '')";
            $genderResult = $conn->query($genderQuery);
            $isGenderValid = $genderResult->num_rows > 0;

            if (!$isGenderValid) {
                echo json_encode(['success' => false, 'error' => 'Invalid gender for this diagnosis']);
                continue;
            }

            $mitemssql = "SELECT `M-Items` FROM `Codesegement` WHERE `M-Items` = '$mitems' AND `Entry_id` = '$Id'";
            $mitemssqlresult = $conn->query($mitemssql);
            $mitemssqlresultExist = $mitemssqlresult->num_rows > 0;

            if ($mitemssqlresultExist) {
                $updateQuery = "UPDATE `Codesegement` SET `M-Items`='$mitems', `ICD-code`='$icd', `Description`='$description', `Effective_Date`='$effectivedate', `Eo`='$eo', `Rating`='$rating',`User`='$user',`coder_emp_id` = '$emp_id',`code_status` = null  WHERE `M-Items`='$mitems' AND `Entry_id`='$Id'";



                if ($conn->query($updateQuery) === TRUE) {
                    // echo json_encode(['success' => true, 'message' => 'Data updated successfully XXXXXXXXX']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Update query error: ' . $conn->error]);
                }
            } else {
                $patientQuery = "SELECT `patient_name`, `mrn`, `assesment_date` FROM `Main_Data` WHERE `Id` = '$Id'";
                $patientResult = $conn->query($patientQuery);

                if ($patientResult) {
                    $dataRow = $patientResult->fetch_assoc();

                    $patientName = $dataRow['patient_name'];
                    $mrn = $dataRow['mrn'];
                    $assessmentDate = $dataRow['assesment_date'];

                    $insertQuery = "INSERT INTO `Codesegement`(`Entry_Id`, `Mrn`, `Patient_Name`, `Assessment_Date`, `M-Items`, `ICD-code`, `Description`, `Effective_Date`, `Eo`, `Rating`, `User`,`status`,`coder_emp_id`) 
                                VALUES ('$Id','$mrn','$patientName','$assessmentDate','$mitems','$icd','$description','$effectivedate','$eo','$rating','$user','$status','$emp_id')";
                    $insertResult = $conn->query($insertQuery);

                    if ($insertResult) {
                        // echo json_encode(['success' => true, 'message' => 'Data inserted successfully xxxxxxxxxxx']);

                    } else {
                        echo json_encode(['success' => false, 'error' => 'Error inserting data']);
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Error in database query']);
                }
            }
        } else {
            if (empty($gender) || !in_array($gender, ['male', 'female', ''])) {
                echo json_encode(['success' => false, 'error' => 'Invalid or empty gender']);
                continue;
            }

            $genderQuery = "SELECT `ICD-10-code` FROM `Codedescription` WHERE `ICD-10-code`='$icd' AND (`Category`= '$gender' OR `Category`= '')";
            $genderResult = $conn->query($genderQuery);
            $isGenderValid = $genderResult->num_rows > 0;

            if (!$isGenderValid) {
                echo json_encode(['success' => false, 'error' => 'Invalid gender for this diagnosis']);
                continue;
            }

            $mitemssql = "SELECT `M-Items` FROM `Codesegement` WHERE `M-Items` = '$mitems' AND `Entry_id` = '$Id'";
            $mitemssqlresult = $conn->query($mitemssql);
            $mitemssqlresultExist = $mitemssqlresult->num_rows > 0;


         

            if ($mitemssqlresultExist) {
                $updateQuery = "UPDATE `Codesegement` SET `M-Items`='$mitems', `ICD-code`='$icd', `Description`='$description', `Effective_Date`='$effectivedate', `Eo`='$eo', `Rating`='$rating',`User`='$user',`coder_emp_id` = '$emp_id',`code_status` = null WHERE `M-Items`='$mitems' AND `Entry_id`='$Id'";


              

                if ($conn->query($updateQuery) === TRUE) {
                    // echo json_encode(['success' => true, 'message' => 'Data updated successfully']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Update query error: ' . $conn->error]);
                }
            } else {
                $patientQuery = "SELECT `patient_name`, `mrn`, `assesment_date` FROM `Main_Data` WHERE `Id` = '$Id'";
                $patientResult = $conn->query($patientQuery);

                if ($patientResult) {
                    $dataRow = $patientResult->fetch_assoc();

                    $patientName = $dataRow['patient_name'];
                    $mrn = $dataRow['mrn'];
                    $assessmentDate = $dataRow['assesment_date'];

                    $insertQuery = "INSERT INTO `Codesegement`(`Entry_Id`, `Mrn`, `Patient_Name`, `Assessment_Date`, `M-Items`, `ICD-code`, `Description`, `Effective_Date`, `Eo`, `Rating`, `User`,`status`,`coder_emp_id`) 
                                VALUES ('$Id','$mrn','$patientName','$assessmentDate','$mitems','$icd','$description','$effectivedate','$eo','$rating','$user','$status','$emp_id')";
                    $insertResult = $conn->query($insertQuery);

                    if ($insertResult) {
                        // echo json_encode(['success' => true, 'message' => 'Data inserted successfully']);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Error inserting data']);
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Error in database query']);
                }
            }
            // echo json_encode(['success' => false, 'error' => 'Diagnosis type not primary']);
        }
    }
    else{

        echo json_encode(['success' => false, 'error' => 'One Or More Fields Empty']);
                break;


    }
}

$conn->close();
