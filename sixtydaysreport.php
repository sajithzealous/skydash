<!DOCTYPE html>
<html lang="en">

<head>
  <?php
    include 'login_sessions/admin_session.php';
    date_default_timezone_set('America/New_York');
    include 'db/db-con.php';
    include 'include_file/link.php';
  ?>  




  <!-- Include necessary libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<?php
 
$dataPoints = array( 
    array("y" => 7,"label" => "March" ),
    array("y" => 12,"label" => "April" ),
    array("y" => 28,"label" => "May" ),
    array("y" => 18,"label" => "June" ),
    array("y" => 18,"label" => "June" ),

    array("y" => 18,"label" => "June" ),

    array("y" => 18,"label" => "June" ),

    array("y" => 18,"label" => "June" ),

    array("y" => 18,"label" => "June" ),

    array("y" => 18,"label" => "June" ),
    array("y" => 18,"label" => "June" ),
    
    array("y" => 41,"label" => "July" )
);
 
?>
<body>

  <div class="container-scroller">
    <?php include 'include_file/profile.php'; ?>

    <div class="container-fluid page-body-wrapper">
      <?php include 'include_file/sidebar.php'; ?>
      <?php include 'style.php'; ?>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <form class="form-sample" method="GET" action="">
         <form method="GET" action="">
    <div class="row">
        <!-- From Date -->
        <div class="col-md-3">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">From Date</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" name="from_date" id="from_date5" title="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d'); ?>" style="font-size: 12px;" required>
                </div>
            </div>
        </div>

        <!-- To Date -->
        <div class="col-md-3">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">To Date</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" name="to_date" id="to_date5" title="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d'); ?>" style="font-size: 12px;" required>
                </div>
            </div>
        </div>

        <!-- Agency (currently empty, you can add input here if needed) -->
        <div class="col-md-3">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Agency</label>
                <div class="col-sm-9">
                    <!-- Agency input field could go here -->
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-md-3">
            <div class="form-group row">
                <div class="col-sm-8">
                    <button class="btn btn-primary ml-2" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>


          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <h4 class="p-4"> 60-Days Episode Summary</h4>
                <div class="card-body">
                  <div class="row">

                    <div class="col-md-6">
                      
                          <?php
                            include('db/db-con.php');

                            // Declare the current date in a variable
                            $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d');
                            $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');


                            // Perform the SQL query to select approved files data for today and group by coder and team
                            $query = "SELECT 
                                          `first_clinical_group`,
                                          ROUND(SUM(`first_billing_revenue`),2) AS `total_revenue`,
                                          COUNT(`first_clinical_group`) AS `occurrences`,
                                          ROUND(AVG(`first_billing_revenue`),2) AS `average_revenue`
                                      FROM 
                                          `reportsixtydays`
                                       WHERE
                                        
                                         `time_stamp`  BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'    
                                      GROUP BY 
                                          `first_clinical_group`
                                      ORDER BY 
                                          `occurrences` DESC";

                            // Execute the query and check for errors
                            $result = mysqli_query($conn, $query);

                            if (!$result) {
                                die("Query failed: " . mysqli_error($conn));
                            }
                            ?>

                            <div class="col-md-12 stretch-card grid-margin">
                                <div class="card">
                                    <div class="card-body" style="">
                                        <div class="card-title " style="text-align: center;margin-top: 20px;">1st 30 Days Clinical Group Report</div>
                                        <div class="table-responsive" style="max-height: 700px;overflow-y: auto;">
                                            <table class="table table-bordered table-striped" >
                                                <thead>
                                                    <tr>
                                                        <th class="pb-2 border-bottom">Clinical Group</th>
                                                        <th class="border-bottom pb-2">Total Revenue</th>
                                                        <th class="border-bottom pb-2">Total Charts</th>
                                                        <th class="border-bottom pb-2">Average</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Loop through each row in the result set
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td class=""><?php echo $row['first_clinical_group']; ?></td>
                                                        <td><?php echo $row['total_revenue']; ?></td>
                                                        <td><?php echo $row['occurrences']; ?></td>
                                                        <td><?php echo $row['average_revenue']; ?></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>              
                    <div class="col-md-6">
                      
                          <?php
                            include('db/db-con.php');

                            $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d');
                            $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');

                            // Declare the current date in a variable


                            // Perform the SQL query to select approved files data for today and group by coder and team
                            $query = "SELECT 
                                        `second_clinical_group`,
                                        ROUND(SUM(`second_billing_revenue`), 2) AS `total_revenue`,
                                        COUNT(`second_clinical_group`) AS `occurrences`,
                                        ROUND(AVG(`second_billing_revenue`), 2) AS `average_revenue`
                                    FROM 
                                        `reportsixtydays`
                                    WHERE
                                        
                                         `time_stamp`  BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'

                                    GROUP BY 
                                        `second_clinical_group`
                                    ORDER BY 
                                        `occurrences` DESC
                                    ";

                            // Execute the query and check for errors
                            $result = mysqli_query($conn, $query);

                            if (!$result) {
                                die("Query failed: " . mysqli_error($conn));
                            }
                            ?>

                            <div class="col-md-12 stretch-card grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title " style="text-align: center;margin-top: 20px;">2nd 30 Days Clinical Group Report</div>
                                        <div class="table-responsive" style="max-height: 700px;overflow-y: auto;">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom">Clinical Group</th>
                                                        <th class="border-bottom pb-2">Total Revenue</th>
                                                        <th class="border-bottom pb-2">Total Charts</th>
                                                        <th class="border-bottom pb-2">Average</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Loop through each row in the result set
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td class=""><?php echo $row['second_clinical_group']; ?></td>
                                                        <td><?php echo $row['total_revenue']; ?></td>
                                                        <td><?php echo $row['occurrences']; ?></td>
                                                        <td><?php echo $row['average_revenue']; ?></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
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

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <h4 class="p-4"> ADMIISSION SOURCE & REFERRAL</h4>
                <div class="card-body">
                  <div class="row">

                    <div class="col-md-6">
                        <?php
                        include('db/db-con.php');

                        $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d');
                        $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');

                        // SQL query to generate the report
                        $query = "
                                   SELECT
                              first_clinical_group AS 'Clinical Grouping',
                              SUM(CASE WHEN first_admission = 'Community Early' THEN 1 ELSE 0 END) AS 'Community Early',
                              SUM(CASE WHEN first_admission = 'Community Late' THEN 1 ELSE 0 END) AS 'Community Late',
                              SUM(CASE WHEN first_admission = 'Institutional Early' THEN 1 ELSE 0 END) AS 'Institutional Early',
                              SUM(CASE WHEN first_admission = 'Institutional Late' THEN 1 ELSE 0 END) AS 'Institutional Late',
                              COUNT(*) AS 'Grand Total'
                          FROM 
                              reportsixtydays

                          WHERE
                                        
                            `time_stamp`  BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'
                          GROUP BY 
                              first_clinical_group
                          ORDER BY 
                              'Grand Total' DESC";

                        // Execute the query and check for errors
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            die("Query failed: " . mysqli_error($conn));
                        }
                        ?>

                        <div class="col-md-12 stretch-card grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title text-center" style="margin-top: 20px;">Clinical Grouping Report</div>
                                    <div class="table-responsive" style="max-height: 700px;overflow-y: auto;">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="pb-2 border-bottom">Clinical Group</th>
                                                    <th class="border-bottom pb-2">Community Early</th>
                                                    <th class="border-bottom pb-2">Community Late</th>
                                                    <th class="border-bottom pb-2">Institutional Early</th>
                                                    <th class="border-bottom pb-2">Institutional Late</th>
                                                    <th class="border-bottom pb-2">Grand Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Loop through each row in the result set and display the data
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['Clinical Grouping']; ?></td>
                                                    <td><?php echo $row['Community Early']; ?></td>
                                                    <td><?php echo $row['Community Late']; ?></td>
                                                    <td><?php echo $row['Institutional Early']; ?></td>
                                                    <td><?php echo $row['Institutional Late']; ?></td>
                                                    <td><?php echo $row['Grand Total']; ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             
                    <div class="col-md-6">
                      
                          <?php
                            include('db/db-con.php');

                            // Declare the current date in a variable
                            $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d');
                            $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');


                            // Perform the SQL query to select approved files data for today and group by coder and team
                            $query = "SELECT
                              first_clinical_group AS 'Clinical Grouping',
                              SUM(CASE WHEN first_comorbidity = '0' THEN 1 ELSE 0 END) AS 'noadjustments',
                              SUM(CASE WHEN first_comorbidity = '1' THEN 1 ELSE 0 END) AS 'lowadjustments',
                              SUM(CASE WHEN first_comorbidity = '2' THEN 1 ELSE 0 END) AS 'highadjustments',
                              COUNT(*) AS 'Grand Total'
                          FROM 
                              reportsixtydays
                            WHERE
                                        
                            `time_stamp`  BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'
                               
                          GROUP BY 
                              first_clinical_group
                          ORDER BY 
                              'Grand Total' DESC";

                            // Execute the query and check for errors
                            $result = mysqli_query($conn, $query);

                            if (!$result) {
                                die("Query failed: " . mysqli_error($conn));
                            }
                            ?>

                            <div class="col-md-12 stretch-card grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title " style="text-align: center;margin-top: 20px;">Comorbidity Report</div>
                                        <div class="table-responsive" style="max-height: 700px;overflow-y: auto;">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom">Clinical Group</th>
                                                        <th class="border-bottom pb-2">No adjustment (0)</th>
                                                        <th class="border-bottom pb-2">Low Co-morbidity Adjsutment (1)</th>
                                                        <th class="border-bottom pb-2">High Co-morbidity Adjustment (2)</th>
                                                        <th class="border-bottom pb-2">Grand Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Loop through each row in the result set
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td class=""><?php echo $row['Clinical Grouping']; ?></td>
                                                        <td><?php echo $row['noadjustments']; ?></td>
                                                        <td><?php echo $row['lowadjustments']; ?></td>
                                                        <td><?php echo $row['highadjustments']; ?></td>
                                                         <td><?php echo $row['Grand Total']; ?></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
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

                                                          <!-- 1st chart  START-->

          <div class="row">
             <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                     <div class="card-title text-center" style="margin-top: 20px;">60 Days Episode Average Payment Summary</div>
                      <canvas id="chart1"></canvas>
                </div>
     
  
 
      </div>
  </div>
