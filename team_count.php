<?php


   include 'logsession.php';
session_start(); // Start the session
 
$team = $_SESSION['username'];


 include('db/db-con.php');

if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];

 $sql = "SELECT 
                (SELECT COUNT(Status) FROM data WHERE `Status`='ASSIGNED BY TEAM' AND `Team`= '$team') as New,
                (SELECT COUNT(Status) FROM data WHERE `Status`='ASSIGNED BY CODER' AND `Team`= '$team'  ) as cdr,
                
                (SELECT COUNT(Status) FROM data WHERE `Status`='WIP' AND `Team`= '$team') as wip,
                (SELECT COUNT(Status) FROM data WHERE `Status`='ALLOTED TO QC' AND `Team`= '$team') as cmd,
                (SELECT COUNT(Status) FROM data WHERE `Status`='APPROVED' AND `Team`= '$team') as approved,
                (SELECT COUNT(Status) FROM data WHERE `Status`='QC' AND `Team`= '$team') as qc";




    $run = $conn->query($sql);

    if ($run) {
        $result = $run->fetch_assoc();
        echo json_encode($result);
    } else {
        echo "QUERY ERROR: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
