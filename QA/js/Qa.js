$(document).ready(function () {
  $("#loading").show();
  Qc_coderassign();
  updateCheckboxState();
  qcBucket();

});

// Global variable to keep track of the current page
var currentPage = 1;

// Global variable to keep track of the DataTable instance
var dataTable;

// Function to initialize the DataTable and fetch data
function qcBucket() {
  $.ajax({
    url: "QA/Qa_process.php",
    type: "GET",
    dataType: "json",
    data: { page: currentPage }, // Send current page number to server
    success: function (data) {
      if (!data || data.length === 0) {
        $("#no-data-message").show();
        return;
      }
      
      var role_user = data[0].role;

      // alert(role_user);
      var tableConfig = {
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
        scrollY: "500px",
        scrollX: true,
        scrollCollapse: true,
        fixedHeader: true,
      };

      var columns = [
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
        { title: "Coder-Completed" },
        { title: "Priority" },
        { title: "Status" },
        { title: "Coder" },
        { title: "Qc_Coder" },
        { title: "Chart" },
      ];

      if (role_user === "QA") {
        columns.push({ title: "Option" });
      }

      function formatDate(dateString) {
        if (!dateString) return "";
        let dateObj = new Date(dateString);
        return dateObj.toLocaleDateString("en-US", {
          month: "short",
          day: "numeric",
          year: "numeric",
        });
      }

      function addRowToTable(item) {
        $("#loading").hide();
        let formattedDate = formatDate(item.assesment_date);
        let Mrn =
          item.mrn === ""
            ? '<td class="font-weight-medium"><div class="badge badge-danger edit" data-id="' +
              item.Id +
              '" data-toggle="modal" data-target=".bd-example-modal-md-edit">Add Mrn</div></td>'
            : '<td class="font-weight-medium"><div class="badge badge-success">' +
              item.mrn +
              "</div></td>";
        let EditStatus = item.status !== "COMPLETED" ? item.status : "NEW";
        let checkbox =
          '<div class="d-flex"><div class="form-check"><label class="form-check-label"><input type="checkbox" class="form-check-input fileCheck" name="File" value="' +
          item.Id +
          '"><i class="input-helper"></i></label></div><span class="mt-2"></span></div>';
        let qc_date = item.qc_date ? item.qc_date.substring(0, 10) : "";
        let urlButton =
          '<button class="btn btn-primary" onclick="window.open(\'' +
          item.url +
          "', '_blank')\">View Chart</button>";

        let row = [
          checkbox,
          item.Id,
          item.patient_name,
          Mrn,
          item.insurance_type,
          formattedDate,
          item.assesment_type,
          item.agency,
          qc_date,
          item.priority,
          "<span class='badge badge-danger'>" + EditStatus + "</span>",
          item.alloted_to_coder,
          item.qc_person,
          urlButton,
        ];

        if (role_user === "QA") {
          row.push(
            '<a class="btn btn-primary flow working_statues" onclick="Qa_Wip_process(' +
              item.Id +
              ')" id="working_statues" data-id="' +
              item.Id +
              '">Start Working</a>'
          );
        }

        dataTable.row.add(row);
      }

      // Initialize DataTable if not already initialized
      if (!dataTable) {
        dataTable = $("#qa_table_data").DataTable(
          $.extend({}, tableConfig, { columns: columns })
        );
      } else {
        dataTable.clear().draw();
      }

      data.forEach(addRowToTable);
      dataTable.draw();

      // Handle next button click to fetch next page of data
      $('#qa_table_data_next').on('click', function() {
        currentPage++; // Increment current page
        qcBucket(); // Fetch data for next page
      });

      $('#qa_table_data_previous').on('click', function() {
        currentPage--; // Decrement current page
        qcBucket(); // Fetch data for previous page
      });

      $("#QA_search").click(function () {
        var selectedStatuses = $("input[name='Status']:checked")
          .map(function () {
            return $(this).val();
          })
          .get();
        var selectedAgents = $("input[name='Agent']:checked")
          .map(function () {
            return $(this).val();
          })
          .get();
        var selectedCoder = $("input[name='Coder']:checked")
          .map(function () {
            return $(this).val();
          })
          .get();
        var postData = {
          Status: JSON.stringify(selectedStatuses),
          Agent: JSON.stringify(selectedAgents),
          Coder: JSON.stringify(selectedCoder),
        };

        $.ajax({
          type: "POST",
          url:
            role_user === "QaTl" ? "table/process3.php" : "table/process2.php",
          data: postData,
          success: function (items) {
            console.log(items);
            dataTable.clear().draw();

            if (Array.isArray(items)) {
              items.forEach(addRowToTable);
            } else {
              addRowToTable(items);
            }
            dataTable.draw(); // Ensure the table is redrawn after adding rows
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error(errorThrown);
          },
        });
      });
    },
    error: function () {
      console.log("Error fetching data table.");
    },
  });
}
//Wip process
function Qa_Wip_process(Id) {
  // Display SweetAlert confirmation
  Swal.fire({
    title: "Are you sure QA?",
    text: "",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ready, Set, Code!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Ajax request when the confirmation is accepted
      $.ajax({
        url: "QA/Qa_worklog.php",
        type: "POST",
        data: { Id: Id },
        success: function (data) {
          console.log(data);
          var response = JSON.parse(data);
          var Id = response.message;
          if (response.error) {
            Swal.fire({
              title: "Error",
              text: response.error,
              icon: "error",
              confirmButtonText: "OK",
            });
          } else {
            document.cookie = `Id=${Id}; path=/`;
            window.location.href = "qc_coding.php";
          }
        },
        error: function (xhr, status, error) {
          // Handle error if needed
          console.error(error);
        },
      });
    }
  });
}

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

//Qc_coder assign data
function Qc_coderassign() {
  $("#QA_assign").click(function () {
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

                            window.location.reload();
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
                  window.location.reload();
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
