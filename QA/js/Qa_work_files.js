$(document).ready(function () {
  $.ajax({
    url: "QA/Qa_process1.php", // Use the correct path to your PHP file
    type: "GET",
    //   dataType: "json",
    success: function (data) {
      // console.log(data);
      
      var table;
      if (!$.fn.DataTable.isDataTable("#qa_work_files")) {
        // Initialize DataTable

        table = $("#qa_work_files").DataTable({
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

        // Other DataTable setup...
      } else {
        // Use the existing reference
        table = $("#qa_work_files").DataTable();
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

          var urlButton =
            '<button class="btn btn-primary" onclick="window.open(\'' +
            item.url +
            "', '_blank')\">View Chart</button>";

          // var urls = item.url.split('\n').filter(url => url.trim() !== '');  // Remove empty lines
          // var currentIndex = 0;

          // function openNextURL() {
          //   if (currentIndex < urls.length) {
          //     window.open(urls[currentIndex], '_blank');
          //     currentIndex++;
          //   } else {
          //     alert('No more URLs to open.');
          //   }
          // }

          // var urlButton = `<button class="btn btn-primary" onclick="openNextURL()">View Chart</button>`;

          var Mrn =
            item.mrn === ""
              ? '<td class="font-weight-medium"><div class="badge badge-danger edit" data-id="' +
                item.Id +
                '" data-toggle="modal" data-target=".bd-example-modal-md-edit">Add Mrn</div></td>'
              : '<td class="font-weight-medium"><div class="badge badge-success">' +
                item.mrn +
                "</div></td>";

          // var EditStatus = item.status !== "REASSIGNED TO QC CODER" ? item.status : "NEW";

          var logDate = luxon.DateTime.fromFormat(
            item.log_time,
            "yyyy-MM-dd HH:mm:ss",
            { zone: "America/New_York" }
          );

          var daysDifference = Math.round(
            currentDate.diff(logDate, "days", { zone: "America/New_York" })
              .days
          );
          var EditStatus;

          if (
            item.status === "ASSIGNED TO QC CODER" ||
            item.status === "REASSIGNED TO QC CODER"
          ) {
            switch (daysDifference) {
              case 0:
                EditStatus = '<div class="d-flex" >New</div>';
                break;
              case 1:
                EditStatus =
                  '<div class="d-flex" title="1 Days File"><span class="dot-circle" style="background-color: blue;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                break;
              case 2:
                EditStatus =
                  '<div class="d-flex" title="2 Days File"><span class="dot-circle" style="background-color: yellow;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                break;
              default:
                if (daysDifference <= 30) {
                  EditStatus =
                    '<div class="d-flex" title="High-Priority"><span class="dot-circle" style="background-color: red;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                } else {
                  // Set a different status view for cases where daysDifference is greater than 30
                  EditStatus =
                    '<div class="d-flex" title="Very High-Priority"><span class="dot-circle" style="background-color: purple;"></span><span class="" style="color: black; font-weight: bold;">New</span></div>';
                }
                break;
            }
          } else {
            EditStatus =
              '<div class="d-flex"><span class="mt-2">' +
              item.status +
              "</span></div>";
          }

          var buttons = "";

          buttons =
            '<a class="btn btn-primary flow working_statues" onclick="Qa_Wip_process(' +
            item.Id +
            ')" id="working_statues" data-id="' +
            item.Id +
            '">QA WIP</a>';



            var buttons = ""; // Initialize the variable to hold the buttons

            // Check if the status is 'COMPLETED', if true, create the PDF button
            if (item.status.toUpperCase() === "QA WIP") {
              buttons =
              '<a class="btn btn-primary flow working_statues" onclick="Qa_Wip_process(' +
              item.Id +
              ')" id="working_statues" data-id="' +
              item.Id +
              '">QA WIP</a>';

            }
               else {
                buttons =
                '<a class="btn btn-primary flow working_statues" onclick="Qa_Wip_process(' +
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
              EditStatus,
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
