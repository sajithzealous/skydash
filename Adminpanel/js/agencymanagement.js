$(document).ready(function () {
  // Fetch data and initialize DataTable after data is fetched
  datadisplaytable();
  savedata();
  // userstatuschange();
  // initializeDataTable();
});

// Function to fetch and display user data
function datadisplaytable() {
  fetch("Adminpanel/agencysql.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      initializeDataTable(data);
      showdata();
      userstatuschange();
    })
    .catch((error) => console.error("Error fetching data:", error));
}

function initializeDataTable(data) {
  const user_table = createDataTable(data);

  console.log(user_table);

  user_table.columns().every(function (index) {
    const column = this;
    if (index < user_table.columns().indexes().length - 1) {
      index === 6
        ? addDateColumnFilter(column)
        : addColumnFilter(column, index);
    }
  });
}
//creating table
function createDataTable(data) {
  // data.forEach(user => {
  //     const userName = user.user_name; // Access the 'user_name' property of each object
  //     console.log(userName); // Print or use the username as needed
  // });

  return $("#Agency_table").DataTable({
    lengthMenu: [
      [15, 25, 50, -1],
      [15, 25, 50, "All"],
    ],
    fixedHeader: true,
    data: data,
    columns: [
      {
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + 1; // Render the row number as serial number
        },
      },
      { data: "user_name" },
      { data: "user_id" },
      { data: "user_role" },
      { data: "user_status" },
      { data: "created_date" },
      {
        data: null,
        render: function (data, type, row) {
          var status = "";
          if (data.user_status == "Active") {
            var status = "Checked";
          }
          return (
            '<div class="form-check"><label class="switch"><center><input type="checkbox" data-user_id="' +
            data.id +
            '" data-agency_id="' +
            data.user_id +
            '"class="row-checkbox form-check-input fileCheck" data-index="' +
            row.index_id +
            'checked" ' +
            status +
            '><span class="slider round"></span></center></label></div>'
          );
        },
      },
    ],
    initComplete: function () {
      var table = $("#Agency_table");

      // Append input fields and a checkbox to the table header
      table
        .find("thead")
        .append(
          "<tr>" +
            '<th class=""></th>' +
            '<th class="filterRow"></th>' +
            '<th class="filterRow"></th>' +
            '<th class="filterRow"></th>' +
            '<th class="filterRow"></th>' +
            '<th class="filterRow"></th>' +
            "</tr>"
        );
    },
  });
}
//add column wise filter to table data
function addColumnFilter(column, index) {
  const select = $(
    '<select class="form-control searchable-dropdown dropdown-select" data-index="' +
      index +
      '"><option value=""></option></select>'
  ).appendTo("#Agency_table th.filterRow:nth-child(" + (index + 1) + ")");

  select.select2({
    theme: "classic", // Adjust the theme as needed
    width: "100%",
    placeholder: "Search...",
    allowClear: true,
  });

  column
    .data()
    .unique()
    .sort()
    .each(function (d, j) {
      select.append('<option value="' + d + '">' + d + "</option>");
    });

  // Trigger change event to apply initial filtering
  select.on("change", function () {
    const val = $.fn.dataTable.util.escapeRegex($(this).val());
    column.search(val ? "^" + val + "$" : "", true, false).draw();
  });
}



//add column wise date filter to table data
// function addDateColumnFilter(column) {
//   const dateInput = $('<input type="date" class="">')
//     .appendTo("user_table th.date")
//     .on("input", function () {
//       const val = $(this).val();
//       const formattedDate = formatDate(val);
//       column.search(formattedDate).draw();
//     });
// }

function addColumnFilter(column, index) {
  const select = $(
    '<select class="form-control searchable-dropdown dropdown-select" multiple="multiple" data-index="' +
      index +
      '"><option value=""></option></select>'
  ).appendTo("#Agency_table th.filterRow:nth-child(" + (index + 1) + ")");

  select.select2({
    theme: "bootstrap", // Adjust the theme as needed
    width: "100%",
    height:"100%",
    placeholder: "Search...",
    allowClear: true,
  });

  column
    .data()
    .unique()
    .sort()
    .each(function (d, j) {
      select.append('<option value="' + d + '">' + d + "</option>");
    });

  // Trigger change event to apply initial filtering
  select.on("change", function () {
    const vals = $(this).val() || [];
    const regex = vals.map(function (val) {
      return "^" + $.fn.dataTable.util.escapeRegex(val) + "$";
    }).join('|');
    column.search(regex, true, false).draw();
  });
}


