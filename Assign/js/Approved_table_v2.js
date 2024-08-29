$(document).ready(function () {

   Approvedtable();
  Assign_data_coder();
});

function Approvedtable() {
  // var pageSize = 10; // Number of entries per page

  var table = $("#Approved_table").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "Assign/Approved_get_process_v2.php",
      type: "GET",
      data: function (d) {
        // Adding pagination parameters to the request
        d.page = Math.ceil(d.start / d.length) + 1;
        d.length = d.length;
      },
      dataSrc: function (json) {
        console.log("Data from server:", json);
        return json.data;
      },
      error: function (xhr, error, thrown) {
        console.error("Error in fetching data: ", xhr.responseText);
      },
    },
    paging: true,
    ordering: true,
    searching: true,
    info: true,
    responsive: true,
    lengthMenu: [10, 25, 50, 100],
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
    scrollY: "500px",
    scrollX: true,
    scrollCollapse: true,
    fixedHeader: true,
    columns: [
      {
        title: "#",
        data: "Id",
        render: function (data, type, row) {
          return (
            '<div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input fileCheck" name="File" value="' +
            data +
            '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div>'
          );
        },
       
      },
      { title: "Id", data: "Id" },
      { title: "Patient Name", data: "patient_name" },
      { title: "MRN", data: "mrn" },
      { title: "Insurance Type", data: "insurance_type" },
      { title: "Assesment Date", data: "assesment_date" },
      { title: "Assesment Type", data: "assesment_type" },
      { title: "Agency", data: "agency" },
      { title: "Priority", data: "priority" },
      { title: "Status", data: "status" },
      { title: "Assigned coder", data: "alloted_to_coder" },
      { title: "Coded Date", data: "AssignCoder_date" },
      { title: "Qc person", data: "qc_person" },
      { title: "Alloted to qc Date", data: "qc_date" },
      { title: "Audited Date", data: "qc_completed_date" },
      { title: "Completed Date", data: "file_completed_date" },
      { title: "Coder Comments", data: "coder_comments" },
      { title: "Client Comments", data: "client_comments" },
      { title: "Agency Comments", data: "agency_comments" },
      {
        title: "Chart",
        data: "url",
        render: function (data, type, row) {
          return (
            '<button class="btn btn-primary" onclick="window.open(\'' +
            data +
            "', '_blank')\">View Chart</button>"
          );
        },
       
      },
      {
        title: "Worked Files",
        data: "Id",
        render: function (data, type, row) {
          return (
            '<a class="btn btn-success flow" onclick="view_worked_files(' +
            data +
            ')">QC View</a>'
          );
        },
        
      },
      {
        title: "Approved Files",
        data: "Id",
        render: function (data, type, row) {
          return (
            '<a class="btn btn-primary flow" onclick="final_preview(' +
            data +
            ')">Approved File</a>'
          );
        },
       
      },
    ],
  });

  $("#loading").hide();

  // Function to format date in 'MMM D, YYYY' format
  function formatDate(dateString) {
    var dateObj = new Date(dateString);
    return dateObj.toLocaleDateString("en-US", {
      month: "short",
      day: "numeric",
      year: "numeric",
    });
  }

  // Function to render status view
  function renderStatusView(item) {
    var currentDate = luxon.DateTime.now().setZone("America/New_York");
    var logDate = luxon.DateTime.fromFormat(
      item.log_time,
      "yyyy-MM-dd HH:mm:ss",
      { zone: "America/New_York" }
    );
    var daysDifference = Math.round(currentDate.diff(logDate, "days").days);

    var status_view;
    if (
      item.status === "ASSIGNED BY TEAM" ||
      item.status === "REASSIGNED BY TEAM"
    ) {
      switch (daysDifference) {
        case 0:
          status_view = '<div class="d-flex">New</div>';
          break;
        case 1:
          status_view =
            '<div class="d-flex" title="1 Day File"><span class="dot-circle" style="background-color: blue;"></span><span style="color: black; font-weight: bold;">New</span></div>';
          break;
        case 2:
          status_view =
            '<div class="d-flex" title="2 Days File"><span class="dot-circle" style="background-color: yellow;"></span><span style="color: black; font-weight: bold;">New</span></div>';
          break;
        default:
          status_view =
            daysDifference <= 30
              ? '<div class="d-flex" title="High-Priority"><span class="dot-circle" style="background-color: red;"></span><span style="color: black; font-weight: bold;">New</span></div>'
              : '<div class="d-flex" title="Very High-Priority"><span class="dot-circle" style="background-color: purple;"></span><span style="color: black; font-weight: bold;">New</span></div>';
      }
    } else {
      status_view =
        '<div class="d-flex"><span class="mt-2">' +
        item.status +
        "</span></div>";
    }

    return status_view;
  }

  // Custom rendering for columns that require formatting
  table.on("draw", function () {
    var data = table.rows().data();
    data.each(function (item, index) {
      var formattedDate = formatDate(item.assesment_date);
      var statusView = renderStatusView(item);

      // Update row data with formatted values
      var rowData = $.extend({}, item, {
        assesment_date: formattedDate,
        status: statusView,
      });

      // Update the table row
      table.row(index).data(rowData).invalidate();
    });
  });
}


