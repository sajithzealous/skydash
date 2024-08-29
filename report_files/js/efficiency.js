$(document).ready(function () {
  reports();
  login_details();
});

reports_2();


function reports() {
  $("#searchbtn").on("click", function () {
    var fromdate = $("#from_date5").val();
    var todate = $("#to_date5").val();
    var team_select = $("#team_select5").val();
    var coder_name = $("#coder_name5").val();
    var status = $("#status5").val();
    var agency = $("#agency5").val();

    efficiency_report(
      fromdate,
      todate,
      team_select,
      coder_name,
      status,
      agency
    );
  });
}

function reports_2() {
  $("#search_btn2").on("click", function () {
    var fromdate = $("#from_date1").val();
    var todate = $("#to_date1").val();
    var selectedAgencies = []; // Array to store selected agencies

    // Iterate over each checkbox
    $('input[name="selectedAgencies[]"]:checked').each(function () {
      selectedAgencies.push($(this).val()); // Push the value of checked checkboxes into the array
    });
    // Now selectedAgencies array contains all the checked agencies
    console.log(selectedAgencies);

    agency_report(fromdate, todate, selectedAgencies);
  });
}

function login_details() {
  $("#logdata").on("click", function () {

 
    var fromdate = $("#from_date5").val();
    var todate = $("#to_date5").val();
    var team_select = $("#team_select5").val();
    var coder_name = $("#coder_name5").val();
     

    login_details_fetch(
      fromdate,
      todate,
      team_select,
      coder_name
     
    );
  });
}

$("#team_select5").on("change", function () {
  var team = $(this).val();
  var parts = team.split(" - ");
  var teamname = parts[0];
  var team_id = parts[1];

  $.ajax({
    url: "filter/fetch_coders.php",
    type: "POST",
    data: {
      teamname: teamname,
      team_id: team_id,
    },
    dataType: "json",
    success: function (response) {
      console.log("Response from server:", response);
      var options = '<option value="">Select-Coder</option>';
      $.each(response, function (index, coder) {
        options +=
          '<option value="' +
          coder.Coders +
          " - " +
          coder.coder_emp_id +
          '">' +
          coder.Coders +
          " - " +
          coder.coder_emp_id +
          "</option>";
      });
      $("#coder_name5").html(options);
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
    },
  });
});

function efficiency_report(
  fromdate,
  todate,
  team_select,
  coder_name,
  status,

  Agency
) {
  var parts = team_select.split(" - ");
  var teamname = "";
  var team_id = "";
  if (parts.length > 1) {
    teamname = parts[0];
    team_id = parts[1];
  }
  var parts1 = coder_name.split(" - ");
  var codername = "";
  var coderid = "";
  if (parts1.length > 1) {
    codername = parts1[0];
    coderid = parts1[1];
  }

  var Sno = 1;
  var hour = "";
  $.ajax({
    url: "report_files/efficiency_report.php?action=efficiency_report",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
      teamname: teamname,
      team_id: team_id,
      codername: codername,
      coderid: coderid,
      status: status,
      Agency: Agency,
    },
    success: function (data) {
      $("#show_data").empty();
      console.log("show_datajohn", data);
      var Sno = 1; // Assuming Sno is a counter variable

      data.efficiency_report.forEach(function (item) {
        var totalWorkingHours =
          item.total_working_hours === "00:00:00"
            ? ""
            : item.total_working_hours;
        $("#show_data").append(
          "<tr><td>" +
            Sno +
            "</td><td>" +
            item.agency +
            "</td><td>" +
            item.Team_name +
            "</td><td>" +
            item.code_name +
            "</td><td>" +
            item.code_id +
            "</td><td>" +
            item.Total_Files +
            "</td><td>" +
            item.Assigned +
            "</td><td>" +
            item.WIP +
            "</td><td>" +
            item.pnd +
            "</td><td>" +
            item.allt_qc +
            "</td><td>" +
            item.QC_WIP +
            "</td><td>" +
            item.QCCOM +
            "</td><td>" +
            item.approved +
            "</td><td>" +
            totalWorkingHours +
            "</td></tr>"
        );
        Sno++;
      });
    },

    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
}

//AGENCY REPORT====================================================

function agency_report(fromdate, todate, selectedAgencies) {
  var Sno = 1;
  var hour = "";
  $.ajax({
    url: "report_files/efficiency_report.php?action=agency_report",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
      selectedAgencies: selectedAgencies,
    },
    success: function (data) {
      $("#show_data1").empty();
      console.log("agency_report", data);
      var Sno = 1; // Assuming Sno is a counter variable

      data.agency_report.forEach(function (item) {
        // var totalWorkingHours = item.total_working_hours === '00:00:00' ? '' : item.total_working_hours;
        $("#show_data1").append(
          "<tr><td>" +
            Sno +
            "</td><td>" +
            item.agency +
            "</td><td>" +
            item.Total_Files +
            "</td><td>" +
            item.NEW +
            "</td><td>" +
            item.team +
            "</td><td>" +
            item.Assigned +
            "</td><td>" +
            item.WIP +
            "</td><td>" +
            item.reassing +
            "</td><td>" +
            item.pnd +
            "</td><td>" +
            item.QC_WIP +
            "</td><td>" +
            item.allt_qc +
            "</td><td>" +
            item.QCCOM +
            "</td><td>" +
            item.approved +
            "</td></tr>"
        );
        Sno++;
      });
    },

    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
}


// ===============================================================================login_details=====================================================

function login_details_fetch(
  fromdate,
  todate,
  team_select,
  coder_name
) {

  var parts = team_select.split(" - ");
  var teamname = "";
  var team_id = "";
  if (parts.length > 1) {
    teamname = parts[0];
    team_id = parts[1];
  }
  var parts1 = coder_name.split(" - ");
  var codername = "";
  var coderid = "";
  if (parts1.length > 1) {
    codername = parts1[0];
    coderid = parts1[1];
  }


 $.ajax({
    url: "report_files/efficiency_report.php?action=login_details",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
      teamname: teamname,
      team_id: team_id,
      codername: codername,
      coderid: coderid
    },
    success: function (data) {
      $("#show_logindata").empty();
      console.log("show_logindata", data);
      var Sno = 1; // Assuming Sno is a counter variable

      data.login_details.forEach(function (item) {
        var totalWorkingHours = "0";

        // Calculate total working hours only if logout_time is not null
        if (item.logout_time) {
          var loginTime = new Date("1970-01-01T" + item.login_time + "Z");
          var logoutTime = new Date("1970-01-01T" + item.logout_time + "Z");
          var totalMilliseconds = logoutTime - loginTime;
          var totalSeconds = Math.floor(totalMilliseconds / 1000);
          var hours = Math.floor(totalSeconds / 3600);
          var minutes = Math.floor((totalSeconds % 3600) / 60);
          var seconds = totalSeconds % 60;

          totalWorkingHours = hours.toString().padStart(2, '0') + ":" +
                              minutes.toString().padStart(2, '0') + ":" +
                              seconds.toString().padStart(2, '0');
        }

        $("#show_logindata").append(
          "<tr><td>" +
          Sno +
          "</td><td>" +
          item.username +
          "</td><td>" +
          item.emp_id +
          "</td><td>" +
          item.team_name +
          "</td><td>" +
          item.log_date +
          "</td><td>" +
          item.login_time +
          "</td><td>" +
          (item.logout_time ? item.logout_time : "") +
          "</td><td>" +
          totalWorkingHours +
          "</td></tr>"
        );
        Sno++;
      });
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    }
  });
}
