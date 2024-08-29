$(document).ready(function () {
  // Fetch data and initialize DataTable after data is fetched
  datadisplaytable();
  savedata();
});

// Function to fetch and display user data
var globalFun;
function datadisplaytable() {
  fetch("Adminpanel/comorbidityhighsql.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      globalFun = data;
      initializeDataTable(data);
      userstatuschange();
      showdata();
  
    });
    // .catch((error) => console.error("Error fetching data:", error));
}

function initializeDataTable(data) {
  const user_table = createDataTable(data);
  // console.log(data);

  user_table.columns().every(function (index) {
    const column = this;
    if (index < user_table.columns().indexes().length - 1) {
      index === 7
        ? addDateColumnFilter(column)
        : addColumnFilter(column, index);
    }
  });
}
//creating table
function createDataTable(data) {

  return $("#cghtable").DataTable({
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
      { data: "Id" },
      { data: "grpone" },
      { data: "grptwo" },
      { data: "Year" },
      { data: "status" },
      { data: "timestamp" },  
      {
        data: null,
        render: function (data, type, row) {
          var status = "";
          if (data.status == "active") {
            var status = "checked";
          }
          return (
            '<div class="form-check"><label class="switch"><center><input type="checkbox" data-id="' +
            data.Id +
            '" class="row-checkbox form-check-input fileCheck" ' +
            status +
            '><span class="slider round"></span></center></label></div>'
        );
        
        },
      },
    ],
    initComplete: function () {
      var table = $("#cghtable");

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
            '<th class=""></th>' +
            '<th class=""></th>' +
            "</tr>"
        );
    },
  });
}

function addColumnFilter(column, index) {
  const select = $(
    '<select class="form-control searchable-dropdown dropdown-select" multiple="multiple" data-index="' +
      index +
      '"><option value=""></option></select>'
  ).appendTo("#cghtable th.filterRow:nth-child(" + (index + 1) + ")");

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

function addDateColumnFilter(column) {
  const dateInput = $('<input type="date" class="">')
    .appendTo("user_table th.date")
    .on("input", function () {
      const val = $(this).val();
      const formattedDate = formatDate(val);
      column.search(formattedDate).draw();
    });
}


//function to save data
function savedata() {
  $("body").on("click", "#newcghsave", function () {
    var Grpone = $("#textInputGroupone").val().trim();
    var Grptwo = $("#textInputGrouptwo").val().trim();
    var Year = $("#textInputYear").val().trim();
    var status = $("#selectInputCghStatus").val().trim();


    if (Grpone == "") {
      Swal.fire({
        title: "Empty field!",
        text: "Please Enter Grpone!",
        icon: "info",
      });
    } else if (Grptwo == "") {
      Swal.fire({
        title: "Empty field!",
        text: "Please Enter Grptwo!",
        icon: "info",
      });
    }
    else if (Year == "") {
      Swal.fire({
        title: "Empty field!",
        text: "Please Enter Year!",
        icon: "info",
      });
    }
    else if (status == "") {
      Swal.fire({
        title: "Empty field!",
        text: "Please Enter status!",
        icon: "info",
      });
    }  else {
      $.ajax({
        url: "Adminpanel/create-comorbidityhigh.php?action=create",
        type: "get",
        data: {
          Grpone: Grpone,
          Grptwo: Grptwo,
          Year: Year,
          status: status,
        },
        success: function (response) {
          console.log(response);
          var data = JSON.parse(response);

          if (data.status == "Ok") {
            Swal.fire({
              title: "Success!",
              text: "New Comorbidity High Created!",
              icon: "success",
            }).then(function () {
              location.reload();
            });
          } else if (data.status == "Available") {
            Swal.fire({
              title: "Duplicate!",
              text: "This Comorbidity High Already Exist!",
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
      });
    }
  });
}

//status change of user
function userstatuschange() {
  $("body").on("change", ".row-checkbox", function () {

   
var row_id = $(this).data("id");
var this_checkbox = $(this);
if (this_checkbox.prop("checked")) {
  var status = "active";
} else {
  var status = "In-Active";
}

    //  alert(this_checkbox);

    $.ajax({
      url: "Adminpanel/create-comorbidityhigh.php?action=update_status",
      type: "get",
      data: {
        row_id: row_id,
        status: status,
     
      },
      success: function (response) {
        console.log(response);
        var data = JSON.parse(response);

        if (data.status == "Ok") {
          Swal.fire({
            title: "Success!",
            text: "Status Updated!",
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
    url: "Adminpanel/create-comorbidityhigh.php?action=get_active_count",
    type: "get",
    data: {},
    success: function (response) {
      console.log(response);
      var data = JSON.parse(response);

      if (data.status == "Ok") {
        var total_count = data.data.total;
        var total_active = data.data.total_active;
        var total_inactive = data.data.total_inactive;
        console.log(data);

        $("#activecgh").html(total_active);
        $("#inactivecgh").html(total_inactive);
        $("#totalcgh").html(total_count);
      } else {
      }
    },
  });
}
