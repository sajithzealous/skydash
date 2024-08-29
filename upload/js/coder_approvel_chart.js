 
        $(document).ready(function () {
            $("#datepicker").on('change', function () {
                var date = $("#datepicker").val();
                chart(date);
            });
        });

        function chart(date) {
            console.log("Selected date range:", date);
            var dateValues = date.split(" - ");
            var fromdate = new Date(dateValues[0]).toLocaleDateString('en-CA');
            var todate = new Date(dateValues[1]).toLocaleDateString('en-CA');

            $.ajax({
                url: "chart.php",
                type: "GET",
                dataType: 'json',
                data: {
                    fromdate: fromdate,
                    todate: todate
                },
                success: function (response) {
                    console.log("AJAX Response:", response);
                    updateChart(response);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + status, error);
                }
            });
        }

        function updateChart(data) {
            var ctx = document.getElementById('approvalChart').getContext('2d');
            var approvalChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Anand Sekar Team Approvals',
                        data: data.approvalCountsTeam1,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Srimugan Ganesan Team Approvals',
                        data: data.approvalCountsTeam2,
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
        }
 