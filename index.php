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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
                      
                      <div class="card-body demo" id="new_file"  >

                      <h4>New Files</h4><br>
                      <p class="fs-30 mb-1" id="NEW"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  " style="background-color:#186b78">
                    <div class="card-body " id="ass_file">
                      <h4 style="color:white">Files Assigned </h4><br>
                      <p class="fs-30 mb-1" id="assing" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card "style="background-color: #897382;">
                    <div class="card-body " id="wip_file">
                      <h4 style="color:white">  WIP </h4><br>
                      <p class="fs-30 mb-1"id="processing" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-light-danger">
                    <div class="card-body " id="cmd_file">
                     <h4> Alloted To QC</h4><br>
                      <p class="fs-30 mb-1"id="COM"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
 
            <div class="col-md-6 grid-margin transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card" style="background-color: #7a839bd1;">
                    <div class="card-body" id="assign_tem">
                      <h4 style="color:white"> Assign To Team</h4><br>
                      <p class="fs-30 mb-1" id="ass_team" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-dark-blue">
                    <div class="card-body" id="Inprogress">
                        <h4> ON HOLD</h4><br>
                      <p class="fs-30 mb-1" id="inp"> </p>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card " style="background-color:#72539b">
                    <div class="card-body" id="Pending"> 
                     <h4 style="color:white">Pending </h4><br>
                      <p class="fs-30 mb-1" id="pnd" style="color:white"> </p> 
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  "style="background-color: #607d8b;">
                    <div class="card-body" id="Qcwip">
                     <h4 style="color:white"> QC WIP</h4><br>
                      <p class="fs-30 mb-1" id="qcwip" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>


 
          <div class="row">
              <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card"  style="background-color:#1871A0">
                    <div class="card-body demo" id="qccmd_file" >
                      <h4 class="text-white"> QC COMPLETED   </h4><br>
                      <p class="fs-30 mb-1 text-white" id="qc_com"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  " style="background-color:#e28743">
                    <div class="card-body " id="noqc">
                      <h4 style="color:white">NO QC</h4><br>
                      <p class="fs-30 mb-1" id="qc_no" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
   
            <div class="col-md-6 grid-margin transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
              <div class="row">
                  <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card" style="background-color: #13386B;">
                    <div class="card-body" id="aprd_file">
                      <h4 style="color:white">Files Approved</h4><br>
                      <p class="fs-30 mb-1" id="app" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div> 
               <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color: #0FA8A8;">
                    <div class="card-body" id="dirctapp">
                        <h4 style="color:white">Direct Approved</h4><br>
                      <p class="fs-30 mb-1" id="directapp_count" style="color:white"> </p>
                      <p> </p>
                    </div>
                  </div>
                </div>  
              </div>
 
            </div>  

          </div>

 

          
          
          <!-- <script src="upload/js/coder_perform.js" type="text/javascript"></script>   -->

              <script src="upload/js/count.js" type="text/javascript"></script>
               <!-- <script src="upload/js/data_show_dash.js" type="text/javascript"></script> -->
                <script src="upload/js/age_of_file.js" type="text/javascript"></script>
               


<?php  $randomNumber = rand(1000, 9999);  ?>

 


    <script src="upload/js/data_show_dash.js?<?php echo $randomNumber ?>"></script>


 
 
               


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
                              <div class="col-md-7 border-right">
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
                                      <td class="text-muted">Above&nbsp A Week</td>
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

                                
                             <div class="col-md-5 mt-3">
 
    <div class="card-title">Agency Wise New Files</div>
 
                                <?php include 'agencynewfileschart.php' ?>
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




 <div class="row">

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                 
   
                        <div class="row">
                       
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6">
                                  <!-- <input     id="datepicker1" class="custom-daterangepicker" ><span> </span>    -->
                            <?php include 'cht.php' ?>
                              </div>

                                 <div class="col-md-6">

                                   <!-- <div class="card-title">Agency Approved Counts by Month and Year</div> -->
                                  
      
                         <?php include('Approvedcountindex.php') ?>
                              </div>
 
                          </div> 
                        </div> 
                      </div> 
                    </div> 
                   </div>
                 </div>

           </div>



 <div class="row">

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                  <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <div class="row">
                       
                          <div class="col-md-12">
                           <div class="row">
    <div class="col-md-12">
        <div class="card">
          <h5 class="card-title text-primary">Top 5 CODER BY TEAM WEEKLY APPROVELS</h5>
            <div class="card-body">
                
               
             
               <?php include 'chat.php' ?>   
            </div>
        </div>
    </div>
   <div class="col-md-2">
 <!--  <div class="leaderboard text-black" style="margin-left: -49px;">
   <div class="card-title"> <h2>Coder List</h2></div>
    <ol>
        <?php
        // Example arrays (replace with your actual data)
       
            // Array of top 10 names
           $count = count($coders_team2);
           $count = count($coders_team1);
        

            
         for ($i = 0; $i < $count; $i++) {
         $name = $coders_team2[$i];
         $position = $i + 1;
         $id_value = $coders_team_id2[$i];
         $team1 = $alloted_team2[$i];  
    
    echo "<li>$name <br>(ID: $id_value)<br> (Team: $team1)</li>";
}

  for ($i = 0; $i < $count; $i++) {
         $name = $coders_team1[$i];
         $position = $i + 1;
         $id_value = $coders_team_id1[$i];
         $team2 = $alloted_team1[$i];  
    
    echo "<li>$name <br>(ID: $id_value)<br> (Team: $team2)</li>";

  }
 
        ?>
    </ol>
