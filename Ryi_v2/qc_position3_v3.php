<?php

// Include database connection
include "../db/db-con.php";

// Start the session
session_start();

// Check if the required parameters are set in the POST request
if (isset($_POST["totalAgencyValues"], $_POST["totalCoderValues"], $_POST["Id"])) {
    // Assign values from POST parameters to variables
    $totalAgencyPoints = $_POST["totalAgencyValues"];
    $totalCoderPoints = $_POST["totalCoderValues"];
    $Id = $_POST["Id"];

    // Check if the $Id is not empty
    if (!empty($Id)) {
        // Define constants and variables
        $coderChecked = "Coder";
        $agencyChecked = "Agency";
        $mItem = "M1021A";
        $agencyPrimaryCode = "Primary";

        // Query to fetch data for agency
        $sqlDataAgency = "SELECT `ICD-code` FROM `Codesegementqc` WHERE `Entry_Id`='$Id' AND `Agencychecked`='$agencyChecked' AND `Agencyprimarycode`='$agencyPrimaryCode' AND `Error_type` !='Deleted'";
        $resultAgency = $conn->query($sqlDataAgency);

        // Fetch clinical group for agency if query successful
        if ($resultAgency) {
            $row = $resultAgency->fetch_assoc();
            $icd = $row["ICD-code"];

            $clinicangroupQuery = "SELECT * FROM `Codedescription` WHERE `ICD-10-code` = ? AND `Diagnosis_type` = 'Primary'";
            $stmt = $conn->prepare($clinicangroupQuery);
            $stmt->bind_param("s", $icd);
            $stmt->execute();
            $clinicangroupResult = $stmt->get_result();

            // Check if any rows are returned
            if ($clinicangroupResult->num_rows > 0) {
                // Fetch the data
                $position3value = $clinicangroupResult->fetch_assoc();
                $clinicalNameAgency = $position3value["Clinical_group_name"];

                if (!empty($clinicalNameAgency)) {
                    // Prepare and execute the SQL query for total agency points
                    $queryAgency = "SELECT $clinicalNameAgency FROM `Position_3` WHERE `points`='$totalAgencyPoints'";
                    $resultAgency = $conn->query($queryAgency);

                    // Check if there are results for total agency points
                    if ($resultAgency->num_rows > 0) {
                        $position3valueAgency = $resultAgency->fetch_assoc();
                        $agencyValue = $position3valueAgency[$clinicalNameAgency];

                        // Determine response for total agency points
                        if ($agencyValue == "LOW") {
                            $response["total_agency"] = "A";
                        } elseif ($agencyValue == "MEDIUM") {
                            $response["total_agency"] = "B";
                        } elseif ($agencyValue == "HIGH") {
                            $response["total_agency"] = "C";
                        }
                    } else {
                        $response["total_agency"] = "No data available for total agency points";
                    }
                }
            } else {
                // Return error if no records found
                $response["success"] = false;
                $response["error"] = "No records found for agency";
            }
        }

        // Query to fetch data for coder
        $sqlDataCoder = "SELECT `ICD-code` FROM `Codesegementqc` WHERE `Entry_Id`='$Id' AND `Coderchecked`='$coderChecked' AND `M_Item`='$mItem' AND `Error_type` !='Deleted'";
        $resultCoder = $conn->query($sqlDataCoder);

        // Fetch clinical group for coder if query successful
        if ($resultCoder) {
            $row = $resultCoder->fetch_assoc();
            $icd = $row["ICD-code"];
            // echo $icd;

            $clinicangroupQuery = "SELECT * FROM `Codedescription` WHERE `ICD-10-code` = ? AND `Diagnosis_type` = 'Primary'";
            $stmt = $conn->prepare($clinicangroupQuery);
            $stmt->bind_param("s", $icd);
            $stmt->execute();
            $clinicangroupResult = $stmt->get_result();

            // Check if any rows are returned
            if ($clinicangroupResult->num_rows > 0) {
                // Fetch the data
                $position3value = $clinicangroupResult->fetch_assoc();
                $clinicalNameCoder = $position3value["Clinical_group_name"];

                // echo $clinicalNameCoder;

                if (!empty($clinicalNameCoder)) {
                    // Prepare and execute the SQL query for total coder points
                    $queryCoder = "SELECT $clinicalNameCoder FROM `Position_3` WHERE `points`='$totalCoderPoints'";
                    $resultCoder = $conn->query($queryCoder);

                    if ($resultCoder->num_rows > 0) {
                        $position3valueCoder = $resultCoder->fetch_assoc();
                        $coderValue = $position3valueCoder[$clinicalNameCoder];

                        // Determine response for total coder points
                        if ($coderValue == "LOW") {
                            $response["total_coder"] = "A";
                        } elseif ($coderValue == "MEDIUM") {
                            $response["total_coder"] = "B";
                        } elseif ($coderValue == "HIGH") {
                            $response["total_coder"] = "C";
                        }
                    } else {
                        $response["total_coder"] = "No data available for total coder points";
                    }
                }
            } else {
                // Return error if no records found
                $response["success"] = false;
                $response["error"] = "No records found for coder";
            }
        }
    } else {
        // Return error if $Id is empty
        $response["success"] = false;
        $response["error"] = "Id parameter is empty";
    }
} else {
    // Return error if required parameters are not set
    $response["success"] = false;
    $response["error"] = "Required parameters are missing";
}

// Close the database connection
$conn->close();

// Return the response
echo json_encode($response);
?>
