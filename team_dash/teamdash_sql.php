<?php
session_start();
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);
  include('../db/db-con.php');
include('../query_con.php');


$action=$_GET['action'];
if($action=='total_team_count'){ 
  total_team_count($connect);
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
if($action=='qc_file'){ 
  qc_file($connect);
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
if($action=='team_performance_filter'){ 
  team_performance_filter($conn);
}
//! team performance function 

function team_performance_filter($conn){
  if(isset($_POST["fromdate2"])){
    $fromdate =$_POST["fromdate2"] ;   
     }
   if(isset($_POST["todate2"])){
     $todate =$_POST["todate2"] ;   
   }
   $username=$_SESSION['username'];
   $empid=$_SESSION['empid'];
   $role=$_SESSION['role'];
   if($role='TeamLeader'){
   
    $sql = "SELECT
   `alloted_to_coder` as code,
   `alloted_team` as Team,
   sum(CASE WHEN   status = 'WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS WIP,
   sum(CASE WHEN  status = 'ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS Completed,
   sum(CASE WHEN  status = 'QA WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QC,
   sum(CASE WHEN  status = 'QC COMPLETED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QCCOM,
   sum(CASE WHEN  status = 'APPROVED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS APPROVED,
   sum(CASE WHEN  status = 'InProgression' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS prg,
   sum(CASE WHEN  status = 'PENDING' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS pd ,
   sum(CASE WHEN `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER')  AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END ) AS combined_status

 FROM
   Main_Data where `alloted_to_coder`!='NULL'  AND  `alloted_team`='$username' AND `team_emp_id`='$empid' 
   GROUP BY
             `alloted_to_coder`, `alloted_team`
         ";
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
  if(isset($_POST["fromdate2"])){
   $fromdate =$_POST["fromdate2"] ;   
    }
  if(isset($_POST["todate2"])){
    $todate =$_POST["todate2"] ;   
  }
  $username=$_SESSION['username'];
    $empid=$_SESSION['empid'];
  $role=$_SESSION['role'];
  if($role='TeamLeader'){
  
  $sql = "SELECT
  `alloted_to_coder` as code,
  `alloted_team` as Team,
  sum(CASE WHEN   status = 'WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS WIP,
  sum(CASE WHEN  status = 'ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS Completed,
  sum(CASE WHEN  status = 'QA WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QC,
  sum(CASE WHEN  status = 'QC COMPLETED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QCCOM,
  sum(CASE WHEN  status = 'APPROVED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS APPROVED,
  sum(CASE WHEN  status = 'InProgression' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS prg,
  sum(CASE WHEN  status = 'PENDING' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS pd ,
  sum(CASE WHEN `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER') AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END ) AS combined_status
FROM
  Main_Data where `alloted_to_coder`!='NULL'  AND  `alloted_team`='$username' AND `team_emp_id`='$empid' 
  GROUP BY
            `alloted_to_coder`, `alloted_team`
        ";
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
      if($role_name="TeamLeader"){
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
 
 
  function total_team_count($connect){
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
   if($role='TeamLeader'){   
    $sth = $connect->prepare("SELECT  
    sum(CASE WHEN alloted_team='$username' AND  team_emp_id= '$empid' AND (status = 'ASSIGNED TO TEAM' OR status = 'REASSIGNED TO TEAM') AND `AssignTeam_date` >= '$fromdate 00:00:00' AND `AssignTeam_date` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS assignedteam_count,
    sum(CASE WHEN alloted_team='$username' AND  team_emp_id= '$empid'  AND status = 'WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS wip_count,
    sum(CASE WHEN alloted_team='$username' AND  team_emp_id= '$empid' AND status = 'ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS completed_count,
    sum(CASE WHEN alloted_team='$username' AND  team_emp_id= '$empid' AND status = 'QC COMPLETED' AND `qc_person` IS NULL AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QC_count,
    sum(CASE WHEN alloted_team='$username' AND  team_emp_id= '$empid' AND status = 'QA WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS WIPQC_count,
    sum(CASE WHEN alloted_team='$username' AND  team_emp_id= '$empid' AND status = 'QC COMPLETED' AND `qc_person` IS NOT NULL AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS QCCOMPLETED_count,
    sum(CASE WHEN alloted_team='$username' AND  team_emp_id= '$empid' AND status = 'APPROVED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS APPROVED_count,
    sum(CASE WHEN alloted_team='$username' AND  team_emp_id= '$empid' AND (status = 'ASSIGNED TO CODER' OR status = 'REASSIGNED TO CODER') AND `AssignCoder_date` >= '$fromdate 00:00:00' AND `AssignCoder_date` <= '$todate 23:59:59' THEN 1 ELSE 0 END) AS assignedcoder_count
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
$empid=$_SESSION['empid'];
$role=$_SESSION['role'];
if($role='TeamLeader'){

$sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  alloted_team='$username' AND team_emp_id='$empid' AND `status` in ('ASSIGNED TO TEAM','REASSIGNED TO TEAM') AND `AssignTeam_date` >= '$fromdate 00:00:00' AND `AssignTeam_date` <= '$todate 23:59:59'");
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
if($role='TeamLeader'){
$sth = $connect->prepare("SELECT `alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  alloted_team='$username' AND team_emp_id='$empid' AND `status` in  ('ASSIGNED TO CODER','REASSIGNED TO CODER') AND `AssignCoder_date` >= '$fromdate 00:00:00' AND `AssignCoder_date` <= '$todate 23:59:59'");
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
function qc_file($connect){
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
if($role='TeamLeader'){
$sth = $connect->prepare("SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  alloted_team='$username' AND team_emp_id='$empid' AND `status`='ALLOTED TO QC' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
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
$role=$_SESSION['role'];
$empid=$_SESSION['empid'];
if($role='TeamLeader'){
      $sth = $connect->prepare("SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  alloted_team='$username' AND team_emp_id='$empid' AND `status`='QA WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
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
$role=$_SESSION['role'];
$empid=$_SESSION['empid'];
if($role='TeamLeader'){
      $sth = $connect->prepare("SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  alloted_team='$username' AND team_emp_id='$empid' AND `status`='WIP' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
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
$role=$_SESSION['role'];
$empid=$_SESSION['empid'];
// if($role='TeamLeader'){
     
 $sth = $connect->prepare("SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  alloted_team='$username' AND team_emp_id='$empid' AND qc_person IS NULL AND  `status`='QC COMPLETED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
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
$role=$_SESSION['role'];
$empid=$_SESSION['empid'];
if($role='TeamLeader'){
      $sth = $connect->prepare("SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`alloted_to_coder`,`qc_person`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  alloted_team='$username' AND team_emp_id='$empid' AND qc_person IS NOT NULL AND `status`='QC COMPLETED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
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
$role=$_SESSION['role'];
$empid=$_SESSION['empid'];
if($role='TeamLeader'){
      $sth = $connect->prepare("SELECT `Id`,`alloted_team`,`agency`,`patient_name`,`phone_number`,`mrn`,`status`,`qc_person`,`alloted_to_coder`,`insurance_type`,`assesment_type` FROM Main_Data WHERE  alloted_team='$username' AND  team_emp_id='$empid' AND `status`='APPROVED' AND `File_Status_Time` >= '$fromdate 00:00:00' AND `File_Status_Time` <= '$todate 23:59:59'");
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