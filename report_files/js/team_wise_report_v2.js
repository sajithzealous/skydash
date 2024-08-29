$(document).ready(function () {
  qafeedback_report();
  production_reports();
});


//PRODUNCTION-REPORT-team_select
$('#team_select').on('change',function() {
      var team = $(this).val();
      var parts = team.split(" - ");
      var teamname = parts[0];
      var team_id = parts[1];


      $.ajax({
          url: 'filter/fetch_coders.php', 
          type: 'POST',
          data: { 
             
              teamname: teamname,
              team_id: team_id
          },
          dataType: 'json',
          success: function(response) {
              console.log("Response from server:", response);
              var options = '<option value="">Select</option>';
              $.each(response, function(index, coder) {
                  options += '<option value="' + coder.Coders + ' - ' + coder.coder_emp_id + '">' + coder.Coders + ' - ' + coder.coder_emp_id + '</option>';
              });
              $('#coder_name').html(options);
          },
          error: function(xhr, status, error) {
              console.error("Error:", error);
          }
      });
});

//FEEDBACK-REPORT-teamselection
$("#team_select3").on("change", function () {
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
      var options = '<option value="">Select</option>';
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
      $("#coder_name3").html(options);
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
    },
  });
});



//FEEDBACK-REPORT-searchbtn3
function qafeedback_report() {
  $("#searchbtn3").on("click", function () {
    var fromdate = $("#from_date3").val();
    var todate = $("#to_date3").val();
    var team_select = $("#team_select3").val();
    var coder_name = $("#coder_name3").val();
    var status = $("#status3").val();
    var Segment = $("#segment").val();
    var Agency = $("#agency").val();

    if (Segment == "") {
      alert("Choose one option in segement");

      return;
    }

    coder_with_status_feedback(
      fromdate,
      todate,
      team_select,
      coder_name,
      status,
      Segment,
      Agency
    );
  });
}
//FEEDBACK-REPORT-data in table
function coder_with_status_feedback(
  fromdate,
  todate,
  team_select,
  coder_name,
  status,
  Segment,
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
  $.ajax({
    url: "report_files/teamwise_report_v2.php?action=coder_with_status_feedback",
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
      Segment: Segment,
      Agency:Agency,
    },
    success: function (data) {
      $("#table_data3").empty();
      var codesegementdata = data.Codesegementqc;
      var oasissegementdata = data.oasisqc;
      var pocsegementdata = data.Pocsegementqc;
      var serialnumber = 1;

      function buildTable(
        entryId,
        patientName,
        mrn,
        filestatus,
        coderempid,
        coder,
        team,
        teamempid,
        insuranceType,
        assessmentDate,
        assessmentType,
        agency,
        codedDate,
        CompletedDate,
        qcPerson,
        qcCompleteddate,
        qcdate,
        mItem,
        coderResponse,
        qcResponse,
        errorReason,
        errorType,
        remark
      ) {
        var rowHTML = "<tr>";
        rowHTML += "<td>" + serialnumber++ + "</td>";
        rowHTML += "<td>" + entryId + "</td>";
        rowHTML += "<td>" + coder + "</td>";
        rowHTML += "<td>" + coderempid + "</td>";
        rowHTML += "<td>" + team + "</td>";
        rowHTML += "<td>" + teamempid + "</td>";
        rowHTML += "<td>" + patientName + "</td>";
        rowHTML += "<td>" + mrn + "</td>";
        rowHTML += "<td>" + filestatus + "</td>";
        rowHTML += "<td>" + insuranceType + "</td>";
        rowHTML += "<td>" + assessmentDate + "</td>";
        rowHTML += "<td>" + assessmentType + "</td>";
        rowHTML += "<td>" + agency + "</td>";
        rowHTML += "<td>" + qcPerson + "</td>";
        rowHTML += "<td>" + mItem + "</td>";
        rowHTML += "<td>" + coderResponse + "</td>";
        rowHTML += "<td>" + qcResponse + "</td>";
        rowHTML += "<td>" + errorReason + "</td>";
        rowHTML += "<td>" + errorType + "</td>";
        rowHTML += "<td>" + remark + "</td>";
        rowHTML += "<td>" + codedDate + "</td>";
        rowHTML += "<td>" + qcdate + "</td>";
        rowHTML += "<td>" + qcCompleteddate + "</td>";
        rowHTML += "<td>" + CompletedDate + "</td>"; 
        rowHTML += "</tr>";

        // Append the row to the table body
        $("#table_data3").append(rowHTML);

        // rowHTML += "<td>" + entryId + "</td>";
      }

      // Call the function for each segment
      $.each(codesegementdata, function (index, item) {
        buildTable(
          item.Entry_Id,
          item.Patient_Name,
          item.Mrn,
          item.Filestatusdata,
          item.coderempidmain,
          item.alloted_to_coder,
          item.alloted_team,
          item.team_emp_id,
          item.insurance_type,
          item.assesment_date,
          item.assesment_type,
          item.agency,
          item.AssignCoder_date,
          item.file_completed_date,
          item.qc_person,
          item.qc_completed_date,
          item.qc_date,
          item.M_Item,
          item.codericdcode,
          item["ICD-code"],
          item.Error_reason,
          item.Error_type,
          item.Qc_rationali
        );
      });

      $.each(oasissegementdata, function (index, item) {
        buildTable(
          item.Entry_id,
          item.Patient_Name,
          item.Mrn,
          item.Filestatusdata,
          item.coderempidmain,
          item.alloted_to_coder,
          item.alloted_team,
          item.team_emp_id,
          item.insurance_type,
          item.assesment_date,
          item.assesment_type,
          item.agency,
          item.AssignCoder_date,
          item.file_completed_date,
          item.qc_person,
          item.qc_completed_date,
          item.qc_date,
          item.M_item,
          item.Coder_response,
          item.Qc_response,
          item.Error_reason,
          item.Error_type,
          item.Qc_rationali
        );
      });

      $.each(pocsegementdata, function (index, item) {
        buildTable(
          item.Entry_id,
          item.Patient_Name,
          item.Mrn,
          item.Filestatusdata,
          item.coderempidmain,
          item.alloted_to_coder,
          item.alloted_team,
          item.team_emp_id,
          item.insurance_type,
          item.assesment_date,
          item.assesment_type,
          item.agency,
          item.AssignCoder_date,
          item.file_completed_date,
          item.qc_person,
          item.qc_completed_date,
          item.qc_date,
          item.Poc_item,
          item.Poc_coder_response,
          item.Coder_response,
          item.Error_reason,
          item.Error_type,
          item.Qc_rationali
        );
      });
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
      $("#table_data3")
        .empty()
        .append(
          '<tr><td colspan="15"><center>No records found</center></td></tr>'
        );
    },
  });
}

