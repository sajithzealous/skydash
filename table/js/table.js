$(document).ready(function () {
  Datas();
  Assign();
  updateCheckboxState();
});

// function Datas() {
//   var checkedItems = new Set(); // Store checked item IDs

//    var table = $("#table_data").DataTable({
//     paging: true,
//     ordering: true,
//     searching: true,
//     dom: '<"top"ilfp>rt<"clear">',
//     info: true,
//     responsive: true,
//     lengthMenu: [10, 25, 50, 100],
//     pageLength: 10,
//     order: [[0, "asc"]],
//     language: {
//       lengthMenu: "Show _MENU_ entries",
//       info: "Showing _START_ to _END_ of _TOTAL_ entries",
//       search: "Search:",
//       paginate: {
//         first: "First",
//         previous: "Previous",
//         next: "Next",
//         last: "Last",
//       },
//     },
//     scrollY: "500px", // Set the height for scrollable content
//     scrollX: true, // Enable horizontal scrolling
//     scrollCollapse: true, // Enable table scrolling
//     fixedHeader: true, // Enable fixed header
//     columns: [
//       // Define the column headers and their order

//       { title: "<input type='checkbox'  class='form-control' style='height:20px'>" , className: "no-sort" },
//       { title: "Id" },
//       { title: "Patient Name" },
//       { title: "MRN" },
//       { title: "Insurance Type" },
//       { title: "Assesment Date" },
//       { title: "Assesment Type" },
//       { title: "Agency" },
//       { title: "Priority" },
//       { title: "Status" },
//       { title: "Chart" },
//     ],
    

//     drawCallback: function (settings) {
//       initCheckboxListeners();
//       updateCheckboxesBasedOnSet();
//     },

 

  
//   });
//    $('.no-sort').removeClass("sorting-asc");
//    $('.no-sort').removeClass("sorting-desc");
//   // Separate pagenation file Total Count

//   function initCheckboxListeners() {
//     $(".myCheckbox")
//       .off("change")
//       .change(function () {
//         var value = $(this).val();
//         if (this.checked) {
//           checkedItems.add(value);
//         } else {
//           checkedItems.delete(value);
//         }
//         updateCheckedCountDisplay();
//       });
//   }

//   function updateCheckedCountDisplay() {
//     var checkedValues = Array.from(checkedItems);
//     console.log("Checked Values: ", checkedValues);
//     $("#checkedFilesCount").html(
//         '<label class="badge badge-info">' + checkedItems.size + "</label>"
//     );
// }


//   function updateCheckboxesBasedOnSet() {
//     $(".myCheckbox").each(function () {
//       $(this).prop("checked", checkedItems.has($(this).val()));
//     });
//   }

//   function populateTable(data) {
//     table.clear().draw();

//     if (data.length === 0) {
//       // $("#no-data-message").show();
//     } else {
//       // $("#no-data-message").hide();

//       data.forEach(function (item) {
//         let dateString = item.assesment_date;
//         let dateObj = new Date(dateString);
//         let formattedDate = dateObj.toLocaleDateString("en-US", {
//           month: "short",
//           day: "numeric",
//           year: "numeric",
//         });

//         var currentDate = luxon.DateTime.now().setZone("America/New_York");

//         // var logDate = luxon.DateTime.fromFormat(item.log_time, 'yyyy-MM-dd HH:mm:ss');

//         // Format currentDate with hours, minutes, and seconds
//         var fDate = currentDate.toFormat("yyyy-MM-dd HH:mm:ss");

//         var logDate = luxon.DateTime.fromFormat(
//           item.log_time,
//           "yyyy-MM-dd HH:mm:ss",
//           { zone: "America/New_York" }
//         );
//         // Replace 'your_timezone' with the actual time zone of your dates

//         var daysDifference = Math.round(
//           currentDate.diff(logDate, "days", { zone: "America/New_York" }).days
//         );

//         var status_view;

