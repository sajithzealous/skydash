 
 $(document).ready(function(){


var weeklyCounts = <?php echo json_encode($weeklyCounts); ?>;

// Get the canvas element
var ctx = document.getElementById('myChart').getContext('2d');

// Create the vertical column chart

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['This Week', '1st Week Ago', '2nd Week Ago', '3rd Week Ago', '4th Week Ago'],
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
                beginAtZero: true,
                ticks: {
                    stepSize: 1,  // Set the step size to 1
                    callback: function(value) {
                        return Number.isInteger(value) ? value : '';
                    }
                }
            }
        }

    }
});

  });