//Production Report 
function production_reports() {
  // Function to handle changing date input IDs based on filter selection


  // Event handler for search button click
  $("#searchbtn").on('click', function () {
      // Call function to change input IDs based on filter
      changeDateInputIds();

      // Fetch updated input values
      var fromdate1 = $("#from_date1").val();
      var todate1 = $("#to_date1").val();
      var fromdate = $("#from_date").val();
      var todate = $("#to_date").val();
      var team_select = $("#team_select").val();
      var coder_name = $("#coder_name").val();
      var status = $("#status").val();
      var mrn = $("#mrn_sea").val();
      var p_name = $("#p_name").val();

      // Fetch selected agencies
      var agency = [];
      $('input[name="selectedAgencies[]"]:checked').each(function() {
          agency.push($(this).val());
      });

      console.log("Selected agencies:", agency);

      // Check if required fields are empty
      if (fromdate === '' || todate === '') {
          alert("Please select required date fields.");
          return;
      }



      var parts = team_select.split(" - ");
      var teamname = parts[0];
      var team_id = parts[1];


      var parts1 = coder_name.split(" - ");
      var codername = parts1[0];
      var coderid = parts1[1];

      // Perform AJAX request old
//       $.ajax({
//         url: "report_files/teamwise_report_v2.php?action=production_report",
//         type: "GET",
//         dataType: "json",
//         data: {
//             fromdate1: fromdate1,
//             todate1: todate1,
//             fromdate: fromdate,
//             todate: todate,
//             teamname: teamname,
//             team_id: team_id,
//             codername: codername,
//             coderid: coderid,
//             status: status,
//             mrn: mrn,
//             p_name: p_name,
//             agencies: agency
//         },
    
//         success: function (data) {
//             console.log("Success:", data);
    
//             $("#table_data").empty();
    
//             // Function to build each row of the table
//             function buildTable(
//                 serialnumber,
//                 Id,
//                 coder,
//                 coderempid,
//                 team,
//                 patientName,
//                 mrn,
//                 insuranceType,
//                 assessmentDate,
//                 assessmentType,
//                 agency,
//                 status,
//                 pending_comments,
//                 pending_reason,
//                 pending_date,
//                 totalcasemix,
//                 totalcasemixagency,
//                 AssignCoder_date,
//                 qc_date,
//                 qc_completed_date,
//                 total_working_hours,
//                 file_completed_date
//             ) {
//                 var rowHTML = "<tr>";
//                 rowHTML += "<td>" + serialnumber + "</td>";
//                 rowHTML += "<td>" + coder + "</td>";
//                 rowHTML += "<td>" + coderempid + "</td>";
//                 rowHTML += "<td>" + team + "</td>";
//                 rowHTML += "<td>" + patientName + "</td>";
//                 rowHTML += "<td>" + mrn + "</td>";
//                 rowHTML += "<td>" + insuranceType + "</td>";
//                 rowHTML += "<td>" + assessmentDate + "</td>";
//                 rowHTML += "<td>" + assessmentType + "</td>";
//                 rowHTML += "<td>" + agency + "</td>";
//                 rowHTML += "<td>" + status + "</td>";
//                 rowHTML += "<td>" + pending_comments + "</td>";
//                 rowHTML += "<td>" + pending_reason + "</td>";
//                 rowHTML += "<td>" + pending_date + "</td>";
//                 rowHTML += "<td>" + totalcasemix + "</td>";
//                 rowHTML += "<td>" + totalcasemixagency + "</td>";
//                 rowHTML += "<td>" + AssignCoder_date + "</td>";
//                 rowHTML += "<td>" + qc_date + "</td>";
//                 rowHTML += "<td>" + qc_completed_date + "</td>";
//                 rowHTML += "<td>" + total_working_hours + "</td>";
//                 rowHTML += "<td>" + file_completed_date + "</td>";
//                 rowHTML += '<td><a class="btn btn-primary flow" onclick="coder_preview(' + Id + ')">Coder View</a></td>';
//                 rowHTML += '<td><a class="btn btn-primary flow" onclick="qc_preview(' + Id + ')">QC View</a></td>';
//                 rowHTML += '<td><a class="btn btn-primary flow" onclick="final_preview(' + Id + ')">Final View</a></td>';
//                 rowHTML += "</tr>";
    
//                 // Append the row to the table body
//                 $("#table_data").append(rowHTML);
//             }
    
//           // Counter for serial number
// var serialnumber = 1;
// var totalcasemixagencydata = 0;
// var totalcasemixdata = 0;
// var count = 0;

// // Iterate over each item in the data array and build table rows
// $.each(data, function (index, item) {
//     buildTable(
//         serialnumber++,
//         (item.Id || ''),
//         (item.alloted_to_coder || ''),
//         (item.coder_emp_id || ''),
//         (item.alloted_team || ''),
//         (item.patient_name || ''),
//         (item.mrn || ''),
//         (item.insurance_type || ''),
//         (item.assesment_date || ''),
//         (item.assesment_type || ''),
//         (item.agency || ''),
//         (item.status || ''),
//         (item.pending_comments || ''),
//         (item.pending_reason || ''),
//         (item.pending_date || ''),
//         (item.totalcasemixagency || ''),
//         (item.totalcasemix || ''),
//         (item.AssignCoder_date || ''),
//         (item.qc_date || ''),
//         (item.qc_completed_date || ''),
//         (item.total_working_hours || ''),
//         (item.file_completed_date || '')
//     );

//     // Increment the count
//     count++;

//     // Sum the totalcasemixagency and totalcasemix values
//     totalcasemixagencydata += parseInt(item.totalcasemixagency) || 0;
//     totalcasemixdata += parseInt(item.totalcasemix) || 0;
// });

// console.log(totalcasemixagencydata);
// console.log(totalcasemixdata)

// // Calculate the averages
// var averageCasemixAgency = totalcasemixagencydata / count;
// var averageCasemix = totalcasemixdata / count;

// // Output the averages (for example, you can log them to the console or display them on the page)
// console.log("Average Casemix Agency: " + averageCasemixAgency.toFixed(2));
// console.log("Average Casemix: " + averageCasemix.toFixed(2));

// // Optionally, you can display these averages in the UI
// // For example, append these to an element on the page:
// $('#averageCasemixAgency').text(averageCasemixAgency.toFixed(2));
// $('#averageCasemix').text(averageCasemix.toFixed(2));

//         },
    
//         error: function (xhr, status, error) {
//             // Handle error response
//             console.error("Error:", xhr.responseText);
//             // Clear previous results or show a message
//             $("#table_data").empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
//         }
//     });



// perform AJAX request New
$.ajax({
  url: "report_files/teamwise_report_v2.php?action=production_report",
  type: "GET",
  dataType: "json",
  data: {
      fromdate1: fromdate1,
      todate1: todate1,
      fromdate: fromdate,
      todate: todate,
      teamname: teamname,
      team_id: team_id,
      codername: codername,
      coderid: coderid,
      status: status,
      mrn: mrn,
      p_name: p_name,
      agencies: agency
  },

  success: function (data) {
      console.log("Success:", data);

      $("#table_data").empty();

      // Initialize variables to calculate total casemix values
      var totalCasemixSum = 0;
      var totalCasemixAgencySum = 0;
      var totalEntries = data.length;  // Get total number of entries for averaging

      // Function to remove commas from a string and convert it to a number
      function parseValue(value) {
          return parseFloat(value.replace(/,/g, '')) || 0;  // Remove commas and convert to float
      }

      // Function to build each row of the table
      function buildTable(
          serialnumber,
          Id,
          coder,
          coderempid,
          team,
          patientName,
          mrn,
          insuranceType,
          assessmentDate,
          assessmentType,
          agency,
          status,
          pending_comments,
          pending_reason,
          pending_date,
          totalcasemix,
          totalcasemixagency,
          AssignCoder_date,
          qc_date,
          qc_completed_date,
          total_working_hours,
          file_completed_date
      ) {
          var rowHTML = "<tr>";
          rowHTML += "<td>" + serialnumber + "</td>";
          rowHTML += "<td>" + coder + "</td>";
          rowHTML += "<td>" + coderempid + "</td>";
          rowHTML += "<td>" + team + "</td>";
          rowHTML += "<td>" + patientName + "</td>";
          rowHTML += "<td>" + mrn + "</td>";
          rowHTML += "<td>" + insuranceType + "</td>";
          rowHTML += "<td>" + assessmentDate + "</td>";
          rowHTML += "<td>" + assessmentType + "</td>";
          rowHTML += "<td>" + agency + "</td>";
          rowHTML += "<td>" + status + "</td>";
          rowHTML += "<td>" + pending_comments + "</td>";
          rowHTML += "<td>" + pending_reason + "</td>";
          rowHTML += "<td>" + pending_date + "</td>";
          rowHTML += "<td>" + totalcasemixagency + "</td>";
          rowHTML += "<td>" + totalcasemix + "</td>";
          rowHTML += "<td>" + AssignCoder_date + "</td>";
          rowHTML += "<td>" + qc_date + "</td>";
          rowHTML += "<td>" + qc_completed_date + "</td>";
          rowHTML += "<td>" + total_working_hours + "</td>";
          rowHTML += "<td>" + file_completed_date + "</td>";
          rowHTML += '<td><a class="btn btn-primary flow" onclick="coder_preview(' + Id + ')">Coder View</a></td>';
          rowHTML += '<td><a class="btn btn-primary flow" onclick="qc_preview(' + Id + ')">QC View</a></td>';
          rowHTML += '<td><a class="btn btn-primary flow" onclick="final_preview(' + Id + ')">Final View</a></td>';
          rowHTML += "</tr>";

          // Append the row to the table body
          $("#table_data").append(rowHTML);
      }

      // Counter for serial number
      var serialnumber = 1;

      // Iterate over each item in the data array and build table rows
      $.each(data, function (index, item) {
          var totalcasemix = parseValue(item.totalcasemix || '0');
          var totalcasemixagency = parseValue(item.totalcasemixagency || '0');

          // Add the values to the sum variables
          totalCasemixSum += totalcasemix;
          totalCasemixAgencySum += totalcasemixagency;

          buildTable(
              serialnumber++,
              (item.Id || ''),
              (item.alloted_to_coder || ''),
              (item.coder_emp_id || ''),
              (item.alloted_team || ''),
              (item.patient_name || ''),
              (item.mrn || ''),
              (item.insurance_type || ''),
              (item.assesment_date || ''),
              (item.assesment_type || ''),
              (item.agency || ''),
              (item.status || ''),
              (item.pending_comments || ''),
              (item.pending_reason || ''),
              (item.pending_date || ''),
              item.totalcasemix || '',
              item.totalcasemixagency || '',
              (item.AssignCoder_date || ''),
              (item.qc_date || ''),
              (item.qc_completed_date || ''),
              (item.total_working_hours || ''),
              (item.file_completed_date || '')
          );
      });

      // Calculate the average for totalcasemix and totalcasemixagency
   
      var averageCasemixAgency = totalCasemixAgencySum / totalEntries;
      var averageCasemix = totalCasemixSum / totalEntries;

      // Append a row at the bottom to show the total sum and averages
      var totalRow = "<tr><td colspan='14'><strong>Total:</strong></td>";
      
      totalRow += "<td><strong>" + totalCasemixAgencySum.toFixed(2) + "</strong></td>";  // Total for totalcasemixagency
      totalRow += "<td><strong>" + totalCasemixSum.toFixed(2) + "</strong></td>"; 
      totalRow += "<td></td>";
      totalRow += "<td></td>"; // Total for totalcasemix
      totalRow += "<td></td></tr>";

      var avgRow = "<tr><td colspan='14'><strong>Average:</strong></td>";
    
      avgRow += "<td><strong>" + averageCasemixAgency.toFixed(2) + "</strong></td>";  // Average for totalcasemixagency
      avgRow += "<td><strong>" + averageCasemix.toFixed(2) + "</strong></td>";
      avgRow += "<td></td>";
      avgRow += "<td></td>";  // Average for totalcasemix
      avgRow += "<td></td></tr>";

      // Append the total and average rows to the table
      $("#table_data").append(totalRow);
      $("#table_data").append(avgRow);
  },

  error: function (xhr, status, error) {
      // Handle error response
      console.error("Error:", xhr.responseText);
      // Clear previous results or show a message
      $("#table_data").empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
  }
});

  });
}


function changeDateInputIds() {
  var dateFilter = document.getElementById('date_filter').value;
  var fromDate = document.getElementById('from_date') || document.getElementById('from_date1');
  var toDate = document.getElementById('to_date') || document.getElementById('to_date1');

  if (dateFilter === 'Live-Report') {
      if (fromDate) fromDate.id = 'from_date1';
      if (toDate) toDate.id = 'to_date1';
  } else if (dateFilter === 'Assign-Date') {
      if (fromDate) fromDate.id = 'from_date';
      if (toDate) toDate.id = 'to_date';
  } else {
      if (fromDate) fromDate.id = 'from_date';
      if (toDate) toDate.id = 'to_date';
  }
}





function final_preview(Id) {
  //Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

//   alert(Id);

  // Open the URL in a new tab/window
  window.open("final_preview.php", "_blank");
}

function coder_preview(Id) {
    // alert(Id)
  //Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;
//   alert(Id);
  // Open the URL in a new tab/window
  window.open("generate_pdf.php", "_blank");
}

function qc_preview(Id) {

    // alert(Id)
  //Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;
//   alert(Id);
  // Open the URL in a new tab/window
  window.open("qc_single_preview.php", "_blank");
}