//         if (item.status === "New") {
//           switch (daysDifference) {
//             case 0:
//               status_view = '<div class="d-flex" >New</div>';
//               break;
//             case 1:
//               status_view =
//                 '<div class="d-flex" title="1 Days File"><span class="dot-circle" style="background-color: blue;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
//               break;
//             case 2:
//               status_view =
//                 '<div class="d-flex" title="2 Days File"><span class="dot-circle" style="background-color: yellow;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
//               break;
//             default:
//               if (daysDifference <= 30) {
//                 status_view =
//                   '<div class="d-flex" title="High-Priority"><span class="dot-circle" style="background-color: red;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
//               } else {
//               }
//               break;
//           }
//         } else {
//           status_view =
//             '<div class="d-flex"><span class="mt-2">' +
//             item.status +
//             "</span></div>";
//         }

//         var checkbox =
//           ' </div><div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input myCheckbox" name="File" value="' +
//           item.Id +
//           '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div>';
//         var urlButton =
//           '<a class="btn btn-primary flow" onclick="OpenChart(this)" data-urls="' +
//           item.url +
//           '">View Chart</a>';

//         table.row
//           .add([
//             checkbox,
//             item.Id,
//             item.patient_name,
//             item.mrn,
//             item.insurance_type,
//             formattedDate,
//             item.assesment_type,
//             item.agency,
//             item.priority,
//             status_view,
//             urlButton,
//           ])
//           .draw();
//       });
//     }

//     // // FILE CHECKED COUNT
//     // $(".myCheckbox").change(function () {
//     //   var checkedValues = $("input[name='File']:checked")
//     //     .map(function () {
//     //       return $(this).val();
//     //     })
//     //     .get();

//     //   // Get the count of checked values
//     //   var count = checkedValues.length;
//     //   console.log("Number of Checked Values: " + count);
//     //   $("#checkedFilesCount").html(
//     //     '<label class="badge badge-info">' + count + "</label>"
//     //   );
//     // });
//   }

//   // initCheckboxListeners();

//   // SEPARATE TEAMWISE CODERS FILTER

//   var hasSelectedTeam = false; // Initialize as false

//   $(".myCheckboxTeam").change(function () {
//     var selectedTeam = $("input[name='Team']:checked")
//       .map(function () {
//         return $(this).val();
//       })
//       .get();

//     var postData = {
//       Team: JSON.stringify(selectedTeam),
//     };
//     console.log("empset",postData);
//     hasSelectedTeam = selectedTeam.length > 0;
//     console.log("Has selected team:", hasSelectedTeam);

//     populateCheckboxes(
//       hasSelectedTeam ? "filter/coder_filter.php" : "filter/coders.php",
//       postData,
//       ".views_coder"
//     );
//   });

//   function populateCheckboxes(url, data, containerSelector) {
//     var coderContainer = $(containerSelector); // Reference to the container

//     // Clear existing checkboxes before adding new ones
//     coderContainer.empty();

//     $.ajax({
//       type: "POST",
//       url: url,
//       data: data,
//       success: function (data) {

//         console.log("array emp",data);
//         // Loop through the data and create checkboxes
//         data.forEach(function (item) {



//           // Create a new checkbox element
//           var checkboxTemplate = $(
//             '<div class="d-flex"><div class="form-check ml-3"><label class="form-check-label"><input type="checkbox" class="form-check-input" value="' +
//               item.coder_emp_id+
//               '" name="Coder"><i class="input-helper"></i></label></div><span class="mt-2">' +
//                   item.Coders + '(' + item.coder_emp_id + ')' +
//               "</span></div>"
 

//           );

//           // Append the newly created checkbox to the container
//           coderContainer.append(checkboxTemplate);
//         });
//       },
//       error: function (jqXHR, textStatus, errorThrown) {
//         console.log(errorThrown);
//       },
//     });
//   }

//   // SEPARATE FILTER FUNCTION

//   $("#searchButton").click(function () {
//     $("#loading").show();
//     // Statuses
//     var selectedStatuses = $("input[name='Status']:checked")
//       .map(function () {
//         return $(this).val();
//       })
//       .get();

//     // Assessment Types
//     var selectedAssessment = $("input[name='Assessment']:checked")
//       .map(function () {
//         return $(this).val();
//       })
//       .get();

