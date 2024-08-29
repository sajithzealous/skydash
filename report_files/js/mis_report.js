$(document).ready(function() {
    // Fetch data and initialize DataTable after data is fetched
    // datapicking();

        var dateValues = $('#datepicker2').val().split("-");
        var fromdate = new Date(dateValues[0]).toLocaleDateString("en-CA");
        var todate = new Date(dateValues[1]).toLocaleDateString("en-CA");
        if(fromdate != 'Invalid Date')
        {
            datadisplaytable(fromdate,todate);
        }

});

$('#datepicker2').on("change",function(){

    var dateValues = $(this).val().split("-");
    var fromdate = new Date(dateValues[0]).toLocaleDateString("en-CA");
    var todate = new Date(dateValues[1]).toLocaleDateString("en-CA");
    $("#report").DataTable().destroy();
 
    $('#report thead tr:nth-child(2)').remove();
  
    if(fromdate != 'Invalid Date')
    {
        datadisplaytable(fromdate,todate);
    
      
    }
    // dataexport();

});



// Function to fetch and display user data
function datadisplaytable(fromdate, todate) {
    fetch('report_files/mis_report.php?start_date='+fromdate+'&end_date='+todate)
        .then(response => response.json())
        .then(data => {
            // Populate table with fetched data
            initializeDataTable(data);
         

            console.log(data);

            // Access log_time property from the fetched data



        })  
        .catch(error => console.error('Error fetching data:', error));
}

function initializeDataTable(data,logTime) {
    const user_table = createDataTable(data,logTime);
  
    

    user_table.columns().every(function (index) {
        const column = this;
        console.log(column)
        return addColumnFilter(column, index, user_table);
        // if (index < user_table.columns().indexes().length - 1) {
        //     return index === 13
        //         ? addDateColumnFilter(column)
        //         : addColumnFilter(column, index);
        // }
    });
}

function createDataTable(data) {
return $("#report").DataTable({
        paging: true,
        ordering: false,
        searching: true,
        
        dom: '<"top"ilfp>rt<"clear">',
        info: true,
        responsive: true,
        lengthMenu: [
            [15, 25, 50, -1],
            [15, 25, 50, "All"],
        ],
        order: [[0, "asc"]],
        language: {
          lengthMenu: "Show _MENU_ entries",
          info: "Showing _START_ to _END_ of _TOTAL_ entries",
          search: "Search:",
          paginate: {
            first: "First",
            previous: "Previous",
            next: "Next",
            last: "Last",
          },
        },
        scrollY: true, // Set the height for scrollable content
        scrollX: true, // Enable horizontal scrolling
        scrollCollapse: true,
        fixedHeader: true,
        data: data,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'custom-excel-button'
            },
            {
                extend: 'csv',
                className: 'custom-csv-button'
            }
        ],

        // stateSave: true,
      
        
        columns: [

            
            { 
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1; // Render the row number as serial number
                }
            },

           
           
            { data: "patient_name" },
            { data: "mrn" },
            { data: "insurance_type" },
            { data: "assesment_date" }, 
            { data: "assesment_type" }, 
            { data: "status" },
            { data: "agency" },
            { data: "alloted_to_coder" },
            { data: "coder_emp_id" },
            { data: "qc_person" },
            { data: "qc_person_emp_id" },
            { data: "totalcasemix" },
    
            
            {
                // Add a column for buttons
                
                    data: "status",
                    render: function (data, type, row) {
                        if (data === "QC COMPLETED") {
                            return '<a class="btn btn-success flow" onclick="view_worked_files(' + row.Id + ')">QC View</a>';
                        } else if (data === "APPROVED") {
                            return'<a class="btn btn-success flow" onclick="view_worked_files(' + row.Id + ')">QC View</a>'+
                            '<a class="btn btn-primary flow" onclick="final_preview(' + row.Id + ')">Approved File</a>';
                        } else {
                            return ''; // Empty if status is neither "qc completed" nor "approved"
                        }
                    }
                
            }
        ],
        initComplete: function () {
            var table = $('#report');
            // initializeDataTable(data);

            // Append input fields and a checkbox to the table header
            table.find('thead').append(
                '<tr>' +
                '<th class=""></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '</tr>'
            );
            
        },
    });

}

function addColumnFilter(column, index, user_table) {
    const select = $(
        '<select class="form-control searchable-dropdown dropdown-select"   data-index="' + index + '"><option value=""></option></select>'
    )
        .appendTo("#report th.filterRow:nth-child(" + (index + 1) + ")");

    select.select2({
        theme: "bootstrap",
        width: "100%",
        height:"100%",
        placeholder: "Search...",
        allowClear: true
    });

    column
        .data()
        .unique()
        .sort()
        .each(function (d, j) {
            select.append('<option value="' + d + '">' + d + '</option>');
        });

    // Trigger change event to apply initial filtering
    select.on('change', function () {
        const val = $.fn.dataTable.util.escapeRegex($(this).val());
        column.search(val ? "^" + val + "$" : "", true, false).draw();
        console.log(1)
    user_table.columns().every(function (index) {
        const column = this;
        console.log(column)
        return addColumnFilter(column, index, user_table);
        // if (index < user_table.columns().indexes().length - 1) {
        //     return index === 13
        //         ? addDateColumnFilter(column)
        //         : addColumnFilter(column, index);
        // }
    });
    
    });
}

function addDateColumnFilter(column) {
    const dateInput = $('<input type="date" class="">')
        .appendTo("#report th.date") // Corrected selector
        .on("input", function () {
            const val = $(this).val();
            const formattedDate = formatDate(val);
            column.search(formattedDate).draw();
        });
}

function view_worked_files(Id) {
    // Set a cookie with the ID (optional, if needed in PHP)
    document.cookie = `Id=${Id}; path=/`;

    var urlStr = "qc_single_preview.php generate_pdf.php";
    console.log("URL String:", urlStr); // Debugging line

    var urls = urlStr.trim().split(" ");

    console.log("URLs after split:", urls); // Debugging line

    urls.forEach((url) => {
        console.log("1");
        if (url.trim() !== "") {
            setTimeout(() => {
                window.open(url, "_blank");
            }, 100);
        }
    });
}

function final_preview(Id) {
    // Set a cookie with the ID (optional, if needed in PHP)
    document.cookie = `Id=${Id}; path=/`;

    window.open("final_preview.php", "_blank");
}

function formatDate(dateString) {
    // Add your logic to format the date string as needed
    return dateString;
}


