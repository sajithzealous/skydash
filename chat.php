<?php
// Database connection parameters
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

// Calculate the start and end dates for the current week
$currentDate = date('Y-m-d');  // Today's date
$startOfWeek = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));  // Last Sunday
$endOfWeek = date('Y-m-d', strtotime('next saturday', strtotime($startOfWeek)));  // Next Saturday

// Initialize arrays for storing coder names and approval counts
$coders_team1 = [];
$approval_counts_team1 = [];
$coders_team2 = [];
$approval_counts_team2 = [];

// Query for team 'Anand Sekar' for the current week
$sql_team1 = "SELECT alloted_to_coder,coder_emp_id,alloted_team,COUNT(status) AS approval_count 
              FROM Main_Data 
              WHERE status = 'APPROVED' 
                AND alloted_team = 'Anand Sekar' 
                AND file_completed_date >= '$startOfWeek' 
                AND file_completed_date <= '$endOfWeek'
              GROUP BY alloted_to_coder,coder_emp_id,alloted_team
              ORDER BY approval_count DESC 
              LIMIT 5";

$result_team1 = $conn->query($sql_team1);

// Fetch results for team 1
if ($result_team1->num_rows > 0) {
    while ($row = $result_team1->fetch_assoc()) {
        $coders_team1[] = $row['alloted_to_coder'];
         $coders_team_id1[] = $row['coder_emp_id'];
         $alloted_team1[] = $row['alloted_team'];
        $approval_counts_team1[] = $row['approval_count'];
    }
} else {
    echo "0 results for team 'Anand Sekar' this week";
}

// Query for team 'Srimugan Ganesan' for the current week
$sql_team2 = "SELECT alloted_to_coder,coder_emp_id,alloted_team, COUNT(status) AS approval_count 
              FROM Main_Data 
              WHERE status = 'APPROVED' 
                AND alloted_team = 'Srimugan Ganesan' 
                AND file_completed_date >= '$startOfWeek' 
                AND file_completed_date <= '$endOfWeek'
              GROUP BY alloted_to_coder,coder_emp_id,alloted_team
              ORDER BY approval_count DESC 
              LIMIT 5";

$result_team2 = $conn->query($sql_team2);

// Fetch results for team 2
if ($result_team2->num_rows > 0) {
    while ($row = $result_team2->fetch_assoc()) {
        $coders_team2[] = $row['alloted_to_coder'];
         $coders_team_id2[] = $row['coder_emp_id'];
         $alloted_team2[] = $row['alloted_team'];
        $approval_counts_team2[] = $row['approval_count'];
    }
} else {
    echo "0 results for team 'Srimugan' this week";
}

// Close database connection
$conn->close();

// Ensure both arrays have the same length by filling with placeholders
$max_length = max(count($coders_team1), count($coders_team2));

while (count($coders_team1) < $max_length) {
    $coders_team1[] = null;
    $approval_counts_team1[] = 0;
}

while (count($coders_team2) < $max_length) {
    $coders_team2[] = null;
    $approval_counts_team2[] = 0;
}

// Combine coder names with their team labels for better readability
$combined_labels = [];
for ($i = 0; $i < $max_length; $i++) {
    $label = '';
    if (isset($coders_team1[$i])) {
        $label .= ' ' . ($i + 1) . '. ' . $coders_team1[$i];
    }
    if (isset($coders_team2[$i])) {
        if (!empty($label)) $label .= ' | ';
        $label .= '' . ($i + 1) . '. ' . $coders_team2[$i];
    }
    $combined_labels[] = $label;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Small Size Bar Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Optional: Add some padding to the chart container */
        .chart-container {
            padding: 20px;
        }
    </style>

</head>
<body>
 
    <div class="chart-container">
        <canvas id="approvalChart" width="100" height="400"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('approvalChart').getContext('2d');
        var approvalChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($combined_labels); ?>,
                datasets: [{
                    label: 'Anand Sekar Team Approvals',
                    data: <?php echo json_encode($approval_counts_team1); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Srimugan Ganesan Team Approvals',
                    data: <?php echo json_encode($approval_counts_team2); ?>,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


 
    <title>Top 10 Names Leaderboard</title>
    <style>
     
        .leaderboard {
            max-width: 600px;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .leaderboard h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            text-shadow: 2px 2px 2px rgba(0,0,0,0.2);
        }
        .leaderboard ol {
            list-style-type: none;
            padding-left: 0;
        }
        .leaderboard li {
            font-size: 18px;
            margin-bottom: 10px;
            position: relative;
            padding-left: 30px;
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 10px 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .leaderboard li:before {
            content: '';
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: url('cup.png') no-repeat center center;
            background-size: contain;
        }
        .leaderboard li:nth-child(1):before {
            background-image: url('gold-cup.png');
        }
        .leaderboard li:nth-child(2):before {
            background-image: url('silver-cup.png');
        }
        .leaderboard li:nth-child(3):before {
            background-image: url('bronze-cup.png');
        }
    </style>
</head>
<body>
 
</body>
</html>





























</body>
</html>
