<?php 
 session_start();


 if (isset($_SESSION['role'])) {
 
     $role = $_SESSION['role'];


 
     if ($role == 'user' || $role == 'TeamLeader' || $role == 'superadmin' || $role == 'QA' || $role == 'ceo' || $role == 'QaTl' ) {  
 
        
     }
     else{
     	header("Location:session_des.php");
     }

 } else {
      header("Location:login.php");
     exit();
 }
?>