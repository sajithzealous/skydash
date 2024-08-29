$(document).ready(function () {
  $("#loading").show();
  Qc_coderassign();
  updateCheckboxState();


  $.ajax({
    url: "QA/Qa_process_v1.php", // Use the correct path to your PHP file
    type: "GET",
    //   dataType: "json",
    success: function (data) {
      // console.log(data);
      var role_user = data[0].role;


      if(role_user == "QaTl"){

        var table;
        if (!$.fn.DataTable.isDataTable("#qa_table_data")) {
          // Initialize DataTable
  
          table = $("#qa_table_data").DataTable({
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

            ],
          });
  
          // Other DataTable setup...
        } else {
          // Use the existing reference
          table = $("#qa_table_data").DataTable();
          
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
  
          function Qc_table(item) {
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
  
            var EditStatus = item.status !== "COMPLETED" ? item.status : "NEW";


            var checkbox =
            ' </div><div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input fileCheck" name="File" value="' +
            item.Id +
            '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div>';
  
     

  
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
                item.qc_date,
                item.priority,
                "<span class='badge badge-danger'>" + EditStatus + "</span>",
                item.alloted_to_coder,
                item.qc_person,
                urlButton,
               
              ])
              .draw();
              $("#loading").hide();
             
  
            // MRN EDIT
            $(".edit").click(function () {
              var Id = $(this).data("id");
              Mrn_edit(Id);
            });
          }
          // Use the function inside your forEach loop
          data.forEach(function (item) {
            Qc_table(item);
          });
  
          // SEPARATE FILTER FUNCTION
  
            $("#QA_search").click(function () {
  
  
              //Status
            var selectedStatuses = $("input[name='Status']:checked")
              .map(function () {
                return $(this).val();
              })
              .get();
  
      
  
              // Agent
              var selectedAgents = $("input[name='Agent']:checked")
                .map(function () {
                  return $(this).val();
                })
                .get();
  
           
              // Coder
              var selectedCoder = $("input[name='Coder']:checked")
                .map(function () {
                  return $(this).val();
                })
                .get();
              console.log("Coder_empi", selectedCoder);
              var postData = {
                Status:JSON.stringify(selectedStatuses),
                Agent: JSON.stringify(selectedAgents),
                Coder: JSON.stringify(selectedCoder),
              };
  
              console.log("ddddd",postData);
  
              $.ajax({
                type: "POST",
                url: "table/process3.php",
                data: postData,
                success: function (items) {
                  console.log(items);
                  table.clear().draw(); // Clear existing table data
  
                  if (Array.isArray(items)) {
                    items.forEach(function (row) {
                      Qc_table(row);
                    });
                  } else {
                    Qc_table(items); // Handle single row insertion here
                  }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  console.error(errorThrown);
                },
              });
            });
  
        }
      }
      
      if(role_user== "QA"){


        var table;
        if (!$.fn.DataTable.isDataTable("#qa_table_data")) {
          // Initialize DataTable
  
          table = $("#qa_table_data").DataTable({
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
              { title: "Coder-Completed" },
              { title: "Priority" },
              { title: "Status" },
              { title: "Coder" },
              { title: "QC-Coder" },
              { title: "Chart" },
              { title: "Option" },
            ],
          });
  
          // Other DataTable setup...
        } else {
          // Use the existing reference
          table = $("#qa_table_data").DataTable();
          
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
  
          function Qc_table(item) {
            //DATE FORMATE
            var qc_dates = item.qc_date;
 
 

var dateOnly;

if (qc_dates !== null && typeof qc_dates !== 'undefined') {
    // Extracting only the date part (first 10 characters)
    dateOnly = qc_dates.substring(0, 10);
} else {
    dateOnly = ""; // Set dateOnly to an empty string
}

// Outputting the extracted date or an empty string if qc_dates is null
//console.log(dateOnly); // Output: (Empty string)


            let dateString = item.assesment_date;
            let dateObj = new Date(dateString);
            let formattedDate = dateObj.toLocaleDateString("en-US", {
              month: "short",
              day: "numeric",
              year: "numeric",
            });
            var currentDate = luxon.DateTime.now().setZone("America/New_York");
  
            var fDate = currentDate.toFormat("yyyy-MM-dd HH:mm:ss");
  
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
  
            var EditStatus = item.status !== "COMPLETED" ? item.status : "NEW";
  
            var buttons = "";
  
            buttons =
              '<a class="btn btn-primary flow working_statues" onclick="Qa_Wip_process(' +
              item.Id +
              ')" id="working_statues" data-id="' +
              item.Id +
              '">Start Working</a>';
  
            table.row
              .add([
                item.Id,
                item.patient_name,
                Mrn,
                item.insurance_type,
                formattedDate,
                item.assesment_type,
                item.agency,
                dateOnly,

                item.priority,
                "<span class='badge badge-danger'>" + EditStatus + "</span>",
                item.alloted_to_coder,
                item.qc_person,
                urlButton,
                buttons, // Add the buttons based on the condition
              ])
              .draw();
              $("#loading").hide();
             
  
            // MRN EDIT
            $(".edit").click(function () {
              var Id = $(this).data("id");
              Mrn_edit(Id);
            });
          }
          // Use the function inside your forEach loop
          data.forEach(function (item) {
            Qc_table(item);
          });
  
          // SEPARATE FILTER FUNCTION
  
            $("#QA_search").click(function () {
  
  
              //Status
            var selectedStatuses = $("input[name='Status']:checked")
              .map(function () {
                return $(this).val();
              })
              .get();
  
              console.log("Agent", selectedStatuses);
  
              // Agent
              var selectedAgents = $("input[name='Agent']:checked")
                .map(function () {
                  return $(this).val();
                })
                .get();
  
              console.log("Agent", selectedAgents);
              // Coder
              var selectedCoder = $("input[name='Coder']:checked")
                .map(function () {
                  return $(this).val();
                })
                .get();
              console.log("Coder_empi", selectedCoder);
              var postData = {
                Status:JSON.stringify(selectedStatuses),
                Agent: JSON.stringify(selectedAgents),
                Coder: JSON.stringify(selectedCoder),
              };
  
              console.log(postData);
  
              $.ajax({
                type: "POST",
                url: "table/process2.php",
                data: postData,
                success: function (items) {
                  console.log(items);
                  table.clear().draw(); // Clear existing table data
  
                  if (Array.isArray(items)) {
                    items.forEach(function (row) {
                      Qc_table(row);
                    });
                  } else {
                    Qc_table(items); // Handle single row insertion here
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


  
});


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
function Qc_coderassign(){
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
