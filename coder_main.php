<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" type="text/css" href="coder_dash/css/coder_dash.css" />
  <?php

   include 'login_sessions/user_session.php';
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
<script src="coder_dash/js/coder_dash.js"></script>
<!-- custom js-->
<!-- custom css-->


<!-- custom css-->
<!-- chart js-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

 
                <input id="ecommerce-dashboard-daterangepicker" class="custom-daterangepicker float-right" ><span> </span>   

                   
              

                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6 grid-margin transparent">
              <div class="row">
              <!-- 
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-tale ">
                    <div class="card-body demo" id="assign_to_team" value="">
                      <h4> ReAssigned  To Coder</h4><br>
                      <p class="fs-30 mb-1" id="assigned_team"> 0</p>
                      <p> </p>
                    </div>
                  </div>
                </div> -->
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  fileassign" >
                    <div class="card-body " id="assign_coder">
                      <h4 style="color:white"> New </h4><br>
                      <p class="fs-30 mb-1" id="assigned_coder" style="color:white"> 0</p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit"z>
                  <div class="card  wip" >
                    <div class="card-body" id="wip_file">
                      <h4 style="color:white">WIP</h4><br>
                      <p class="fs-30 mb-1" id="processing" style="color:white">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card allowed">
                      <!-- this tag -- qc_file -- old name -->
                    <div class="card-body " id="cmd_file">  
                      <h4 style="color:white">Alloted To QC</h4><br>
                      <p class="fs-30 mb-1"id="completed" style="color:white"> 0</p>
                      <!--this tag -- allot_qc --  old name -->
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card wipqcfile">
                    <div class="card-body " id="wipqc_file">
                     <h4> QC WIP </h4><br>
                      <p class="fs-30 mb-1"id="qc_wip"> 0</p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

  
            <div class="col-md-6 grid-margin transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
              <div class="row">
             
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-dark-blue">
                    <div class="card-body" id="InProgress">
                        <h4>InProgress</h4><br> 
                      <p class="fs-30 mb-1" id="inp">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent" style="height:120px;" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card "style="background-color:#A04F4F">
                    <div class="card-body" id="Pending">
                     <h4 style="color:white">Pending</h4><br> 
                      <p class="fs-30 mb-1" id="pnd" style="color:white;">0 </p>
                      <p > </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card qccomplete" >
                    <div class="card-body" id="qccmd_file">
                     <h4 style="color:white">QC Completed</h4><br>
                      <p class="fs-30 mb-1" id="qc_com" style="color:white">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                  <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                    <div class="card  approval" style="background-color:#A04F4F">
                    <div class="card-body " id="aprd_file">
                      <h4 style="color:white">Files Approved</h4><br>
                      <p class="fs-30 mb-1" id="approvedfile" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>

               
              </div>
            </div>

          </div>
              <div class="row">
                <div class="col-md-12">
                <!-- <input id="datepicker1" class="custom-daterangepicker float-right">&nbsp;&nbsp;&nbsp; -->
                <!-- <select name="coder_name" class="teams" id="coder_name">
                <option value="">All</option>            
                </select> -->
                
                </div>
                

              </div>
              <br>
              
          
   

            <div class="col-md-12 ">
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
                            
                                  <canvas id="myPieChart" width="400" height="400" ></canvas>

                                    <!-- <canvas id="pieChart"></canvas> -->
                                     <!-- <canvas id="myBarChart" style="background-color: aliceblue;margin-left:15px!important;margin-right:15px!important;margin-bottom:15px!important;"></canvas> -->
                                  </div>
                                </div>
                              </div>
                               <!-- <canvas id="myBarChart"></canvas> -->
                              </div>
                           
                              
                              <div class="col-md-6 mt-3">
                                <div class="card">
                               <div class="card-body">

                                    <!-- <p style="text-align: center;"style="text-align: center;"> Team Performance</p> -->
                                    <p class="card-title mb-0"> </p> 
                                    <div class="table-responsive">

                                                
                                        <!-- <table class="table table-striped table-borderless"> -->
                                        <!-- <thead>
                                            <tr>
                                            <center><th class="pb-2 border-bottom" style="text-align: center;">Team</th></center>
                                            <th class="pl-0  pb-2 border-bottom"style="text-align: center;">Coder</th>
                                            <th class="border-bottom pb-2">Total Files</th>
                                            <th class="border-bottom pb-2">WIP</th>
                                            <th class="border-bottom pb-2">QC</th>
                                            <th class="border-bottom pb-2">Completed</th>
                                            <th class="border-bottom pb-2">APPROVED</th>
                                            </tr>
                                        </thead> -->
                                        <!-- <tbody id="show_data">
                                        
                                        </tbody> -->
                                        <!-- </table> -->
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
<style>
    .custom-scroll {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 500px; /* Set a max height if needed */
    }
</style>
  <!-- Edit modal -->
  <div class="modal fade bd-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <p class="card-title mb-0" id="exampleModalLabel"><span></p></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card " >
              <div class="card">
                <div class="card-body  custom-scroll"  >
                  <div class="table-responsive" >
                    <table class="table table-striped table-borderless" >
                      <thead>
                        <tr>
                          <th>Team</th>
                          <th>Agency</th>
                          <th>Patient_Name</th>
                         
                           <th>Mrn</th>
                          <th >Status</th>

                          <th>Coder</th>
                          <th>Insurance_Type</th>
                          <th>Assesment_Type</th>
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


 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

 

<script>
 
 <?php include 'datepicker.js'; ?>


</script>
<script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
<!-- <script src="vendors/js/vendor.bundle.base.js"></script> -->
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- <script src="vendors/chart.js/Chart.min.js"></script> -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <!-- <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script> -->
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- <script src="js/chart.js"></script> -->
  <!-- End custom js for this page-->
</body>

</html>

