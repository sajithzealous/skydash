<?php
// Database credentials
include('../db/db-con.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Retrieve the action parameter from GET request
$action = $_GET['action'];

// Get user ID from cookies
$Id = $_COOKIE['Id'];

if ($action == 'billingone') {
    // Check if 'icdone' is set in the POST parameters
    if (isset($_POST['icdone'])) {
        $icdone = $_POST['icdone'];
        $icdone = $conn->real_escape_string($icdone);

        // SQL query to fetch description based on ICD code
        $query = "SELECT * FROM `Codedescription` WHERE `ICD-10-code` = '$icdone' AND `Diagnosis_type`= 'Primary'";

        // Execute the query
        $result = $conn->query($query);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $description = $row['Description'];
                $clinicalgroup = $row['Clinical_group_name'];
                echo json_encode(['description' => $description,'clinicalgroup'=>$clinicalgroup]);
            } else {
                echo json_encode(['error' => 'No Data Given ICD Code']);
            }
        } else {
            echo json_encode(['error' => 'Query execution error: ' . $conn->error]);
        }

        // Close the database connection
        $conn->close();
    } else {
        echo json_encode(['error' => 'ICD code is not provided.']);
    }

} 



else if ($action == 'billingtwo') {
    // Check if 'icdone' is set in the POST parameters
    if (isset($_POST['icdtwo'])) {
        $icdtwo = $_POST['icdtwo'];
        $icdtwo = $conn->real_escape_string($icdtwo);

        // SQL query to fetch description based on ICD code
        $query = "SELECT * FROM `Codedescription` WHERE `ICD-10-code` = '$icdtwo' AND `Diagnosis_type`= 'Primary'";

        // Execute the query
        $result = $conn->query($query);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $description = $row['Description'];
                $clinicalgroup = $row['Clinical_group_name'];
                echo json_encode(['description' => $description,'clinicalgroup'=>$clinicalgroup]);
            } else {
                echo json_encode(['error' => 'No Data Given ICD Code']);
            }
        } else {
            echo json_encode(['error' => 'Query execution error: ' . $conn->error]);
        }

        // Close the database connection
        $conn->close();
    } else {
        echo json_encode(['error' => 'ICD code is not provided.']);
    }

}
else if ($action == 'billing_insert') {
    // Check if all required fields are provided
    if (
        isset(
            $_POST['icdone'], $_POST['desone'], $_POST['adtone'], $_POST['cglone'], $_POST['levelone'], $_POST['caone'], 
            $_POST['lupaone'], $_POST['hippsone'], $_POST['revenueone'], $_POST['icdtwo'], 
            $_POST['destwo'], $_POST['adttwo'], $_POST['cgltwo'], $_POST['leveltwo'], $_POST['catwo'], 
            $_POST['lupatwo'], $_POST['hippstwo'], $_POST['revenuetwo']
        )
    ) {
        // Fetch the entry_id from reportsixtydays using the provided ID
        $checkQuery = "SELECT `entry_id` FROM `reportsixtydays` WHERE `Id` = '$Id'";
        $checkResult = $conn->query($checkQuery);

        // Fetch data from Main_Data using the provided ID
        $query = "SELECT `Id`, `patient_name`, `mrn`, `insurance_type`, `assesment_date`, 
                         `assesment_type`, `agency`, `status`, `alloted_team`, `coder_emp_id`
                  FROM `Main_Data` 
                  WHERE `Id` = '$Id'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $mainData = $result->fetch_assoc();

            if ($checkResult->num_rows > 0) {
                // If entry exists, update the existing record
                $sql = "UPDATE `reportsixtydays` SET 
                            `patient_name` = '{$mainData['patient_name']}', 
                            `mrn` = '{$mainData['mrn']}', 
                            `agency` = '{$mainData['agency']}', 
                            `insurance_type` = '{$mainData['insurance_type']}', 
                            `assesment_date` = '{$mainData['assesment_date']}', 
                            `assesment_type` = '{$mainData['assesment_type']}', 
                            `first_status` = '{$mainData['status']}', 
                            `team_name` = '{$mainData['alloted_team']}', 
                            `coder_emp_id` = '{$mainData['coder_emp_id']}', 
                            `first_entry_date` = NOW(), 
                            `first_icd_code` = '{$conn->real_escape_string($_POST['icdone'])}', 
                            `first_desc` = '{$conn->real_escape_string($_POST['desone'])}', 
                            `first_admission` = '{$conn->real_escape_string($_POST['adtone'])}', 
                            `first_comorbidity` = '{$conn->real_escape_string($_POST['caone'])}', 
                            `first_clinical_group` = '{$conn->real_escape_string($_POST['cglone'] . ' - ' . $_POST['levelone'])}', 
                            `first_lupa` = '{$conn->real_escape_string($_POST['lupaone'])}', 
                            `first_hipps` = '{$conn->real_escape_string($_POST['hippsone'])}', 
                            `first_billing_revenue` = '{$conn->real_escape_string($_POST['revenueone'])}', 
                            `second_icd_code` = '{$conn->real_escape_string($_POST['icdtwo'])}', 
                            `second_desc` = '{$conn->real_escape_string($_POST['destwo'])}', 
                            `second_admission` = '{$conn->real_escape_string($_POST['adttwo'])}', 
                            `second_comorbidity` = '{$conn->real_escape_string($_POST['catwo'])}', 
                            `second_clinical_group` = '{$conn->real_escape_string($_POST['cgltwo'] . ' - ' . $_POST['leveltwo'])}', 
                            `second_lupa` = '{$conn->real_escape_string($_POST['lupatwo'])}', 
                            `second_hipps` = '{$conn->real_escape_string($_POST['hippstwo'])}', 
                            `second_billing_revenue` = '{$conn->real_escape_string($_POST['revenuetwo'])}', 
                            `time_stamp` = NOW() 
                        WHERE `Id` = '$Id'";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(['status' => 'success', 'message' => 'Data successfully updated in reportsixtydays.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error updating data in reportsixtydays: ' . $conn->error]);
                }
            } else {
                // If entry does not exist, insert a new record
                $sql2 = "INSERT INTO `reportsixtydays` (
                            `entry_id`, `patient_name`, `mrn`, `agency`, `insurance_type`, 
                            `assesment_date`, `assesment_type`, `first_status`, `team_name`, 
                            `coder_emp_id`, `first_entry_date`, `first_icd_code`, `first_desc`, 
                            `first_admission`, `first_comorbidity`, `first_clinical_group`, `first_lupa`, `first_hipps`,
                            `first_billing_revenue`, `second_icd_code`, `second_desc`, 
                            `second_admission`, `second_comorbidity`, `second_clinical_group`, `second_lupa`, `second_hipps`, 
                            `second_billing_revenue`, `time_stamp`
                        ) VALUES (
                            '$Id', '{$mainData['patient_name']}', '{$mainData['mrn']}', 
                            '{$mainData['agency']}', '{$mainData['insurance_type']}', 
                            '{$mainData['assesment_date']}', '{$mainData['assesment_type']}', '{$mainData['status']}', 
                            '{$mainData['alloted_team']}', '{$mainData['coder_emp_id']}', NOW(), 
                            '{$conn->real_escape_string($_POST['icdone'])}', '{$conn->real_escape_string($_POST['desone'])}', 
                            '{$conn->real_escape_string($_POST['adtone'])}', '{$conn->real_escape_string($_POST['caone'])}', 
                            '{$conn->real_escape_string($_POST['cglone'] . ' - ' . $_POST['levelone'])}', 
                            '{$conn->real_escape_string($_POST['lupaone'])}', 
                            '{$conn->real_escape_string($_POST['hippsone'])}', '{$conn->real_escape_string($_POST['revenueone'])}', 
                            '{$conn->real_escape_string($_POST['icdtwo'])}', '{$conn->real_escape_string($_POST['destwo'])}', 
                            '{$conn->real_escape_string($_POST['adttwo'])}', '{$conn->real_escape_string($_POST['catwo'])}', 
                            '{$conn->real_escape_string($_POST['cgltwo'] . ' - ' . $_POST['leveltwo'])}', 
                            '{$conn->real_escape_string($_POST['lupatwo'])}', 
                            '{$conn->real_escape_string($_POST['hippstwo'])}', '{$conn->real_escape_string($_POST['revenuetwo'])}', 
                            NOW()
                        )";

                if ($conn->query($sql2) === TRUE) {
                    echo json_encode(['status' => 'success', 'message' => 'Data successfully inserted into reportsixtydays.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error inserting data into reportsixtydays: ' . $conn->error]);
                }
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data found for the given ID.']);
        }

        // Close the database connection
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
    }
}



 else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
}  
?>
