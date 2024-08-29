$(document).ready(function () {

  alert()
  var register_id = "";
  var code = "";
  var codedescription_table = "";
  // !  code description datatable   function
  // Function to initialize DataTable
  function initializeDataTable(data) {
    const codedescription_table = createDataTable(data);

    codedescription_table.columns().every(function (index) {
        const column = this;
        if (index < codedescription_table.columns().indexes().length - 1) {
            index === 2
                ? addDateColumnFilter(column)
                : addColumnFilter(column, index);
        }
    });

    handleSelectAllCheckboxEvents(codedescription_table);
    handleRowCheckboxEvents();
    handleDeleteButtonClickEvent(codedescription_table);
    updateTotalCountLabel(codedescription_table);
}

function createDataTable(data) {
    return $("#codedescription_table").DataTable({
        lengthMenu: [
            [15, 25, 50, -1],
            [15, 25, 50, "All"],
        ],
        fixedHeader: true,
        data: data,
        columns: [
            { data: "index_id" },
            { data: "code" },
            { data: "effective_date" },
            { data: "short_desc" },
            { data: "logn_desc" },
            { data: "classification" },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        '<div class="form-check"><label class="form-check-label"><center><input type="checkbox" class="row-checkbox form-check-input fileCheck" data-index="' +
                        row.index_id +
                        '"><i class="input-helper float-right"></i></center></label></div>'
                    );
                },
            },
        ],
        initComplete: function () {
            var table = $('#codedescription_table');

            // Append input fields and a checkbox to the table header
            table.find('thead').append(
                '<tr>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="date"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '</tr>'
            );

          
        },
    });
}

