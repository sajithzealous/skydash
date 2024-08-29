<?php
$servername = "localhost";
$username = "zhcadmin";
$password = "d0m!n$24";
$dbname = "HCLI";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
$query = "SELECT alloted_team,
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS `this_week`,
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE() - INTERVAL 7 DAY, 1) THEN 1 ELSE 0 END) AS `1weekago`,
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE() - INTERVAL 14 DAY, 1) THEN 1 ELSE 0 END) AS `2weeksago`,
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE() - INTERVAL 21 DAY, 1) THEN 1 ELSE 0 END) AS `3weeksago`,
    SUM(CASE WHEN WEEK(`File_Status_Time`, 1) = WEEK(CURDATE() - INTERVAL 28 DAY, 1) THEN 1 ELSE 0 END) AS `4weekago`
FROM
    Main_Data
WHERE
    `status` = 'APPROVED'
    AND `File_Status_Time` >= DATE_FORMAT(CURDATE() ,'%Y-%m-01') -- Start of the current month
    AND `File_Status_Time` < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH ,'%Y-%m-01') -- Start of the next month
GROUP BY 
    alloted_team;
 
";

$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

// Process data for Chart.js
$teams = [];
$this_week = [];
$first_week = [];
$second_week = [];
$third_week = [];
$fourth_week = [];

foreach ($data as $row) {
    $teams[] = $row['alloted_team'];
    $this_week[] = $row['this_week'];
    $first_week[] = $row['1weekago'];
    $second_week[] = $row['2weeksago'];
    $third_week[] = $row['3weeksago'];
    $fourth_week[] = $row['4weekago'];
}
?>
<script>
    var teams = <?php echo json_encode($teams); ?>;
    var this_week = <?php echo json_encode($this_week); ?>;
    var first_week = <?php echo json_encode($first_week); ?>;
    var second_week = <?php echo json_encode($second_week); ?>;
    var third_week = <?php echo json_encode($third_week); ?>;
    var fourth_week = <?php echo json_encode($fourth_week); ?>;
</script>

<!DOCTYPE html>
<html lang="en">
<head>
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
       

       
    </style>
</head>
<body>

<div class="">
    <div class="card-title john-title">Weekly Approved Counts by Team</div>
    <div class="chart-container">
        <canvas id="myChart"></canvas>
    </div>
</div>

 

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: teams,
            datasets: [
                {
                    label: 'This Week',
                    data: this_week,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                },
                {
                    label: '1Week ago',
                    data: first_week,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                },
                {
                    label: '2Weeks ago',
                    data: second_week,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                },
                {
                    label: '3Weeks ago',
                    data: third_week,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                },
                {
                    label: '4Weeks ago',
                    data: fourth_week,
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                },
            ]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: ' '
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
