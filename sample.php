<?php
// PHP code to calculate the values
$principal_interest = 1825.19;
$property_tax = 280;
$homeowners_insurance = 66;
$total = $principal_interest + $property_tax + $homeowners_insurance;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Payment Breakdown</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            width: 50%;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <canvas id="paymentChart"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('paymentChart').getContext('2d');
        var paymentChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Principal & interest', 'Property tax', 'Homeowner\'s insurance'],
                datasets: [{
                    data: [<?php echo $principal_interest; ?>, <?php echo $property_tax; ?>, <?php echo $homeowners_insurance; ?>],
                    backgroundColor: ['#4a90e2', '#7ed321', '#bd10e0'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly payment breakdown\n$<?php echo number_format($total, 2); ?>/mo',
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