function addColumnFilter(column, index) {
  const select = $(
      '<select class="form-control searchable-dropdown dropdown-select" data-index="' + index + '"><option value=""></option></select>'
  )
      .appendTo("#codedescription_table th.filterRow:nth-child(" + (index + 1) + ")");

  select.select2({
      theme: "classic", // Adjust the theme as needed
      width: "100%",
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
  });
}

  
  
  function addDateColumnFilter(column) {
    const dateInput = $('<input type="date" class="">')
      .appendTo("#codedescription_table th.date")
      .on("input", function () {
        const val = $(this).val();
        const formattedDate = formatDate(val);
        column.search(formattedDate).draw();
      });
  }



  function updateTotalCountLabel(table) {
    const selectedCount = table.rows().count();
    $("#total-count-label").text("Total: " + selectedCount);
  }

  function handleSelectAllCheckboxEvents(table) {
    $("#select-all-checkbox").on("change", function () {
      handleSelectAllCheckbox(table);
      const selectedCount = $(this).prop("checked") ? table.rows().count() : 0;
      $("#selected-count-label").text("Selected All: " + selectedCount);
    });
  }

  function handleRowCheckboxEvents() {
    $(".row-checkbox").on("change", function () {
      updateSelectedCountLabel();
    });
  }

  function handleDeleteButtonClickEvent(table) {
    $("#delete-selected").on("click", function () {
      handleDeleteButtonClick(table);
    });
  }

  function formatDate(inputDate) {
    var dateParts = inputDate.split("-");
    if (dateParts.length === 3) {
      return dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
    }
    return inputDate;
  }

  // Function to handle Select All checkbox change
  function handleSelectAllCheckbox(table) {
    var checkboxes = $(".row-checkbox");
    checkboxes.prop("checked", $("#select-all-checkbox").prop("checked"));
    table
      .$(".row-checkbox")
      .prop("checked", $("#select-all-checkbox").prop("checked"));
  }

  // Function to update selected count label
  function updateSelectedCountLabel() {
    var selectedCount = $(".row-checkbox:checked").length;
    $("#selected-count-label").text("Selected :" + selectedCount);
  }

  // Function to handle the delete button click
  function handleDeleteButtonClick(table) {
    var selectedRows = [];

    if ($("#select-all-checkbox").prop("checked")) {
      table.rows().every(function () {
        selectedRows.push(this.data().index_id);
      });
    } else {
      $(".row-checkbox:checked").each(function () {
        selectedRows.push($(this).data("index"));
      });
    }

    if (selectedRows.length > 0) {
      performDeletion(selectedRows, table);
    } else {
      displayNoRowsSelectedMessage();
    }
    //updateSelectedCountLabel();
  }

  // Function to perform deletion
  // Function to perform deletion
  function performDeletion(selectedRows, table) {
    // Display confirmation alert with the count of selected rows
    swal
      .fire({
        title: "Are you sure?",
        text: `You are about to delete ${selectedRows.length} row(s).`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete.isConfirmed) {
          // If user confirms, proceed with the deletion
          executeDeletion(selectedRows, table);
        } else {
          // If user cancels, show a message
          // swal.fire('', 'Deletion canceled.', 'info');
        }
      });
  }

  // Function to execute the deletion after confirmation
  function executeDeletion(selectedRows, table) {
    $.ajax({
      url: "code_des/code_sql.php?action=codedescriptiontable_checkbox",
      method: "POST",
      data: { selectedRows: selectedRows },
      success: function (response) {
        handleDeleteResponse(response, table);
      },
      error: function (error) {
        console.error("Error deleting rows: ", error);
      },
    });
  }

  // Function to handle the response after deleting rows
  function handleDeleteResponse(response, table) {
    if (response == 1) {
      // Display success message using SweetAlert
      swal
        .fire(
          "",
          'Rows deleted   <b style="color:green;">Successfully</b>',
          "success"
        )
        .then((okay) => {
          if (okay) {
            window.location.replace("coder_dropdown.php");
          }
        });

      // Clear and redraw the DataTable after successful deletion
      table.clear().draw();
    } else {
      // Display error message using SweetAlert
      swal.fire(
        "",
        '   <b style="color:red;">Please Select Check </b> Box!',
        "error"
      );
    }
  }

  // Function to display a message when no rows are selected for deletion
  function displayNoRowsSelectedMessage() {
    swal.fire("", "Please select at least one row to delete!", "warning");
  }

  // Fetch data using AJAX and initialize DataTable
  $.getJSON(
    "code_des/code_sql.php?action=codedescriptiontable",
    initializeDataTable

   
  );

  // $.getJSON('code_des/code_sql.php?action=codedescriptiontable', function(data) {
  //      codedescription_table = $('#codedescription_table').DataTable({
  //         lengthMenu: [
  //             [15, 25, 50, -1],
  //             [15, 25, 50, 'All']
  //         ],
  //         fixedHeader: true,
  //         data: data,
  //         columns: [
  //             { data: 'index_id' },
  //             { data: 'code' },
  //             { data: 'effective_date' },
  //             { data: 'short_desc' },
  //             { data: 'logn_desc' },
  //             { data: 'classification' },
  //             {

  //                 data: null,
  //                 render: function (data, type, row) {
  //                  //return '<div class="form-check" style="text-align: center;"> <label class="form-check-label"> <input type="checkbox" class="row-checkbox form-check-input fileCheck" data-index="' + row.index_id + '"><i class="input-helper"></i></label> </div>';
  //                  return'<div class="form-check"> <label class="form-check-label"> <center><input type="checkbox" class=" row-checkbox  form-check-input fileCheck"  data-index="' + row.index_id + '"><i class="input-helper float-right"></i></center></label> </div> ';

  //                  // return '<center><input type="checkbox" class="row-checkbox" data-index="' + row.index_id + '"/></center>';
  //                 }

  //             }

  //         ]
  //     });
  //     codedescription_table.columns().every(function(index) {
  //         var column = this;

  //         // Check if it's not the last column before adding the dropdown
  //         if (index < codedescription_table.columns().indexes().length - 1) {
  //             var select = $('<select><option value="">All</option></select>')
  //                 .appendTo($(column.header()))
  //                 .on('change', function() {
  //                     var val = $.fn.dataTable.util.escapeRegex($(this).val());
  //                     column.search(val ? '^' + val + '$' : '', true, false).draw();
  //                 });

  //             column.data().unique().sort().each(function(d, j) {
  //                 select.append('<option value="' + d + '">' + d + '</option>');
  //             });
  //         }
  //     });
  //     $('#select-all-checkbox').on('change', function () {
  //         var checkboxes = $('.row-checkbox');
  //         checkboxes.prop('checked', $(this).prop('checked'));
  //         codedescription_table.$('.row-checkbox').prop('checked', $(this).prop('checked'));
  //         updateSelectedCountLabel();
  //     });

  //     // Function to update selected count label
  //     function updateSelectedCountLabel() {
  //         var selectedCount = $('.row-checkbox:checked').length;
  //         $('#selected-count-label').text(selectedCount + ' selected');
  //     }

  //     // Function to handle the delete button click
  //     $('#delete-selected').on('click', function () {
  //         // Array to store indices of selected rows
  //         var selectedRows = [];

  //         // Check if the "Select All" checkbox is checked
  //         if ($('#select-all-checkbox').prop('checked')) {
  //             // If checked, delete all rows
  //             codedescription_table.rows().every(function () {
  //                 selectedRows.push(this.data().index);
  //             });
  //         } else {
  //             // If not checked, delete only selected rows
  //             $('.row-checkbox:checked').each(function () {
  //                 selectedRows.push($(this).data('index'));
  //             });
  //         }

  //         // Check if any row is selected
  //         if (selectedRows.length > 0) {
  //             // Perform deletion based on selectedRows array
  //             $.ajax({
  //                 url: 'code_des/code_sql.php?action=codedescriptiontable_checkbox',
  //                 method: 'POST',
  //                 data: { selectedRows: selectedRows },
  //                 success: function (response) {
  //                     console.log(response);

  //                     if (response == 1) {
  //                         // Display success message using SweetAlert
  //                         swal.fire(
  //                             '',
  //                             'Rows deleted   <b style="color:green;">Successfully</b>',
  //                             'success'
  //                         ).then(okay => {
  //                             if (okay) {
  //                                 window.location.replace("coder_dropdown.php");
  //                             }
  //                         });

  //                         // Clear and redraw the DataTable after successful deletion
  //                         codedescription_table.clear().draw();
  //                     } else {
  //                         // Display error message using SweetAlert
  //                         swal.fire(
  //                             '',
  //                             '   <b style="color:red;">Please Select Check </b> Box!',
  //                             'error'
  //                         );
  //                     }
  //                 },
  //                 error: function (error) {
  //                     console.error('Error deleting rows: ', error);
  //                 }
  //             });
  //         } else {
  //             // If no rows are selected, display a message
  //             swal.fire(
  //                 '',
  //                 'Please select at least one row to delete!',
  //                 'warning'
  //             );
  //         }
  //     });
  //       // Delete selected rows
  //     $('#delete-selected').on('click', function () {
  //         var selectedRows = [];
  //         $('.row-checkbox:checked').each(function () {
  //             selectedRows.push($(this).data('index'));
  //         });

  //         // Perform deletion based on selectedRows array
  //         // Replace the following line with your actual AJAX call for deletion
  //         $.ajax({
  //             url: 'code_des/code_sql.php?action=codedescriptiontable_checkbox',
  //             method: 'POST',
  //             data: { selectedRows: selectedRows },
  //             success: function (response) {
  //                 console.log(response);
  //                 // After successful deletion, redraw the DataTable

  //                 //console.log(response);

  //                 if(response==1){
  //                     swal.fire(
  //                 '',
  //                 'Rows deleted   <b style="color:green;">Successfully</b>',
  //                 'success'
  //                 ).then(okay => {
  //                 if (okay) {
  //                     window.location.replace("coder_dropdown.php");
  //                     //window.location.reload();
  //                 }
  //                 }) ;
  //                 codedescription_table.clear().draw();
  //                 }

  //                 else{
  //                     swal.fire(
  //                 '',
  //                 '   <b style="color:red;">Please Select Check </b> Box!',
  //                 'error'
  //                 ) ;

  //                 }

  //             },
  //             error: function (error) {
  //                 console.error('Error deleting rows: ', error);
  //             }
  //         });
  //     });

  // codedescription_table.columns().every(function(index) {
  //     var column = this;
  //     var select = $('<select><option value=""></option></select>')
  //         .appendTo($(column.header()))
  //         .on('change', function() {
  //             var val = $.fn.dataTable.util.escapeRegex($(this).val());
  //             column.search(val ? '^' + val + '$' : '', true, false).draw();
  //         });

  //     column.data().unique().sort().each(function(d, j) {
  //         select.append('<option value="' + d + '">' + d + '</option>');
  //     });
  // });
  // Add individual column filtering
  // codedescription_table.columns().every(function() {
  //     var column = this;
  //     var select = $('<select><option value=""></option></select>')
  //         .appendTo($(column.header()))
  //         .on('change', function() {
  //             var val = $.fn.dataTable.util.escapeRegex($(this).val());
  //             column.search(val ? '^' + val + '$' : '', true, false).draw();
  //         });

  //     column.data().unique().sort().each(function(d, j) {
  //         select.append('<option value="' + d + '">' + d + '</option>');
  //     });
  // });

  // Function to update the label with the count of selected checkboxes

  $("#csvsampledbtn").click(function () {
    // Assuming the server-side script that generates the CSV file is named 'generate_csv.php'
    var csvFileUrl = "code_des/code_sql.php?action=csvfiledownload";

    // Use Ajax to fetch the CSV file
    $.ajax({
      url: csvFileUrl,
      type: "GET",
      dataType: "text",
      success: function (data) {
        // Create a Blob from the CSV data
        var blob = new Blob([data], { type: "text/csv" });

        // Create a link element to trigger the download
        var link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "sample.csv";

        // Append the link to the document and trigger the click event
        document.body.appendChild(link);
        link.click();

        // Remove the link element
        document.body.removeChild(link);
      },
      error: function (error) {
        console.error("Error fetching CSV file:", error);
      },
    });
  });
  // Add event listeners for individual column search
  $("#search_index_id").on("keyup", function () {
    codedescription_table.columns(0).search(this.value).draw();
  });

  //! coder description  submit function
  $("#codedesFrom").submit(function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Get form data
    var formData = $(this).serialize();

    // AJAX request
    $.ajax({
      type: "POST",
      url: "code_des/code_sql.php?action=code_description", // Specify your PHP script URL
      data: formData,
      success: function (data) {
        // Handle success, you can display a message or perform other actions
        //console.log(response);
        console.log(data);
        var response = JSON.parse(data);
        if (response == 1) {
          swal
            .fire(
              "",
              'Code Description Added <b style="color:green;">Successfully</b>',
              "success",
              4000
            )
            .then((okay) => {
              if (okay) {
                window.location.replace("coder_dropdown.php");
                //window.location.reload();
              }
            });
        } else {
          swal.fire(
            "",
            'Record Already  <b style="color:red;"> Exists</b> !',
            "error"
          );
        }
      },
      error: function (error) {
        // Handle error, display an error message, or perform other actions
        //console.log("Error: " + error);
      },
    });
  });
  function refreshPage() {
    // Redirect to the same page using JavaScript
    window.location.href = window.location.href;
  }
  $("#refreshBtn").on("click", function () {
    refreshPage();
  });
  // ! code description  bulk upload function
  $("#uploadCsvBtn").on("click", function () {
    var formData = new FormData($("#csvUploadForm")[0]);
    //alert(formData);

    $.ajax({
      type: "POST",
      url: "code_des/code_sql.php?action=file_upload",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data);
        // alert(data);
        if (data == "") {
          swal.fire(
            "",
            'File already exists. Please choose a <b style="color:red;"> different file</b> !',
            "error"
          );
        } else {
          swal
            .fire(
              "",
              'CSV file has been uploaded <b style="color:green;">Successfully</b>',
              "success",
              4000
            )
            .then((okay) => {
              if (okay) {
                window.location.replace("coder_dropdown.php");
                //window.location.reload();
              }
            });
        }
      },
    });
  });
});