</div>


                                                <!-- 1st chart  END-->


                                                  <!-- 2ND chart  START-->

          <div class="row">
             <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                     <div class="card-title text-center" style="margin-top: 20px;">Top 10 Volume Clinical Grouping</div>
                      <canvas id="chart2"></canvas>
                </div>
     
  
 
      </div>
  </div>
</div>

       <style>
    .chart-container {
        position: relative;
        height: 500px; /* Adjust height as needed */
        width: 100%;
        margin-bottom: 20px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(240, 240, 240, 0.8)); /* Gradient background */
        border: 1px solid #ddd; /* Optional border */
        border-radius: 8px; /* Optional rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional shadow */
    }
    #lineChart {
        background: transparent; /* Ensure the chart itself has a transparent background */
    }
</style>
                                             <!-- 2ND chart  END-->
 
<div class="card">
                <div class="card-body">
  <div class="row">
        <!-- First Chart -->

            
 

        <div class="col-md-6">
            <div class="chart-container">
                 <div class="card-title text-center" style="margin-top: 20px;">1st 30 day EOE</div>
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <!-- Second Chart -->
        <div class="col-md-6">
            <div class="chart-container">
                 <div class="card-title text-center" style="margin-top: 20px;">2nd 30 day EOE</div>
                <canvas id="lineChart1"></canvas>
            </div>
        </div>
    </div>
 </div>
