$(document).ready(function () {
  fetchData();
  Mrn_edit();
  Assign_data_coder();
  updateCheckboxState();
  $("#loading").show();

  // FILE CHECKED COUNT
  // Set initial count to 0
  var count = 0;
  $("#checkedFilesCount").html(
    '<label class="badge badge-info">' + count + "</label>"
  );
});

// GET FUNCTION
function fetchData() {
  $("input[name='File']").prop("checked", false);
  var checkedItems = new Set(); // Store checked item IDs
  $.ajax({
    url: "Assign/get_process.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log(data);
      var role_user = data[0].role;
      // console.log("Role:", role_user);
      // TEAMLEADER TABLE

      if (role_user == "TeamLeader") {
        var table;

        if (!$.fn.DataTable.isDataTable("#assign_table_data")) {
          // Initialize DataTable

          table = $("#assign_table_data").DataTable({
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
                next: "Nexta",
                last: "Last",
              },
            },
            scrollY: "500px", // Set the height for scrollable content
            scrollX: true, // Enable horizontal scrolling
            scrollCollapse: true, // Enable table scrolling
            fixedHeader: true, // Enable fixed header
            columns: [
              {
                title:
                  "<input type='checkbox' id='selectAllCheckbox' class='form-control' style='height:20px'>",
                className: "no-sort",
              },
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
          table = $("#assign_table_data").DataTable();
          $("#loading").hide();
        }
        $(".no-sort").removeClass("sorting-asc");
        $(".no-sort").removeClass("sorting-desc");

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
                urlButton,
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

          

          // SEPARATE FILTER FUNCTION

          function searchData(){


            $("#search").click(function () {
              $("#loading").show();
              // Statuses
              var selectedStatuses = $("input[name='Status']:checked")
                .map(function () {
                  return $(this).val();
                })
                .get();
  
              // console.log(selectedStatuses);
              new_status_for_team = ["ASSIGNED TO TEAM", "REASSIGNED TO TEAM"];
              // Create a new array to store modified statuses
              var modifiedStatuses = selectedStatuses
                .map(function (status) {
                  if (status === "NEW") {
                    return new_status_for_team; // Change 'NEW' to 'ASSIGNED TO TEAM'
                  } else {
                    return status; // Keep other statuses unchanged
                  }
                })
                .flat();
  
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
                      $("#loading").hide();
                    });
                  } else {
                    addRowToTable(items);
                    $("#loading").hide(); // Handle single row insertion here
                  }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  console.error(errorThrown);
                  $("#loading").hide();
                },
              });
            });
          }

          searchData();

 
        }
      }
      // CODER TABLE
      else if (role_user == "Coder" || role_user == "superadmin") {
        var table;
        if (!$.fn.DataTable.isDataTable("#assign_table_data")) {
          // Initialize DataTable

          table = $("#assign_table_data").DataTable({
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
              { title: "Chart" },
              { title: "Option" },
            ],
          });

          $("#loading").hide();

          // Other DataTable setup...
        } else {
          // Use the existing reference
          table = $("#assign_table_data").DataTable();
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

          data.forEach(function (item) {
            //DATE FORMATE
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
              item.status === "ASSIGNED TO CODER" ||
              item.status === "REASSIGNED TO CODER"
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

            var urlButton =
              '<a class="btn btn-primary flow" onclick="openMultipleUChart(this)" data-urls="' +
              item.url +
              '">View Chart</a>';
            var Mrn =
              item.mrn === ""
                ? '<td class="font-weight-medium"><div class="badge badge-danger edit" data-id="' +
                  item.Id +
                  '" data-toggle="modal" data-target=".bd-example-modal-md-edit">Add Mrn</div></td>'
                : '<td class="font-weight-medium"><div class="badge badge-success">' +
                  item.mrn +
                  "</div></td>";

            var buttons = ""; // Initialize the variable to hold the buttons

            // Check if the status is 'COMPLETED', if true, create the PDF button
            if (item.status.toUpperCase() === "COMPLETED") {
              buttons =
                '<a class="btn btn-primary " onclick="window.location.href=\'generate_pdf.php?Id=' +
                item.Id +
                "'\">Open Document</a>";
            } else if (item.status.toUpperCase() === "INPROGRESSION") {
              buttons =
                '<a class="btn btn-primary" onclick="storeIdAndRedirect(' +
                item.Id +
                ')">InProgression</a>';
            } else if (item.status.toUpperCase() === "WIP") {
              buttons =
                '<a class="btn btn-primary working_statues" onclick="start_working(' +
                item.Id +
                ')">WIP</a>';
            } else {
              buttons =
                '<a class="btn btn-primary flow working_statues" onclick="start_working(' +
                item.Id +
                ')" id="working_statues" data-id="' +
                item.Id +
                '">Start Working</a>';
            }

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
                buttons, // Add the buttons based on the condition
              ])
              .draw();

            // MRN EDIT
            $(".edit").click(function () {
              var Id = $(this).data("id");
              Mrn_edit(Id);
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

// Open Multiple Chart
function openMultipleUChart(element) {
  // Access the data-urls attribute
  var urlStr = element.getAttribute("data-urls");
  // console.log("URL String:", urlStr); // Debugging line
  // Check if URLs are separated by digits followed by 'www'
  var modifiedUrlStr = urlStr.replace(/(\d)(www)/g, "$1 $2");

  // If the modification didn't occur, try splitting by 'https://' and 'http://'
  if (modifiedUrlStr === urlStr) {
    modifiedUrlStr = urlStr.replace(/(https:\/\/|http:\/\/)/g, " $1");
  }

  var urls = modifiedUrlStr.trim().split(" ");

  console.log("URLs after split:", urls); // Debugging line
  if (urls == "null") {
    Swal.fire({
      title: "Warning!",
      text: "The patient's chart is not available.",
      icon: "warning",
      confirmButtonText: "OK",
    });
    return;
  }
  // Loop through each URL and open in a new tab
  urls.forEach((url) => {
    if (url !== "") {
      window.open(url, "_blank");
    }
  });
}

function storeIdAndRedirect(Id) {
  // Set the cookie with the item.Id value
  // document.cookie = `Id=${itemId}; path=/`;

  // // Redirect to 'coding.php'
  // window.location.href = "coding.php";
  Swal.fire({
    title: "Are you sure?",
    text: "",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ready, Set, Code!",
  }).then((result) => {
    if (result.isConfirmed) {
      alert(Id);
      // Ajax request when the confirmation is accepted
      $.ajax({
        url: "Assign/InProgression_log.php",
        type: "POST",
        data: { Id: Id },
        success: function (data) {
          // console.log(data);
          // Redirect to coding.php with the Id parameter after AJAX success
          var response = JSON.parse(data);
          var Id = response.message;
          $.ajax({
            url: "PendingWip/pendingdisplaydata.php",
            type: "POST",
            data: { Id: Id },
            success: function (data) {
              document.cookie = `Id=${Id}; path=/`;
              window.location.href = "coding.php";
            },
          });
        },
        error: function (xhr, status, error) {
          // Handle error if needed
          console.error(error);
        },
      });
    }
  });
}

//Wip process
function start_working(Id) {
  // alert(Id);
  Swal.fire({
    title: "Are you sure work this file?",
    text: "",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ready, Set, Code!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Ajax request when the confirmation is accepted
      $.ajax({
        url: "Assign/workinprogress.php",
        type: "POST",
        data: { Id: Id },
        success: function (data) {
          // console.log(data);
          // Redirect to coding.php with the Id parameter after AJAX success
          var response = JSON.parse(data);

          var Id = response.message;
          document.cookie = `Id=${Id}; path=/`;
          window.location.href = "coding.php";
        },
        error: function (xhr, status, error) {
          // Handle error if needed
          console.error(error);
        },
      });
    }
  });
}

//MRN EDIT FUNCTION
function Mrn_edit(Id) {
  $.ajax({
    url: "Assign/mrn_edit_process.php",
    type: "GET",
    data: { Id: Id },
    dataType: "json",
    success: function (data) {
      $("#Id").val(data.Id);
      $("#Patient_Name").val(data.Patient_Name);
    },
    error: function () {
      // Handle error
    },
  });
}

function modal_close() {
  $("#myModal").removeClass("show");
  $("body").removeClass("modal-open");
  $(".modal-backdrop").remove();
}

//MRN UPDATE FUNCTION
$(document).ready(function () {
  $("#update").click(function (event) {
    event.preventDefault();
    var Id = $("#Id").val();
    var Mrn = $("#Mrn").val();

    if (Mrn == "") {
      alert("Please Enter Mrn");
      return false;
    }

    // console.log(Id, Mrn);

    $.ajax({
      type: "POST",
      url: "Assign/mrn_update_process.php",
      data: { Id: Id, Mrn: Mrn },
      success: function (data) {
        // console.log(data);

        // Check if data is already an object (JSON)
        var response = typeof data === "object" ? data : JSON.parse(data);

        if (response.success) {
          Swal.fire({
            title: "Success!",
            text: response.success,
            icon: "success",
            confirmButtonText: "OK",
          }).then(function (result) {
            if (result.isConfirmed) {
              modal_close();
            }
          });
        } else if (response.error) {
          Swal.fire({
            title: "Error",
            text: response.error,
            icon: "error",
            confirmButtonText: "OK",
          });
        }

        fetchData();
      },
      error: function (data) {
        console.log(data);
      },
    });
  });
});

// Separate pagenation file ID Get

var selectedFiles = new Set(); // Global state for selected file IDs

// Function to update checkbox state
function updateCheckboxState() {
  $("input[name='File']").each(function () {
    var fileId = $(this).val();

    if (selectedFiles.has(fileId)) {
      $(this).prop("checked", true);
    } else {
      $(this).prop("checked", false);
    }
  });
}

// Event listener for checkbox changes
$(document).on("change", "input[name='File']", function () {
  var fileId = $(this).val();
  if (this.checked) {
    selectedFiles.add(fileId);
  } else {
    selectedFiles.delete(fileId);
  }
  updateCheckedCountDisplay();
});

function updateCheckedCountDisplay() {
  $("#checkedFilesCount").html(
    '<label class="badge badge-info">' + selectedFiles.size + "</label>"
  );
}

$(document).on("change", "#selectAllCheckbox", function () {
  var isChecked = $(this).prop("checked");

  $(".fileCheck").prop("checked", isChecked);
  checkedItems = new Set(); // Clear the existing set
  if (isChecked) {
    // If "Select All" checkbox is checked, add all item IDs to the set
    $(".fileCheck").each(function () {
      checkedItems.add($(this).val());

      selectedFiles = checkedItems;
      // alert(selectedFiles)
    });
  } else {
    selectedFiles.clear();
  }
  updateCheckedCountDisplay();
});

// ASSIGN FUNCTION
function Assign_data_coder() {
  $("#Coder_Assign").click(function () {
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
        url: "Assign/Team_assign_process.php",
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
                  url: "Assign/reassign_coder_process.php",
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


                            // window.location.reload();
                            $("#loading").hide();

              
                          
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
                  // window.location.reload();

                  

                  
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
