$(document).ready(function() {

    var currentDate = new Date();
    var options = {
        month: '2-digit',
        day: '2-digit',
        year: 'numeric',
        timeZone: 'America/New_York', // Data stored in New York time zone
    };
    var formattedDateNY = currentDate.toLocaleDateString('en-US', options);
    var formattedDateIST = moment.tz(formattedDateNY, 'MM/DD/YYYY', 'America/New_York').clone().tz('Asia/Kolkata').format('MM/DD/YYYY');

    function updateDateRange(start, end, targetElement) {
        const startDateFormatted = start.clone().tz('Asia/Kolkata').format('MM/DD/YYYY hh:mm A');
        const endDateFormatted = end.clone().tz('Asia/Kolkata').format('MM/DD/YYYY hh:mm A');
        $(targetElement).html(`${startDateFormatted} - ${endDateFormatted}`);
    }

    function initializeDateRangePicker(targetElement) {
        const startDateNY = moment.tz(formattedDateNY, 'MM/DD/YYYY', 'America/New_York');
        const endDateNY = moment.tz(formattedDateNY, 'MM/DD/YYYY', 'America/New_York');

        $(targetElement).daterangepicker({
            startDate: startDateNY,
            endDate: endDateNY,
            timePicker: true,
            timePicker24Hour: true,
            opens: 'right',
            ranges: {
                'ALL': [moment().startOf('year').tz('America/New_York'), moment().endOf('year').tz('America/New_York')],
                'Today': [moment(startDateNY), moment(endDateNY)],
                'Yesterday': [moment(startDateNY).subtract(1, 'days').endOf('day'), moment(endDateNY).subtract(1, 'days').endOf('day')],
                'Last 7 Days': [moment(startDateNY).subtract(6, 'days'), moment(endDateNY)],
                'Last 30 Days': [moment(startDateNY).subtract(29, 'days'), moment(endDateNY)],
                'This Month': [moment(startDateNY).startOf('month'), moment(endDateNY).endOf('month')],
                'Last Month': [moment(startDateNY).subtract(1, 'month').startOf('month'), moment(endDateNY).subtract(1, 'month').endOf('month')]
            }
        }, function(start, end) {
            updateDateRange(start, end, targetElement);
        });

        updateDateRange(startDateNY, endDateNY, targetElement);
    }

    // Initialize date range pickers
    initializeDateRangePicker('#ecommerce-dashboard-daterangepicker');
    initializeDateRangePicker('#datepicker1');
    initializeDateRangePicker('#datepicker2');
});
