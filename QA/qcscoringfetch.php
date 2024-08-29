<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch session variables
$user = $_SESSION['username'];
$emp_id = $_SESSION['empid'];
$action = $_GET['action'];

// Include database connection
include('../db/db-con.php');

$total = 100;
//code segement  score
if ($action === 'codescore') {
  $Id = $_POST['Id'];

  // Fetch 'M-Items' for the given Entry_Id
  echo $sqlSelectMItems = "SELECT `M_Item` FROM `Codesegementqc` WHERE `Entry_Id`='$Id' AND `Error_type` IN ('Added','Deleted','Modified','Other')";
  $resultMItems = $conn->query($sqlSelectMItems);

  if ($resultMItems === false) {
    // Handle query error
    echo "Error: " . $conn->error;
  } else {
    $mItems = array();

    // Fetch all 'M-Items'
    while ($row = $resultMItems->fetch_assoc()) {
      $mItems[] = $row['M_Item'];
    }

    // If 'M-Items' are found
    if (!empty($mItems)) {
      // Prepare 'M-Items' for SQL query
      $mItemsData = implode("','", $mItems);

      // Fetch scores for 'M-Items' from coding-scoring table
      $sqlTotalScore = "SELECT `Mitem`, SUM(`Score`) AS total_score 
                      FROM `coding-scoring` 
                      WHERE `status`='active' 
                      AND `Mitem` IN ('$mItemsData') AND `Segement` ='Code'
                      GROUP BY `Mitem`";
      $resultTotalScore = $conn->query($sqlTotalScore);

      if ($resultTotalScore === false) {
        // Handle query error
        echo "Error: " . $conn->error;
      } else {
        $totalScore = 0;


        // Loop through the result set to calculate total score
        while ($row = $resultTotalScore->fetch_assoc()) {
          // Add score to total score
          $totalScore += $row['total_score'];
        }

        // Calculate the number of 'M-Items' without scores
        $missingItemsCount = count($mItems) - $resultTotalScore->num_rows;

        // Add default scores (1) for missing 'M-Items'
        $totalScore += $missingItemsCount;

        // Output the total score
         "Total Score: $totalScore";

        $totalcode = $total - $totalScore;

        if ($totalcode) {


          $queryselect = "SELECT `Entry_Id` FROM `qcscoringvalue` WHERE `Entry_Id` ='$Id'AND `code_scoring` IS NOT NULL";
          $queryselectresult = ($conn)->query($queryselect);

          if ($queryselectresult->num_rows > 0) {

            $queryupdatecode = "UPDATE `qcscoringvalue` SET `code_scoring` ='$totalcode', `qc_code_scoring`='$totalScore' WHERE `Entry_Id` ='$Id'AND `code_scoring` IS NOT NULL";

            $resultupdatequery = ($conn)->query($queryupdatecode);
          } else {

            $query = "SELECT * FROM `Main_Data` WHERE `Id`='$Id'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $Id = $row['Id'];
              $patientName = $row['patient_name'];
              $mrn = $row['mrn'];
              $assessmentDate = $row['assesment_date'];
              $Team = $row['alloted_team'];
              $coder = $row['alloted_to_coder'];
              $coder_Id = $row['coder_emp_id'];
              $qccoder = $row['qc_person'];
              $qccoder_Id = $row['qc_person_emp_id'];
            } else {
              echo "No user found with the given ID";
            }

             $insertquery = "INSERT INTO `qcscoringvalue`(`Entry_Id`, `Mrn`, `Patient_Name`, `Assessment_Date`, `code_scoring`, `qc_code_scoring`,`coder`, `coder_emp_id`, `qc_coder`, `qc_emp_id`) VALUES ('$Id','$mrn','$patientName','$assessmentDate','$totalcode','$totalScore','$coder','$coder_Id','$qccoder','$qccoder_Id')";


            $resultinsertquery = ($conn)->query($insertquery);

           if (!$resultinsertquery) {
    echo "Error: " . $conn->error;
} else {
    echo "Insertion successful!";
}
          }
        }
      }
    } else {
      // No 'M-Items' found
      echo "No 'M-Items' found for the given Entry_Id.";
    }
  }
}


