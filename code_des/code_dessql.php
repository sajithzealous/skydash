<?php
session_start();
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);
 include('../db/db-con.php');
include('../query_con.php');
$action=$_GET['action'];
if($action=='code_description'){ 
    code_description($conn);
}
if($action=='file_upload'){ 
    file_upload($conn);
}
if($action=='codedescriptiontable'){ 
    codedescriptiontable($connect);
}
if($action=='codedescriptiontable_checkbox'){ 
    codedescriptiontable_checkbox($conn);
}



function codedescriptiontable_checkbox ($conn){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['selectedRows']) && is_array($_POST['selectedRows'])) {
            $selectedRows = array_map('intval', $_POST['selectedRows']);
            foreach ($selectedRows as $index_id) {
                // Assuming you have a table named 'your_table_name'
                $query = "DELETE FROM Codedescription WHERE index_id = $index_id";
                $result = $conn->query($query);
            }
            $sucess_alert=1;
            echo json_encode($sucess_alert);
           // echo json_encode(['status' => 'success', 'message' => 'Rows deleted successfully']);
           // exit;
        } elseif (isset($_POST['rowIndex'])) {
            // Sanitize and validate input (this is a basic example, you may need to improve it)
            $rowIndex = intval($_POST['rowIndex']);
            $query = "DELETE FROM Codedescription WHERE index_id = (SELECT index_id FROM code_description LIMIT 1 OFFSET $rowIndex)";
            $result = $conn->query($query);
            $sucess_alert=2;
            echo json_encode($sucess_alert);
            //echo json_encode(['status' => 'success', 'message' => 'Row deleted successfully']);
            //exit;
        }
       
    }
   
    // If the request is not a valid POST request, send an error response
   // echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    //exit;
}


// !  code description datatable   function         
function codedescriptiontable($connect){
    $sth = $connect->prepare("SELECT * FROM `Codedescription`"); 
    $sth->execute();
    $row=$sth->rowCount();
    if($row>0){
        $stock_view_details = $sth->fetchAll(PDO::FETCH_ASSOC);
        //echo $result;
    }
    else{
        $stock_view_details=0;
    }
    echo json_encode($stock_view_details);
}
 //! coder description  submit function
function code_description($conn){
    if(isset($_POST["icd_code"])){
        $icd_code =$_POST["icd_code"] ;   
    }
    if(isset($_POST["desc"])){
       $desc =$_POST["desc"] ;   
     }
     if(isset($_POST["clinical_grp"])){
        $clinical_grp =$_POST["clinical_grp"] ;   
    }
    if(isset($_POST["clinical_des"])){
       $clinical_des =$_POST["clinical_des"] ;   
   }
    if(isset($_POST["diagnosis_type"])){
       $diagnosis_type =$_POST["diagnosis_type"] ;   
    }
    $sql = "select * from Codedescription where code='$icd_code'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
           // echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Email: " . $row["email"] . "<br>";
        }
        $sucess_alert=0;
        echo json_encode($sucess_alert);
    } else {
        $sql="INSERT INTO `Codedescription` ( `code`, `effective_date`, `short_desc`, `logn_desc`, `classification`) VALUES ( '$icd_code', '', '$desc', '$clinical_des', '$clinical_grp')";
        if($conn->query($sql) === TRUE) {   
            $sucess_alert=1;
            echo json_encode($sucess_alert);
       }
           
    }
          
      
   }
// ! code description  bulk upload function
function file_upload($conn){
      $file = $_FILES['csvFile']['tmp_name'];
      $handle = fopen($file, "r");
      $i=0;
      if($handle){
              while(($data = fgetcsv($handle, 10000, ",")) !== false)
              {    
                $i=$i+1;
                if($i>1){
                  //$id = $conn->real_escape_string($data[0]);
                    $code = $conn->real_escape_string($data[0]);
                    $date_effective =$conn->real_escape_string( $data[1]);
                    $shot_desc =$conn->real_escape_string( $data[2]);
                    $long_desc = $conn->real_escape_string($data[3]);
                    $classfication = $conn->real_escape_string($data[4]);
                      //echo "select * from Codedescription where code='$code'";         
                    $employee_query="select * from Codedescription where code='$code'"; 
                    $employees_query = $conn->query($employee_query);
                    $employees_count =mysqli_num_rows($employees_query);  
                
               
                if( $employees_count==0) {  
                    echo "INSERT INTO `Codedescription` ( `code`, `effective_date`, `short_desc`, `logn_desc`, `classification`) VALUES ( '$code', '$date_effective', '$shot_desc', '$long_desc', '$classfication')";    
                    $employees_insert_sql="INSERT INTO `Codedescription` ( `code`, `effective_date`, `short_desc`, `logn_desc`, `classification`) VALUES ( '$code', '$date_effective', '$shot_desc', '$long_desc', '$classfication')";
                    $employees_result = $conn->query($employees_insert_sql);  
                    $sucess_alert=1;
                    echo json_encode($sucess_alert);
                  } 

                  else{

                  }
      
                }            
                
             }
            
      }
}



?>