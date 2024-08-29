<?php
session_start();
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);
include('../db-con.php');
include('../query_con.php');
$action=$_GET['action'];
if($action=='register'){ 
    register($conn);
}
function register($conn){
    if(isset($_POST["username"])){
        $username =$_POST["username"] ;   
    }
    if(isset($_POST["password"])){
       $password =$_POST["password"] ;   
     }
     if(isset($_POST["userid"])){
        $userid =$_POST["userid"] ;   
    }
    if(isset($_POST["user_role"])){
       $user_role =$_POST["user_role"] ;   
   }
    if(isset($_POST["companyname"])){
       $companyname =$_POST["companyname"] ;   
    }
    if(isset($_POST["user_status"])){
       $user_status =$_POST["user_status"] ;   
    }
 
    $sql = "SELECT * FROM userlogin where user_id='$userid'";

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
           // echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Email: " . $row["email"] . "<br>";
        }
        $sucess_alert=0;
        echo json_encode($sucess_alert);
    } else {
        $sql="INSERT INTO `userlogin`( `user_name`, `user_password`, `user_id`, `user_role`, `user_company`, `user_team`, `user_status`, `created_date`, `Team`) VALUES ('$username','$password','$userid','$user_role','$companyname','','$user_status',current_timestamp(),'')";
        if($conn->query($sql) === TRUE) {   
            $sucess_alert=1;
            echo json_encode($sucess_alert);
       }
           
    }
          
      
   }
    


?>