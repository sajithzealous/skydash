<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Fetch session variables
$user = $_SESSION["username"];
$emp_id = $_SESSION["empid"];
$action = $_GET["action"];

// Include database connection
include "../db/db-con.php";

//Code segement score
if ($action === "codescore") {
    // Fetch Id from POST data
    $Id = $_POST["Id"];
    $totalScoreCode = 0;
    $totalScoreQC = 0;

    // Fetch 'M-Items' from Codesegement
    $totalcodesegement = "SELECT `M-Items` FROM `Codesegement` WHERE `Entry_Id`='$Id' AND `Coderchecked`='Coder'";
    $totalcodesegementpoints = $conn->query($totalcodesegement);

    if ($totalcodesegementpoints === false) {
        // Handle query error
        echo "Error: " . $conn->error;
    } else {
        $mItems = [];
        while ($row = $totalcodesegementpoints->fetch_assoc()) {
            $mItems[] = $row["M-Items"];
        }

        if (!empty($mItems)) {
            $mItemsData = implode("','", $mItems);
            $sqlTotalScore = "SELECT `Mitem`, SUM(`Score`) AS total_score 
                              FROM `coding-scoring` 
                              WHERE `status`='active' 
                              AND `Mitem` IN ('$mItemsData') 
                              AND `Segement`='Code'
                              GROUP BY `Mitem`";
            $resultTotalScore = $conn->query($sqlTotalScore);

            if ($resultTotalScore === false) {
                // Handle query error
                echo "Error: " . $conn->error;
            } else {
                while ($row = $resultTotalScore->fetch_assoc()) {
                    $totalScoreCode += $row["total_score"];
                }
            }
        } else {
            echo "No M-Items found in Codesegement.";
        }
    }

    // Fetch 'Poc_item' from Codesegementqc
    $totalcodesegementqc = "SELECT `M_Item` FROM `Codesegementqc` WHERE `Entry_Id`='$Id' AND `Error_type` IN ('Added','Deleted','Modified','Other') AND `Coderchecked`='Coder'";
    $totalcodesegementpointsqc = $conn->query($totalcodesegementqc);

    if ($totalcodesegementpointsqc === false) {
        // Handle query error
        echo "Error: " . $conn->error;
    } else {
        $mItems = [];
        while ($row = $totalcodesegementpointsqc->fetch_assoc()) {
            $mItems[] = $row["M_Item"];
        }

        if (!empty($mItems)) {
            $mItemsData = implode("','", $mItems);
            $sqlTotalScoreQC = "SELECT `Mitem`, SUM(`Score`) AS total_score 
                                FROM `coding-scoring` 
                                WHERE `status`='active' 
                                AND `Mitem` IN ('$mItemsData') 
                                AND `Segement`='Code'
                                GROUP BY `Mitem`";
            $resultTotalScoreQC = $conn->query($sqlTotalScoreQC);

            if ($resultTotalScoreQC === false) {
                // Handle query error
                echo "Error: " . $conn->error;
            } else {
                while ($row = $resultTotalScoreQC->fetch_assoc()) {
                    $totalScoreQC += $row["total_score"];
                }
            }
        } else {
            echo "No M-Items found in Codesegementqc.";
        }
    }

    // Calculate the combined total score
   $totalScoreQC; 
     $totalScoreCode; 
     $totalscoreqccode = $totalScoreCode - $totalScoreQC; 
    if ($totalScoreQC == 0) {
        $combinedTotalScorecode = 100;
    } else {
        $combinedTotalScore = ($totalscoreqccode / $totalScoreCode) * 100;
      
        $combinedTotalScorecode = 100 - $combinedTotalScore;

        echo $combinedTotalScorecode;

    }

    // Output the combined total score
    // echo "Combined Total Score: " . $combinedTotalScorecode;

    if ($combinedTotalScorecode) {
        // echo $combinedTotalScorecode;
        $queryselect = "SELECT `Entry_Id` FROM `qcscoringvalue` WHERE `Entry_Id` ='$Id'AND `code_scoring` IS NOT NULL";
        $queryselectresult = $conn->query($queryselect);

        if ($queryselectresult->num_rows > 0) {
            $queryupdatecode = "UPDATE `qcscoringvalue` SET `code_scoring` ='$combinedTotalScore', `qc_code_scoring`='$combinedTotalScorecode' WHERE `Entry_Id` ='$Id'AND `code_scoring` IS NOT NULL";

            $resultupdatequery = $conn->query($queryupdatecode);
        } else {
            $query = "SELECT * FROM `Main_Data` WHERE `Id`='$Id'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $Id = $row["Id"];
                $patientName = $row["patient_name"];
                $mrn = $row["mrn"];
                $assessmentDate = $row["assesment_date"];
                $Team = $row["alloted_team"];
                $coder = $row["alloted_to_coder"];
                $coder_Id = $row["coder_emp_id"];
                $qccoder = $row["qc_person"];
                $qccoder_Id = $row["qc_person_emp_id"];
            } else {
                echo "No user found with the given ID";
            }

            $insertquery = "INSERT INTO `qcscoringvalue`(`Entry_Id`, `Mrn`, `Patient_Name`, `Assessment_Date`, `code_scoring`, `qc_code_scoring`,`coder`, `coder_emp_id`, `qc_coder`, `qc_emp_id`) VALUES ('$Id','$mrn','$patientName','$assessmentDate','$combinedTotalScorecode','$combinedTotalScore','$coder','$coder_Id','$qccoder','$qccoder_Id')";

            $resultinsertquery = $conn->query($insertquery);

            if (!$resultinsertquery) {
                echo "Error: " . $conn->error;
            } else {
                echo "Insertion successful!";
            }
        }
    }
}

