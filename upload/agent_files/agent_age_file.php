 
 <?php
 session_start();

$servername = "localhost";
$username   = "zhcadmin";
$password   = "d0m!n$24";
$dbname     = "HCLI";
$port       = "22022";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
   // die("Connection failed: " . $conn->connect_error);
} else {
   // echo "Connected successfully";
} 

 $agency= $_SESSION['username'];



// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
 
 

 

  if (isset($_GET['getdate'])) {
     
      $getdate = $_GET['getdate'];

 

header('Content-Type: application/json');

$sql = "SELECT 
        (SELECT COUNT(`Status`)
               FROM Main_Data
           WHERE `Status` = 'new' AND `agency` = '$agency'
  AND `log_time` >= DATE_SUB('$getdate', INTERVAL 1 DAY)
  AND `log_time` < '$getdate') AS oneday,

          (SELECT COUNT(`Status`)
           FROM Main_Data 
           WHERE `Status` = 'new' AND `agency` = '$agency'
             AND `log_time` >= DATE_SUB('$getdate', INTERVAL 2 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 1 DAY)) AS twodays,
             
          (SELECT COUNT(`Status`) 
           FROM Main_Data 
           WHERE `Status` = 'new' AND `agency` = '$agency'
             AND `log_time` >= DATE_SUB('$getdate', INTERVAL 3 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 2 DAY)) AS threedays,
             
          (SELECT COUNT(`Status`)
           FROM Main_Data 
           WHERE `Status` = 'new' AND `agency` = '$agency'
             AND `log_time` >= DATE_SUB('$getdate', INTERVAL 4 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 3 DAY)) AS fourdays,
             
          (SELECT COUNT(`Status`) 
           FROM Main_Data 
           WHERE `Status` = 'new' AND `agency` = '$agency'
             AND `log_time` >= DATE_SUB('$getdate', INTERVAL 5 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 4 DAY)) AS fivedays,

          (SELECT COUNT(`Status`) 
           FROM Main_Data 
           WHERE `Status` = 'new' AND `agency` = '$agency'
             AND `log_time` <= DATE_SUB('$getdate', INTERVAL 5 DAY)
             ) AS sixdays";

$run = mysqli_query($conn, $sql);

if ($run) {
    $result = mysqli_fetch_assoc($run);
    echo json_encode($result);
} else {
    echo json_encode(array('error' => "QUERY ERROR: " . mysqli_error($conn)));
}



}

 
 
?>

 
 
