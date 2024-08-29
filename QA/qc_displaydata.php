<?php

session_start();
 


 include('../db/db-con.php');

$Id = $_POST['Id'];
 


if ($Id) {
    $runquery = "SELECT `status` FROM `Main_Data` WHERE `Id`='$Id'";
    $selectresult = $conn->query($runquery);
    $selectrow = $selectresult->fetch_assoc();
    $status = $selectrow['status'];

    if ($status === 'QA WIP') {
        $query = "SELECT * FROM `Main_Data` WHERE `Id`='$Id'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $Id = $row['Id'];
            $patientName = $row['patient_name'];
            $phoneNumber = $row['phone_number'];
            $mrn = $row['mrn'];
            $agency = $row['agency'];
            $assessmentDate = $row['assesment_date'];
            $assessmentType = $row['assesment_type'];
            $insuranceType = $row['insurance_type'];
            $Team = $row['alloted_team'];
            $coder = $row['alloted_to_coder'];
            $url = $row['url'];
        } else {
            echo "No user found with the given ID";
        }

        // CODESEGMENT
        $codesegementpending = "SELECT `M-Items`, `ICD-code`, `Description`, `Effective_Date`, `Eo`, `Rating`, `Coderchecked` , `Agencychecked` , `Agencyprimarycode` FROM `Codesegement` WHERE `Entry_Id`='$Id' AND `code_status` IS NULL ";
        $codesegementresult = $conn->query($codesegementpending);

        $codedata=array();

        if ($codesegementresult && $codesegementresult->num_rows > 0) {
           
            while( $coderow = $codesegementresult->fetch_assoc()){

                $codedata[]= $coderow;

            }
            
        } else {
            // echo "No codesegement found with the given ID";
        }

        // OASIS
        $oasissegementpending = "SELECT `M_item`, `Agency_response`, `Coder_response`, `Coder_rationali` FROM `oasis` WHERE `Entry_Id`='$Id' AND `code_status` IS NULL ";
        $oasissegementresult = $conn->query($oasissegementpending);

         $oasisdata=array();

        if ($oasissegementresult && $oasissegementresult->num_rows > 0) {

            while($oasisrow = $oasissegementresult->fetch_assoc()){

                $oasisdata[]=$oasisrow;
            }

        
  
         }

         else {
            // echo "No oasissegement found with the given ID";
        }

        // POC
        $pocsegementpending = "SELECT `Poc_item`, `Coder_response` FROM `Pocsegement` WHERE `Entry_Id`='$Id' AND `code_status` IS NULL";
        $pocsegementresult = $conn->query($pocsegementpending);


        $pocdata=array();

        if ($pocsegementresult && $pocsegementresult->num_rows > 0) {
            while($pocrow = $pocsegementresult->fetch_assoc()){

                $pocdata[]=$pocrow;

                // echo $pocdata;
            }

        } else {
            // echo "No pocsegement found with the given ID";
        }


        // GGitem data
$ggitemsegementpending = "SELECT `header`,`M_item`, `Agency_response`, `Coder_response`, `Coder_rationali`,`Error_reason`,`Error_type`  FROM `oasis_qc_new` WHERE `Entry_Id`='$Id' AND `code_status` IS NULL";

// Execute the query
$ggitemsegementresult = $conn->query($ggitemsegementpending);

// Array to store fetched data
$ggitemdata = array();

if ($ggitemsegementresult && $ggitemsegementresult->num_rows > 0) {
    // If data is found, fetch and store it
    while ($ggitemrow = $ggitemsegementresult->fetch_assoc()) {
        $ggitemdata[] = $ggitemrow;
    }
} else {
    // If no data is found in the first table, check another table
    $otherTableQuery = "SELECT `header`,`M_item`, `Agency_response`, `Coder_response`, `Coder_rationali`FROM `oasis_new` WHERE `Entry_Id`='$Id'AND `code_status` IS NULL";
    $otherTableResult = $conn->query($otherTableQuery);

    if ($otherTableResult && $otherTableResult->num_rows > 0) {
        // If data is found in the other table, fetch and store it
        while ($otherTableRow = $otherTableResult->fetch_assoc()) {
            $ggitemdata[] = $otherTableRow;
        }
    } else {
        // If no data is found in any table, you can handle it accordingly
        // For example:
        // echo "No data found in any table";
    }
}






          $response = array(
            'code_data' =>$codedata,
            'oasis_data' => $oasisdata,
            'poc_data' => $pocdata,
            'ggitem_data'=> $ggitemdata
        );

        // Send the combined response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);



    } else {
        echo "Status did not match 'QC WIP'";
    }
} else {
    echo "Invalid ID";
}

$conn->close();
?>

