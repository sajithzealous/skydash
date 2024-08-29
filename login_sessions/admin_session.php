<?php 
 session_start();


 if (isset($_SESSION['role'])) {
 
     $role = $_SESSION['role'];


 
     if ($role == 'Admin' || $role == 'superadmin'|| $role=='ceo' || $role=='agency' || $role=='tm') {  
 
        
     }
     else{
     	header("Location:session_des.php");
     }

 } else {
            header("Location:login.php");

     exit();
 }