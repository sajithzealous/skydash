$(document).ready(function () {
  Qc_c();

 
});

 // GET FUNCTION QA file
 function Qc_c() {
  $.ajax({
    url: "QA/qc_c_process.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log(data);
      var role_user = data[0].role;
      // console.log("Role:", role_user);
      // TEAMLEADER TABLE

      if (role_user == "QA" || role_user == "superadmin") {
        var table;

        if (!$.fn.DataTable.isDataTable("#qc_c")) {
          // Initialize DataTable

          table = $("#qc_c").DataTable({
            paging: true,
            ordering: true,
            searching: true,
            info: true,
            responsive: true,
            lengthMenu: [10, 25, 50, 100],
            pageLength: 10,
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
            scrollY: "500px", // Set the height for scrollable content
            scrollX: true, // Enable horizontal scrolling
            scrollCollapse: true, // Enable table scrolling
            fixedHeader: true, // Enable fixed header
            columns: [
              // { title: "#" },
              { title: "Id" },
              { title: "Patient Name" },
              { title: "MRN" },
              { title: "Insurance Type" },
              { title: "Assesment Date" },
              { title: "Assesment Type" },
              { title: "Agency" },
              { title: "Priority" },
              { title: "Status" },
              { title: "Chart" },
              { title: "View" },
            ],
          });

          // Other DataTable setup...
        } else {
          // Use the existing reference
          table = $("#qc_c").DataTable();
        }

        // Clear the existing data
        if (table) {
          table.clear().draw();
        }

        table.clear().draw();

        if (data.length === 0) {
          $("#no-data-message").show();
        } else {
          $("#no-data-message").hide();

          function addRowToTable(item) {
            let dateString = item.assesment_date;
            let dateObj = new Date(dateString);
            let formattedDate = dateObj.toLocaleDateString("en-US", {
              month: "short",
              day: "numeric",
              year: "numeric",
            });

            var currentDate =
              luxon.DateTime.now().setZone("America/New_York");

            var fDate = currentDate.toFormat("yyyy-MM-dd HH:mm:ss");

            var logDate = luxon.DateTime.fromFormat(
              item.log_time,
              "yyyy-MM-dd HH:mm:ss",
              { zone: "America/New_York" }
            );

            var daysDifference = Math.round(
              currentDate.diff(logDate, "days", { zone: "America/New_York" })
                .days
            );

            var status_view;

            if (
              item.status === "ASSIGNED BY TEAM" ||
              item.status === "REASSIGNED BY TEAM"
            ) {
              switch (daysDifference) {
                case 0:
                  status_view = '<div class="d-flex" >New</div>';
                  break;
                case 1:
                  status_view =
                    '<div class="d-flex" title="1 Days File"><span class="dot-circle" style="background-color: blue;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                  break;
                case 2:
                  status_view =
                    '<div class="d-flex" title="2 Days File"><span class="dot-circle" style="background-color: yellow;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                  break;
                default:
                  if (daysDifference <= 30) {
                    status_view =
                      '<div class="d-flex" title="High-Priority"><span class="dot-circle" style="background-color: red;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                  } else {
                    // Set a different status view for cases where daysDifference is greater than 30
                    status_view =
                      '<div class="d-flex" title="Very High-Priority"><span class="dot-circle" style="background-color: purple;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                  }
                  break;
              }
            } else {
              status_view =
                '<div class="d-flex"><span class="mt-2">' +
                item.status +
                "</span></div>";
            }

            // var checkbox =
            //   ' </div><div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input fileCheck" name="File" value="' +
            //   item.Id +
            //   '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div>';
            var urlButton =
              '<button class="btn btn-primary" onclick="window.open(\'' +
              item.url +
              "', '_blank')\">View Chart</button>";
              var worked_files = "";

              worked_files =
                '<a class="btn btn-success flow" onclick="view_worked_files(' +
                item.Id +
                ')">QC View</a>';
            var Mrn =
              item.mrn === ""
                ? '<td class="font-weight-medium"><div class="badge badge-danger edit" data-id="' +
                  item.Id +
                  '" data-toggle="modal" data-target=".bd-example-modal-md-edit">Add Mrn</div></td>'
                : '<td class="font-weight-medium"><div class="badge badge-success">' +
                  item.mrn +
                  "</div></td>";

            table.row
              .add([
                item.Id,
                item.patient_name,
                Mrn,
                item.insurance_type,
                formattedDate,
                item.assesment_type,
                item.agency,
                item.priority,
                status_view,
                urlButton,
                worked_files,
              ])
              .draw();

            // MRN EDIT
            $(".edit").click(function () {
              var Id = $(this).data("id");
              Mrn_edit(Id);
            });
          }

          // Use the function inside your forEach loop
          data.forEach(function (item) {
            addRowToTable(item);
          });

          // FILE CHECKED COUNT
          // Set initial count to 0

          // Handle the change event on a parent element that exists initially
          $(document).on("change", ".fileCheck", function () {
            var checkedValues = $("input[name='File']:checked")
              .map(function () {
                return $(this).val();
              })
              .get();

            // Update the count of checked values
            count = checkedValues.length;
            // console.log("Number of Checked Values: " + count);
            $("#checkedFilesCount").html(
              '<label class="badge badge-info">' + count + "</label>"
            );
          });

          // SEPARATE FILTER FUNCTION

          $("#search").click(function () {
            // Statuses
            var selectedStatuses = $("input[name='Status']:checked")
              .map(function () {
                return $(this).val();
              })
              .get();

            // console.log(selectedStatuses);
            (new_status_for_team = "ASSIGNED BY TEAM"), "REASSIGNED BY TEAM";
            // Create a new array to store modified statuses
            var modifiedStatuses = selectedStatuses.map(function (status) {
              if (status === "NEW") {
                return new_status_for_team; // Change 'NEW' to 'ASSIGNED BY TEAM'
              } else {
                return status; // Keep other statuses unchanged
              }
            });

            // console.log(modifiedStatuses);

            // Coder
            var selectedCoder = $("input[name='Coder']:checked")
              .map(function () {
                return $(this).val();
              })
              .get();

            var postData = {
              Statuses: JSON.stringify(modifiedStatuses),
              Coder: JSON.stringify(selectedCoder),
            };

            // console.log(postData);

            $.ajax({
              type: "POST",
              url: "table/process1.php",
              data: postData,
              success: function (items) {
                // console.log(items);
                table.clear().draw(); // Clear existing table data

                if (Array.isArray(items)) {
                  items.forEach(function (row) {
                    addRowToTable(row);
                  });
                } else {
                  addRowToTable(items); // Handle single row insertion here
                }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                console.error(errorThrown);
              },
            });
          });
        }
      }

      else if (role_user == "TeamLeader" || role_user == "superadmin" || role_user == "QaTl") {
        var table;

        if (!$.fn.DataTable.isDataTable("#qc_c")) {
          // Initialize DataTable

          table = $("#qc_c").DataTable({
            paging: true,
            ordering: true,
            searching: true,
            info: true,
            responsive: true,
            lengthMenu: [10, 25, 50, 100],
            pageLength: 10,
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
            scrollY: "500px", // Set the height for scrollable content
            scrollX: true, // Enable horizontal scrolling
            scrollCollapse: true, // Enable table scrolling
            fixedHeader: true, // Enable fixed header
            columns: [
              // { title: "#" },
              { title: "Id" },
              { title: "Patient Name" },
              { title: "MRN" },
              { title: "Insurance Type" },
              { title: "Assesment Date" },
              { title: "Assesment Type" },
              { title: "Agency" },
              { title: "Alloted To Coder" },
              { title: "Coded Date" },
              { title: "Qc Coder" },
              { title: "Alloted To Qc Date" },
              { title: "Audited Date" },
              { title: "Priority" },
              { title: "Status" },
              { title: "Chart" },
              { title: "View" },
            ],
          });

          // Other DataTable setup...
        } else {
          // Use the existing reference
          table = $("#qc_c").DataTable();
        }

        // Clear the existing data
        if (table) {
          table.clear().draw();
        }

        table.clear().draw();

        if (data.length === 0) {
          $("#no-data-message").show();
        } else {
          $("#no-data-message").hide();

          function addRowToTable(item) {
            let dateString = item.assesment_date;
            let dateObj = new Date(dateString);
            let formattedDate = dateObj.toLocaleDateString("en-US", {
              month: "short",
              day: "numeric",
              year: "numeric",
            });

            var currentDate =
              luxon.DateTime.now().setZone("America/New_York");

            var fDate = currentDate.toFormat("yyyy-MM-dd HH:mm:ss");

            var logDate = luxon.DateTime.fromFormat(
              item.log_time,
              "yyyy-MM-dd HH:mm:ss",
              { zone: "America/New_York" }
            );

            var daysDifference = Math.round(
              currentDate.diff(logDate, "days", { zone: "America/New_York" })
                .days
            );

            var status_view;

            if (
              item.status === "ASSIGNED BY TEAM" ||
              item.status === "REASSIGNED BY TEAM"
            ) {
              switch (daysDifference) {
                case 0:
                  status_view = '<div class="d-flex" >New</div>';
                  break;
                case 1:
                  status_view =
                    '<div class="d-flex" title="1 Days File"><span class="dot-circle" style="background-color: blue;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                  break;
                case 2:
                  status_view =
                    '<div class="d-flex" title="2 Days File"><span class="dot-circle" style="background-color: yellow;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                  break;
                default:
                  if (daysDifference <= 30) {
                    status_view =
                      '<div class="d-flex" title="High-Priority"><span class="dot-circle" style="background-color: red;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                  } else {
                    // Set a different status view for cases where daysDifference is greater than 30
                    status_view =
                      '<div class="d-flex" title="Very High-Priority"><span class="dot-circle" style="background-color: purple;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                  }
                  break;
              }
            } else {
              status_view =
                '<div class="d-flex"><span class="mt-2">' +
                item.status +
                "</span></div>";
            }

            // var checkbox =
            //   ' </div><div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input fileCheck" name="File" value="' +
            //   item.Id +
            //   '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div>';
            var urlButton =
              '<button class="btn btn-primary" onclick="window.open(\'' +
              item.url +
              "', '_blank')\">View Chart</button>";
              var worked_files = "";

              worked_files =
                '<a class="btn btn-success flow" onclick="view_worked_files_tl(' +
                item.Id +
                ')">QC View</a>';
            var Mrn =
              item.mrn === ""
                ? '<td class="font-weight-medium"><div class="badge badge-danger edit" data-id="' +
                  item.Id +
                  '" data-toggle="modal" data-target=".bd-example-modal-md-edit">Add Mrn</div></td>'
                : '<td class="font-weight-medium"><div class="badge badge-success">' +
                  item.mrn +
                  "</div></td>";

            table.row
              .add([
                item.Id,
                item.patient_name,
                Mrn,
                item.insurance_type,
                formattedDate,
                item.assesment_type,
                item.agency,
                item.alloted_to_coder,
                item.AssignCoder_date,
                item.qc_person,
                item.qc_date,
                item.qc_completed_date,
                item.priority,
                status_view,
                urlButton,
                worked_files,
              ])
              .draw();

            // MRN EDIT
            $(".edit").click(function () {
              var Id = $(this).data("id");
              Mrn_edit(Id);
            });
          }

          // Use the function inside your forEach loop
          data.forEach(function (item) {
            addRowToTable(item);
          });

          // FILE CHECKED COUNT
          // Set initial count to 0

          // Handle the change event on a parent element that exists initially
          $(document).on("change", ".fileCheck", function () {
            var checkedValues = $("input[name='File']:checked")
              .map(function () {
                return $(this).val();
              })
              .get();

            // Update the count of checked values
            count = checkedValues.length;
            // console.log("Number of Checked Values: " + count);
            $("#checkedFilesCount").html(
              '<label class="badge badge-info">' + count + "</label>"
            );
          });

          // SEPARATE FILTER FUNCTION

          $("#search").click(function () {
            // Statuses
            var selectedStatuses = $("input[name='Status']:checked")
              .map(function () {
                return $(this).val();
              })
              .get();

            // console.log(selectedStatuses);
            (new_status_for_team = "ASSIGNED BY TEAM"), "REASSIGNED BY TEAM";
            // Create a new array to store modified statuses
            var modifiedStatuses = selectedStatuses.map(function (status) {
              if (status === "NEW") {
                return new_status_for_team; // Change 'NEW' to 'ASSIGNED BY TEAM'
              } else {
                return status; // Keep other statuses unchanged
              }
            });

            // console.log(modifiedStatuses);

            // Coder
            var selectedCoder = $("input[name='Coder']:checked")
              .map(function () {
                return $(this).val();
              })
              .get();

            var postData = {
              Statuses: JSON.stringify(modifiedStatuses),
              Coder: JSON.stringify(selectedCoder),
            };

            // console.log(postData);

            $.ajax({
              type: "POST",
              url: "table/process1.php",
              data: postData,
              success: function (items) {
                // console.log(items);
                table.clear().draw(); // Clear existing table data

                if (Array.isArray(items)) {
                  items.forEach(function (row) {
                    addRowToTable(row);
                  });
                } else {
                  addRowToTable(items); // Handle single row insertion here
                }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                console.error(errorThrown);
              },
            });
          });
        }
      }
    },
    error: function () {
      console.log("Error fetching data table.");
    },
  });
}


function view_worked_files(Id) {
  // Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

  var urlStr = "qc_single_preview.php";
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



function view_worked_files_tl(Id) {
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