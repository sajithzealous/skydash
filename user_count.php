  <?php
  

   include 'logsession.php';
session_start(); // Start the session

$user = $_SESSION['username'];
 include('db/db-con.php');
 

if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
   
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];

    // SQL query to fetch counts for different statuses within the specified date range for a specific coder
    $sql = "SELECT 
                (SELECT COUNT(Status) FROM data WHERE `Status`='ASSIGNED BY CODER' AND `coder`= '$user' AND `AssignCoder_date` >= '$fromdate 00:00:00' AND `AssignCoder_date` <= '$todate 23:59:59') as New,
                
                (SELECT COUNT(Status) FROM data WHERE `Status`='WIP' AND `coder`= '$user' AND `AssignCoder_date` >= '$fromdate 00:00:00' AND `AssignCoder_date` <= '$todate 23:59:59') as processing,
                (SELECT COUNT(Status) FROM data WHERE `Status`='APPROVED' AND `coder`= '$user' AND `AssignCoder_date` >= '$fromdate 00:00:00' AND `AssignCoder_date` <= '$todate 23:59:59') as approved,
                (SELECT COUNT(Status) FROM data WHERE `Status`='QC' AND `coder`= '$user' AND `AssignCoder_date` >= '$fromdate 00:00:00' AND `AssignCoder_date` <= '$todate 23:59:59') as qc";

    // Execute the query
    $run = mysqli_query($conn, $sql);

    if ($run) {
        // Fetch the result as an associative array
        $result = mysqli_fetch_assoc($run);
        // Output the result as JSON
        echo json_encode($result);
    } else {
        // Output an error message if the query fails
        echo "QUERY ERROR: " . mysqli_error($conn);
    }
}

 

// else{

// 	   $sql = " SELECT (SELECT COUNT(Status) FROM data WHERE `Status`='new') as New, (SELECT COUNT(Status) FROM data WHERE `Status`='completed') as completed,
//         (SELECT COUNT(Status) FROM data WHERE `Status`='processing') as processing,
//         (SELECT COUNT(Status) FROM data WHERE `Status`='approved') as approved,
//         (SELECT COUNT(Status) FROM data WHERE `Status`='pending') as pending,
//         (SELECT COUNT(Status) FROM data WHERE `Status`='reject') as reject,
//         (SELECT COUNT(Status) FROM data WHERE `Status`='qc') as qc,
//         (SELECT COUNT(Status) FROM data WHERE `Status`='qc') as assing";
          


//     $run = mysqli_query($conn, $sql);

//     if ($run) {
//         // Fetch the result as an associative array
//         $result = mysqli_fetch_assoc($run);
//         echo json_encode($result);
//     } else {
//         echo "QUERY ERROR: " . mysqli_error($conn);
//     }
// }

 
 
?>

 
 
