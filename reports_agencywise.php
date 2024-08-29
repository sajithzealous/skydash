<!DOCTYPE html>
<html lang="en">

<head>
 
<?php
 


 
   date_default_timezone_set('America/New_York');



 // include 'login_sessions/client_session.php';

   include('db/db-con.php');
  include  'include_file/link.php';

  ?>  
 
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Include moment.js from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

 
  

 

</head>
<body>
  <?php
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT file_status FROM `filestatus` WHERE `status`='active'");
    $sth->execute();
    $status = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

date_default_timezone_set('America/New_York');

// Get the current timestamp
$currentTimestamp = time();

// Convert the timestamp to the desired date format
$estDate = date('Y-m-d', $currentTimestamp);
?>
  <div class="container-scroller">
    <?php
    include 'include_file/profile.php';
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
     <?php
      include 'include_file/sidebar.php'; // Use a relative path to include the file
      ?>
 
 <?php
include 'style.php';
 ?>
 
 <style type="text/css"> .custom-scroll {
    overflow-y: auto; /* This allows vertical scrolling if the content overflows the container vertically */
    overflow-x: auto; /* This is invalid CSS syntax; `overflow-x` property expects a value like `auto`, `hidden`, `scroll`, or `visible`, not a specific length like `500px` */
    max-height: 500px; /* This sets the maximum height of the container, beyond which it will start to scroll vertically */
}

 #head {
        position: sticky;
        top: 0;
        background-color: white; /* Optional: Change background color as needed */
        z-index: 1000; /* Optional: Ensure the header appears above other elements */
    }
</style>
 
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
 
            

            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  
                 
                 </div>
                </div>
              </div>
            </div>
          </div>
<!-- <div class="row">
     <div class="col-lg-2">
       <select class="form-control" name="team" id="id_status" style="border-color: red;">
    <option value="">Select Status</option>
     
    <option value="APPROVED">COMPLETED</option>
</select>

    </div>  
    <div class="col-lg-">
        <input id="datepicker2" class="custom-daterangepicker form-control" placeholder="Select Date">
    </div>
    <div class="col-lg-6">
        <button type="button" class="btn btn-primary btn-sm float-left" id="searchbtn">Search</button>
    </div>  
</div> -->
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <p class="card-title mb-0 text-primary text-uppercase"> Report</p><br><br>
            <button type="button" class="btn btn-primary btn-sm float-right y-3 work_log" id="client_id" style="margin-top: -67px;">Search</button>
            <h4 class="card-title">Filters</h4>
            <form class="form-sample">
                <div class="row">
                <div class="col-md-3">
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">From Date</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="from_date"  title="<?php echo $estDate; ?>" value="<?php echo $estDate; ?>" style="font-size: 14px;"required>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">To Date</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" id="to_date" title="<?php echo $estDate; ?>" value="<?php echo $estDate; ?>" style="font-size: 14px;"required>
        </div>
    </div>
</div>

                    <div class="col-md-2">
                        <div class="form-group row">
                            <!-- <label class="col-sm-4 col-form-label bold" style="margin-right: -40px;">Team</label> -->
                          
                            <div class="col-sm-10 ml-3">
                               <input type="text" class="form-control" name="mrn" value="" id="mrn_id" placeholder="Mrn Search">
                            </div>
                        </div>
                    </div>
                      <div class="col-md-2">
                        <div class="form-group row">
                            <!-- <label class="col-sm-4 col-form-label">Coder</label> -->
                            <div class="col-sm-10">
                                   <input type="text" class="form-control" name="Patient_name" value="" id="patient_id" placeholder="Patient-Name Search">
                            </div>
                        </div>
                    </div>

                     <div class="col-md-2">
    <div class="form-group row">
        <div class="col-sm-10">
         <select class="form-control" name="statsu" id="stds_id" style="color:black;">
            <option value="">Select-Status</option>
            <option value="APPROVED">Completed</option>
            <option value="WIP">WIP</option> 
           
        </select>   
    </div>
</div>
</div>
 
                </div>
            </form>
        </div>
    </div>
</div>




   <br> 


 <div class="row">
 <div class="col-lg-12 grid-margin stretch-card">
              <div class="card position-relative">

                <div class="card-body ">
                  
           <img id="download_excel" src="images/dd.png" title="Download" class="NEW float-right hover:bg-primary-600" style="width: 45px; margin-top: -8px; margin-left: 420px; ">
        
          <p class="card-title mb-0 text-primary text-uppercase"></p><br><br>
          <div class="table-responsive custom-scroll">
  <table class="display expandable-table table table-hover" id="DataTable" width="110%">
    <thead class="bg-light" id="head">
        <tr id="tr-icon">
            <th class="border-bottom pb-2" style="text-align: center;">Sno</th>
            <th class="border-bottom pb-2" style="text-align: center;">Agency</th>
            <th class="border-bottom pb-2" style="text-align: center;">Patient Name</th>
            <th class="border-bottom pb-2" style="text-align: center;">Mrn</th>
            <th class="border-bottom pb-2" style="text-align: center;">Insurance Type</th>
            <th class="border-bottom pb-2" style="text-align: center;">Assessment Type</th>
            <th class="border-bottom pb-2" style="text-align: center;">Assessment Date</th>
            <th class="border-bottom pb-2" style="text-align: center;">Status</th>
            <th class="border-bottom pb-2" style="text-align: center;">Pending Reason</th>
            <th class="border-bottom pb-2" style="text-align: center;">Pending Comment</th>
           <!--  <th class="border-bottom pb-2" style="text-align: center;">Pre-Audit</th>
            <th class="border-bottom pb-2" style="text-align: center;">Post-Audit</th>
            <th class="border-bottom pb-2" style="text-align: center;">Difference</th> -->
            <th class="border-bottom pb-2" style="text-align: center;">Preview</th>
            <th class="border-bottom pb-2" style="text-align: center;">Feedback</th>
        </tr>
    </thead>
    <tbody id="show_data" style="text-align: center;">
        <!-- Your table data will be populated here -->
    </tbody>
</table>













            </div>

    
             
          </div>
          <div class="row">
            <div class="col-md-12">


<!-- <input id="datepicker1" class="custom-daterangepicker float-right"> -->
            </div>
             

          </div>
          <br>
          <?php $rand =rand(0000,9999); ?>
          
  
               <script src="upload/agent_files/reports_agencywise.js?<?php echo $rand ?>" type="text/javascript"></script>  
 
 
           
             

          </div>
 
 
          </div> 
                              
                               

                            </div> 
                          </div> 
                        </div> 
                      </div> 


 
  
<!-- this two div is main div any code put above div  -->
          </div>
               
        </div>
<!-- END  this two div is main div any code put above div  -->



      
       
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
<!-- ------------------------------------------------------------- Model Design----------------------------------------------- -->
 
  <!-- Edit modal -->
 


 
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
 

 

 
 
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>
 
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->

 

</body>

</html>

