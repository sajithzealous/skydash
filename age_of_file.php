 
<?php


 include('db/db-con.php');

 

  if (isset($_GET['getdate'])) {
     
      $getdate = $_GET['getdate'];

 

header('Content-Type: application/json');

$sql = "SELECT 
        (SELECT COUNT(`status`)
               FROM Main_Data
           WHERE `status` = 'new'
  AND `log_time` >= DATE_SUB('$getdate', INTERVAL 1 DAY)
  AND `log_time` < '$getdate') AS oneday,

          (SELECT COUNT(`status`)
           FROM Main_Data 
           WHERE `status` = 'new' 
             AND `log_time` >= DATE_SUB('$getdate', INTERVAL 2 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 1 DAY)) AS twodays,
             
          (SELECT COUNT(`status`) 
           FROM Main_Data 
           WHERE `status` = 'new' 
             AND `log_time` >= DATE_SUB('$getdate', INTERVAL 3 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 2 DAY)) AS threedays,
             
          (SELECT COUNT(`status`)
           FROM Main_Data 
           WHERE `status` = 'new' 
             AND `log_time` >= DATE_SUB('$getdate', INTERVAL 4 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 3 DAY)) AS fourdays,
             
          (SELECT COUNT(`status`) 
           FROM Main_Data 
           WHERE `status` = 'new' 
             AND `log_time` >= DATE_SUB('$getdate', INTERVAL 5 DAY)
             AND `log_time` < DATE_SUB('$getdate', INTERVAL 4 DAY)) AS fivedays,

          (SELECT COUNT(`status`) 
           FROM Main_Data 
           WHERE `status` = 'new' 
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

 
 
