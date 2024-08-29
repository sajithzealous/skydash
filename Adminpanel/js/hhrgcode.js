$(document).ready(function () {
  // Fetch data and initialize DataTable after data is fetched
  datadisplaytable();
  savedata();
});

// Function to fetch and display user data
var globalFun;
function datadisplaytable() {
  fetch("Adminpanel/hhrgcodesql.php")
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

  return $("#hhrgtable").DataTable({
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
      { data: "National" },
      { data: "Laborportion" },
      { data: "Nonlabor" },
      { data: "Year" },
      { data: "Status" },
      { data: "timestamp" },  
      {
        data: null,
        render: function (data, type, row) {
          var status = "";
          if (data.Status == "active") {
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
      var table = $("#hhrgtable");

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
            '<th class="filterRow"></th>' +
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
  ).appendTo("#hhrgtable th.filterRow:nth-child(" + (index + 1) + ")");

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
  $("body").on("click", "#newhhrgsave", function () {
    var National = $("#textInputNational").val().trim();
    var Labor = $("#textInputLabor").val().trim();
    var Nonlabor = $("#textInputNonLabor").val().trim();
    var Year = $("#textInputYear").val().trim();
    var status = $("#selectInputHHRGStatus").val().trim();


    if (National == "") {
      Swal.fire({
        title: "Empty field!",
        text: "Please Enter National!",
        icon: "info",
      });
    } else if (Labor == "") {
      Swal.fire({
        title: "Empty field!",
        text: "Please Enter Labor!",
        icon: "info",
      });
    }
    else if (Nonlabor == "") {
      Swal.fire({
        title: "Empty field!",
        text: "Please Enter Nonlabor!",
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
        url: "Adminpanel/create-hhrgcode.php?action=create",
        type: "get",
        data: {
          National: National,
          Labor: Labor,
          Nonlabor: Nonlabor,
          Year: Year,
          status: status,
        },
        success: function (response) {
          console.log(response);
          var data = JSON.parse(response);

          if (data.status == "Ok") {
            Swal.fire({
              title: "Success!",
              text: "New HHRG Code Created!",
              icon: "success",
            }).then(function () {
              location.reload();
            });
          } else if (data.status == "Available") {
            Swal.fire({
              title: "Duplicate!",
              text: "This HHRG Code Already Exist!",
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
      url: "Adminpanel/create-hhrgcode.php?action=update_status",
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
    url: "Adminpanel/create-hhrgcode.php?action=get_active_count",
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

        $("#activehhrg").html(total_active);
        $("#inactivehhrg").html(total_inactive);
        $("#totalhhrg").html(total_count);
      } else {
      }
    },
  });
}
