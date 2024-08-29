<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and user session files
include('../db/db-con.php');

// Start the session
session_start();

// Get user ID from the session
$userId = $_COOKIE['Id'];

// Check if the required parameters are set in the POST request
if (isset($_POST['hppsCodeagency'], $_POST['hppsCodecoder'], $_POST['cpsccode'], $_POST['location'])) {

    // Assign values from POST parameters to variables
    $hppscodeagency = $_POST['hppsCodeagency'];
    $hppscodecoder = $_POST['hppsCodecoder'];
    $cpsccode = $_POST['cpsccode'];
    $location = $_POST['location'];

    // Fetch HPPS weight for agency
    $queryHPPSagency = $conn->prepare("SELECT `Weight` FROM `hpps_code` WHERE `Hipps_code`='$hppscodeagency'");
    $queryHPPSagency->execute();
    $resultHPPSagency = $queryHPPSagency->get_result();

    // Fetch HPPS weight for coder
    $queryHPPScoder = $conn->prepare("SELECT `Weight` FROM `hpps_code` WHERE `Hipps_code`='$hppscodecoder'");
    $queryHPPScoder->execute();
    $resultHPPScoder = $queryHPPScoder->get_result();

    // Check if the query was successful
    if ($resultHPPSagency && $resultHPPScoder) {
        $rowHPPSagency = $resultHPPSagency->fetch_assoc();
        $rowHPPScoder = $resultHPPScoder->fetch_assoc();

        // Fetch CPSC weight
        $queryCPSC = $conn->prepare("SELECT `Weight` FROM `cpsc_code` WHERE `Cpsc_Code`='$cpsccode' OR `State`='$location'");
        $queryCPSC->execute();
        $resultCPSC = $queryCPSC->get_result();

        // Check if the query was successful
        if ($resultCPSC) {
            $rowCPSC = $resultCPSC->fetch_assoc();

            // Fetch values from hppscodevalue table based on status='active'
            $queryHPPSCodeValue = $conn->prepare("SELECT `National`, `Labor_Portion`, `Non_Labor_Portion` FROM `hppscodevalue` WHERE `status`='active'");
            $queryHPPSCodeValue->execute();
            $resultHPPSCodeValue = $queryHPPSCodeValue->get_result();

            // Check if the query was successful
            if ($resultHPPSCodeValue) {
                $rowHPPSCodeValue = $resultHPPSCodeValue->fetch_assoc();

                // Calculate total value for agency
                $default = $rowHPPSCodeValue['National'];
                $laborPortion = $rowHPPSCodeValue['Labor_Portion'];
                $nonLaborPortion = $rowHPPSCodeValue['Non_Labor_Portion'];
                $A = $rowHPPSagency['Weight'];
                $E = $rowCPSC['Weight'];
                $B = $default * $A;
                $C = $B * $laborPortion;
                $D = $B * $nonLaborPortion;
                $F = $C * $E;
                $totalvalueagency = number_format($F + $D, 2);

                // Calculate total value for coder
                $Aone = $rowHPPScoder['Weight'];
                $Bone = $default * $Aone;
                $Cone = $Bone * $laborPortion;
                $Done = $Bone * $nonLaborPortion;
                $Fone = $Cone * $E;
                $totalvaluecoder = number_format($Fone + $Done, 2);

                // Fetch data from Main_Data table
                $select_query = "SELECT * FROM `Main_Data` WHERE `Id` = '$userId'";
                $result = $conn->query($select_query);

                // Check if data exists and proceed
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    // Sanitize user data for SQL insertion
                    $Id = $conn->real_escape_string($row['Id']);
                    $patient_name = $conn->real_escape_string($row['patient_name']);
                    $mrn = $conn->real_escape_string($row['mrn']);
                    $insurance_type = $conn->real_escape_string($row['insurance_type']);
                    $assessment_date = $conn->real_escape_string($row['assesment_date']);
                    $assessment_type = $conn->real_escape_string($row['assesment_type']);
                    $agency = $conn->real_escape_string($row['agency']);

                    // Update totalcasemix in Main_Data table
                    $update_query = "UPDATE `Main_Data` SET `totalcasemix`='$totalvaluecoder', `totalcasemixagency`='$totalvalueagency' WHERE `Id`='$userId'";
                    $update_result = $conn->query($update_query);

                    if ($update_result) {
                        $status = 'precoding';

                        // Check if entry exists in total_case_mix table
                        $select_query_precoding = "SELECT * FROM `total_case_mix` WHERE `Entry_Id`='$userId' AND `Status`='precoding'";
                        $select_query_precoding_result = $conn->query($select_query_precoding);
                        $sqlupdateagency_result ='';
                        $sqlinsertagency_result ='';

                        if ($select_query_precoding_result->num_rows > 0) {

                           
                            // Update existing entry in total_case_mix table for agency
                            $sqlupdateagency = "UPDATE `total_case_mix` SET `Hipps_code`='$hppscodeagency', `Hipps_weight`='$A', `Cpsc_code`='$cpsccode', `Location`='$location', `Cpsc_weight`='$E', `National_Value`='$default', `Case_Mix`='$B', `Labor_Portion`='$C', `Non_Labor_Portion`='$D', `Adjusted_Labor_Portion`='$F', `Total_Case_Mix`='$totalvalueagency'WHERE `Entry_Id`='$userId'  AND `Status`='precoding'";
                            $sqlupdateagency_result = $conn->query($sqlupdateagency);
                        } else {

                         
                            // Insert new entry into total_case_mix table for agency
                            $sqlinsertagency = "INSERT INTO `total_case_mix`(`Entry_Id`,`Mrn`,`Patient_Name`,`Assessment_Date`,`Assesment_Type`,`Insurance_Type`, `Agency`,`Hipps_code`, `Hipps_weight`, `Cpsc_code`, `Location`, `Cpsc_weight`, `National_Value`, `Case_Mix`, `Labor_Portion`, `Non_Labor_Portion`, `Adjusted_Labor_Portion`, `Total_Case_Mix`, `Status`) VALUES ('$Id','$mrn','$patient_name','$assessment_date','$assessment_type','$insurance_type','$agency','$hppscodeagency','$A','$cpsccode','$location','$E','$default','$B','$C','$D','$F','$totalvalueagency','$status')";
                            $sqlinsertagency_result = $conn->query($sqlinsertagency);
                        }

                        if ($sqlupdateagency_result || $sqlinsertagency_result) {
                            $statusone = 'postcoding';

                            // Check if entry exists in total_case_mix table
                            $select_query = "SELECT * FROM `total_case_mix` WHERE `Entry_Id`='$userId' AND `Status`='postcoding'";
                            $result = $conn->query($select_query);
                            $sqlupdatecoder_result ='';
                            $sqlinsertcoder_result ='';
                        

                            if ($result->num_rows > 0) {

                                
                                // Update existing entry in total_case_mix table for coder
                                $sqlupdatecoder = "UPDATE `total_case_mix` SET `Hipps_code`='$hppscodecoder', `Hipps_weight`='$Aone', `Cpsc_code`='$cpsccode', `Location`='$location', `Cpsc_weight`='$E', `National_Value`='$default', `Case_Mix`='$Bone', `Labor_Portion`='$Cone', `Non_Labor_Portion`='$Done', `Adjusted_Labor_Portion`='$Fone', `Total_Case_Mix`='$totalvaluecoder' WHERE `Entry_Id`='$userId' AND `Status`='postcoding' ";
                                $sqlupdatecoder_result = $conn->query($sqlupdatecoder);
                            
                            } else {
                               
                                // Insert new entry into total_case_mix table for coder
                                $sqlinsertcoder = "INSERT INTO `total_case_mix`(`Entry_Id`,`Mrn`,`Patient_Name`,`Assessment_Date`,`Assesment_Type`,`Insurance_Type`, `Agency`,`Hipps_code`, `Hipps_weight`, `Cpsc_code`, `Location`, `Cpsc_weight`, `National_Value`, `Case_Mix`, `Labor_Portion`, `Non_Labor_Portion`, `Adjusted_Labor_Portion`, `Total_Case_Mix`, `Status`) VALUES ('$Id','$mrn','$patient_name','$assessment_date','$assessment_type','$insurance_type','$agency','$hppscodecoder','$Aone','$cpsccode','$location','$E','$default','$Bone','$Cone','$Done','$Fone','$totalvaluecoder','$statusone')";
                                $sqlinsertcoder_result = $conn->query($sqlinsertcoder);


                            }

                            if ( $sqlinsertcoder_result || $sqlupdatecoder_result) {
                                // Set the response header to indicate JSON content
                                header('Content-Type: application/json');

                                // Encode the results as JSON and echo the response
                                echo json_encode(['total_value_agency' => $totalvalueagency, 'total_value_coder' => $totalvaluecoder]);
                            } else {
                                echo json_encode(['error' => 'Error in updating/inserting data into total_case_mix table for coder: ' . $conn->error]);
                            }
                        } else {
                            echo json_encode(['error' => 'Error in updating/inserting data into total_case_mix table for agency: ' . $conn->error]);
                        }
                    } else {
                        echo json_encode(['error' => 'Error in updating totalcasemix in Main_Data table: ' . $conn->error]);
                    }
                } else {
                    echo json_encode(['error' => 'No data found for the given ID.']);
                }
            } else {
                // Error in fetching values from hppscodevalue table
                echo json_encode(['error' => 'Error in fetching values from hppscodevalue table: ' . $conn->error]);
            }
        } else {
            // No matching record found for cpsccode or location
            echo json_encode(['error' => 'No matching record found for the given cpsccode or location.']);
        }
    } else {
        // No matching record found for hppscode
        echo json_encode(['error' => 'No matching record found for the given hppscode.']);
    }

    // Close the prepared statements
    $queryHPPSagency->close();
    $queryHPPScoder->close();
    $queryCPSC->close();
    $queryHPPSCodeValue->close();

    // Close the database connection
    $conn->close();
} else {
    // Required parameters not set in the POST request
    echo json_encode(['error' => 'Required parameters not set in the POST request.']);
}

?>
