$(document).ready(function(){

fetchData();
Assign_data_qccoder();
$("#loading").show();
});


//fetching data to table

function fetchData() {
  var checkedItems = new Set(); // Store checked item IDs
  $.ajax({
    url: "Assign/qc_get_process.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log(data);
      var role_user = data[0].role;
       console.log("Role:", role_user);
      // TEAMLEADER TABLE

      if (role_user == "TeamLeader") {
        var table;

        if (!$.fn.DataTable.isDataTable("#assign_qc_table_data")) {
          // Initialize DataTable

          table = $("#assign_qc_table_data").DataTable({
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
              { title: "#" },
              { title: "Id" },
              { title: "Patient Name" },
              { title: "MRN" },
              { title: "Insurance Type" },
              { title: "Assesment Date" },
              { title: "Assesment Type" },
              { title: "Agency" },
              { title: "Priority" },
              { title: "Status" },
              { title: "Assigned coder" },
              { title: "Coded Date" },
              { title: "Qc person" },
              { title: "Alloted to qc Date" },
              { title: "Audited Date" },
              { title: "Chart" },
              { title: "Coder_View" },
            ],

            drawCallback: function (settings) {
              initCheckboxListeners();
              updateCheckboxesBasedOnSet();
              $("#loading").hide();
            },
          });

          // Other DataTable setup...
        } else {
          // Use the existing reference
          table = $("#assign_qc_table_data").DataTable();
          $("#loading").hide();
        }

        // Separate pagenation file Total Count

        function initCheckboxListeners() {
          $(".fileCheck")
            .off("change")
            .change(function () {
              var value = $(this).val();
              if (this.checked) {
                checkedItems.add(value);
              } else {
                checkedItems.delete(value);
              }
              updateCheckedCountDisplay();
            });
        }

        function updateCheckedCountDisplay() {
          var checkedValues = Array.from(checkedItems);
          console.log("Checked Values: ", checkedValues);

          $("#checkedFilesCount").html(
            '<label class="badge badge-info">' + checkedItems.size + "</label>"
          );
        }

        function updateCheckboxesBasedOnSet() {
          $(".fileCheck").each(function () {
            $(this).prop("checked", checkedItems.has($(this).val()));
          });
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

            var currentDate = luxon.DateTime.now().setZone("America/New_York");

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
              item.status === "ASSIGNED TO TEAM" ||
              item.status === "REASSIGNED TO TEAM"
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

            var checkbox =
              ' </div><div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input fileCheck" name="File" value="' +
              item.Id +
              '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div>';
            var urlButton =
              '<button class="btn btn-primary" onclick="window.open(\'' +
              item.url +
              "', '_blank')\">View Chart</button>";
              var worked_files =
              '<a class="btn btn-success flow" onclick="view_worked_files(' +
              item.Id +
              ')">Coder_View</a>';
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
                checkbox,
                item.Id,
                item.patient_name,
                Mrn,
                item.insurance_type,
                formattedDate,
                item.assesment_type,
                item.agency,
                item.priority,
                status_view,
                item.alloted_to_coder,
                item.AssignCoder_date,
                item.qc_person,
                item.qc_date,
                item.qc_completed_date,
                urlButton,
                worked_files,
              ])
              .draw();

          }

          // Use the function inside your forEach loop
          data.forEach(function (item) {
            addRowToTable(item);
          });

          // SEPARATE FILTER FUNCTION

          // $("#search").click(function () {
          //   // Statuses
          //   var selectedStatuses = $("input[name='Status']:checked")
          //     .map(function () {
          //       return $(this).val();
          //     })
          //     .get();

          //   // console.log(selectedStatuses);
          //   new_status_for_team = ["ASSIGNED TO TEAM", "REASSIGNED TO TEAM"];
          //   // Create a new array to store modified statuses
          //   var modifiedStatuses = selectedStatuses.map(function (status) {
          //     if (status === "NEW") {
          //       return new_status_for_team; // Change 'NEW' to 'ASSIGNED TO TEAM'
          //     } else {
          //       return status; // Keep other statuses unchanged
          //     }
          //   }).flat();

          //   // console.log(modifiedStatuses);

          //   // Coder
          //   var selectedCoder = $("input[name='Coder']:checked")
          //     .map(function () {
          //       return $(this).val();
          //     })
          //     .get();

          //   var postData = {
          //     Statuses: JSON.stringify(modifiedStatuses),
          //     Coder: JSON.stringify(selectedCoder),
          //   };

          //   // console.log(postData);

          //   $.ajax({
          //     type: "POST",
          //     url: "table/process1.php",
          //     data: postData,
          //     success: function (items) {
          //       // console.log(items);
          //       table.clear().draw(); // Clear existing table data

          //       if (Array.isArray(items)) {
          //         items.forEach(function (row) {
          //           addRowToTable(row);
          //         });
          //       } else {
          //         addRowToTable(items); // Handle single row insertion here
          //       }
          //     },
          //     error: function (jqXHR, textStatus, errorThrown) {
          //       console.error(errorThrown);
          //     },
          //   });
          // });
        }
      }

       if (role_user == "Coder") {
        var table;

        if (!$.fn.DataTable.isDataTable("#assign_qc_table_data")) {
          // Initialize DataTable

          table = $("#assign_qc_table_data").DataTable({
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

              { title: "Id" },
              { title: "Patient Name" },
              { title: "MRN" },
              { title: "Insurance Type" },
              { title: "Assesment Date" },
              { title: "Assesment Type" },
              { title: "Agency" },
              { title: "Priority" },
              { title: "Status" },
              { title: "Assigned coder" },
              { title: "Chart" },
              { title: "Coder_View" },
            ],

            drawCallback: function (settings) {
              $("#loading").hide();

            },
          });

          // Other DataTable setup...
        } else {
          // Use the existing reference
          table = $("#assign_qc_table_data").DataTable();
          $("#loading").hide();
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

           

             

            if (
              item.status === "ASSIGNED TO TEAM" ||
              item.status === "REASSIGNED TO TEAM"
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

            var checkbox =
              ' </div><div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input fileCheck" name="File" value="' +
              item.Id +
              '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div>';
            var urlButton =
              '<button class="btn btn-primary" onclick="window.open(\'' +
              item.url +
              "', '_blank')\">View Chart</button>";
             var worked_files =
              '<a class="btn btn-success flow" onclick="view_worked_files(' +
              item.Id +
              ')">Coder_View</a>';
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
                item.alloted_to_coder,
                urlButton,
                worked_files,
              ])
              .draw();

          }

          // Use the function inside your forEach loop
          data.forEach(function (item) {
            addRowToTable(item);
          });

          // SEPARATE FILTER FUNCTION

          // $("#search").click(function () {
          //   // Statuses
          //   var selectedStatuses = $("input[name='Status']:checked")
          //     .map(function () {
          //       return $(this).val();
          //     })
          //     .get();

          //   // console.log(selectedStatuses);
          //   new_status_for_team = ["ASSIGNED TO TEAM", "REASSIGNED TO TEAM"];
          //   // Create a new array to store modified statuses
          //   var modifiedStatuses = selectedStatuses.map(function (status) {
          //     if (status === "NEW") {
          //       return new_status_for_team; // Change 'NEW' to 'ASSIGNED TO TEAM'
          //     } else {
          //       return status; // Keep other statuses unchanged
          //     }
          //   }).flat();

          //   // console.log(modifiedStatuses);

          //   // Coder
          //   var selectedCoder = $("input[name='Coder']:checked")
          //     .map(function () {
          //       return $(this).val();
          //     })
          //     .get();

          //   var postData = {
          //     Statuses: JSON.stringify(modifiedStatuses),
          //     Coder: JSON.stringify(selectedCoder),
          //   };

          //   // console.log(postData);

          //   $.ajax({
          //     type: "POST",
          //     url: "table/process1.php",
          //     data: postData,
          //     success: function (items) {
          //       // console.log(items);
          //       table.clear().draw(); // Clear existing table data

          //       if (Array.isArray(items)) {
          //         items.forEach(function (row) {
          //           addRowToTable(row);
          //         });
          //       } else {
          //         addRowToTable(items); // Handle single row insertion here
          //       }
          //     },
          //     error: function (jqXHR, textStatus, errorThrown) {
          //       console.error(errorThrown);
          //     },
          //   });
          // });
        }
      }



      // CODER TABLE
      // else if (role_user == "Coder") {
      //   var table;
      //   if (!$.fn.DataTable.isDataTable("#assign_table_data")) {
      //     // Initialize DataTable

      //     table = $("#assign_table_data").DataTable({
      //       paging: true,
      //       ordering: true,
      //       searching: true,
      //       info: true,
      //       responsive: true,
      //       lengthMenu: [10, 25, 50, 100],
      //       pageLength: 10,
      //       language: {
      //         lengthMenu: "Show _MENU_ entries",
      //         info: "Showing _START_ to _END_ of _TOTAL_ entries",
      //         search: "Search:",
      //         paginate: {
      //           first: "First",
      //           previous: "Previous",
      //           next: "Next",
      //           last: "Last",
      //         },
      //       },
      //       scrollY: "500px", // Set the height for scrollable content
      //       scrollX: true, // Enable horizontal scrolling
      //       scrollCollapse: true, // Enable table scrolling
      //       fixedHeader: true, // Enable fixed header
      //       columns: [
      //         { title: "Id" },
      //         { title: "Patient Name" },
      //         { title: "MRN" },
      //         { title: "Insurance Type" },
      //         { title: "Assesment Date" },
      //         { title: "Assesment Type" },
      //         { title: "Agency" },
      //         { title: "Priority" },
      //         { title: "Status" },
      //         { title: "Chart" },
      //         { title: "Option" },
      //       ],
      //     });

      //     // Other DataTable setup...
      //   } else {
      //     // Use the existing reference
      //     table = $("#assign_table_data").DataTable();
      //   }

      //   // Clear the existing data
      //   if (table) {
      //     table.clear().draw();
      //   }

      //   table.clear().draw();

      //   if (data.length === 0) {
      //     $("#no-data-message").show();
      //   } else {
      //     $("#no-data-message").hide();

      //     data.forEach(function (item) {
      //       //DATE FORMATE
      //       let dateString = item.assesment_date;
      //       let dateObj = new Date(dateString);
      //       let formattedDate = dateObj.toLocaleDateString("en-US", {
      //         month: "short",
      //         day: "numeric",
      //         year: "numeric",
      //       });
      //       var currentDate = luxon.DateTime.now().setZone("America/New_York");

      //       var fDate = currentDate.toFormat("yyyy-MM-dd HH:mm:ss");

      //       var logDate = luxon.DateTime.fromFormat(
      //         item.log_time,
      //         "yyyy-MM-dd HH:mm:ss",
      //         { zone: "America/New_York" }
      //       );

      //       var daysDifference = Math.round(
      //         currentDate.diff(logDate, "days", { zone: "America/New_York" })
      //           .days
      //       );

      //       var status_view;

      //       if (
      //         item.status === "ASSIGNED TO CODER" ||
      //         item.status === "REASSIGNED TO CODER"
      //       ) {
      //         switch (daysDifference) {
      //           case 0:
      //             status_view = '<div class="d-flex" >New</div>';
      //             break;
      //           case 1:
      //             status_view =
      //               '<div class="d-flex" title="1 Days File"><span class="dot-circle" style="background-color: blue;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
      //             break;
      //           case 2:
      //             status_view =
      //               '<div class="d-flex" title="2 Days File"><span class="dot-circle" style="background-color: yellow;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
      //             break;
      //           default:
      //             if (daysDifference <= 30) {
      //               status_view =
      //                 '<div class="d-flex" title="High-Priority"><span class="dot-circle" style="background-color: red;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
      //             } else {
      //               // Set a different status view for cases where daysDifference is greater than 30
      //               status_view =
      //                 '<div class="d-flex" title="Very High-Priority"><span class="dot-circle" style="background-color: purple;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
      //             }
      //             break;
      //         }
      //       } else {
      //         status_view =
      //           '<div class="d-flex"><span class="mt-2">' +
      //           item.status +
      //           "</span></div>";
      //       }

      //       var urlButton =
      //         '<a class="btn btn-primary flow" onclick="openMultipleUChart(this)" data-urls="' +
      //         item.url +
      //         '">View Chart</a>';
      //       var Mrn =
      //         item.mrn === ""
      //           ? '<td class="font-weight-medium"><div class="badge badge-danger edit" data-id="' +
      //             item.Id +
      //             '" data-toggle="modal" data-target=".bd-example-modal-md-edit">Add Mrn</div></td>'
      //           : '<td class="font-weight-medium"><div class="badge badge-success">' +
      //             item.mrn +
      //             "</div></td>";

      //       var buttons = ""; // Initialize the variable to hold the buttons

      //       // Check if the status is 'COMPLETED', if true, create the PDF button
      //       if (item.status.toUpperCase() === "COMPLETED") {
      //         buttons =
      //           '<a class="btn btn-primary " onclick="window.location.href=\'generate_pdf.php?Id=' +
      //           item.Id +
      //           "'\">Open Document</a>";
      //       } else if (item.status.toUpperCase() === "INPROGRESSION") {
      //         buttons =
      //           '<a class="btn btn-primary" onclick="storeIdAndRedirect(' +
      //           item.Id +
      //           ')">InProgression</a>';
      //       } else if (item.status.toUpperCase() === "WIP") {
      //         buttons =
      //           '<a class="btn btn-primary working_statues" onclick="start_working(' +
      //           item.Id +
      //           ')">WIP</a>';
      //       } else {
      //         buttons =
      //           '<a class="btn btn-primary flow working_statues" onclick="start_working(' +
      //           item.Id +
      //           ')" id="working_statues" data-id="' +
      //           item.Id +
      //           '">Start Working</a>';
      //       }

      //       table.row
      //         .add([
      //           item.Id,
      //           item.patient_name,
      //           Mrn,
      //           item.insurance_type,
      //           formattedDate,
      //           item.assesment_type,
      //           item.agency,
      //           item.priority,
      //           status_view,
      //           urlButton,
      //           buttons, // Add the buttons based on the condition
      //         ])
      //         .draw();

      //       // MRN EDIT
      //       $(".edit").click(function () {
      //         var Id = $(this).data("id");
      //         Mrn_edit(Id);
      //       });
      //     });
      //   }
      // }
    },
    error: function () {
      console.log("Error fetching data table.");
    },
  });
}


//assign and reassign data to qc coder
function Assign_data_qccoder() {
  $("#QC_Assign").click(function () {
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
    // console.log("coder:", coder);

    var checkedValues = Array.from(selectedFiles);
    console.log("checkedValues fd", checkedValues);
    
    // console.log("filecheck count", checkedValues.length);
    if (checkedValues.length > 0 && coder) {
      console.log(coder.length);
      $.ajax({
        type: "POST",
        url: "Assign/qc_Team_assign_process.php",
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
                  url: "Assign/qc_Team_reassign_process.php",
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
                            fetchData();
                            $("input[name='Coder']").prop("checked", false);
                            $("#checkedFilesCount").empty();
                            var count = 0;
                            $("#checkedFilesCount").html(
                              '<label class="badge badge-info">' +
                                count +
                                "</label>"
                            );
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
                  fetchData();
                  $("input[name='Coder']").prop("checked", false);
                  $("#checkedFilesCount").empty();
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


function view_worked_files(Id) {
  // Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

  var urlStr = "generate_pdf.php";
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
