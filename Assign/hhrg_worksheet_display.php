<?php

include('../db/db-con.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_POST['id'];

$action = $_GET['action'];



$response = array();

 if($action=='profile')
 {

    if ($id) {
  
        $query2 = "SELECT `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `team_name`, `coder_emp_id` FROM `reportsixtydays` WHERE `entry_id`='$id'";
        $result2 = $conn->query($query2);

        if ($result2 && $result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $response['data'] = $row2; // Store code data in the response array
        } else {
            $response['data'] = "No data found for hhrgcodedata with the given ID";
        }
    } else {
        $response['user_data'] = "No user found with the given ID";
    }
 }

else if($action=='report_data')
{

    $query="SELECT `Id`, `entry_id`,`first_entry_date`, `first_icd_code`, `first_desc`, `first_admission`, `first_comorbidity`, `first_clinical_group`, `first_lupa`, `first_hipps`, `first_billing_revenue`, `second_icd_code`, `second_desc`, `second_admission`, `second_comorbidity`, `second_clinical_group`, `second_lupa`, `second_hipps`, `second_billing_revenue`, `time_stamp` FROM `reportsixtydays` WHERE `entry_id`='$id'";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response['data'] = $row; // Store code data in the response array
        } else {
            $response['data'] = "No data found for hhrgcodedata with the given ID";
        }

}

  
// Encode the response array as JSON and send it
echo json_encode($response);

?>