//     // Agent
//     var selectedAgent = $("input[name='Agent']:checked")
//       .map(function () {
//         return $(this).val();
//       })
//       .get();

//     // Team
//     var selectedTeam = $("input[name='Team']:checked")
//       .map(function () {
//         return $(this).val();
//       })
//       .get();

//     // Coder
//     var selectedCoder = $("input[name='Coder']:checked")
//       .map(function () {
//         return $(this).val();
//       })
//       .get();

//     var postData = {
//       Statuses: JSON.stringify(selectedStatuses),
//       Assessment: JSON.stringify(selectedAssessment),
//       Agent: JSON.stringify(selectedAgent),
//       Team: JSON.stringify(selectedTeam),
//       Coder: JSON.stringify(selectedCoder),
//     };

//     console.log(postData);

//     $.ajax({
//       type: "POST",
//       url: "table/process.php",
//       data: postData,
//       success: function (data) {
//         console.log(data);
//         populateTable(data);
//         $("#loading").hide();
//       },
//       error: function (jqXHR, textStatus, errorThrown) {
//         console.log(errorThrown);
//         $("#loading").hide();
//       },
//     });
//   });
// }

// Separate pagenation file ID Get



function Datas() {
  var checkedItems = new Set(); // Store checked item IDs

   var table = $("#table_data").DataTable({
    paging: true,
    ordering: true,
    searching: true,
    dom: '<"top"ilfp>rt<"clear">',
    info: true,
    responsive: true,
    lengthMenu: [10, 25, 50, 100],
    pageLength: 10,
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
    scrollY: "500px", // Set the height for scrollable content
    scrollX: true, // Enable horizontal scrolling
    scrollCollapse: true, // Enable table scrolling
    fixedHeader: true, // Enable fixed header
    columns: [
      // Define the column headers and their order

      { title: "<input type='checkbox' id='selectAllCheckbox' class='form-control' style='height:20px'>" , className: "no-sort" },
      { title: "Id" },
      { title: "Patient Name" },
      { title: "MRN" },
      { title: "Insurance Type" },
      { title: "Assessment Date" },
      { title: "Assessment Type" },
      { title: "Agency" },
      { title: "Priority" },
      { title: "Status" },
      { title: "Chart" },
    ],
    

    drawCallback: function (settings) {
      initCheckboxListeners();
      updateCheckboxesBasedOnSet();
     
    },

   

  
  });
  $('#loading').hide();
   $('.no-sort').removeClass("sorting-asc");
   $('.no-sort').removeClass("sorting-desc");
  // Separate pagination file Total Count

  function initCheckboxListeners() {
    $(".myCheckbox")
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
    $(".myCheckbox").each(function () {
      $(this).prop("checked", checkedItems.has($(this).val()));
    });
  }

  function populateTable(data) {
    table.clear().draw();

    if (data.length === 0) {
      // $("#no-data-message").show();
    } else {
      // $("#no-data-message").hide();

      data.forEach(function (item) {


        let dateString = item.assesment_date;
        let dateObj = new Date(dateString);
        let formattedDate = dateObj.toLocaleDateString("en-US", {
          month: "short",
          day: "numeric",
          year: "numeric",
        });

        var currentDate = luxon.DateTime.now().setZone("America/New_York");

        // var logDate = luxon.DateTime.fromFormat(item.log_time, 'yyyy-MM-dd HH:mm:ss');

        // Format currentDate with hours, minutes, and seconds
        var fDate = currentDate.toFormat("yyyy-MM-dd HH:mm:ss");

        var logDate = luxon.DateTime.fromFormat(
          item.log_time,
          "yyyy-MM-dd HH:mm:ss",
          { zone: "America/New_York" }
        );
        // Replace 'your_timezone' with the actual time zone of your dates

        var daysDifference = Math.round(
          currentDate.diff(logDate, "days", { zone: "America/New_York" }).days
        );

        // var status_view;

        // if (item.status != "New") {
        //   status_view =
        //     '<div class="d-flex"><span class="mt-2">' +
        //     item.status +
        //     "</span></div>";
         
        // } else {
        //   switch (daysDifference) {
        //     case 0:
        //       status_view = '<div class="d-flex" >New</div>';
        //       break;
        //     case 1:
        //       status_view =
        //         '<div class="d-flex" title="1 Days File"><span class="dot-circle" style="background-color: blue;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
        //       break;
        //     case 2:
        //       status_view =
        //         '<div class="d-flex" title="2 Days File"><span class="dot-circle" style="background-color: yellow;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
        //       break;
        //     default:
        //       if (daysDifference <= 30) {
        //         status_view =
        //           '<div class="d-flex" title="High-Priority"><span class="dot-circle" style="background-color: red;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
        //       }
        //       break;
        //   }
          
        // }

        var checkbox =
          ' </div><div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input myCheckbox" name="File" value="' +
          item.Id +
          '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div>';
        var urlButton =
          '<a class="btn btn-primary flow" onclick="OpenChart(this)" data-urls="' +
          item.url +
          '">View Chart</a>';

        //   console.log([
        //     checkbox,
        //     item.Id,
        //     item.patient_name,
        //     item.mrn,
        //     item.insurance_type,
        //     formattedDate,
        //     item.assesment_type,
        //     item.agency,
        //     item.priority,
        //     status_view,
        //     urlButton,
        // ]);

        table.row
          .add([
            checkbox,
            item.Id,
            item.patient_name,
            item.mrn,
            item.insurance_type,
            formattedDate,
            item.assesment_type,
            item.agency,
            item.priority,
            item.status,
            urlButton,
          ])
          .draw();
      });
    }

    // // FILE CHECKED COUNT
    // $(".myCheckbox").change(function () {
    //   var checkedValues = $("input[name='File']:checked")
    //     .map(function () {
    //       return $(this).val();
    //     })
    //     .get();

    //   // Get the count of checked values
    //   var count = checkedValues.length;
    //   console.log("Number of Checked Values: " + count);
    //   $("#checkedFilesCount").html(
    //     '<label class="badge badge-info">' + count + "</label>"
    //   );
    // });
  }

  // initCheckboxListeners();

  // SEPARATE TEAMWISE CODERS FILTER

  var hasSelectedTeam = false; // Initialize as false

  $(".myCheckboxTeam").change(function () {
    var selectedTeam = $("input[name='Team']:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    var postData = {
      Team: JSON.stringify(selectedTeam),
    };
    console.log("empset",postData);
    hasSelectedTeam = selectedTeam.length > 0;
    console.log("Has selected team:", hasSelectedTeam);

    populateCheckboxes(
      hasSelectedTeam ? "filter/coder_filter.php" : "filter/coders.php",
      postData,
      ".views_coder"
    );
  });

  function populateCheckboxes(url, data, containerSelector) {
    var coderContainer = $(containerSelector); // Reference to the container

    // Clear existing checkboxes before adding new ones
    coderContainer.empty();

    $.ajax({
      type: "POST",
      url: url,
      data: data,
      success: function (data) {

        console.log("array emp",data);
        // Loop through the data and create checkboxes
        data.forEach(function (item) {



          // Create a new checkbox element
          var checkboxTemplate = $(
            '<div class="d-flex"><div class="form-check ml-3"><label class="form-check-label"><input type="checkbox" class="form-check-input" value="' +
              item.coder_emp_id+
              '" name="Coder"><i class="input-helper"></i></label></div><span class="mt-2">' +
                  item.Coders + '(' + item.coder_emp_id + ')' +
              "</span></div>"
 

          );

          // Append the newly created checkbox to the container
          coderContainer.append(checkboxTemplate);
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
      },
    });
  }

  // SEPARATE FILTER FUNCTION

  $("#searchButton").click(function () {
    $("#loading").show();
    // Statuses
    var selectedStatuses = $("input[name='Status']:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    // Assessment Types
    var selectedAssessment = $("input[name='Assessment']:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    // Agent
    var selectedAgent = $("input[name='Agent']:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    // Team
    var selectedTeam = $("input[name='Team']:checked")
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

    var postData = {
      Statuses: JSON.stringify(selectedStatuses),
      Assessment: JSON.stringify(selectedAssessment),
      Agent: JSON.stringify(selectedAgent),
      Team: JSON.stringify(selectedTeam),
      Coder: JSON.stringify(selectedCoder),
    };

    console.log(postData);

    $.ajax({
      type: "POST",
      url: "table/process.php",
      data: postData,
      success: function (data) {
        console.log(data);
        populateTable(data);
        $("#loading").hide();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
        $("#loading").hide();
      },
    });
  });

  // Toggle selection of all checkboxes
  $(document).on('change', '#selectAllCheckbox', function(){
    var isChecked = $(this).prop('checked');
    $('.myCheckbox').prop('checked', isChecked);
    checkedItems = new Set(); // Clear the existing set
    if (isChecked) {
      // If "Select All" checkbox is checked, add all item IDs to the set
      $('.myCheckbox').each(function() {
        checkedItems.add($(this).val());

        selectedFiles=checkedItems;
      });
    }
    updateCheckedCountDisplay(); // Update the checked count display
  });
}

var selectedFiles = new Set(); // Global state for selected file IDs

// Function to update checkbox state
function updateCheckboxState() {
  $("input[name='File']").each(function() {
    var fileId = $(this).val();
    if (selectedFiles.has(fileId)) {
      $(this).prop('checked', true);
    } else {
      $(this).prop('checked', false);
    }
  });
}

// Event listener for checkbox changes
$(document).on('change', "input[name='File']", function() {
  var fileId = $(this).val();
  if (this.checked) {
    selectedFiles.add(fileId);
  } else {
    selectedFiles.delete(fileId);
  }
});

// Assign Process to Team
function Assign() {
  $("#Assign").click(function () {

    var TeamSelect = $("input[name='Team']:checked")
    .map(function () {
      return $(this).val();
    })
    .get();

  if (TeamSelect.length > 1) {
    Swal.fire({
      title: "Warning",
      text: "You can assign only one team for files!",
      icon: "warning",
      confirmButtonText: "OK",
    });
    return;
  }
    var Team = $("input[name='Team']:checked").val();
    console.log("Team:", Team);

    var Coder = $("input[name='Coder']:checked").val();
    console.log("Coder:", Coder);

    var checkedValues = Array.from(selectedFiles);
    console.log("checkedValues fd", checkedValues);

    if (checkedValues.length > 0 && Team) {
      if (Coder) {
        // Show an alert if both Team and Coder are selected
        Swal.fire({
          title: "Warning",
          text: "You can only assign to a team, not to a coder right now!",
          icon: "warning",
          confirmButtonText: "OK",
        });
      } else {
        $.ajax({
          type: "POST",
          url: "Assign/assign_process.php",
          data: { Id: checkedValues.join(","), Team: Team }, // Join IDs into a string
          success: function (data) {
            console.log(data);
            var responses = JSON.parse(data); // Parse the JSON received from PHP
            console.log(responses);
            if (responses[0].message == "reassign") {
              Swal.fire({
                title: "Are you sure?",
                text: "You want to reassign the file to a new team?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Reassign it!",
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    type: "POST",
                    url: "Assign/reassign_team_process.php",
                    data: { Id: checkedValues.join(","), Team: Team },
                    success: function (data) {
                      console.log("Raw JSON response:", data);

                      try {
                        var responses = JSON.parse(data);

                        responses.forEach(function (response) {
                          if (response.success) {
                            console.log(response.message);
                            Swal.fire({
                              title: "Success!",
                              text: response.message,
                              icon: "success",
                              confirmButtonText: "OK",
                            }).then(function () {
                              window.location.href = "home1.php";
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
                  console.log(response.message);
                  Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    confirmButtonText: "OK",
                  }).then(function () {
                    window.location.href = "home1.php";
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
            }
          },

          error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
          },
        });
      }
    } else {
      Swal.fire({
        title: "Error",
        text: "Please choose both 'File' and 'Team'.",
        icon: "error",
        confirmButtonText: "OK",
      });
    }
  });
}

// Open Multiple Chart
function OpenChart(element) {
  // Access the data-urls attribute
  var urlStr = element.getAttribute("data-urls");
  console.log("URL String:", urlStr); // Debugging line
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
