<?php

include('db/db-con.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Check database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get today's date in the format 'Y-m-d'
    $todayDate = date('Y-m-d');

    // SQL query
$sql = "
SELECT 
    a.agency_name,
    COUNT(md.Id) AS data_count
FROM 
    `Agent` a
LEFT JOIN 
    `Main_Data` md ON a.agency_name = md.agency AND DATE(md.file_completed_date) = '$todayDate' AND `status`='APPROVED'
WHERE 
    a.count_status = 'Yes'
GROUP BY 
    a.agency_name;
";

    $result = $conn->query($sql);

    $total_count='';

    // Prepare the email body
   
    $emailBody = "<table border='1' cellpadding='10' class='display table'>";
    $emailBody .= "<tr><th>Agency Name</th>";
	$total_count = 0;
    // Fetching the data and constructing the table horizontally
    if ($result->num_rows > 0) {

        $agency_name_arr = [];
        $data_count_Arr = [];
        while($row = $result->fetch_assoc()) {
            
        	$agency_name_arr[]=$row['agency_name'];
        	$data_count_Arr[]=$row['data_count'];
        	// $total_count=$row['total_count'];
            // $emailBody .= "<td>{$row['agency_name']} ({$row['data_count']})</td>";
        }

        foreach ($agency_name_arr as $agency) {
        	 $emailBody .= "<td>".$agency."</td>";
        }
        $emailBody .= "</tr>";
        $emailBody .= "<tr><th>Data Count</th>";
        foreach ($data_count_Arr as $dataCount) {
        	 $emailBody .= "<td>".$dataCount."</td>";

        	 $total_count = $total_count + $dataCount;
        }
        $emailBody .= "</tr>";

    } else {
        $emailBody .= "<tr><td colspan='2'>No results found</td></tr>";
    }

    $emailBody .= "</table>";


 $emailHead = "<h2>Active Agencies and Approved Data Counts for $todayDate ($total_count)</h2>";

    // PHPMailer settings
    $mail->SMTPDebug = 2;                      // Enable verbose debug output
    $mail->isSMTP();                           // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';      // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                  // Enable SMTP authentication
    $mail->Username   = 'sdt@zealousservices.com'; // SMTP username
    $mail->Password   = 'Z3@l0u$2024';           // SMTP password
    $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                   // TCP port to connect to

    // Recipients
    $mail->setFrom('sdt@zealousservices.com', 'Mailer');
  $mail->addAddress('towfic@zealoushealthcare.com', 'Towfic');
   $mail->addAddress('rahul@zealousservices.com', 'Rahul');
    $mail->addAddress('business@zealoushealthcare.com', 'Bussiness Team');


    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Active Agencies and Data Approved Counts for Today';
    $mail->Body    = $emailHead.'<br>'.$emailBody;
    $mail->AltBody = 'This email contains the active agencies and their data counts for today.';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
