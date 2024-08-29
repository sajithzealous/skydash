<!DOCTYPE html>
<html lang="en">

<head>
  <?php

  include 'login_sessions/agency_session.php';
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

 
                <input     id="ecommerce-dashboard-daterangepicker" class="custom-daterangepicker"><span> </span>   

                   
              

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
                      <h4>New File</h4><br>
                      <p class="fs-30 mb-1" id="NEW"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  " style="background-color:#186b78">
                    <div class="card-body " id="ass_file">
                      <h4 style="color:white">Files Assigned</h4><br>
                      <p class="fs-30 mb-1" id="assing" style="color:white">  </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
             <!--  <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card "style="background-color: #897382;">
                    <div class="card-body " id="qc_file">
                      <h4 style="color:white"> </h4><br>
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
              </div> -->
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
                      <p class="fs-30 mb-1" id="app"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
          <!--     <div class="row">
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
              </div> -->
            </div>

          </div>
          <div class="row">
            <div class="col-md-12">
<!-- <input id="datepicker1" class="custom-daterangepicker float-right"> -->
            </div>
             

          </div>
          <br>

          <?php $random= rand(1000,9999); ?>
          
           <script src="upload/agent_files/agent_count.js?<?php echo$random?>" type="text/javascript"></script>
            <script src="upload/agent_files/data_show_agent.js?<?php echo$random?>" type="text/javascript"></script>
              <script src="upload/agent_files/agent_age.js" type="text/javascript"></script>
         
         
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
                            <p class="card-title">New Files Time Span  </p>
                              <h1 class="text-primary  " id="total" value=""> </h1>
                              <h3 class="font-weight-500 mb-xl-4 text-primary">Total Count</h3>
                              
                            </div>  
                            </div>
                          <div class="col-md-12 col-xl-9">
                            <div class="row">
                              <div class="col-md-4 border-right color-red">
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

                           <div class="col-lg-8"><p class="card-title">Weekly Completed Count </p>
                          

                              <div class="col-lg-12   ">
                           <canvas id="myChart" width="40" height="20" style="background-color: #f5f5f5; border-radius: 8px;"></canvas>
                        

                                   </div>
 
 
  <?php
include 'agency_chat.php';
 ?>
                             
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
 
    .bd-example-modal-lg-edit .modal-dialog {
    max-width: 80%; /* Adjust the width as needed */
  }

 
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
                        <tr class="thd">
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
 



<script>
// Get the weekly counts from PHP
var weeklyCounts = <?php echo json_encode($weeklyCounts); ?>;

// Get the canvas element
var ctx = document.getElementById('myChart').getContext('2d');

// Create the vertical column chart

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['This Week', '1Week Ago', '2Weeks Ago', '3Weeks Ago', '4Weeks Ago'],
        datasets: [{
            label: 'Completed Count',
            data: weeklyCounts,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)', // Red
                'rgba(54, 162, 235, 0.2)', // Blue
                'rgba(255, 206, 86, 0.2)', // Yellow
                'rgba(75, 192, 192, 0.2)', // Green
                'rgba(153, 102, 255, 0.2)' // Purple
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        animation: {
            duration: 2000,
            easing: 'easeInOutQuad'
        },
        scales: {
    y: {
        ticks: {
            stepSize: 1, // Set the step size to 1
            callback: function(value) {
                return Math.floor(value) === value ? value : ''; // Force integer display
            }
        }
    }
}

    }
});



</script>





















  <!-- End custom js for this page-->
</body>

</html>

