<?php 
 session_start();


 if (isset($_SESSION['role'])) {
 
     $role = $_SESSION['role'];


 
     if ($role == 'TeamLeader' || $role == 'superadmin' || $role == 'ceo') {  
 
        
     }
     else{
     	header("Location:session_des.php");
     }

 } else {
    header("Location:login.php");
     exit();
 }