//oasis segment score
 else if ($action === "oasisscore") {
    // Fetch Id from POST data
    $entryId = $_POST["Id"];
    $totalScoreOasis = 0;
    $totalScoreOasisQC = 0;
    // Fetch 'Oasis_item' from Oasis segment
    $oasisSegmentQuery = "SELECT `M_item` FROM `oasis` WHERE `Entry_Id`='$entryId'";
    $oasisSegmentResult = $conn->query($oasisSegmentQuery);
    if ($oasisSegmentResult === false) {
        // Handle query error
        echo "Error: " . $conn->error;
    } else {
        $oasisItems = [];
        while ($row = $oasisSegmentResult->fetch_assoc()) {
            $oasisItems[] = $row["M_item"];
        }
        if (!empty($oasisItems)) {
            $oasisItemsData = implode("','", $oasisItems);
            $totalScoreOasisQuery = "SELECT SUM(`Score`) AS total_score
                                   FROM `coding-scoring`
                                   WHERE `status`='active'
                                   AND `Mitem` IN ('$oasisItemsData')
                                   AND `Segment`='Oasis'";
            $totalScoreOasisResult = $conn->query($totalScoreOasisQuery);
            if ($totalScoreOasisResult === false) {
                // Handle query error
                echo "Error: " . $conn->error;
            } else {
                while ($row = $totalScoreOasisResult->fetch_assoc()) {
                    $totalScoreOasis += $row["total_score"];
                }
            }
        } else {
            echo "No M_item found in Oasis segment.";
        }
    }
    // Fetch 'M_item' from Oasis segment QC
    $oasisSegmentQcQuery = "SELECT `M_item` FROM `oasisqc` WHERE `Entry_Id`='$entryId' AND `Error_type` IN ('Added','Deleted','Modified','Other')";
    $oasisSegmentQcResult = $conn->query($oasisSegmentQcQuery);
    if ($oasisSegmentQcResult === false) {
        // Handle query error
        echo "Error: " . $conn->error;
    } else {
        $oasisItemsQc = [];
        while ($row = $oasisSegmentQcResult->fetch_assoc()) {
            $oasisItemsQc[] = $row["M_item"];
        }
        if (!empty($oasisItemsQc)) {
            $oasisItemsQcData = implode("','", $oasisItemsQc);
            $totalScoreOasisQcQuery = "SELECT SUM(`Score`) AS total_score
                                     FROM `coding-scoring`
                                     WHERE `status`='active'
                                     AND `Mitem` IN ('$oasisItemsQcData')
                                     AND `Segment`='Oasis'";
            $totalScoreOasisQcResult = $conn->query($totalScoreOasisQcQuery);
            if ($totalScoreOasisQcResult === false) {
                // Handle query error
                echo "Error: " . $conn->error;
            } else {
                while ($row = $totalScoreOasisQcResult->fetch_assoc()) {
                    $totalScoreOasisQC += $row["total_score"];
                }
            }
        } else {
            echo "No M_item found in Oasis segment QC.";
        }
    }
    // Calculate the combined total score
     $totalScoreOasis;
     $totalScoreOasisQC;
     $netTotalScoreOasis = $totalScoreOasis - $totalScoreOasisQC;
    // echo $netTotalScoreOasis;
    if ($totalScoreOasisQC == 0) {
        $combinedTotalScoreOasis = 100;
    } else {
        $combinedTotalScoreOasis = ($netTotalScoreOasis / $totalScoreOasis) * 100;
        $combinedTotalScoreOasisqc = 100 - $combinedTotalScoreOasis;
    }
    // Output the combined total score




        if ($combinedTotalScoreOasis) {

           $sqlselectdataoa = "SELECT `Entry_Id`,`code_scoring`FROM `qcscoringvalue` WHERE `Entry_Id`='$entryId'";
          $sqlselectdataoaresult = $conn->query($sqlselectdataoa);

          if ($sqlselectdataoaresult) {

             $sqlupdatedataoasis = "UPDATE `qcscoringvalue` SET `oasis_scoring`='$combinedTotalScoreOasis', `qc_oasis_scoring`='$combinedTotalScoreOasisqc' WHERE `Entry_Id`='$entryId'";

            if ($conn->query($sqlupdatedataoasis) === TRUE) {

              echo json_encode($sqlupdatedataoasis);
            } else {

              // echo json_encode($response);
            }
          }
        }
}



