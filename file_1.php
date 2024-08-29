 
 <?php
 include('db/db-con.php');
 

if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
     
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
 
$sql = "SELECT `Team`,`Agency`,`Patient_Name`,`Phone_Number`,`Mrn`,`Status`,`Insurance_Type`FROM data WHERE `Status`='new' AND `Uploaded_Date` >= '$fromdate 00:00:00' AND `Uploaded_Date` <= '$todate 23:59:59'";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();

 
}
 
 

 
 
?>

 
 