</div>

 
       
 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
<?php

 $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d');
 $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');
// Database connection and query for Chart 1
$sql1 = "SELECT first_clinical_group, ROUND(AVG(first_billing_revenue),2) AS average_revenue 
         FROM reportsixtydays
          WHERE
                                        
            `time_stamp`  BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'
         GROUP BY first_clinical_group 
         ORDER BY average_revenue DESC";

$result1 = $conn->query($sql1);
$labels1 = [];
$dataPoints1 = [];
while ($row = $result1->fetch_assoc()) {
    $labels1[] = $row['first_clinical_group'];
    $dataPoints1[] = $row['average_revenue'];
}

// Database connection and query for Chart 2
$sql2 = "SELECT first_clinical_group, COUNT(first_clinical_group) AS occurrences_count 
         FROM reportsixtydays
         WHERE
                                        
            `time_stamp`  BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59' 
         GROUP BY first_clinical_group 
         ORDER BY occurrences_count DESC 
         LIMIT 10";

$result2 = $conn->query($sql2);

// Prepare data for Chart.js
$labels2 = [];
$dataPoints2 = [];
while ($row = $result2->fetch_assoc()) {
    $labels2[] = $row['first_clinical_group']; // Corrected label
    $dataPoints2[] = $row['occurrences_count']; // Corrected data point
}

