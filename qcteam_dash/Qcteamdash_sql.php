<?php
session_start();
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);
 include('../db/db-con.php');
 
$action=$_GET['action'];

   $username=$_SESSION['username'];
    $empid=$_SESSION['empid'];
   $role=$_SESSION['role'];
 

if ($action == 'files_count') {
    
       if (isset($_GET["fromdate"]) && isset($_GET["todate"])) {
        $fromdate = $_GET["fromdate"];
        $todate = $_GET["todate"];

       

        try {
            $query = "SELECT  
                SUM(CASE 
                        WHEN qc_team='$username' 
                            AND qc_team_emp_id='$empid' 
                            AND qc_person_emp_id IS NULL 
                            AND status = 'ALLOTED TO QC' 
                            AND File_Status_Time >= '$fromdate 00:00:00' 
                            AND File_Status_Time <= '$todate 23:59:59' 
                            THEN 1 
                        ELSE 0 
                    END) AS alloted_qc,
                
                SUM(CASE 
                        WHEN qc_team='$username' 
                            AND qc_team_emp_id='$empid' 
                            AND (status = 'ASSIGNED TO QC CODER' OR status = 'REASSIGNED TO QC CODER') 
                            AND File_Status_Time >= '$fromdate 00:00:00' 
                            AND File_Status_Time <= '$todate 23:59:59' 
                            THEN 1 
                        ELSE 0 
                    END) AS qc_allot_coder,
                
                SUM(CASE 
                        WHEN qc_team='$username' 
                            AND qc_team_emp_id='$empid' 
                            AND status = 'QC COMPLETED' 
                            AND qc_person IS NULL 
                            AND File_Status_Time >= '$fromdate 00:00:00' 
                            AND File_Status_Time <= '$todate 23:59:59' 
                            THEN 1 
                        ELSE 0 
                    END) AS direct_completed,
                
                SUM(CASE 
                        WHEN qc_team='$username' 
                            AND qc_team_emp_id='$empid' 
                            AND status = 'QA WIP' 
                            AND File_Status_Time >= '$fromdate 00:00:00' 
                            AND File_Status_Time <= '$todate 23:59:59' 
                            THEN 1 
                        ELSE 0 
                    END) AS WIPQC_count,
                
                SUM(CASE 
                        WHEN qc_team='$username' 
                            AND qc_team_emp_id='$empid' 
                            AND status = 'QC COMPLETED' 
                            AND qc_person IS NOT NULL 
                            AND File_Status_Time >= '$fromdate 00:00:00' 
                            AND File_Status_Time <= '$todate 23:59:59' 
                            THEN 1 
                        ELSE 0 
                    END) AS QCCOMPLETED_count,
                
                SUM(CASE 
                        WHEN qc_team='$username' 
                            AND qc_team_emp_id='$empid' 
                            AND status = 'APPROVED' 
                            AND File_Status_Time >= '$fromdate 00:00:00' 
                            AND File_Status_Time <= '$todate 23:59:59' 
                            THEN 1 
                        ELSE 0 
                    END) AS APPROVED_count
                FROM
                    Main_Data
                WHERE
                    qc_team='$username' 
                    AND qc_team_emp_id='$empid' 
                    AND File_Status_Time BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'";

            $sth = $connect->prepare($query);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (PDOException $e) {
            echo json_encode(array('error' => $e->getMessage()));
        }
    } else {
        echo json_encode(array('error' => 'Invalid date range.'));
    }
}

 