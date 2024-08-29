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
        $codesegementpending = "SELECT `M_Item`, `ICD-code`AS icdcode, `Description`, `Effective_Date`, `Eo`, `Rating`,`Error_reason`,`Error_type`,`Qc_rationali`,`Coderchecked`,`Agencychecked`,`Agencyprimarycode` FROM `Codesegementqc` WHERE `Entry_Id`='$Id'";
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
        $oasissegementpending = "SELECT `M_item`, `Agency_response`, `Coder_response`,`Qc_response`, `Coder_rationali`,`Error_reason`,`Error_type`,`Qc_rationali` FROM `oasisqc` WHERE `Entry_Id`='$Id'";
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

        //GGITEM
        $ggitemsegementpending = "SELECT `header`,`M_item`, `Agency_response`, `Coder_response`, `Coder_rationali` ,`Error_reason`,`Error_type`FROM `oasis_qc_new` WHERE `Entry_Id`='$Id' AND `code_status` IS NULL ";

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


        // POC
        $pocsegementpending = "SELECT `Poc_item`, `Poc_coder_response`,`Coder_response`,`Error_reason`,`Error_type`,`Qc_rationali` FROM `Pocsegementqc` WHERE `Entry_Id`='$Id'";
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


          $response = array(
            'code_data' =>$codedata,
            'oasis_data' => $oasisdata,
            'ggitem_data'=>$ggitemdata,
            'poc_data' => $pocdata
        );

        // Send the combined response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);



    } else {
        echo "Status did not match 'QA WIP'";
    }
} else {
    echo "Invalid ID";
}

$conn->close();
?>
