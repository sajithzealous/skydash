<?php
session_start();
 

$user = $_SESSION['username'] ?? null;
$emp_id = $_SESSION['empid'];

 include('../db/db-con.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['formData'])) {
    $Entry_Id = $_POST['Id'] ?? null; 
    $formDataArray = $_POST['formData'];

    if ($Entry_Id !== null) {
        $query = "SELECT `patient_name`, `mrn` FROM `Main_Data` WHERE `Id` = '$Entry_Id'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $patientName = $row['patient_name'];
            $mrn = $row['mrn'];

            foreach ($formDataArray as $formData) {
                $mitemValue = $formData['mitemAttributeValue'] ?? '';
                $Agency_response = is_array($formData['us1']) ? implode(', ', $formData['us1']) : $formData['us1'];
                $Coder_response = is_array($formData['us2']) ? implode(', ', $formData['us2']) : $formData['us2'];
                $Coder_rationali = $formData['us3'];
                $Error_reason=$formData['oasisreason']?? '';
                $Error_type=$formData['oasiserrortype']?? '';
                $Qc_rationali=$formData['oasisqcrationaile']?? '';
                $status = 'Qc_review';


if (isset($formData['newoasis1']) && !empty($formData['newoasis1'])) {
     $Qc_agency_response = is_array($formData['newoasis1']) ? implode(',', $formData['newoasis1']) : $formData['newoasis1'];
} else {
    $Qc_agency_response = $Agency_response;
}

if (isset($formData['newoasis2']) && !empty($formData['newoasis2'])) {
    $Qc_coder_response = is_array($formData['newoasis2']) ? implode(',', $formData['newoasis2']) : $formData['newoasis2'];
} else {
    $Qc_coder_response = $Coder_response;
}

if (isset($formData['newoasis3']) && !empty($formData['newoasis3'])) {
    $Qc_coder_rationali = $formData['newoasis3'];
} else {
    $Qc_coder_rationali = $Coder_rationali;
}
if (isset($formData['newoasis4']) && !empty($formData['newoasis4'])) {
    $Qc_response = is_array($formData['newoasis4']) ? implode(',', $formData['newoasis4']) : $formData['newoasis4'];
    
}else {
    $Qc_response = $Coder_response;
}


                

                $extractedData = '';
                $pattern = '/\(([^)]+)\)/';
                if (preg_match($pattern, $mitemValue, $matches)) {
                    $extractedData = $matches[1];

                    if ($extractedData !== '') {
                        $extractedDatasql = "SELECT `M_item` FROM `oasisqc` WHERE `M_item` = '$extractedData' AND `Entry_id` = '$Entry_Id'";
                        $extractedDatasqlresult = $conn->query($extractedDatasql);
                        $rowsExist = ($extractedDatasqlresult->num_rows > 0);

                        if ($rowsExist) {
                            $updateQuery = "UPDATE `oasisqc` SET `Agency_response`='$Qc_agency_response', `Coder_response`='$Qc_coder_response', `Qc_response`='$Qc_response',`Coder_rationali`=' $Qc_coder_rationali',`Error_reason`='$Error_reason',`Error_type`='$Error_type',`Qc_rationali`='$Qc_rationali',`User` = '$user',`coder_emp_id` ='$emp_id'WHERE `M_item`='$extractedData' AND `Entry_id`='$Entry_Id'";
                            $updateResult = $conn->query($updateQuery);

                            if ($updateResult === TRUE) {
                                $response['success'] = true;
                                $response['data'] = $extractedData;
                                $response['message'] = 'Data Updated Successfully';
                                // echo json_encode($response);
                            } else {
                                $response['success'] = false;
                                $response['error'] = 'Update query error: ' . $conn->error;
                                // echo json_encode($response);
                            }
                        } else {
                            if ($Qc_agency_response !== '' && $Qc_response !== '') {
                                                              $insertQuery = "INSERT INTO `oasisqc`(`Entry_id`, `Mrn`, `Patient_Name`, `M_item`, `Agency_response`, `Coder_response`, `Qc_response`,`Coder_rationali`,`Error_reason`,`Error_type`,`Qc_rationali`, `User`,`status`,`coder_emp_id`) 
VALUES ('$Entry_Id', '$mrn', '$patientName', '$extractedData', '$Qc_agency_response', '$Qc_coder_response','$Qc_response', '$Qc_coder_rationali','$Error_reason','$Error_type','$Qc_rationali', '$user','$status','$emp_id')";
                                $insertResult = $conn->query($insertQuery);

                                if ($insertResult === TRUE) {
                                    $response['success'] = true;
                                    $response['data'] = $extractedData;
                                    $response['message'] = 'Data Inserted Successfully';
                                    // echo json_encode($response);
                                } else {
                                    $response['success'] = false;
                                    $response['error'] = 'Insert query error: ' . $conn->error;
                                    // echo json_encode($response);
                                }
                            } else {
                                $response['success'] = false;
                                $response['error'] = 'Empty data fields';
                                // echo json_encode($response);
                            }
                        }
                    } else {
                        $response['success'] = false;
                        $response['error'] = 'No data found within parentheses';
                        // echo json_encode($response);
                    }
                }
            }
        } else {
            $response['success'] = false;
            $response['error'] = 'No matching records found for provided ID';
            // echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'Please provide a valid ID';
        // echo json_encode($response);
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Empty Data Not Insertted';
    // echo json_encode($response);
}
echo json_encode($response);
$conn->close();
?>