</div>   -->
<style>
    .leaderboard {
        margin-left: -49px;
        overflow-y: auto;
        max-height: 500px;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;

    }

    .leaderboard h2 {
        text-align: center;
        margin-bottom: 10px;
    }

    .leaderboard ol {
        padding: 0;
        list-style-type: none;
    }

    .leaderboard li {
        padding: 5px 10px;
        margin-bottom: 5px;
        background-color: #f9f9f9;
        border-radius: 3px;
    }
</style>


       
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












<!-- 
<script>
  


$(document).ready(function () {
    $("#datepicker1").on('change', function () {
        var date = $("#datepicker1").val();
        chart(date);
        
    });
});

function chart(date) {
    console.log("Selected date range:", date);
    var dateValues = date.split(" - "); // Assuming the format is 'fromdate - todate'
    var fromdate = dateValues[0];
    var todate = dateValues[1];

    // Convert to 'YYYY-MM-DD' format
    fromdate = new Date(fromdate).toLocaleDateString('en-CA'); // 'en-CA' represents the 'en'glish language in 'CA'nada
    todate = new Date(todate).toLocaleDateString('en-CA');

$.ajax({
    url: "cht.php",
    type: "GET",
    dataType: 'json',
    data: {
        fromdate: fromdate,
        todate: todate
    },
    success: function (response) {
        console.log("AJAX Response:", response);
        // Add code here to handle the response
    },
    error: function (xhr, status, error) {
        console.error("AJAX Error: " + status, error);
    }
});

}
</script> -->


 
<style>
  
  .canvasjs-chart-credit{
    display: none;

  }
</style>
    

<!-- =========================================================================================Team Performance Start============================================== -->
 

 <?php
// Database connection (replace with your actual connection details)
try {
    $pdo = new PDO('mysql:host=localhost;dbname=HCLI', 'zhcadmin', 'd0m!n$24');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch data
    $query = "
        SELECT 
            agency,
            EXTRACT(YEAR FROM file_completed_date) AS year,
            DATE_FORMAT(file_completed_date, '%M') AS month_name,
            EXTRACT(MONTH FROM file_completed_date) AS month_number,
            COUNT(status) AS approved_count
        FROM 
            Main_Data
        WHERE 
            status = 'APPROVED'
        GROUP BY 
            agency,
            year,
            month_name,
            month_number
        ORDER BY
            year,
            month_number,
            agency;
    ";

    $stmt = $pdo->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process the results into a structure suitable for CanvasJS
    $dataPoints = [];
    foreach ($results as $row) {
        $agency = $row['agency'];
        $year = $row['year'];
        $month = $row['month_name'];
        $count = $row['approved_count'];
        
        if (!isset($dataPoints[$agency])) {
            $dataPoints[$agency] = [];
        }
        
        $dataPoints[$agency][] = ["label" => "$agency $month  $year", "y" => $count];
    }

    $chartData = [];
    foreach ($dataPoints as $agency => $points) {
        $chartData[] = [
            "type" => "column",
            "name" => $agency,
            "label"=>$agency,$month,$year,
            "indexLabel" => "{y}",
            "yValueFormatString" => "#,##0",
            "showInLegend" => true,
            "dataPoints" => $points
        ];
    }

    // Convert chart data to JSON format for use in JavaScript
    $chartDataJson = json_encode($chartData, JSON_NUMERIC_CHECK);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
 
    <script>
    window.onload = function () {
        var chartData = <?php echo $chartDataJson; ?>;

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text:""
            },
            axisY: {
                title: ""
            },
             axisX: {
                title: "",
                 titleFontSize: 18, // Set a font size for the X-axis title
                labelFontSize: 1, // Set a font size for X-axis labels
               
                
            },
            data: chartData
        });
        chart.render();
    }
    </script>
 
    
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
   



 














































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





 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>
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
  <script>
        
    
  </script>
</body>

</html>