$sql3 = "SELECT `assesment_date`, `first_billing_revenue` FROM `reportsixtydays`WHERE `time_stamp`  BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59' limit 20";

$result3 = $conn->query($sql3);

// Prepare data for Chart.js
$labels3 = [];
$dataPoints3 = [];
while ($row = $result3->fetch_assoc()) {
    $labels3[] = $row['assesment_date']; // X-axis labels
    $dataPoints3[] = $row['first_billing_revenue']; // Y-axis data points
}


$sql4 = "SELECT `assesment_date`, `second_billing_revenue` FROM `reportsixtydays` WHERE `time_stamp`  BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59' limit 20";

$result4 = $conn->query($sql4);

// Prepare data for Chart.js
$labels4 = [];
$dataPoints4 = [];
while ($row = $result4->fetch_assoc()) {
    $labels4[] = $row['assesment_date']; // X-axis labels
    $dataPoints4[] = $row['second_billing_revenue']; // Y-axis data points
}
$conn->close();

 
?>

<!--  
<div class="chart-container">
    <canvas id="chart3"></canvas>
</div> -->

<script>
    const ctx1 = document.getElementById('chart1').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels1); ?>, // X-axis labels
            datasets: [{
                label: 'Average Revenue',
                data: <?php echo json_encode($dataPoints1); ?>, // Y-axis data
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Clinical Groups' // Label for X-axis
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: '   ' // Label for Y-axis
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString(); // Formatting Y-axis values
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return '$' + value.toLocaleString(); // Formatting tooltip values
                        }
                    }
                }
            }
        }
    });

    const ctx2 = document.getElementById('chart2').getContext('2d');
    new Chart(ctx2, {
        type: 'bar', // Horizontal bar chart
        data: {
            labels: <?php echo json_encode($labels2); ?>,
            datasets: [{
                label: 'Occurrences Count',
                data: <?php echo json_encode($dataPoints2); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y', // Horizontal bars
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString(); // Formatting X-axis values
                        }
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

 
    const ctx3 = document.getElementById('lineChart').getContext('2d');
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels3); ?>, // X-axis labels
            datasets: [{
                label: '1st 30 day EOE',
                data: <?php echo json_encode($dataPoints3); ?>, // Y-axis data
                fill: false,
                backgroundColor: 'rgba(255, 99, 132, 1)',
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: ' '
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 20
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: ''
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    const ctx4 = document.getElementById('lineChart1').getContext('2d');
    new Chart(ctx4, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels4); ?>, // X-axis labels
            datasets: [{
                label: '2nd 30 day EOE',
                data: <?php echo json_encode($dataPoints4); ?>, // Y-axis data
                fill: false,
                backgroundColor: 'rgba(75, 192, 192, 1)',
                borderColor: 'rgba(255, 99, 132, 0.5)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: ''
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 20
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: ''
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>


  


 


</div>
</div>
</div>
    
 

         </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>


 

<script>
        const labels = <?php echo json_encode($groups); ?>;
        const data = {
            labels: labels,
            datasets: [{
                label: 'Average Revenue ($)',
                data: <?php echo json_encode($revenues); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script> 
</body>

</html>
