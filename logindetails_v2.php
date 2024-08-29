<!DOCTYPE html>
<html lang="en">

<head>

  
  <?php
  
   date_default_timezone_set('Asia/Kolkata');


  include('db/db-con.php');
  include  'include_file/link.php';

  
  ?>  
</head>
<body>

  <?php

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT Team,team_emp_id FROM coders GROUP BY Team,team_emp_id;
 ");
    $sth->execute();
    $team = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

 
 
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
 
 
      <div class="main-panel">
        <div class="content-wrapper">
 
                
       <div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <p class="card-title mb-0 text-primary text-uppercase">Total Login-Details</p><br><br>
            <button type="button" class="btn btn-primary btn-sm float-right y-3 searchbtn" id="logdata" style="margin-top: -67px;">Search</button>
            <h4 class="card-title">Filters</h4>
            <form class="form-sample">
                <div class="row">
                <div class="col-md-2">
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">From Date</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="from_date5"  title="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" style="font-size: 12px;"required>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">To Date</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" id="to_date5" title="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" style="font-size: 12px;"required>
        </div>
    </div>
</div>

                    <div class="col-md-2">
                        <div class="form-group row">
                            <!-- <label class="col-sm-4 col-form-label bold" style="margin-right: -40px;">Team</label> -->
                             <span style="color: red;">*</span>
                            <div class="col-sm-10">
                               <!--  <select class="form-control" name="team" id="team_select">
                                    <option value="">Select</option>
                                    <?php foreach ($team as $teams) { ?>
                                        <option value="<?= $teams['Team'] ?>"><?= $teams['Team'] ?></option>
                                    <?php } ?>
                                </select> -->
                                  <select class="form-control" name="team" id="team_select5" style="color:black;font-weight: 6000;">
    <option value="">All-Team</option>
     
    <?php foreach ($team as $teams) { ?>
        <option value="<?= $teams['Team'] . ' - ' . $teams['team_emp_id'] ?>"><?= $teams['Team'] . ' - ' . $teams['team_emp_id'] ?></option>
    <?php } ?>
</select>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group row">
                            <!-- <label class="col-sm-4 col-form-label">Coder</label> -->
                            <div class="col-sm-10">
                                <select class="form-control" id="coder_name5" name="coder" style="color:black;font-weight: 6000;">
                                    <option value="">Coder-Name </option>
                                </select>
                            </div>
                        </div>
                    </div>

 

 

  
                </div>
            </form>
        </div>
    </div>
</div>
        
          
          <?php  $randomNumber = rand(1000, 9999);  ?>
          <script src="report_files/js/efficiency_v2.js?<?php echo $randomNumber ?>" type="text/javascript"></script>  
  
    
          <br>
 

<!-- =========================================================================================Team Performance Start============================================== -->
<style type="text/css">
.custom-scroll1 {
    overflow-y: auto; /* This allows vertical scrolling if the content overflows the container vertically */
    overflow-x: auto; /* This is invalid CSS syntax; `overflow-x` property expects a value like `auto`, `hidden`, `scroll`, or `visible`, not a specific length like `500px` */
    max-height: 500px; /* This sets the maximum height of the container, beyond which it will start to scroll vertically */
}

 #headers1 {
        position: sticky;
        top: 0;
        background-color: white; /* Optional: Change background color as needed */
        z-index: 1000; /* Optional: Ensure the header appears above other elements */
    }

</style>
 <div class="row">

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">

                <div class="card-body  ">
                  
           <img id="download_excel" src="images/dd.png" title="Download" class="NEW float-right hover:bg-primary-600" style="width: 45px; margin-top: -8px; margin-left: 420px; ">
        
          <p class="card-title mb-0 text-primary text-uppercase">Total Login-Report</p><br><br>
          <div class="table-responsive custom-scroll1">
            <table class="table table table-striped   table-hover" width="110%" id="logindetaildata">
              <thead class="bg-primary text-white" id="headers1" >
                <tr>
                  <th id="head" class="pb-2 border-bottom" style="text-align: center;">Sno</th>
                  <th id="head" class="pl-0 pb-2 border-bottom" style="text-align: center;">CoderName</th>
                  <th id="head" class="pb-2 border-bottom" style="text-align: center;">Coder_EmpId</th>
                  <th id="head" class="pl-0 pb-2 border-bottom" style="text-align: center;">TeamName</th>
                   <th id="head" class="pl-0 pb-2 border-bottom" style="text-align: center;">Login Date</th>
                  <th id="head" class="border-bottom pb-2" style="text-align: center;">Total Login Hours</th>
               
                </tr>
              </thead>
              <tbody id="show_logintotaldata" style="text-align: center;">
               
              </tbody>
            </table>
          </div> 
                              
                               

                            </div> 
                          </div> 
                        </div> 
                      </div> 
                     

             <!-- =====================================================================================================Team Performance End==================================================== -->
 



    <script>
        document.getElementById('download_excel').addEventListener('click', function () {
            var headers = Array.from(document.querySelectorAll("#head")).slice(0).map(function (th) {
                return th.textContent;
            });
            var rows = Array.from(document.querySelectorAll("#show_logindata tr"));
            var data = [headers].concat(rows.map(function (row) {
                return Array.from(row.children).slice(0).map(function (cell) {
                    return cell.textContent;
                });
            }));

            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1"); // "Sheet1" is the sheet name
            XLSX.writeFile(wb, "Login-Report.xlsx");
        });

    </script>

 










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
 
 


 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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

