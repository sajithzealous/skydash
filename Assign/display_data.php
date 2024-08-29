<?php
// Assuming you have a valid database connection in db-con.php
$urls = array();
 include('../db/db-con.php');

// Check if the 'id' parameter is set in the URL
$userId = isset($_COOKIE['Id']) ? $_COOKIE['Id'] : null;
// echo$userId;
$baseURL = "https://preqvoice.com/Elevate/";

// Initialize variables
$Id = '';
$patientName = "";
$phoneNumber = "";
$mrn = "";
$agency = "";
$assessmentDate = "";
$assessmentType = "";
$url = "";

// Fetch user data from the database based on the ID
if ($userId) {
    try {
        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Example query to fetch user data
        $query = "SELECT * FROM `Main_Data` WHERE `Id`='$userId'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch user data
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $Id = $row['Id'];
            $patientName = $row['patient_name'];
            $phoneNumber = $row['phone_number'];
            $mrn = $row['mrn'];
            $gency = $row['agency'];
            $assessmentDate = $row['assesment_date'];
           if($assessmentDate==Null || $assessmentDate==''){

            $assessmentDate='None';
           }
           else{
             $assessmentDate = date("m/d/Y", strtotime($assessmentDate));
           }
          
            $assessmentType = $row['assesment_type'];
            $insuranceType = $row['insurance_type'];
            $Team = $row['alloted_team'];
            $coder = $row['alloted_to_coder'];
            $dob = $row['dob'];
            $dob1 = date("m/d/Y", strtotime($dob));
            $gender = $row['gender'];
            $urls = trim($row['url']);
        }


        // echo$patientName;
        // echo$urls;

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
