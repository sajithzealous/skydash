<!DOCTYPE html>
<html lang="en">

<head>
  <?php


   include 'logsession.php';
   date_default_timezone_set('America/New_York');


   include('../db/db-con.php');
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

 
                <input     id="ecommerce-dashboard-daterangepicker" class="custom-daterangepicker" ><span> </span>   

                   
              

                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-tale">
                    <div class="card-body demo" id="new_file" value="">
                      <h4>New Files</h4><br>
                      <p class="fs-30 mb-1" id="NEW"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  " style="background-color:#186b78">
                    <div class="card-body " id="ass_file">
                      <h4 style="color:white">Files Assingned </h4><br>
                      <p class="fs-30 mb-1" id="assing" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card "style="background-color: #897382;">
                    <div class="card-body " id="qc_file">
                      <h4 style="color:white">Alloted To QC</h4><br>
                      <p class="fs-30 mb-1"id="allot_qc" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-light-danger">
                    <div class="card-body " id="wipqc_file">
                     <h4>Assing To Team</h4><br>
                      <p class="fs-30 mb-1"id="qc_wip"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

  
            <div class="col-md-6 grid-margin transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card   " style="background-color: #7a839bd1;">
                    <div class="card-body" id="wip_file">
                      <h4 style="color:white">WIP</h4><br>
                      <p class="fs-30 mb-1" id="processing" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-dark-blue">
                    <div class="card-body" id="cmd_file">
                        <h4>Files Completed</h4><br>
                      <p class="fs-30 mb-1" id="COM"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card " style="background-color:#72539b">
                    <div class="card-body" id="qccmd_file">
                     <h4 style="color:white">QC Completed</h4><br>
                      <p class="fs-30 mb-1" id="qc_com" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  "style="background-color: #607d8b;">
                    <div class="card-body" id="aprd_file">
                     <h4 style="color:white">Approved Files</h4><br>
                      <p class="fs-30 mb-1" id="app" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-12">
<!-- <input id="datepicker1" class="custom-daterangepicker float-right"> -->
            </div>
             

          </div>
          <br>
          
          
         
              <script src="upload/js/count.js" type="text/javascript"></script>
               <script src="upload/js/data_show_dash.js" type="text/javascript"></script>
                <script src="upload/js/age_of_file.js" type="text/javascript"></script>
                <script src="upload/js/coder_perform.js" type="text/javascript"></script>  



            <div class="row">

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                  <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <div class="row">
                          <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                            <div class="ml-xl-4 mt-3">
                            <p class="card-title"> Age Of Files  </p>
                              <h1 class="text-primary  " id="total" value=""> </h1>
                              <h3 class="font-weight-500 mb-xl-4 text-primary">Total Count</h3>
                              
                            </div>  
                            </div>
                          <div class="col-md-12 col-xl-9">
                            <div class="row">
                              <div class="col-md-4 border-right">
                                <div class="table-responsive mb-3 mb-md-0 mt-3">
                                  <table class="table table-borderless report-table">
                                       <tr>
                                      <td class="text-muted">1&nbspDays</td>
                                      <td class="w-100 px-0">
                                        <div class="progress progress-md mx-4">
                                          <div class="progress-bar bg-secondary" role="progressbar" id="progressbar_1"style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                      </td>
                                      <td><h5 class="font-weight-bold mb-0" id="oneday"> </h5></td>
                                    </tr>
                                    <tr>
                                      <td class="text-muted">2&nbspDays</td>
                                      <td class="w-100 px-0">
                                        <div class="progress progress-md mx-4">

                                         <div class="progress-bar bg-primary" role="progressbar" id="progressbar_2" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>
                                        </div>
                                      </td>
                                      <td><h5 class="font-weight-bold mb-0" id="twodays"> </h5></td>
                                    </tr>
                                    <tr>
                                      <td class="text-muted">3&nbspDays</td>
                                      <td class="w-100 px-0">
                                        <div class="progress progress-md mx-4">
                                          <div class="progress-bar bg-warning" role="progressbar" id="progressbar_3"style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                      </td>
                                      <td><h5 class="font-weight-bold mb-0" id="threedays"> </h5></td>
                                    </tr>
                                    <tr>
                                      <td class="text-muted">4&nbspDays</td>
                                      <td class="w-100 px-0">
                                        <div class="progress progress-md mx-4">
                                          <div class="progress-bar bg-success" role="progressbar" id="progressbar_4"style="width: 0%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                      </td>
                                      <td><h5 class="font-weight-bold mb-0" id="fourdays"> </h5></td>
                                    </tr>
                                    <tr>
                                      <td class="text-muted">5&nbspDays</td>
                                      <td class="w-100 px-0">
                                        <div class="progress progress-md mx-4">
                                          <div class="progress-bar bg-info" role="progressbar"id="progressbar_5" style="width: 0%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                      </td>
                                      <td><h5 class="font-weight-bold mb-0" id="fivedays"> </h5></td>
                                    </tr>
                                
                                    <tr>
                                      <td class="text-muted">Above&nbsp AWeek</td>
                                      <td class="w-100 px-0">
                                        <div class="progress progress-md mx-4">
                                          <div class="progress-bar bg-danger" role="progressbar" id="progressbar_6"style="width: 0%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                      </td>
                                      <td><h5 class="font-weight-bold mb-0" id="sixdays"> </h5></td>
                                    </tr>
                                  </table>
                                </div>
                              </div>

         
                              <div class="col-md-8 mt-3">

                                  <div class="card">

                               <div class="card-body">

                   <p style="margin-top: -31px;">  <b>Team Performance</p></b>
                  <p class="card-title mb-0"> </p> 
                   <div class="table-responsive"> 

                             
                    <table class="table table-borderd table-light table-hover">
                      <thead>
                        <tr>
                          <center><th class="pb-2 border-bottom" style="text-align: center;">Team</th></center>
                          <th class="pl-0  pb-2 border-bottom"style="text-align: center;">Coder</th>
                          <th class="border-bottom pb-2"style="text-align: center;">Total Files</th>
                          <th class="border-bottom pb-2"style="text-align: center;">WIP</th>
                          <th class="border-bottom pb-2"style="text-align: center;">QC</th>
                          <th class="border-bottom pb-2"style="text-align: center;">Completed</th>
                          <th class="border-bottom pb-2" style="text-align: center;">Approved</th>
                         
                        </tr>
                      </thead>
                      <tbody id="show_data" style="text-align: center;">
                       
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
                          <th>Alloted_Team</th> 
                         
                          <th>Agency</th>
                          <th>Patient_Name</th>
                          <th>Phone_Number</th>
                           <th>Mrn</th>
                          <th >Status</th>

                          <th>Coder</th>
                          <th>Insurance_Type</th>
                          

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

