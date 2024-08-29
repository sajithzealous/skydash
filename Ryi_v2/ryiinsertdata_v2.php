<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user = $_SESSION['username'] ?? '';
$emp_id = $_SESSION['empid'] ?? '';

include('../db/db-con.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$data = $_POST['dataArray'] ?? [];

if (empty($data)) {
    echo json_encode(['success' => false, 'error' => 'Empty Data Not Inserted']);
    exit;
}

foreach ($data as $row) {
    $Id = $row['Id'];
    $timingtext = $row['timingtext'];
    $sourcetext = $row['sourcetext'];
    $cpscCodetext = $row['cpscCodetext'];
    $locationtext = $row['locationtext'];

    $precodevalue=$row['precodevalue'];
    $precodevaluemultiply=$row['precodevaluemultiply'];
    $postcodevalue=$row['postcodevalue'];
    $postcodevaluemultiply=$row['postcodevaluemultiply'];
    $additionalvaluemultiply=$row['additionalvaluemultiply'];
    $additionvalue=$row['additionvalue'];



    // $checkboxValuestext = $row['checkboxValuestext'];
    // $checkboxdataValues = $row['checkboxdataValues'];
    // $checkboxValuesString = implode(',', $checkboxValuestext);
    // $checkboxDataValuesString = implode(',', $checkboxdataValues);
    // $Groomingdata = $row['Groomingdata'];
    // $Groomingtext = $row['Groomingtext'];
    // $Dressupperdata = $row['Dressupperdata'];
    // $Dressuppertext = $row['Dressuppertext'];
    // $Dresslowerdata = $row['Dresslowerdata'];
    // $Dresslowertext = $row['Dresslowertext'];
    // $Bathingdata = $row['Bathingdata'];
    // $Bathingtext = $row['Bathingtext'];
    // $Toiletdata = $row['Toiletdata'];
    // $Toilettext = $row['Toilettext'];
    // $Transferingdata = $row['Transferingdata'];
    // $Transferingtext = $row['Transferingtext'];
    // $Locomotiondata = $row['Locomotiondata'];
    // $Locomotiontext = $row['Locomotiontext'];

    $sqldata = "SELECT `patient_name`, `mrn`, `phone_number`, `assesment_date` FROM `Main_Data` WHERE `Id`='$Id'";
    $result = $conn->query($sqldata);

    if ($result && $result->num_rows > 0) {
        $resultdata = $result->fetch_assoc();
        $patientName = $resultdata['patient_name'];
        $mrn = $resultdata['mrn'];
        $assessmentDate = $resultdata['assesment_date'];

        // Check if the entry exists
        $selectdata = "SELECT `Entry_Id` FROM `hhrgcodedata` WHERE `Entry_Id`='$Id'";
        $selectdataresult = $conn->query($selectdata);

        if ($selectdataresult && $selectdataresult->num_rows > 0) {
            // Entry exists, update it
            $updateresult = "UPDATE `hhrgcodedata` SET `timing`='$timingtext',`source`='$sourcetext',`cpsccode`='$cpscCodetext',`location`='$locationtext',`precodevalue`='$precodevalue',`precodevaluemultiply`='$precodevaluemultiply',`postcodevalue`='$postcodevalue',`postcodevaluemultiply`='$postcodevaluemultiply',`additionvalue`='$additionvalue',`additionalvaluemultiply`='$additionalvaluemultiply',`User`='$user',`coder_emp_id`='$emp_id' WHERE `Entry_Id`='$Id'";
            $updateResult = $conn->query($updateresult);

            if ($updateResult) {
                echo json_encode(['success' => true, 'message' => 'Data updated successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error updating data']);
            }
        } else {
            // Entry does not exist, insert it
            $insertquery = "INSERT INTO `hhrgcodedata`(`Entry_Id`, `Mrn`, `Patient_Name`, `Assessment_Date`, `timing`, `source`, `cpsccode`, `location`,`precodevalue`, `precodevaluemultiply`, `postcodevalue`, `postcodevaluemultiply`, `additionvalue`, `additionalvaluemultiply`, `User`, `coder_emp_id`) VALUES ('$Id','$mrn','$patientName','$assessmentDate','$timingtext','$sourcetext','$cpscCodetext','$locationtext','$precodevalue','$precodevaluemultiply','$postcodevalue','$postcodevaluemultiply','$additionvalue','$additionalvaluemultiply','$user','$emp_id')";

            $insertresult = $conn->query($insertquery);

            if ($insertresult) {
                echo json_encode(['success' => true, 'message' => 'Data inserted successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error inserting data']);
            }
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No data found for given Id']);
    }
}
?>
