<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
 include('db/db-con.php');






if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the uploaded CSV file
    $file = $_FILES['formFile']['tmp_name'];

    // Open and process the CSV file
    if (($handle = fopen($file, "r")) !== FALSE) {
        $header = fgetcsv($handle, 1000, ",");
        $numColumns = count($header);



        // Define the expected database table header
        $expectedHeader = ['patient_name', 'mrn','phone_number','insurance_type','assesment_date', 'assesment_type', 'agency', 'url', 'priority'];

        // Check if the CSV header matches the expected header
        if ($header !== $expectedHeader) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'CSV header does not match the database table header.']);
            fclose($handle);
            exit; // Stop processing further
        } 
        // Initialize error and data arrays
        $errorLines = [];
        $nonEmptyData = [];
        $emptyData = [];
        $rowcount = 0;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowcount++;

            // Validate and process each field
            $errorMessages = array(); // Store error messages for this row
            $rowData = autoValidateData($data, $errorMessages);
            $datadum = autoValidateDataee($data, $errorMessages);



            if ($rowData !== null) {
                $nonEmptyData[] = $rowData;
                // echo json_encode($rowData); // Data with non-empty fields
            } else {
                $emptyData[] = $datadum;
                // echo json_encode($data); // Data with empty fields
            }
        }
        fclose($handle);

        // Database insertion for non-empty data
        // if (!empty($nonEmptyData)) {
        //     $conn = new mysqli($servername, $username, $password, $dbname);

        //     if ($conn->connect_error) {
        //         die("Connection failed: " . $conn->connect_error);
        //     }

        //     $insertQuery = "INSERT INTO `Main_Data`(`patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `url`, `priority`, `status`) VALUES ";

        //     foreach ($nonEmptyData as $rowData) {
        //         $rowData = array_map([$conn, 'real_escape_string'], $rowData);

        //         $insertQuery .= "('" . implode("','", $rowData) . "'),";
        //     }

        //     $insertQuery = rtrim($insertQuery, ",");

        //     if ($conn->query($insertQuery) === TRUE) {
        //         // Data insertion successful
        //     } else {
        //         echo "Error: " . $conn->error;
        //     }

           
        // }



if (!empty($nonEmptyData)) {
   
    $agencyname = "SELECT `agency_name` FROM `Agent` WHERE `client_name`='$user' AND `client_id`='$emp_id'";
    $agencyresult = $conn->query($agencyname);

    // Check if agency result exists and fetch all agency names
    $agencies = array();
    if ($agencyresult && $agencyresult->num_rows > 0) {
        while ($agencyData = $agencyresult->fetch_assoc()) {
            $agencies[] = $agencyData['agency_name'];
        }
    } else {
       header('Content-Type: application/json');
      echo json_encode(['success' => false, 'error' => 'Error:Agency Not Provide.']);
        exit; // Handle error gracefully or exit the script
    }

    $insertQuery = "INSERT INTO `Main_Data`(`patient_name`, `mrn`,`phone_number`,`insurance_type`, `assesment_date`, `assesment_type`, `agency`, `url`, `priority`, `status`, `file_uploaded_by`) VALUES ";
    $values = array();
     

    foreach ($nonEmptyData as $rowData) {
         $rowData = array_map([$conn, 'real_escape_string'], $rowData);
         

        // Check if the agency name exists in the fetched agencies
        if (in_array($rowData['agency'], $agencies)) {
            // Build values for insertion
            $values[] = "('" . implode("','", $rowData) . "')";
        } else {
            // Handle error or mismatched data
                header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Error: Agency name mismatch for data.']);
           // echo "Error: Agency name mismatch for data: " . implode(",", $rowData);
            exit; // Stop the execution
        }
    }

    // If there are values to insert
    if (!empty($values)) {
        $insertQuery .= implode(",", $values);

        // Perform the insertion query
        if ($conn->query($insertQuery) === TRUE) {
            // Data insertion successful
           header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'File Uploaded Sucessfully']);
        } else {
            echo "Error: File Not-Uploaded  .";
        }
    } else {
        // Handle case where no data matches the agency
        echo "Error: No data matches the agency name.";
    }

    // Close the database connection
    
}
    // Database insertion for empty data
        // if (!empty($emptyData)) {
        
        //     $insertQueryEmpty = "INSERT INTO `Dummy_Data`(`patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `agency`, `url`, `priority`,`status`) VALUES ";

        //     foreach ($emptyData as $rowData) {
        //         $rowData = array_map([$conn, 'real_escape_string'], $rowData);
        //         $insertQueryEmpty .= "('" . implode("','", $rowData) . "'),";
        //     }

        //     $insertQueryEmpty = rtrim($insertQueryEmpty, ",");


        //     // echo  $insertQueryEmpty;

        //     if ($conn->query($insertQueryEmpty) === TRUE) {
        //         echo json_encode(['success' => true, 'message' => 'File']);
        //     } else {
        //         echo "Error: " . $conn->error;
        //     }

           
        // }
    }
}