//assign and reassign data to qc coder
function Assign_data_coder() {
  $("#Approved_assign").click(function () {
    var coderSelect = $("input[name='Coder']:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    if (coderSelect.length > 1) {
      Swal.fire({
        title: "Warning",
        text: "You can assign only one coder for files!",
        icon: "warning",
        confirmButtonText: "OK",
      });
      return;
    }
    var coder = $("input[name='Coder']:checked").val();
    console.log("coder:", coder);

    var checkedValues = Array.from(selectedFiles);
    console.log("checkedValues fd", checkedValues);

    console.log("filecheck count", checkedValues.length);
    if (checkedValues.length > 0 && coder) {
      console.log(coder.length);
      $.ajax({
        type: "POST",
        url: "Assign/reassign_coder_process.php",
        data: { File_Id: checkedValues.join(","), coder: coder },
        success: function (data) {
          // console.log("Res", data);
          var responses = JSON.parse(data); // Parse the JSON received from PHP
          // console.log(responses[0].message);
          if (responses[0].message == "reassign") {
            Swal.fire({
              title: "Are you sure?",
              text: "You want to reassign the file to a new coder?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, Reassign it!",
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  type: "POST",
                  url: "Assign/Team_assign_process.php",
                  data: { File_Id: checkedValues.join(","), coder: coder },
                  success: function (data) {
                    // console.log("Raw JSON response:", data);

                    try {
                      var responses = JSON.parse(data);

                      responses.forEach(function (response) {
                        if (response.success) {
                          // console.log(response.message);
                          Swal.fire({
                            title: "Success!",
                            text: response.message + "(" + coder + ")",
                            icon: "success",
                            confirmButtonText: "OK",
                          }).then(function () {
                            Approvedtable();
                            $("input[name='Coder']").prop("checked", false);
                          });
                        } else {
                          console.log(response.error);
                          Swal.fire({
                            title: "Error",
                            text: response.error,
                            icon: "error",
                            confirmButtonText: "OK",
                          });
                        }
                      });
                    } catch (error) {
                      console.error("Error parsing JSON:", error);
                      Swal.fire({
                        title: "Error",
                        text: "Invalid response from server",
                        icon: "error",
                        confirmButtonText: "OK",
                      });
                    }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", errorThrown);
                    Swal.fire({
                      title: "Error",
                      text: "An error occurred while processing the request",
                      icon: "error",
                      confirmButtonText: "OK",
                    });
                  },
                });
              }
            });
          } else {
            responses.forEach(function (response) {
              if (response.success) {
                // console.log(response.message);
                Swal.fire({
                  title: "Success!",
                  text: response.message + "(" + coder + ")",
                  icon: "success",
                  confirmButtonText: "OK",
                }).then(function () {
                  Approvedtable();
                  $("input[name='Coder']").prop("checked", false);
                });
              } else {
                console.log(response.error);
                Swal.fire({
                  title: "Error",
                  text: response.error + "(" + coder + ")",
                  icon: "error",
                  confirmButtonText: "OK",
                });
              }
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        },
      });
    } else {
      Swal.fire({
        title: "Error",
        text: "Please choose both 'File' and 'Coder'.",
        icon: "error",
        confirmButtonText: "OK",
      });
    }
  });
}

function final_preview(Id) {
  // Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

  window.open("final_preview.php", "_blank");
}
