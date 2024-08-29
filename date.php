  <!DOCTYPE html>
<html lang="en">
<head>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Moment.js -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>

<!-- DateRangePicker -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


</head>
<body>


<!-- Your custom script -->
<script>
   
    $(document).ready(function() {
        function updateDateRange(start, end) {
            $('#ecommerce-dashboard-daterangepicker').html(`${start.format('MMMM D, YYYY')} - ${end.format('MMMM D, YYYY')}`);
        }

        $('#ecommerce-dashboard-daterangepicker').daterangepicker({
            startDate: moment().subtract(1, 'days'),
            endDate: moment(),
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
        }, updateDateRange);

        updateDateRange(moment().subtract(7, 'days'), moment());
    });
 
</script>


<div id="ecommerce-dashboard-daterangepicker" class="custom-daterangepicker">CLICK</div>
<!-- <div id="ecommerce-dashboard-daterangepicker" class="custom-daterangepicker">CLICK</div> -->

 </body>



 