<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  
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
<!-- custom js-->

 

  <script src="QA/js/qc_main.js"></script> 
<!-- custom js-->
<!-- custom css-->
<link rel="stylesheet" type="text/css" href="team_dash/css/team_dash.css" />
<!-- custom css-->
<!-- chart js-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- chart js-->
 

</head>
<body>

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
          <div class="row">
 
            

            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  
                   <!--  <input id="datepicker2" class="custom-daterangepicker">
                    <span> </span> -->

 
                <input id="ecommerce-dashboard-daterangepicker" class="custom-daterangepicker" ><span> </span>   

                   
              

                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-tale " >
                    <div class="card-body demo" id="qcfile" value="">
                      <h4>QC File Assign</h4><br>
                      <p class="fs-30 mb-1" id="file_count"> 0</p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  fileassign" >
                    <div class="card-body " id="qcwipfile">
                      <h4 style="color:white"> QC WIP </h4><br>
                      <p class="fs-30 mb-1" id="qc_wip_count" style="color:white"> 0</p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card allowed">
                    <div class="card-body " id="qcappfile">
                      <h4 style="color:white">APPROVED</h4><br>
                      <p class="fs-30 mb-1"id="qc_app_count" style="color:white"> 0</p>
                                          <!-- allot_qc -->
                      <p> </p>
                    </div>
                  </div>
                </div>
              <!--   <div class="col-md-6 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-light-danger">
                    <div class="card-body " id="wipqc_file">
                     <h4> WIP QC Files</h4><br>
                      <p class="fs-30 mb-1"id="qc_wip"> 0</p>
                      <p> </p>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>

  
            <div class="col-md-6 grid-margin transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card  wip" >
                    <div class="card-body" id="qccompleted">
                      <h4 style="color:white">QC COMPLETED</h4><br>
                      <p class="fs-30 mb-1" id="qc_completed_count" style="color:white">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-dark-blue">
                    <div class="card-body" id="directfile">
                        <h4>Direct Completed</h4><br>
                      <p class="fs-30 mb-1" id="directcount">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
            <!--   <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card qccomplete" >
                    <div class="card-body" id="qccmd_file">
                     <h4 style="color:white">QC Completed</h4><br>
                      <p class="fs-30 mb-1" id="qc_com" style="color:white">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card approval">
                    <div class="card-body" id="aprd_file">
                     <h4 style="color:white">Approved Files</h4><br>
                      <p class="fs-30 mb-1" id="approvedfile" style="color:white">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div> -->
            </div>

          </div>
           <!--    <div class="row">
               <div class="col-md-12">
                <input id="datepicker1" class="custom-daterangepicker float-right">&nbsp;&nbsp;&nbsp;
                <select name="coder_name" class="teams" id="coder_name">
                <option value="">All</option>            
                </select>  
                
                </div> 
                

              </div> -->
              <br>
              
          
         
<style type="text/css">
.custom-scroll1 {
    overflow-y: auto;  
    overflow-x: auto;  
    max-height: 500px;  
}

 #headers1 {
        position: sticky;
        top: 0;
        background-color: white;  
        z-index: 1000;  
    }
</style>



      <!--  <div class="col-md-12 ">
              <div class="card ">
                <div class="">
                  <div id="" class="  " data-ride="">
                    <div class="">
                      <div class="">
                        <div class="row">
                      
                          <div class="col-md-6 mt-3 border-right">
                            
                    <div class="">
                               <div class="">
                               <div class="">
                                <div class="">
                                  <div class="">
                                     <canvas id="myBarChart" style="margin-left:15px!important;margin-right:15px!important;margin-bottom:15px!important;"></canvas>
                                  </div>
                                </div>
                              </div>
                               <canvas id="myBarChart"></canvas> 
                              </div>
                              </div>  
                              </div>
                              <div class="col-md-12 mt-3">
                                <div class="card">
                               <div class="card-body">

                                 <p class="card-title mb-0 text-primary text-uppercase">Team Performance</p><br><br>
                                    <p class="card-title mb-0"> </p> 
                                    <div class="table-responsive custom-scroll1">

                                                
                                        <table class="table table-striped table-border table-hover">
                                        <thead id="headers1" class="bg-light">
                                            <tr>
                                            <center></center>
                                            <th class="pl-0  pb-2 border-bottom"style="text-align: center;">CODER</th>
                                            <th class="border-bottom pb-2">ASSIGN</th>
                                            <th class="border-bottom pb-2">QC WIP</th> 
                                            <th class="border-bottom pb-2">QC-COMPLETED</th>
                                            <th class="border-bottom pb-2">DIRECT-COMPLETED</th>
                                            <th class="border-bottom pb-2">APPROVED</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_data">
                                        
                                        </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                               
                             
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  
                    </div>
                  
                  </div>
                </div>
              </div>
            </div> -->
  
        













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
<style>
    

     #head2 {
        position: sticky;
        top: 0;
        background-color: white; /* Optional: Change background color as needed */
        z-index: 1500; /* Optional: Ensure the header appears above other elements */
    }

 .scroll {
    overflow-y: auto; /* This allows vertical scrolling if the content overflows the container vertically */
    overflow-x: auto; /* This is invalid CSS syntax; `overflow-x` property expects a value like `auto`, `hidden`, `scroll`, or `visible`, not a specific length like `500px` */
    max-height: 590px; /* This sets the maximum height of the container, beyond which it will start to scroll vertically */
}

 
</style>
  <!-- Edit modal -->
  <div class="modal fade bd-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header"><h3  class="sthd"> </h3>
          <!-- <i class="fa-sharp fa-solid fa-cloud-arrow-down fa-lg" id="showdown" title=" Download"style="cursor: pointer;"></i> -->
          <p class="card-title mb-0" id="exampleModalLabel"><span></p></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card " >
              <div class="card">
                <div class="card-body  "  >
                  <div class="table-responsive scroll" >
                    <table class="table table-striped table-hover " >
                      <thead class="thd   text-white" id="head2" style="background-color: #088394;">
                        <tr class="thd "  >
                          <th>AllotedTeam</th> 
                         
                          <th>Agency</th>
                          <th>PatientName</th>
                         
                           <th>Mrn</th>
                          <th >Status</th>

                          <th>Coder</th>
                          <th>InsuranceType</th>
                          <th>AssesmentType</th>
                          <th>AssesmentDate</th>
                          <th>Previwe</th>
                        </tr>  
                      </thead>
                      <tbody id="data-table" >
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>  

  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

 

<script>
 
 <?php include 'datepicker.js'; ?>


</script>
 
  <!-- <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>
 
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script> -->
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- <script src="js/dashboard.js"></script> -->
  <!-- <script src="js/Chart.roundedBarCharts.js"></script> -->
  <!-- End custom js for this page-->
</body>

</html>

