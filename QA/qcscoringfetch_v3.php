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


     echo $totalScoreQC;
     echo $totalScoreCode;
    // if ($totalScoreQC == 0) {
    //     $combinedTotalScorecode = 100;
    // } else {
    //     $combinedTotalScore = ($totalscoreqccode / $totalScoreCode) * 100;
      
    //     $combinedTotalScorecode = 100 - $combinedTotalScore;

    //     echo $combinedTotalScorecode;

    // }

    // Output the combined total score
    // echo "Combined Total Score: " . $combinedTotalScorecode;

    // if ($combinedTotalScorecode) {
    //     // echo $combinedTotalScorecode;
    //     $queryselect = "SELECT `Entry_Id` FROM `qcscoringvalue` WHERE `Entry_Id` ='$Id'AND `code_scoring` IS NOT NULL";
    //     $queryselectresult = $conn->query($queryselect);

    //     if ($queryselectresult->num_rows > 0) {
    //         $queryupdatecode = "UPDATE `qcscoringvalue` SET `code_scoring` ='$combinedTotalScore', `qc_code_scoring`='$combinedTotalScorecode' WHERE `Entry_Id` ='$Id'AND `code_scoring` IS NOT NULL";

    //         $resultupdatequery = $conn->query($queryupdatecode);
    //     } else {
    //         $query = "SELECT * FROM `Main_Data` WHERE `Id`='$Id'";
    //         $result = $conn->query($query);

    //         if ($result && $result->num_rows > 0) {
    //             $row = $result->fetch_assoc();
    //             $Id = $row["Id"];
    //             $patientName = $row["patient_name"];
    //             $mrn = $row["mrn"];
    //             $assessmentDate = $row["assesment_date"];
    //             $Team = $row["alloted_team"];
    //             $coder = $row["alloted_to_coder"];
    //             $coder_Id = $row["coder_emp_id"];
    //             $qccoder = $row["qc_person"];
    //             $qccoder_Id = $row["qc_person_emp_id"];
    //         } else {
    //             echo "No user found with the given ID";
    //         }

    //         $insertquery = "INSERT INTO `qcscoringvalue`(`Entry_Id`, `Mrn`, `Patient_Name`, `Assessment_Date`, `code_scoring`, `qc_code_scoring`,`coder`, `coder_emp_id`, `qc_coder`, `qc_emp_id`) VALUES ('$Id','$mrn','$patientName','$assessmentDate','$combinedTotalScorecode','$combinedTotalScore','$coder','$coder_Id','$qccoder','$qccoder_Id')";

    //         $resultinsertquery = $conn->query($insertquery);

    //         if (!$resultinsertquery) {
    //             echo "Error: " . $conn->error;
    //         } else {
    //             echo "Insertion successful!";
    //         }
    //     }
    // }
}

?>