//ggmitem segement score

else if ($action === "ggmitemcore") {

    // Fetch Id and ggmitemvalue from POST data
    $entryId = $_POST["Id"];
    $ggmitemvalue = $_POST['ggmitemvalue'];

    $totalScoreOasis = 0;
    $totalScoreOasisQC = 0;

    // Fetch 'M_item' from Oasis segment
    $oasisSegmentQuery = "SELECT `M_item` FROM `oasis` WHERE `Entry_Id`='$entryId'";
    $oasisSegmentResult = $conn->query($oasisSegmentQuery);
    if ($oasisSegmentResult === false) {
        echo "Error: " . $conn->error;
    } else {
        $oasisItems = [];
        while ($row = $oasisSegmentResult->fetch_assoc()) {
            $oasisItems[] = $row["M_item"];
        }

        if (!empty($oasisItems)) {
            $oasisItemsData = implode("','", $oasisItems);
            $totalScoreOasisQuery = "SELECT SUM(`Score`) AS total_score
                                     FROM `coding-scoring`
                                     WHERE `status`='active'
                                     AND `Mitem` IN ('$oasisItemsData')
                                     AND `Segment`='Oasis'";
            $totalScoreOasisResult = $conn->query($totalScoreOasisQuery);
            if ($totalScoreOasisResult === false) {
                echo "Error: " . $conn->error;
            } else {
                while ($row = $totalScoreOasisResult->fetch_assoc()) {
                    $totalScoreOasis += $row["total_score"];
                }
            }
        } else {
            echo "No M_item found in Oasis segment.";
        }
    }

    // Fetch 'M_item' from Oasis segment QC
    $oasisSegmentQcQuery = "SELECT `M_item` FROM `oasisqc` WHERE `Entry_Id`='$entryId' AND `Error_type` IN ('Added','Deleted','Modified','Other')";
    $oasisSegmentQcResult = $conn->query($oasisSegmentQcQuery);
    if ($oasisSegmentQcResult === false) {
        echo "Error: " . $conn->error;
    } else {
        $oasisItemsQc = [];
        while ($row = $oasisSegmentQcResult->fetch_assoc()) {
            $oasisItemsQc[] = $row["M_item"];
        }

        if (!empty($oasisItemsQc)) {
            $oasisItemsQcData = implode("','", $oasisItemsQc);
            $totalScoreOasisQcQuery = "SELECT SUM(`Score`) AS total_score
                                       FROM `coding-scoring`
                                       WHERE `status`='active'
                                       AND `Mitem` IN ('$oasisItemsQcData')
                                       AND `Segment`='Oasis'";
            $totalScoreOasisQcResult = $conn->query($totalScoreOasisQcQuery);
            if ($totalScoreOasisQcResult === false) {
                echo "Error: " . $conn->error;
            } else {
                while ($row = $totalScoreOasisQcResult->fetch_assoc()) {
                    $totalScoreOasisQC += $row["total_score"];
                }
            }
        } else {
            echo "No M_item found in Oasis segment QC.";
        }
    }

    // Calculate the net total score for Oasis
    $netTotalScoreOasis = $totalScoreOasis - $totalScoreOasisQC;

    // Calculate the combined total score for Oasis
    if ($totalScoreOasisQC == 0 && $ggmitemvalue == 0) {
        $combinedTotalScoreOasis = 100;
    } else {
        $combinedTotalScoreOasis = ($netTotalScoreOasis / $totalScoreOasis) * 100;
        $ggmitemvaluetotal = ($ggmitemvalue + $combinedTotalScoreOasis) / 2;
        $combinedTotalScoreOasisqc = 100 - $ggmitemvaluetotal;
    }

    // Check and update the database with the new scoring values
    if (isset($combinedTotalScoreOasis)) {

        $sqlSelectDataOasis = "SELECT `Entry_Id`, `code_scoring` FROM `qcscoringvalue` WHERE `Entry_Id`='$entryId'";
        $sqlSelectDataOasisResult = $conn->query($sqlSelectDataOasis);

        if ($sqlSelectDataOasisResult) {
            $sqlUpdateDataOasis = "UPDATE `qcscoringvalue` SET `oasis_scoring`='$combinedTotalScoreOasis', `qc_oasis_scoring`='$combinedTotalScoreOasisqc' WHERE `Entry_Id`='$entryId'";
            
            if ($conn->query($sqlUpdateDataOasis) === TRUE) {
                echo json_encode($sqlUpdateDataOasis);
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Error fetching data: " . $conn->error;
        }
    }
}







//poc segement score
elseif ($action === "pocscore") {
    // Fetch Id from POST data
    $entryId = $_POST["Id"];
    $totalScorePoc = 0;
    $totalScorePocQC = 0;

    // Fetch 'Poc_item' from Pocsegement
    $pocSegmentQuery = "SELECT `Poc_item` FROM `Pocsegement` WHERE `Entry_Id`='$entryId'";
    $pocSegmentResult = $conn->query($pocSegmentQuery);

    if ($pocSegmentResult === false) {
        // Handle query error
        echo "Error: " . $conn->error;
    } else {
        $pocItems = [];
        while ($row = $pocSegmentResult->fetch_assoc()) {
            $pocItems[] = $row["Poc_item"];
        }

        if (!empty($pocItems)) {
            $pocItemsData = implode("','", $pocItems);
            $totalScorePocQuery = "SELECT SUM(`Score`) AS total_score 
                                   FROM `coding-scoring` 
                                   WHERE `status`='active' 
                                   AND `Mitem` IN ('$pocItemsData') 
                                   AND `Segement`='Poc'";
            $totalScorePocResult = $conn->query($totalScorePocQuery);

            if ($totalScorePocResult === false) {
                // Handle query error
                echo "Error: " . $conn->error;
            } else {
                while ($row = $totalScorePocResult->fetch_assoc()) {
                    $totalScorePoc += $row["total_score"];
                }
            }
        } else {
            echo "No Poc_item found in Pocsegement.";
        }
    }

    // Fetch 'Poc_item' from Pocsegementqc
    $pocSegmentQcQuery = "SELECT `Poc_item` FROM `Pocsegementqc` WHERE `Entry_Id`='$entryId' AND `Error_type` IN ('Added','Deleted','Modified','Other')";
    $pocSegmentQcResult = $conn->query($pocSegmentQcQuery);

    if ($pocSegmentQcResult === false) {
        // Handle query error
        echo "Error: " . $conn->error;
    } else {
        $pocItemsQc = [];
        while ($row = $pocSegmentQcResult->fetch_assoc()) {
            $pocItemsQc[] = $row["Poc_item"];
        }

        if (!empty($pocItemsQc)) {
            $pocItemsQcData = implode("','", $pocItemsQc);
            $totalScorePocQcQuery = "SELECT SUM(`Score`) AS total_score 
                                     FROM `coding-scoring` 
                                     WHERE `status`='active' 
                                     AND `Mitem` IN ('$pocItemsQcData') 
                                     AND `Segement`='Poc'";
            $totalScorePocQcResult = $conn->query($totalScorePocQcQuery);

            if ($totalScorePocQcResult === false) {
                // Handle query error
                echo "Error: " . $conn->error;
            } else {
                while ($row = $totalScorePocQcResult->fetch_assoc()) {
                    $totalScorePocQC += $row["total_score"];
                }
            }
        } else {
            echo "No Poc_item found in Pocsegementqc.";
        }
    }

    // Calculate the combined total score
    $totalScorePoc;
    $totalScorePocQC;

    $netTotalScorePoc = $totalScorePoc - $totalScorePocQC;
    // echo  $netTotalScorePoc;
    if ($totalScorePocQC == 0) {
        $combinedTotalScorePoc = 100;
    } else {
        $combinedTotalScore = ($netTotalScorePoc / $totalScorePoc) * 100;
        $combinedTotalScorePoc = 100 - $combinedTotalScore;
    }


            if ($combinedTotalScorePoc) {

          $sqlselectdataoa = "SELECT `Entry_Id`,`code_scoring`FROM `qcscoringvalue` WHERE `Entry_Id`='$entryId' AND `code_scoring` IS NOT Null";
          $sqlselectdataoaresult = $conn->query($sqlselectdataoa);

          if ($sqlselectdataoaresult) {

            $sqlupdatedataoasis = "UPDATE `qcscoringvalue` SET `poc_scoring`='$combinedTotalScore' ,`qc_poc_scoring`='$combinedTotalScorePoc' WHERE `Entry_Id`='$entryId' AND `code_scoring` IS NOT Null";

            if ($conn->query($sqlupdatedataoasis) === TRUE) {

              // echo json_encode($response);
            } else {

              // echo json_encode($response);
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
if ($action === "containershow") {
    $agency = $_POST["agency"];
    $Id = $_POST["Id"];

    $sqlshowcontainer = "SELECT * FROM `codepage` WHERE `agency`='$agency'";
    $sqlshowcontainerresult = $conn->query($sqlshowcontainer);

    if ($sqlshowcontainerresult && $sqlshowcontainerresult->num_rows > 0) {
        $row = $sqlshowcontainerresult->fetch_assoc();

        $response = [
            "code_segment" => $row["code_segment"],
            "oasis_segment" => $row["oasis_segment"],
            "poc_segment" => $row["poc_segment"],
        ];

        echo json_encode($response); // Return data as JSON
    }
}
