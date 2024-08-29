<?php
 include('../db/db-con.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);



$Id = $_POST['Id'];


if ($Id) {
    $runquery = "SELECT `status` FROM `Main_Data` WHERE `Id`='$Id'";
    $selectresult = $conn->query($runquery);
    $selectrow = $selectresult->fetch_assoc();
    $status = $selectrow['status'];

    if ($status === 'PENDING') {
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
        $codesegementpending = "SELECT `M-Items`, `ICD-code`, `Description`, `Effective_Date`, `Eo`, `Rating`,`Coderchecked`,`Agencychecked`,`Agencyprimarycode` FROM `Codesegementpend` WHERE `Entry_Id`='$Id' AND `status`='Used'";
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
        $oasissegementpending = "SELECT `M_item`, `Agency_response`, `Coder_response`, `Coder_rationali` FROM `oasis_pend` WHERE `Entry_Id`='$Id' AND `status`='Used'";
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
        $pocsegementpending = "SELECT `Poc_item`, `Coder_response` FROM `Pocsegement_pend` WHERE `Entry_Id`='$Id' AND `status`='Used' ";
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


         //GGitem data
        $ggitemsegementpending = "SELECT `header`,`M_item`, `Agency_response`, `Coder_response`, `Coder_rationali` FROM `oasis_new` WHERE `Entry_Id`='$Id' AND `code_status` IS NULL ";

        //added emp_id if needed

        // AND`coder_emp_id`='$coder_emp_id'
        $ggitemsegementresult = $conn->query($ggitemsegementpending);

         $ggitemdata=array();

         // echo $oasissegementpending;

        if ($ggitemsegementresult && $ggitemsegementresult->num_rows > 0) {

            while($ggitemrow = $ggitemsegementresult->fetch_assoc()){

                $ggitemdata[]=$ggitemrow;
            }

        
  
         }

         else {
            // echo "No oasissegement found with the given ID";
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
         echo "Status did not match 'PENDING'";
    }
} else {
    echo "Invalid ID";
}

$conn->close();
?>
