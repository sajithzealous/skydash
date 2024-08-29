<?php
session_start();
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);
 include('../db/db-con.php');
include('../query_con.php');
$action=$_GET['action'];
if($action=='total_coder_count'){ 
  total_coder_count($connect);
}
if($action=='total_assign_count'){ 
  total_assign_count($conn);
}
if($action=='total_assign_count_filter'){ 
  total_assign_count_filter($conn);
}
if($action=='assigned_to_team'){ 
  assigned_to_team($connect);
}
if($action=='assign_to_coder'){ 
  assign_to_coder($connect);
}
if($action=='InProgress'){ 
  InProgress($connect);
}
if($action=='Pending'){ 
  Pending($connect);
}
if($action=='wipqc_file'){ 
  wipqc_file($connect);
}
if($action=='wip_file'){ 
  wip_file($connect);
}
if($action=='cmd_file'){ 
  cmd_file($connect);
}
if($action=='qccmd_file'){ 
  qccmd_file($connect);
}
if($action=='aprd_file'){ 
  aprd_file($connect);
}
if($action=='team_chart'){ 
  team_chart($connect);
}
if($action=='coder_name'){ 
  coder_name($connect);
}
if($action=='team_performance'){ 
  team_performance($conn);
}
if($action=='team_performance_filer'){ 
  team_performance_filer($conn);
}


//! team performance function 

