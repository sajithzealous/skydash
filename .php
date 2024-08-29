<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Range Picker Example</title>
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


</head>


<body>
   <div id="ecommerce-dashboard-daterangepicker" class="custom-daterangepicker"></div>


    <script>
        $(document).ready(function() {
            // Callback function to update the selected date range
            function cb(start, end) {
                $('#ecommerce-dashboard-daterangepicker').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            // Initialize date range picker
            $('#ecommerce-dashboard-daterangepicker').daterangepicker({
                startDate: moment().subtract(1, 'days'), // Initial start date (7 days ago)
                endDate: moment(), // Initial end date (today)
                opens: 'right',
                ranges: {
                    'ALL': [moment(), moment()],
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            // Call the callback function initially to display the default date range
            cb(moment().subtract(7, 'days'), moment());
        });
    </script>
</body>
</html>
 -->


 