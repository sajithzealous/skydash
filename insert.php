<?php
 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

 
 include('db/db-con.php');

 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $team_name = $_POST['team'];
    $agency_name = $_POST['agency'];
    $location = $_POST['location'];
    $patient = $_POST['patient'];
    $phone = $_POST['phone'];
    $task = $_POST['task'];
    $mrn = $_POST['mrn'];
    $asse_date = $_POST['asse_date'];
    $dsi = $_POST['dsi'];
    $dsc = $_POST['dsc'];
    $asse_type = $_POST['asse_type'];
    $insu_type = $_POST['insu_type'];
    $status = $_POST['status'];
    $user = $_POST['user'];
    $work = $_POST['work'];
    $remark = $_POST['remark'];
   

 
      $team = ucwords(strtolower(preg_replace('/\s+/', ' ', str_replace(',', '', $team_name))));
     $agency = strtoupper($agency_name);
     $location = strtoupper($location);
        $patient = ucwords(strtolower(preg_replace('/\s+/', ' ', str_replace(',', '', $patient))));
        $patient = trim(preg_replace('/\s+/', ', ', $patient));
    // $task = ucwords(strtolower(preg_replace('/\s+/', ' ', str.replace(',', '', $task))));
    
 
      $asse_date = date('M-d-Y', strtotime($asse_date));
      $dsi = date('M-d-Y', strtotime($dsi));
      $dsc = date('M-d-Y', strtotime($dsc));


 
       $sql = "INSERT INTO `data` (
        `Team`, `Agency`, `Location`, `Patient_Name`,`Phone_Number`,`Task`, `Mrn`,
        `Assessment_Date`, `Dsi`, `Dsc`,`Assessment_Type`, `Insurance_Type`,
                    `Status`, `User`, `Workable`, `Remarks`
    ) VALUES ('$team','$agency','$location','$patient','$phone','$task','$mrn','$asse_date', '$dsi', '$dsc','$asse_type','$insu_type','$status','$user','$work','$remark')";

    $stmt = $conn->prepare($sql);
   
 
     
    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

 
$conn->close();
?>