function autoValidateData($data, &$errorMessages) {
    $user = $_SESSION['username'];
// Validate individual fields using respective functions
$Patient_Name = autoValidatePatientName($data[0], $errorMessages);
$Mrn = autoValidateMRN($data[1], $errorMessages);
 $Phone_Number = isValidPhoneNumber($data[2], $errorMessages); // Use isValidPhoneNumber function
$Insurance_Type = autoValidateInsuranceType($data[3], $errorMessages);
$Assessment_Date = autoValidateDate($data[4], $errorMessages);
$Assessment_Type = autoValidateAssessmentType($data[5], $errorMessages);
$Agency = autoValidateAgency($data[6], $errorMessages);
$url = autoValidateURL($data[7], $errorMessages);
$Priority = autoValidatePriority($data[8], $errorMessages);
$Status = ("New");
$Fileuploadedby=($user);

// Check for empty fields
if (empty($Patient_Name) || empty($Mrn) || empty($Insurance_Type) || empty($Assessment_Date) || empty($Assessment_Type) || empty($Agency)) {
    return null;
}

// Return validated data
return array(
    'patient_name' => $Patient_Name,
    'mrn' => $Mrn,
     'phone_number' => $Phone_Number, 
    'insurance_type' => $Insurance_Type,
    'assesment_date' => $Assessment_Date,
    'assesment_type' => $Assessment_Type,
    'agency' => $Agency,
    'url' => $url,
    'priority' => $Priority,
    'status' => $Status,
    'file_uploaded_by' => $Fileuploadedby,
);

}


function autoValidateDataee($data, &$errorMessages) {
        $user = $_SESSION['username'];
// Validate individual fields using respective functions
$Patient_Name = autoValidatePatientName($data[0], $errorMessages);
$Mrn = autoValidateMRN($data[1], $errorMessages);
 $Phone_Number = isValidPhoneNumber($data[2], $errorMessages); // Use isValidPhoneNumber function
$Insurance_Type = autoValidateInsuranceType($data[3], $errorMessages);
$Assessment_Date = autoValidateDate($data[4], $errorMessages);
$Assessment_Type = autoValidateAssessmentType($data[5], $errorMessages);
$Agency = autoValidateAgency($data[6], $errorMessages);
$url = autoValidateURL($data[7], $errorMessages);
$Priority = autoValidatePriority($data[8], $errorMessages);
$Status = ("New");
$Fileuploadedby=($user);



// Return validated data
return array(
    'patient_name' => $Patient_Name,
    'mrn' => $Mrn,
    'phone_number' => $Phone_Number, 
    'insurance_type' => $Insurance_Type,
    'assesment_date' => $Assessment_Date,
    'assesment_type' => $Assessment_Type,
    'agency' => $Agency,
    'url' => $url,
    'priority' => $Priority,
    'status' => $Status,
    'file_uploaded_by' => $Fileuploadedby,
);

}

function autoValidatePatientName($patientName) {
    return ucwords(strtolower(preg_replace('/\s+/', ' ', str_replace(',', '', $patientName))));
}

function autoValidateMRN($mrn) {
    return $mrn;
}

  // function isValidPhoneNumber($phoneNumber) {
  //     $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
  //     return $phoneNumber;
  // }

function isValidPhoneNumber($phoneNumber) {
    // Remove non-numeric characters
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
    
    // Check if the length is 10
     if (strlen($phoneNumber) =='') {

          $phoneNumber='000000000';
         return $phoneNumber;
     } else {
          //Return false or an indication that the phone number is invalid
        $phoneNumber='000000000';
         return $phoneNumber;
     }
 }


function autoValidateInsuranceType($insuranceType) {
    return ucwords(strtolower(preg_replace('/\s+/', ' ', str_replace(',', '', $insuranceType))));
}

function autoValidateAssessmentType($assesmentType) {
    return ucwords(strtolower(preg_replace('/\s+/', ' ', str_replace(',', '', $assesmentType))));
}

// function autoValidateDate($assessmentDate) {
//     $formatsToCheck = [
//         'Y-m-d',
//         'd-m-Y',
//         'm-d-Y',
        
//     ];

//     foreach ($formatsToCheck as $format) {
//          $assessmentDate = DateTime::createFromFormat($format, $assessmentDate);
//         if ($assessmentDate == false) {
//              return "Invalid date format!";
            
//     }

   
//     return $assessmentDate->format('Y-m-d');
//         }
// }

function autoValidateDate($assessmentDate) {

$assessmentDate = strtotime( $assessmentDate );
$assessmentDate = date( 'Y-m-d', $assessmentDate );
    return $assessmentDate;
}


function autoValidateAgency($agency) {
    return strtoupper($agency);
}

// function autoValidateURL($url) {
//     if (filter_var($url, FILTER_VALIDATE_URL) === false) {
//         return ""; 
//     } else {
//         return $url; 
//     }
// }

function autoValidateURL($url) {
     return $url; 
    
}


function autoValidatePriority($priority) {
    return $priority;
}

function autoValidateStatus($status) {
    return $status;
}


?>
