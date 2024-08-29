<!DOCTYPE html>
<html lang="en">

<head>

  
  <?php


   include 'login_sessions/admin_session.php';
   date_default_timezone_set('America/New_York');


     include('db/db-con.php');
  include  'include_file/link.php';

  
  ?>  

<!-- Include moment.js from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

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

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT file_status FROM `filestatus` WHERE `status`='active'");
    $sth->execute();
    $status = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT agency_name FROM `Agent` WHERE `agency_status`='active'  GROUP BY `agency_name`");
    $sth->execute();
    $agency_name = $sth->fetchAll(PDO::FETCH_ASSOC);
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
            <p class="card-title mb-0 text-primary text-uppercase">Agency-Report</p><br><br>
            <button type="button" class="btn btn-primary btn-sm float-right y-3 searchbtn" id="search_btn2" style="margin-top: -67px;">Search</button>
            <h4 class="card-title">Filters</h4>
            <form class="form-sample">
                <div class="row">
                <div class="col-md-3">
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">From Date</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="from_date1"  title="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" style="font-size: 12px;"required>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">To Date</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" id="to_date1" title="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" style="font-size: 12px;"required>
        </div>
    </div>
</div>
 &nbsp&nbsp
<!-- ========================================================================================================== dropdown code start here ============================================ -->
<div class="col-md-3">
    <div class="form-group row">
        <div class="col-sm-10">
            <div class="dropdown" style="position:relative;">
                <button class="btn dropdown-toggle" type="button" id="agencyDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 15px; border: 1px solid black;">
                    <strong>Select Agency</strong>
                </button>
                <div class="dropdown-menu" aria-labelledby="agencyDropdown" style="max-height: 200px; overflow-y: auto; width: 300px;">
                    <?php foreach ($agency_name as $row) { ?>
                        <div class="dropdown-item" style="padding: 10px; display: flex; align-items: center; width:200px">
                            <input type="checkbox"  name="selectedAgencies[]" id="<?= htmlspecialchars($row['agency_name']) ?>" value="<?= htmlspecialchars($row['agency_name']) ?>" style="margin-right: 10px;">
                            <label class="text-uppercase text-black"for="<?= htmlspecialchars($row['agency_name']) ?>"><?= htmlspecialchars($row['agency_name']) ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Additional CSS for better styling -->
<!-- <style>
    .dropdown-menu {
        width: 100%; /* Adjust width as needed */
        background: linear-gradient(135deg, #ffcc33 0%, #ff6699 100%);
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 5px;
        margin: 5px;
        padding: 10px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .dropdown-item:hover {
        background-color: rgba(255, 255, 251, 1);
        transform: translateY(-2px);
    }

    .dropdown-item input[type="checkbox"] {
        margin-right: 10px;
    }

    .dropdown-item label {
        margin: 0;
    }

    .dropdown-toggle {
        width: 180px;
        height: 50px;
        background-color:#0a156b;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        transition: background-color 0.3s;
    }

    .dropdown-toggle:hover {
        background-color: goldenrod;
    }
</style> -->

<!-- Optional: Additional JavaScript to keep dropdown open when interacting with checkboxes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
            menu.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    });
</script>

<style >
    
.dropdown-menu{
    z-index: 18000;
}

</style>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- ========================================================================================================== dropdown code END here ============================================ -->
 
 

 



                    <div class="col-md-2">
                        <div class="form-group row">
                            <!-- <label class="col-sm-4 col-form-label bold" style="margin-right: -40px;">Team</label> -->
                         <!--     <span style="color: red;">*</span>
                            <div class="col-sm-10"> -->
                               <!--  <select class="form-control" name="team" id="team_select">
                                    <option value="">Select</option>
                                    <?php foreach ($team as $teams) { ?>
                                        <option value="<?= $teams['Team'] ?>"><?= $teams['Team'] ?></option>
                                    <?php } ?>
                                </select> -->
           <!--                        <select class="form-control" name="team" id="team_select5" style="color:black;font-weight: 6000;">
    <option value="">All-Team</option>
     
    <?php foreach ($team as $teams) { ?>
        <option value="<?= $teams['Team'] . ' - ' . $teams['team_emp_id'] ?>"><?= $teams['Team'] . ' - ' . $teams['team_emp_id'] ?></option>
    <?php } ?>
</select>  
                            </div> -->
                        </div>
                    </div>
         <!--            <div class="col-md-2">
                        <div class="form-group row">
                             <label class="col-sm-4 col-form-label">Coder</label> -->
                           <!--  <div class="col-sm-10">
                                <select class="form-control" id="coder_name5" name="coder" style="color:black;font-weight: 6000;">
                                    <option value="">Coder-Name </option>
                                </select>
                            </div>
                        </div>
                    </div> 

       -->
 

             <!--         <div class="col-md-2">
                        <div class="form-group row">
                          
                            <div class="col-sm-10">
<select class="form-control" name="team" id="status5" style="color:black;font-weight: 6000;">
    <option value="">Status</option>
    <?php foreach ($status as $status) { ?>
        <option value="<?= $status['file_status']  ?>"><?= $status['file_status'] ?></option>
    <?php } ?>
</select>  
                            </div>
                        </div>
                    </div> -->

  
                </div>
            </form>
        </div>
    </div>
</div>
        
          
          <?php  $randomNumber = rand(1000, 9999);  ?>
          <script src="report_files/js/efficiency.js?<?php echo $randomNumber ?>" type="text/javascript"></script>  
  
    
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
        
          <p class="card-title mb-0 text-primary text-uppercase">Agency-Report</p><br><br>
          <div class="table-responsive custom-scroll1">
            <table class="table table table-striped   table-hover" width="110%">
              <thead class="bg-primary text-white" id="headers1" >
                <tr>
                  <th id="head" class="pb-2 border-bottom" style="text-align: center;">Sno</th>
                  <th id="head" class="pb-2 border-bottom" style="text-align: center;">AgencyName</th>
                  <th id="head" class="pl-0 pb-2 border-bottom" style="text-align: center;">TotalFiles</th>
                   <th id="head" class="pl-0 pb-2 border-bottom" style="text-align: center;">Not Assign
                   </th>
                   <th id="head" class="pl-0 pb-2 border-bottom" style="text-align: center;">Assign To Team</th>
                  <th id="head" class="border-bottom pb-2" style="text-align: center;">Assigned To Coder</th>
                  <th id="head" class="border-bottom pb-2" style="text-align: center;">Wip</th>
                  <th id="head" class="border-bottom pb-2" style="text-align: center;">ReAssigned</th>
                  <th id="head" class="border-bottom pb-2" style="text-align: center;">Pending</th>
                  <th id="head" class="border-bottom pb-2" style="text-align: center;">QCWIP</th>
                  <th id="head" class="border-bottom pb-2" style="text-align: center;"> Alloted To QC</th>
                  <th id="head" class="border-bottom pb-2" style="text-align: center;">QCCompleted</th>
               
                  <th id="head" class="border-bottom pb-2" style="text-align: center;">Completed</th>
                   
                </tr>
              </thead>
              <tbody id="show_data1" style="text-align: center;">
               
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
            var rows = Array.from(document.querySelectorAll("#show_data1 tr"));
            var data = [headers].concat(rows.map(function (row) {
                return Array.from(row.children).slice(0).map(function (cell) {
                    return cell.textContent;
                });
            }));

            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1"); // "Sheet1" is the sheet name
            XLSX.writeFile(wb, "Agency-Report.xlsx");
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