//function to save data
function savedata() {
  $("body").on("click", "#newagencysave", function () {
    var checkboxChecked = $('#selectcheckbox').prop('checked');
    var username = $("#textInputUser").val().trim();
    var password = $("#textInputpassword").val().trim();
    var emp_id = $("#textInputempid").val().trim();
    var user_role = $("#selectInputuserrole").val().trim();
    var user_status = $("#selectInputStatus").val().trim();
    var client_id = $("#selectInputclientid").val().trim();

    // Check if checkbox is checked
    if (checkboxChecked) {
        // If checkbox is checked, clear username and password fields
        password = "";
    } else {

        if (password === "") {
            Swal.fire({
                title: "Empty field!",
                text: "Please Enter Password!",
                icon: "info",
            });
            return; // Exit function early if validation fails
        }
    }

    // Continue with validation for other fields
            // Validate username and password fields if checkbox is not checked
            if (username === "") {
              Swal.fire({
                  title: "Empty field!",
                  text: "Please Enter Agencyname!",
                  icon: "info",
              });
              return; // Exit function early if validation fails
          }
          else if (emp_id === "") {
        Swal.fire({
            title: "Empty field!",
            text: "Please Enter Agency_id!",
            icon: "info",
        });
    } else if (user_role === "") {
        Swal.fire({
            title: "Empty field!",
            text: "Please Enter Agency_role!",
            icon: "info",
        });
    } else if (user_status === "") {
        Swal.fire({
            title: "Empty field!",
            text: "Please Enter Status!",
            icon: "info",
        });
    } else {
        // Perform AJAX request
        $.ajax({
            url: "Adminpanel/create-agency.php?action=create",
            type: "GET",
            data: {
                username: username,
                password: password,
                emp_id: emp_id,
                user_role: user_role,
                user_status: user_status,
                client_id: client_id,
            },
            success: function (response) {
                console.log(response);
                var data = JSON.parse(response);

                if (data.status === "Ok") {
                    Swal.fire({
                        title: "Success!",
                        text: "New Agency Created!",
                        icon: "success",
                    }).then(function () {
                        location.reload();
                    });
                } else if (data.status === "Available") {
                    Swal.fire({
                        title: "Duplicate!",
                        text: "This Agency ID Already Exists!",
                        icon: "info",
                    });
                    console.log("Already Available");
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "Error Found!",
                        icon: "error",
                    });
                    console.log("Error");
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: "Error!",
                    text: "Failed to create agency. Please try again later.",
                    icon: "error",
                });
                console.error("AJAX Error:", error);
            }
        });
    }
});

}

//status change of user
function userstatuschange() {
  $("body").on("change", ".row-checkbox", function () {

   
    var row_id = $(this).data("user_id");
    var emp_id = $(this).data("agency_id");
    var this_checkbox = $(this);
    alert(emp_id);
    if (this_checkbox.prop("checked")) {
      var status = "In-Active";
    } else {
      var status = "Active";
    }

    $.ajax({
      url: "Adminpanel/create-agency.php?action=update_status",
      type: "get",
      data: {
        row_id: row_id,
        status: status,
        emp_id: emp_id,
      },
      success: function (response) {
        console.log(response);
        var data = JSON.parse(response);

        if (data.status == "Ok") {
          Swal.fire({
            title: "Success!",
            text: "User Status Updated!",
            icon: "success",
          }).then(function () {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error!",
            text: "Error Found!",
            icon: "error",
          });
        }
      },
    });
  });
}

//show the data count
function showdata() {
  $.ajax({
    url: "Adminpanel/create-agency.php?action=get_active_count",
    type: "get",
    data: {},
    success: function (response) {
      console.log(response);
      var data = JSON.parse(response);

      if (data.status == "Ok") {
        var total_count = data.data.total_user;
        var total_active = data.data.total_active;
        var total_inactive = data.data.total_inactive;
        console.log(data);

        $("#activeagency").html(total_active);
        $("#inactiveagency").html(total_inactive);
        $("#totalagecny").html(total_count);
      } else {
      }
    },
  });
}