//qc segement score
if ($action === 'oasisscore') {
  // Fetch Id from POST data
  $Id = $_POST['Id'];
  $mitem = array();

  // Select data from Pocsegementqc
  $sqlselectdata = "SELECT `M_item` FROM `oasisqc` WHERE `Entry_Id`='$Id' AND `Error_type` IN ('Added','Deleted','Modified','Other')";
  $sqlselectsresult = $conn->query($sqlselectdata);

  // Check if data is found
  if ($sqlselectsresult === false) {
    // Handle query error
    echo "Error: " . $conn->error;
  } else {

    // Fetch 'Poc_items'
    while ($row = $sqlselectsresult->fetch_assoc()) {
      // Split M_item based on hyphen
      $split_mitem = explode('-', $row['M_item']);


      // Use only the part before the hyphen
      $mitem[] = trim($split_mitem[0]);
    }

    // Prepare 'Poc_items' for SQL query
     $mitemsdata = implode("','", $mitem);


     echo $mitemsdata;

    // Calculate sum of scores
     $sqldatasearch = "SELECT SUM(`Score`) AS total_score 
                          FROM `coding-scoring` 
                          WHERE `status`='active' 
                          AND `Mitem` IN ('$mitemsdata')
                          AND `Segement` ='Oasis'";

    $sqldatasearchresult = $conn->query($sqldatasearch);


    // Check if query was successful
    if ($sqldatasearchresult === false) {
      // Handle query error
      echo "Error: " . $conn->error;
    } else {
      // Check if score data is found
      if ($sqldatasearchresult->num_rows > 0) {



        // Fetch total score

        $row = $sqldatasearchresult->fetch_assoc();

    
         $oasissegementvalue = $row['total_score'];

         // echo $oasissegementvalue;


        // Output the total score
        $totaloasis = $total - ($oasissegementvalue ?? 0);

        // echo $totaloasis;

        if ($totaloasis) {

           $sqlselectdataoa = "SELECT `Entry_Id`,`code_scoring`FROM `qcscoringvalue` WHERE `Entry_Id`='$Id'";
          $sqlselectdataoaresult = $conn->query($sqlselectdataoa);

          if ($sqlselectdataoaresult) {

             $sqlupdatedataoasis = "UPDATE `qcscoringvalue` SET `oasis_scoring`='$totaloasis', `qc_oasis_scoring`='$oasissegementvalue' WHERE `Entry_Id`='$Id'";

            if ($conn->query($sqlupdatedataoasis) === TRUE) {

              echo json_encode($sqlupdatedataoasis);
            } else {

              // echo json_encode($response);
            }
          }
        }
      } else {
        // No score found
        echo "No score found for Oasis items.";
      }
    }
  }
}




