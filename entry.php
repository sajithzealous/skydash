<?php
include('db/db-con.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);



$role = $_SESSION['role'];
$username = $_SESSION['username'];
$password=$_SESSION['password'];
$emp_id = $_SESSION['empid'];

function handleFileUploads($target_dir, $files) {
    $file_paths = array();
    foreach ($files['tmp_name'] as $index => $tmp_name) {
        $target_file = $target_dir . basename($files['name'][$index]);
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'avif');
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_type, $allowed_types)) {
            die("Error: Invalid file type.");
        }
        if (move_uploaded_file($tmp_name, $target_file)) {
            $file_paths[] = $target_file;
        } else {
            echo "Error uploading file: " . $files['name'][$index];
            exit;
        }
    }
    return $file_paths;
}

function sanitizeInput($input) {
    return ucwords(strtolower(preg_replace('/\s+/', ' ', str_replace(',', '', $input))));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = 'chatupload/';
    $file_paths = handleFileUploads($target_dir, $_FILES['files']);

    $agency_name = $_POST['agency'];
    $patient = $_POST['patient'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '00000000';
    $mrn = $_POST['mrn'];
    $asse_date = $_POST['asse_date'];
    $asse_type = $_POST['asse_type'];
    $insu_type = $_POST['insu_type'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $url = $_POST['url'];

    $patientname = sanitizeInput($patient);
    $asse_type_new = sanitizeInput($asse_type);

    $sql = "INSERT INTO `Main_Data` (
             `patient_name`, `mrn`, `phone_number`, `insurance_type`, `assesment_date`, `assesment_type`, `priority`, `url`, `agency`, `status`
            , `file_uploaded_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $urlColumn = ($url == "") ? implode(" ", $file_paths) : $url;

    $stmt->bind_param("sssssssssss", $patientname, $mrn, $phone, $insu_type, $asse_date, $asse_type_new, $priority, $urlColumn, $agency_name, $status, $username);

    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