function team_performance_filer($conn){
  if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
    }
  if(isset($_POST["todate1"])){
    $todate =$_POST["todate1"] ;   
  }
  $username=$_SESSION['username'];
  $role=$_SESSION['role'];
  if($role='user'){
  $sql = " SELECT    `alloted_to_coder` as code,
  `alloted_team` as Team,
    sum(CASE WHEN alloted_to_coder='$username' AND status = 'WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS WIP,
    sum(CASE WHEN alloted_to_coder='$username' AND status = 'ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS Completed,
    sum(CASE WHEN alloted_to_coder='$username' AND status = 'QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QC,
    sum(CASE WHEN alloted_to_coder='$username' AND status = 'APPROVED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS APPROVED,
    sum(CASE WHEN alloted_to_coder='$username' AND  status = 'InProgression' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS prg,
   sum(CASE WHEN  alloted_to_coder='$username' AND status = 'PENDING' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS pd FROM
    Main_Data ";

$result = $conn->query($sql);
  $data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
}
// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
}
//! team performance function 

function team_performance($conn){
  if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
    }
  if(isset($_POST["todate1"])){
    $todate =$_POST["todate1"] ;   
  }
  $username=$_SESSION['username'];
  $role=$_SESSION['role'];
  if($role='user'){
   
          $sql = "SELECT    `alloted_to_coder` as code,
          `alloted_team` as Team,
            sum(CASE WHEN alloted_to_coder='$username' AND status = 'WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS WIP,
            sum(CASE WHEN alloted_to_coder='$username' AND status = 'ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS Completed,
            sum(CASE WHEN alloted_to_coder='$username' AND status = 'QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QC,
            sum(CASE WHEN alloted_to_coder='$username' AND status = 'APPROVED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS APPROVED,
            sum(CASE WHEN alloted_to_coder='$username' AND  status = 'InProgression' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS prg,
           sum(CASE WHEN  alloted_to_coder='$username' AND status = 'PENDING' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS pd FROM
            Main_Data ";

        $result = $conn->query($sql);
          $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
      }
// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
}
//! coder name binding dropdwon 
function coder_name($connect){
      $role_name=$_SESSION['role'];
      if($role_name="user"){
      $teamname=$_SESSION['username'];
      //echo "SELECT Coders FROM `coders` where Team='$teamname' and status='active'";
      $sth = $connect->prepare("SELECT Coders FROM `coders` where Team='$teamname' and status='active'");
      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);   
    } 
    }
// ! team chart function   
function team_chart($connect){
 // $coder_name_selectedValue="";
  // try {
      //  if(isset($_POST["coder_name_selectedValue"])){
      //   $coder_name_selectedValue =$_POST["coder_name_selectedValue"] ;   
      //  }
       $username=$_SESSION['username'];
       $role=$_SESSION['role'];
       if($role='user'){
    // if (empty($coder_name_selectedValue)) {
        // This block will be executed if $number is greater than 5
        //echo "SELECT count(Status) as status_count,Status FROM assign WHERE Status NOT IN ('NEW')   GROUP by Status";
        $stmt = $connect->prepare("SELECT COUNT(*) AS total_count, CASE WHEN `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER') THEN 'NEW'  ELSE `status` END AS combined_status FROM `Main_Data` WHERE `alloted_to_coder` = '$username' GROUP BY combined_status");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Return data as JSON
        echo json_encode($result);
    // } else {
    //     // This block will be executed if $number is not greater than 5
    //    // echo "SELECT count(Status) as status_count,Status FROM assign WHERE coder='$coder_name_selectedValue' and Status NOT IN ('NEW')   GROUP by STATUS";
    //   // echo "";
    //     $stmt = $connect->prepare("SELECT count(status) as status_count, status FROM Main_Data WHERE alloted_to_coder='$coder_name_selectedValue'   GROUP by status");
    //     $stmt->execute();
    //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    //     // Return data as JSON
    //     echo json_encode($result);
    // }
    }
   
}
//!  Assigned to Team count  function
    //  $fromdate=""; $todate="";
  function total_coder_count($connect){
    $fromdate=""; $todate="";
    if(isset($_POST["fromdate1"])){
        $fromdate =$_POST["fromdate1"] ;   
    }
    if(isset($_POST["todate1"])){
       $todate =$_POST["todate1"] ;   
   }
   $username=$_SESSION['username'];
   $empid=$_SESSION['empid'];
   $role=$_SESSION['role'];
   if($role='user'){

    $sth = $connect->prepare("SELECT  
    sum(CASE WHEN coder_emp_id='$empid' AND status = 'WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS wip_count,
    sum(CASE WHEN coder_emp_id='$empid' AND status = 'PENDING' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS pending,
    sum(CASE WHEN coder_emp_id='$empid' AND status = 'INPROGRESSION' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS inpro,
    sum(CASE WHEN coder_emp_id='$empid' AND status = 'ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS completed_count,
    sum(CASE WHEN coder_emp_id='$empid' AND status = 'QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QC_count,
    sum(CASE WHEN coder_emp_id='$empid' AND status = 'QA WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS WIPQC_count,
    sum(CASE WHEN coder_emp_id='$empid' AND status = 'QC COMPLETED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QCCOMPLETED_count,
    sum(CASE WHEN coder_emp_id='$empid' AND status = 'APPROVED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS APPROVED_count,
    sum(CASE WHEN coder_emp_id='$empid' AND (status = 'ASSIGNED TO CODER' OR status = 'REASSIGNED TO CODER') AND `AssignCoder_date` >= '$fromdate 00:00:00' AND `AssignCoder_date` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS assignedcoder_count
FROM
    Main_Data

  ");

      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);       
    } 

}
//! Total assigned count  function 
function total_assign_count($conn){
      //echo "SELECT count(*) as assign_count, COUNT(CASE WHEN `AssignTeam_date` >= '$fromdate 00:00:00' AND `AssignTeam_date` <= '$todate 23:59:59' THEN 1 ELSE NULL END) AS assign_count1 FROM assign'";
      $username=$_SESSION['username'];
      $role=$_SESSION['role'];
      if($role='user'){
      $query = "SELECT count(*) as assign_count FROM data where Team='$username'";
      $result = mysqli_query($conn, $query);
      
      if ($result) {
          $row = mysqli_fetch_assoc($result);
          echo $row['assign_count'];
      } else {
          echo "0";
      }
    }
   
}
//! Total assigned count  function  filtering
function total_assign_count_filter($conn){
  $fromdate=""; $todate="";
  if(isset($_POST["fromdate1"])){
      $fromdate =$_POST["fromdate1"] ;   
  }
  if(isset($_POST["todate1"])){
     $todate =$_POST["todate1"] ;   
 }
  //echo "SELECT count(*) as assign_count, COUNT(CASE WHEN `AssignTeam_date` >= '$fromdate 00:00:00' AND `AssignTeam_date` <= '$todate 23:59:59' THEN 1 ELSE NULL END) AS assign_count1 FROM assign'";
  $username=$_SESSION['username'];
  $role=$_SESSION['role'];
  if($role='user'){
  $query = "SELECT count(*) as assign_count FROM data where Team='$username' and `AssignTeam_date` >= '$fromdate 00:00:00' AND `AssignTeam_date` <= '$todate 23:59:59'";
  $result = mysqli_query($conn, $query);
  
  if ($result) {
      $row = mysqli_fetch_assoc($result);
      echo $row['assign_count'];
  } else {
      echo "0";
  }
}
 
}

//! Assigned to Team data  model view function
function assigned_to_team($connect){
  $fromdate=""; $todate="";
if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
}
if(isset($_POST["todate1"])){
   $todate =$_POST["todate1"] ;   
}
$username=$_SESSION['username'];
$role=$_SESSION['role'];
if($role='user'){

$sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  alloted_to_coder='$username' and `status`='REASSIGNED TO CODER' AND `AssignTeam_date` >= '$fromdate 00:00:00' AND `AssignTeam_date` <= '$todate 23:59:59'");
      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);     
    }   

}

//! Assigned to coder data  model view function
function assign_to_coder($connect){
  $fromdate=""; $todate="";
if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
}
if(isset($_POST["todate1"])){
   $todate =$_POST["todate1"] ;   
}
$username=$_SESSION['username'];
$empid=$_SESSION['empid'];
$role=$_SESSION['role'];
if($role='user'){
  $sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  coder_emp_id='$empid' and `status` in  ('ASSIGNED TO CODER','REASSIGNED TO CODER') AND `AssignCoder_date` >= '$fromdate 00:00:00' AND `AssignCoder_date` <= '$todate 23:59:59'");
  $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);    
    }    

}

//! Alloted To QC  data  model view function
function InProgress($connect){
  $fromdate=""; $todate="";
if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
}
if(isset($_POST["todate1"])){
   $todate =$_POST["todate1"] ;   
}
$username=$_SESSION['username'];
$empid=$_SESSION['empid'];
$role=$_SESSION['role'];
if($role='user'){
$sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  coder_emp_id='$empid' and `status`='INPROGRESSION' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);   
    }     

}


//! Alloted To Pending  data  model view function
function Pending($connect){
  $fromdate=""; $todate="";
if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
}
if(isset($_POST["todate1"])){
   $todate =$_POST["todate1"] ;   
}
$username=$_SESSION['username'];
$empid=$_SESSION['empid'];
$role=$_SESSION['role'];
if($role='user'){
$sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  coder_emp_id='$empid' and `status`='PENDING' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);   
    }     

}


//! ! WIP QC Files  data  model view function
function wipqc_file($connect){
  $fromdate=""; $todate="";
if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
}
if(isset($_POST["todate1"])){
   $todate =$_POST["todate1"] ;   
}
$username=$_SESSION['username'];
$empid=$_SESSION['empid'];
$role=$_SESSION['role'];
if($role='user'){
      $sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  coder_emp_id='$empid' and `status`='QA WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);  
    }      

}
//! WIP Files  data  model view function
function wip_file($connect){
  $fromdate=""; $todate="";
if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
}
if(isset($_POST["todate1"])){
   $todate =$_POST["todate1"] ;   
}
$username=$_SESSION['username'];
$empid=$_SESSION['empid'];
$role=$_SESSION['role'];
if($role='user'){
      $sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  coder_emp_id='$empid' and `status`='WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);      
    } 

}

//! Completed Files  data  model view function
function cmd_file($connect){
  //echo "suucess";
  //echo "SELECT `Team`,`Agency`,`Patient_Name`,`Phone_Number`,`Mrn`,`Status`,`Insurance_Type`FROM assign WHERE Team='$username' and `Status`='COMPLETED' AND `AssignTeam_date` >= '$fromdate 00:00:00' AND `AssignTeam_date` <= '$todate 23:59:59'";
$fromdate=""; $todate="";
if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
}
if(isset($_POST["todate1"])){
   $todate =$_POST["todate1"] ;   
}
$username=$_SESSION['username'];
$empid=$_SESSION['empid'];
$role=$_SESSION['role'];
// if($role='user'){
     
      $sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  coder_emp_id='$empid' and `status`='ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);  
    // }   
    // else{
    //   echo"dfdsf";
    // }   

}
//! QC Completed Files  data  model view function
function qccmd_file($connect){
  $fromdate=""; $todate="";
if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
}
if(isset($_POST["todate1"])){
   $todate =$_POST["todate1"] ;   
}
$username=$_SESSION['username'];
$empid=$_SESSION['empid'];
$role=$_SESSION['role'];
if($role='user'){
      $sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  coder_emp_id='$empid' and `status`='QC COMPLETED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);   
}
}   

    //! APPROVEL  Files  data  model view function
function aprd_file($connect){
  $fromdate=""; $todate="";
if(isset($_POST["fromdate1"])){
    $fromdate =$_POST["fromdate1"] ;   
}
if(isset($_POST["todate1"])){
   $todate =$_POST["todate1"] ;   
}
$username=$_SESSION['username'];
$empid=$_SESSION['empid'];
$role=$_SESSION['role'];
if($role='user'){
      $sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  coder_emp_id='$empid' and `status`='APPROVED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
      $sth->execute();
      $row=$sth->rowCount();
      if($row>0){
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           //echo $result;
      }
      else{
          $result=0;
      }
      echo json_encode($result);   

    }   
  }
    

?>