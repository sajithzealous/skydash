<?php
session_start();

include('db/db-con.php');
 
$user = $_SESSION['username'];
$emp_id = $_SESSION['empid'];
 
$agency_query = "SELECT `agency_name` FROM `Agent` WHERE `client_name`='$user' AND `client_id`='$emp_id'";
$agency_result = $conn->query($agency_query);
 
$agencies = array();
if ($agency_result && $agency_result->num_rows > 0) {
    while ($agencyData = $agency_result->fetch_assoc()) {
       $agencies[] = $agencyData['agency_name'];
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Error: Check Agency Name.']);
    exit;  
}
 
if (isset($_GET['getdate'])) {
    $getdate = $_GET['getdate'];
 
    if ($agencies) {
        $agency_names = implode("','", $agencies);
   $sql = "SELECT 
        (SELECT COUNT(`status`)
               FROM Main_Data
           WHERE `status` = 'new'
  AND `agency` IN ('$agency_names') AND `log_time` >= DATE_SUB('$getdate', INTERVAL 1 DAY)
  AND `log_time` < '$getdate') AS oneday,

          (SELECT COUNT(`status`)
           FROM Main_Data 
           WHERE `status` = 'new' 
             AND `agency`IN ('$agency_names') AND `log_time` >= DATE_SUB('$getdate', INTERVAL 2 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 1 DAY)) AS twodays,
             
          (SELECT COUNT(`status`) 
           FROM Main_Data 
           WHERE `status` = 'new' 
             AND `agency`IN ('$agency_names') AND `log_time` >= DATE_SUB('$getdate', INTERVAL 3 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 2 DAY)) AS threedays,
             
          (SELECT COUNT(`status`)
           FROM Main_Data 
           WHERE `status` = 'new' 
             AND `agency`IN ('$agency_names') AND `log_time` >= DATE_SUB('$getdate', INTERVAL 4 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 3 DAY)) AS fourdays,
             
          (SELECT COUNT(`status`) 
           FROM Main_Data 
           WHERE `status` = 'new' 
             AND `agency`IN ('$agency_names') AND `log_time` >= DATE_SUB('$getdate', INTERVAL 5 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 4 DAY)) AS fivedays,

          (SELECT COUNT(`status`) 
           FROM Main_Data 
           WHERE `status` = 'new' 
             AND  `agency`IN ('$agency_names') AND `log_time` <= DATE_SUB('$getdate', INTERVAL 5 DAY)
             ) AS sixdays";

        // Execute the SQL query
        $run = mysqli_query($conn, $sql);

        if ($run) {
            $result = mysqli_fetch_assoc($run);
            echo json_encode($result);
        } else {
            echo json_encode(array('error' => "QUERY ERROR: " . mysqli_error($conn)));
        }
    }
}
?>