//poc segement score
if ($action === 'pocscore') {
  // Fetch Id from POST data
  $Id = $_POST['Id'];
  $mitem = array();

  // Select data from Pocsegementqc
  $sqlselectdata = "SELECT `Poc_item` FROM `Pocsegementqc` WHERE `Entry_Id`='$Id' AND `Error_type` IN ('Added','Deleted','Modified','Other')";
  $sqlselectsresult = $conn->query($sqlselectdata);

  // Check if data is found
  if ($sqlselectsresult === false) {
    // Handle query error
    echo "Error: " . $conn->error;
  } else {
    // Fetch 'Poc_items'
    while ($row = $sqlselectsresult->fetch_assoc()) {
      $mitem[] = $row['Poc_item'];
    }

    // Prepare 'Poc_items' for SQL query
    $mitemsdata = implode("','", $mitem);

    // Calculate sum of scores
    $sqldatasearch = "SELECT SUM(`Score`) AS total_score 
                          FROM `coding-scoring` 
                          WHERE `status`='active' 
                          AND `Mitem` IN ('$mitemsdata')
                          AND `Segement` ='Poc'";

    $sqldatasearchresult = $conn->query($sqldatasearch);

    // Check if query was successful
    if ($sqldatasearchresult === false) {
      // Handle query error
      echo "Error: " . $conn->error;
    } else {
      // Check if score data is found
      if ($sqldatasearchresult->num_rows > 0) {
        // Fetch total score
        $row = $sqldatasearchresult->fetch_assoc();
        $pocsegementvalue = $row['total_score'];

        // Output the total score
        $totalpoc =  $total - ($pocsegementvalue ?? 0);

        $pocsegementvalue;


        if ($totalpoc) {

          $sqlselectdataoa = "SELECT `Entry_Id`,`code_scoring`FROM `qcscoringvalue` WHERE `Entry_Id`='$Id' AND `code_scoring` IS NOT Null";
          $sqlselectdataoaresult = $conn->query($sqlselectdataoa);

          if ($sqlselectdataoaresult) {

            $sqlupdatedataoasis = "UPDATE `qcscoringvalue` SET `poc_scoring`='$totalpoc' ,`qc_poc_scoring`='$pocsegementvalue' WHERE `Entry_Id`='$Id' AND `code_scoring` IS NOT Null";

            if ($conn->query($sqlupdatedataoasis) === TRUE) {

              // echo json_encode($response);
            } else {

              // echo json_encode($response);
            }
          }
        }
      } else {
        // No score found
        echo "No score found for Poc items.";
      }
    }
  }
}


//totalscore


if ($action === 'totalscore') {
    $Id = $_POST['Id'];
    $totalscore = $_POST['totalscoringString'];
    $qctotalscore = $_POST['qctotalscoringString'];
    $totalcode = $_POST['codescoring'];
    $totaloasis = $_POST['oasisscoring'];
    $totalpoc = $_POST['pocscoring'];
    $qccodescoring = $_POST['qccodescoring'];
    $qcoasisscoring = $_POST['qcoasisscoring'];
    $qcpocscoring = $_POST['qcpocscoring'];

    // Update total data in main table
    $sqlupdatemaindata = "UPDATE `Main_Data` SET `qc_score`='$qctotalscore', `coder_avrg_score`='$totalscore' , `code_segment_score`='$totalcode', `oasis_segment_score`='$totaloasis', `oasis_segment_score`='$totalpoc' WHERE `Id`='$Id'";
    $sqlupdatemaindataresult = $conn->query($sqlupdatemaindata);

    if ($sqlupdatemaindataresult === TRUE) {
        $selecttoalscoredata = "SELECT  `total_scoring` FROM `qcscoringvalue` WHERE `Entry_Id`='$Id'";
        $selecttotalscoreresult = $conn->query($selecttoalscoredata);

        if ($selecttotalscoreresult->num_rows > 0) {
            $updatetotalscoredata = "UPDATE `qcscoringvalue` SET `code_scoring`='$totalcode',`qc_code_scoring`='$qccodescoring',`oasis_scoring`='$totaloasis',`qc_oasis_scoring`='$qcoasisscoring',`poc_scoring`='$totalpoc',`qc_poc_scoring`='$qcpocscoring', `total_scoring`='$totalscore' ,`qc_total_scoring`='$qctotalscore' WHERE `Entry_Id`='$Id'";
            $updatetotalscoredataresult = $conn->query($updatetotalscoredata);

            if ($updatetotalscoredataresult === TRUE) {
                echo "score got updated";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "No rows found";
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}





//container show data
if($action==='containershow'){


$agency=$_POST['agency'];
$Id=$_POST['Id'];


$sqlshowcontainer="SELECT * FROM `codepage` WHERE `agency`='$agency'";
$sqlshowcontainerresult=$conn ->query($sqlshowcontainer);


if($sqlshowcontainerresult && $sqlshowcontainerresult->num_rows >0){


$row=$sqlshowcontainerresult ->fetch_assoc();


$response=[

'code_segment'=>$row['code_segment'],
'oasis_segment'=>$row['oasis_segment'],
'poc_segment'=>$row['poc_segment'],
];

echo json_encode($response); // Return data as JSON
}

}