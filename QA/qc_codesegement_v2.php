<?php
session_start();
 

$user = $_SESSION['username'] ?? null;
$emp_id = $_SESSION['empid'];

 include('../db/db-con.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$data = $_POST['dataArray'] ?? [];

if (empty($data)) {
    echo json_encode(['success' => false, 'error' => 'Empty Data Not Insertted ']);
    
}



foreach ($data as $row) {
    $Id = $row['EntryId'];
    $mitems = $row['mitems'];
    $icd = $row['icd'];
    $icd_code =strtoupper($icd);
    $description = $row['description'];
    $effectivedate = date("m/d/Y", strtotime($row['effectivedate']));
    $eo = $row['eo'];
    $rating = $row['rating'];
    $gender = $row['gender'];
    $reason=$row['reason'];
    $errortype=$row['errortype'];
    $qcrationaile=$row['qcrationaile'];
    $coderchecked=$row['coderchecked'];
    $agencychecked=$row['agencychecked'];
    $mitemchecking=$row['mitemchecking'];
    $status = 'Qc_review';
    
    $description = $conn -> real_escape_string($description);
    $qcrationaile = $conn -> real_escape_string($qcrationaile);

    if ($mitems == "M1021A") {
        $primaryDiagnosisQuery = "SELECT `ICD-10-code` FROM `Codedescription` WHERE `ICD-10-code`='$icd_code' AND `Diagnosis_type` ='Primary'";
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

        $genderQuery = "SELECT `ICD-10-code` FROM `Codedescription` WHERE `ICD-10-code`='$icd_code' AND (`Category`= '$gender' OR `Category`= '')";
        $genderResult = $conn->query($genderQuery);
        $isGenderValid = $genderResult->num_rows > 0;

        if (!$isGenderValid) {
            echo json_encode(['success' => false, 'error' => 'Invalid gender for this diagnosis']);
            continue;
        }

        $mitemssql = "SELECT `M_Item` FROM `Codesegementqc` WHERE `M_Item` = '$mitems' AND `Entry_id` = '$Id'";
        $mitemssqlresult = $conn->query($mitemssql);
        $mitemssqlresultExist = $mitemssqlresult->num_rows > 0;

        if ($mitemssqlresultExist) {
            $updateQuery = "UPDATE `Codesegementqc` SET `M_Item`='$mitems', `ICD-code`='$icd_code', `Description`='$description', `Effective_Date`='$effectivedate', `Eo`='$eo', `Rating`='$rating' ,`Error_reason`='$reason',`Error_type`='$errortype',`Qc_rationali`='$qcrationaile',`User`='$user',`coder_emp_id` = '$emp_id',`Coderchecked`='$coderchecked',`Agencychecked`='$agencychecked',`Agencyprimarycode`='$mitemchecking' WHERE `M_Item`='$mitems' AND `Entry_id`='$Id'";

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

                $insertQuery = "INSERT INTO `Codesegementqc`(`Entry_Id`, `Mrn`, `Patient_Name`, `Assessment_Date`, `M_Item`, `ICD-code`, `Description`, `Effective_Date`, `Eo`, `Rating`, `User`,`status`,`Error_reason`,`Error_type`,`Qc_rationali`,`coder_emp_id`,`Coderchecked`, `Agencychecked`, `Agencyprimarycode`) 
                                VALUES ('$Id','$mrn','$patientName','$assessmentDate','$mitems','$icd_code','$description','$effectivedate','$eo','$rating','$user','$status','$reason','$errortype','$qcrationaile','$emp_id','$coderchecked','$agencychecked','$mitemchecking')";
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

        $genderQuery = "SELECT `ICD-10-code` FROM `Codedescription` WHERE `ICD-10-code`='$icd_code' AND (`Category`= '$gender' OR `Category`= '')";
        $genderResult = $conn->query($genderQuery);
        $isGenderValid = $genderResult->num_rows > 0;

        if (!$isGenderValid) {
            echo json_encode(['success' => false, 'error' => 'Invalid gender for this diagnosis']);
            continue;
        }

        $mitemssql = "SELECT `M_Item` FROM `Codesegementqc` WHERE `M_Item` = '$mitems' AND `Entry_id` = '$Id'";
        $mitemssqlresult = $conn->query($mitemssql);
        $mitemssqlresultExist = $mitemssqlresult->num_rows > 0;

        if ($mitemssqlresultExist) {
            $updateQuery = "UPDATE `Codesegementqc` SET `M_Item`='$mitems', `ICD-code`='$icd_code', `Description`='$description', `Effective_Date`='$effectivedate', `Eo`='$eo', `Rating`='$rating' ,`Error_reason`='$reason',`Error_type`='$errortype',`Qc_rationali`='$qcrationaile',`User`='$user',`coder_emp_id` = '$emp_id' ,`Coderchecked`='$coderchecked' ,`Agencychecked`='$agencychecked' ,`Agencyprimarycode`='$mitemchecking' WHERE `M_Item`='$mitems' AND `Entry_id`='$Id'";

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

                 
                $insertQuery = "INSERT INTO `Codesegementqc`(`Entry_Id`, `Mrn`, `Patient_Name`, `Assessment_Date`, `M_Item`, `ICD-code`, `Description`, `Effective_Date`, `Eo`, `Rating`, `User`,`status`,`Error_reason`,`Error_type`,`Qc_rationali`,`coder_emp_id`,`Coderchecked`, `Agencychecked`, `Agencyprimarycode`) 
                                VALUES ('$Id','$mrn','$patientName','$assessmentDate','$mitems','$icd_code','$description','$effectivedate','$eo','$rating','$user','$status','$reason','$errortype','$qcrationaile','$emp_id','$coderchecked','$agencychecked','$mitemchecking')";
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

$conn->close();
?>
