<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and user session files
include('../db/db-con.php');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$data = $_POST['dataArray'] ?? [];

foreach ($data as $row) {
    $mitems = $row['mitems'];
    $icd = $row['icd'];

    if (!empty($icd) && !empty($mitems)) {
        if ($mitems == "M1021A") {
            $clinicangroupQuery = "SELECT * FROM `Codedescription` WHERE `ICD-10-code` = ? AND `Diagnosis_type` = 'Primary'";
            $stmt = $conn->prepare($clinicangroupQuery);
            $stmt->bind_param('s', $icd);
            $stmt->execute();

            $clinicangroupResult = $stmt->get_result();

            if ($clinicangroupResult->num_rows > 0) {
                $position2value = $clinicangroupResult->fetch_assoc();

                if ($position2value) {
                    $Clinicalgroup = $position2value['Clinical_group'];
                    $Clinicalgroupname = $position2value['Clinical_group_name'];

                    $jsonResponse = [
                        'success' => true,
                        'Clinicalgroup' => $Clinicalgroup,
                        'Clinicalgroupname' => $Clinicalgroupname,
                    ];

                    echo json_encode($jsonResponse);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Invalid data']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'No records found']);
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>
