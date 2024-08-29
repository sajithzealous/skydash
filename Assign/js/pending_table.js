$(document).ready(function () {
  fetchData();
  // GET FUNCTION
  function fetchData() {
    $.ajax({
      url: "Assign/pending_get_process.php",
      type: "GET",
      dataType: "json",
      success: function (data) {
        console.log(data);
        var role_user = data[0].role;
        // console.log("Role:", role_user);
        if (role_user == "Coder") {
          var table;
          if (!$.fn.DataTable.isDataTable("#pending_table_data")) {
            // Initialize DataTable

            table = $("#pending_table_data").DataTable({
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
                { title: "Reason" },
                { title: "Chart" },
                { title: "Option" },
              ],
            });

            // Other DataTable setup...
          } else {
            // Use the existing reference
            table = $("#pending_table_data").DataTable();
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
                '">View Charts</a>';
              var Mrn =
                item.mrn === ""
                  ? '<td class="font-weight-medium"><div class="badge badge-danger edit" data-id="' +
                    item.Id +
                    '" data-toggle="modal" data-target=".bd-example-modal-md-edit">Add Mrn</div></td>'
                  : '<td class="font-weight-medium"><div class="badge badge-success">' +
                    item.mrn +
                    "</div></td>";

              var buttons = ""; // Initialize the variable to hold the buttons

              if (item.status.toUpperCase() === "PENDING") {
                buttons =
                  '<a class="btn btn-primary" onclick="Wip_process(' +
                  item.Id +
                  ')">PENDING</a>';
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
                  item.pending_reason,
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
});

// Open Multiple Chart
function openMultipleUChart(element) {
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

// function storeIdAndRedirect(itemId) {
//   // Set the cookie with the item.Id value
//   document.cookie = `Id=${itemId}; path=/`;

//   // Redirect to 'coding.php'
//   window.location.href = "coding.php";
// }

//Wip process
function Wip_process(Id) {
  // Display SweetAlert confirmation
  // alert(Id);
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
      // Ajax request when the confirmation is accepted
      $.ajax({
        url: "Assign/Pending_log.php",
        type: "POST",
        data: { Id: Id },
        success: function (data) {
          console.log(data);
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
