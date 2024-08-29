$(document).ready(function() {

    var currentDate = new Date();
    var options = {
      month: '2-digit',
      day: '2-digit',
      year: 'numeric',
      timeZone: 'America/New_York',  
    };
    var formattedDate = currentDate.toLocaleDateString('en-US', options);

    function updateDateRange(start, end, targetElement) {
        const startDateFormatted = start.format('MM/DD/YYYY hh:mm A');
        const endDateFormatted = end.format('MM/DD/YYYY hh:mm A');
        $(targetElement).html(`${startDateFormatted} - ${endDateFormatted}`);
    }

    function initializeDateRangePicker(targetElement) {
        const startDate = moment(formattedDate, 'MM/DD/YYYY');
        const endDate = moment(formattedDate, 'MM/DD/YYYY');

        $(targetElement).daterangepicker({
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
        }, function(start, end) {
            updateDateRange(start, end, targetElement);
        });

        updateDateRange(startDate, endDate, targetElement);
    }

    // Initialize date range pickers
    initializeDateRangePicker('#ecommerce-dashboard-daterangepicker');
    initializeDateRangePicker('#datepicker1');
    initializeDateRangePicker('#datepicker2');
});
