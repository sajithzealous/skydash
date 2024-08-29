$(document).ready(function () {
  login_details();
});

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
    url: "report_files/efficiency_report_v2.php?action=login_details",
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

      console.log(data)
              $("#show_logintotaldata").empty();
        var Sno = 1;

        // Loop through each employee's data and display it
        data.login_details.forEach(function (item) {
            $("#show_logintotaldata").append(
                "<tr><td>" +
                Sno +
                "</td><td>" +
                item.username +
                "</td><td>" +
                item.emp_id +
                "</td><td>" +
                item.team_name +
                "</td><td>" +
                fromdate + " to " + todate +
                "</td><td>" +
                item.total_working_hours +
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
