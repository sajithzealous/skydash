<?php 
 session_start();


 if (isset($_SESSION['role'])) {
 
     $role = $_SESSION['role'];


 
     if ($role == 'QA'|| $role == 'QaTl' || $role == 'superadmin' || $role == 'TeamLeader') {  
 
        
     }
     else{
     	header("Location:session_des.php");
     }

 } else {
            header("Location:login.php");

     exit();
 }