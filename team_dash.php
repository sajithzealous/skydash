<!DOCTYPE html>
<html lang="en">

<head>
  <?php


  
session_start();

   date_default_timezone_set('America/New_York');
$role=$_SESSION['role'];

$team = $_SESSION['teamname'];  
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

 
               <input id="datepickeruser" class="custom-daterangepicker float-right">  

                   
              

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
                    <div class="card-body demo" id="" value="">
                      <h4>New Files</h4><br>
                      <p class="fs-30 mb-1" id="team_assing"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                  <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  " style="background-color:#186b78">
                    <div class="card-body " id="">
                      <h4 style="color:white">Assign To Coder </h4><br>
                      <p class="fs-30 mb-1" id="cdr" style="color:white"> </p>
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
                    <div class="card-body" id="">
                      <h4 style="color:white">WIP</h4><br>
                      <p class="fs-30 mb-1" id="team_wip" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-dark-blue">
                    <div class="card-body" id="cmd_file">
                        <h4>Complete Files</h4><br>
                      <p class="fs-30 mb-1" id="team_cmd"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
       
            </div>

          </div>
         <script src="upload/js/team_dash.js" type="text/javascript"></script>
        </div>
      </div>
    </div>
  </div>
<script >
  

    $(document).ready(function() {

// Create a new Date object
var currentDate = new Date();

// Options for formatting
var options = {
  month: '2-digit',
  day: '2-digit',
  year: 'numeric',
  timeZone: 'America/New_York',  
};
 
var formattedDate = currentDate.toLocaleDateString('en-US', options);

// alert(forDate);

    function updateDateRange(start, end) {
      const startDateFormatted = start.format('MM/DD/YYYY hh:mm A');
      const endDateFormatted = end.format('MM/DD/YYYY hh:mm A');
      $('#datepickeruser').html(`${startDateFormatted} - ${endDateFormatted}`);
    }

     


   // Use moment.js to parse the dates in 'YYYY/MM/DD' format
    // const startDate = moment(forDate);
    // const endDate = moment(forDate, 'YYYY/MM/DD');
    const startDate = moment(formattedDate, 'MM/DD/YYYY');
    const endDate = moment(formattedDate, 'MM/DD/YYYY');



 $('#datepickeruser').daterangepicker({
      startDate: startDate,
      endDate: endDate,
      timePicker: true,
      timePicker24Hour: true,
      opens: 'right',
      ranges: {
        'ALL': [moment().startOf('year'), moment().endOf('year')],
        'Today': [moment(startDate), moment(endDate)],
        
        'Yesterday': [moment(startDate).subtract(1, 'days').endOf('day'), moment(endDate).subtract(1, 'days').endOf('day')],
        'Last 7 Days': [moment(startDate).subtract(6, 'days'), moment(endDate)],
        'Last 30 Days': [moment(startDate).subtract(29, 'days'), moment(endDate)],
        'This Month': [moment(startDate).startOf('month'), moment(endDate).endOf('month')],
        'Last Month': [moment(startDate).subtract(1, 'month').startOf('month'), moment(endDate).subtract(1, 'month').endOf('month')]
      }
    }, updateDateRange);

   updateDateRange(startDate, endDate);
 
   }); 

// Output the PHP variable within JavaScript
 
 
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
