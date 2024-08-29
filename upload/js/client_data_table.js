$(document).ready(function () {
  //EXCEL REPORT DOWNLOADING

  click();

  document
    .getElementById("download_excel")
    .addEventListener("click", function () {
      var headers = Array.from(document.querySelectorAll("#head th"))
        .slice(0, -2)
        .map(function (th) {
          return th.textContent;
        });

      var rows = Array.from(document.querySelectorAll("#show_data tr")).map(
        function (row) {
          // Exclude last two cells in each row
          return Array.from(row.querySelectorAll("td")).map(function (cell) {
            return cell.textContent;
          });
        }
      );

      var data = [headers].concat(rows);

      var wb = XLSX.utils.book_new();
      var ws = XLSX.utils.aoa_to_sheet(data);
      XLSX.utils.book_append_sheet(wb, ws, "Sheet1"); // "Sheet1" is the sheet name
      XLSX.writeFile(wb, "Report.xlsx");
    });

  //EXCEL REPORT DOWNLOADING ENDING

});

function click(){
  $("#client_id").on("click", function () {
    
var fromdate = $("#from_date").val();
var todate = $("#to_date").val();
var mrn = $("#mrn_id").val();
var patient = $("#patient_id").val(); 
var status = $("#stds_id").val();
  

 console.log(fromdate,todate,mrn,patient,status);
 //show_files(data_date);
  


 if ( fromdate === '' || todate === '') {
  
    
 alert("Select Required fields.");
 
 return;
 } 

if(fromdate!='' && todate!='' && mrn!='' && patient==='' && status===''){

    var fromdate = fromdate;
    var todate = todate;
    var mrn = mrn;
   
            
 

      mrn_check(fromdate,todate,mrn);
            
}
else if(fromdate!='' && todate!='' && mrn==='' && patient!='' && status===''){

    var fromdate = fromdate;
    var todate = todate;
    var patient = patient;
    
 

       patient_check(fromdate,todate,patient);
            
}
 else if(fromdate!='' && todate!='' && status!='' && patient==='' && mrn===''){

      var fromdate = fromdate;
      var todate = todate;
      var status = status;
     
              
             
           

      status_check(fromdate,todate,status);
            
}
 else if(fromdate!='' && todate!='' && mrn ==='' && patient ==='' && status===''){

      var fromdate = fromdate;
      var todate = todate;
    
             
           

     all_report(fromdate,todate);
            
   }
 
});
}


function mrn_check(fromdate,todate,mrn) {
  
  $.ajax({
    url: "client_data_table.php?action=mrn_search",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
      mrn:mrn
    },
    // Define the success callback function to handle the response from the server
    success: function (response) {
      console.log("response",response);

      var pending_cmt = "";
      var pending_reason = "";
      var icon = "";
      var Sno = 0;

      $("#show_data").empty();

      if (Array.isArray(response.data)) {
        response.data.forEach(function (item) {
          Sno++;

          pending_cmt =
            item.pending_comments !== null ? item.pending_comments : "";
          pending_reason =
            item.pending_reason !== null ? item.pending_reason : "";



    // Given values
var pre_auditdata = item.totalcasemixagency;
var post_auditdata= item.totalcasemix;

// Check if values are null or empty
if (!pre_auditdata || !post_auditdata) {
    var final_value = ''; // Set final value to empty string
} else {
    // Convert strings to numbers
    var pre_auditdata_float = parseFloat(pre_auditdata.replace(/,/g, ''));
    var post_auditdata_float = parseFloat(post_auditdata.replace(/,/g, ''));

    // Calculate the final value
    var final_value = post_auditdata_float - pre_auditdata_float;
   var truncated_value = final_value.toFixed(3);
}

// Display the final value 




          
         



          var std;
          if (
            [
              "ALLOTED TO QC",
              "QC COMPLETED",
              "WIP",
              "QC",
              "QA WIP",
              "ASSIGNED TO TEAM",
              "PENDING",
              "REASSIGNED TO CODER",
              "ASSIGNED TO CODER",
              "REASSIGNED TO TEAM",
            ].includes(item.status)
          ) {
            std = "WIP";
            console.log(std);
          } else if (["APPROVED"].includes(item.status)) {
            std = "Completed";
          } else {
            std = item.status;
          }

          var row =
            "<tr>" +
            "<td>" +
            Sno +
            "</td>" +
            "<td>" +
            item.agency +
            "</td>" +
            "<td>" +
            item.patient_name +
            "</td>" +
            '<td name="mrn">' +
            item.mrn +
            "</td>" +
            "<td>" +
            item.insurance_type +
            "</td>" +
            "<td>" +
            item.assesment_type +
            "</td>" +
            "<td>" +
            item.assesment_date +
            "</td>" +
            '<td class="font-weight-medium"><div class="badge badge-pill badge-success">' +
            std +
            "</div></td>" +
            "<td>" +
            pending_cmt +
            "</td>" +
            "<td>" +
            pending_reason +
            "</td>";

          if (std == "Completed") {
            row +=
              "<td>" +
              item.totalcasemixagency +
              "</td>" +
              "<td>" +
              item.totalcasemix +
              "</td>" +
              "<td>" +
              truncated_value +
              "</td>" +
              '<td><a class="flow" onclick="final_preview(' +
              item.Id +
              ')"><i class="fas fa-eye ml-2" onclick="preview(' +
              item.Id +
              ')" style="cursor: pointer;"></i></a></td>' +
              '<td><td><i class="fas fa-question-circle query-icon" style="cursor: pointer; margin-left: -96px;"></i>' +
              icon +
              "</td></td>";
          } else {
            row += "<td></td><td></td><td></td><td></td><td></td>";
          }

          row += "</tr>";

          $("#show_data").append(row);
        });
      } else {
        alert("Response data is not an array:", response);
      }
    },

    error: function (xhr, status, error) {
      alert("AJAX Error: " + status, error);
    },
  });
}

function patient_check(fromdate,todate,patient) {
  
  $.ajax({
    url: "client_data_table.php?action=patient_search",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
      patient:patient
    },
    // Define the success callback function to handle the response from the server
    success: function (response) {
      console.log("response",response);

      var pending_cmt = "";
      var pending_reason = "";
      var icon = "";
      var Sno = 0;

      $("#show_data").empty();

      if (Array.isArray(response.data)) {
        response.data.forEach(function (item) {
          Sno++;

          pending_cmt =
            item.pending_comments !== null ? item.pending_comments : "";
          pending_reason =
            item.pending_reason !== null ? item.pending_reason : "";



    // Given values
var pre_auditdata = item.totalcasemixagency;
var post_auditdata= item.totalcasemix;

// Check if values are null or empty
if (!pre_auditdata || !post_auditdata) {
    var final_value = ''; // Set final value to empty string
} else {
    // Convert strings to numbers
    var pre_auditdata_float = parseFloat(pre_auditdata.replace(/,/g, ''));
    var post_auditdata_float = parseFloat(post_auditdata.replace(/,/g, ''));

    // Calculate the final value
    var final_value = post_auditdata_float - pre_auditdata_float;
   var truncated_value = final_value.toFixed(3);
}

// Display the final value 
 
          var std;
          if (
            [
              "ALLOTED TO QC",
              "QC COMPLETED",
              "WIP",
              "QC",
              "QA WIP",
              "ASSIGNED TO TEAM",
              "PENDING",
              "REASSIGNED TO CODER",
              "ASSIGNED TO CODER",
              "REASSIGNED TO TEAM",
            ].includes(item.status)
          ) {
            std = "WIP";
            console.log(std);
          } else if (["APPROVED"].includes(item.status)) {
            std = "Completed";
          } else {
            std = item.status;
          }

          var row =
            "<tr>" +
            "<td>" +
            Sno +
            "</td>" +
            "<td>" +
            item.agency +
            "</td>" +
            "<td>" +
            item.patient_name +
            "</td>" +
            '<td name="mrn">' +
            item.mrn +
            "</td>" +
            "<td>" +
            item.insurance_type +
            "</td>" +
            "<td>" +
            item.assesment_type +
            "</td>" +
            "<td>" +
            item.assesment_date +
            "</td>" +
            '<td class="font-weight-medium"><div class="badge badge-pill badge-success">' +
            std +
            "</div></td>" +
            "<td>" +
            pending_cmt +
            "</td>" +
            "<td>" +
            pending_reason +
            "</td>";

          if (std == "Completed") {
            row +=
              "<td>" +
              item.totalcasemixagency +
              "</td>" +
              "<td>" +
              item.totalcasemix +
              "</td>" +
              "<td>" +
              truncated_value +
              "</td>" +
              '<td><a class="flow" onclick="final_preview(' +
              item.Id +
              ')"><i class="fas fa-eye ml-2" onclick="preview(' +
              item.Id +
              ')" style="cursor: pointer;"></i></a></td>' +
              '<td><td><i class="fas fa-question-circle query-icon" style="cursor: pointer; margin-left: -96px;"></i>' +
              icon +
              "</td></td>";
          } else {
            row += "<td></td><td></td><td></td><td></td><td></td>";
          }

          row += "</tr>";

          $("#show_data").append(row);
        });
      } else {
        alert("Response data is not an array:", response);
      }
    },

    error: function (xhr, status, error) {
      alert("AJAX Error: " + status, error);
    },
  });
}

function status_check(fromdate,todate,status) {
  
  $.ajax({
    url: "client_data_table.php?action=status_search",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
      status:status
    },
    // Define the success callback function to handle the response from the server
    success: function (response) {
      console.log("response",response);

      var pending_cmt = "";
      var pending_reason = "";
      var icon = "";
      var Sno = 0;

      $("#show_data").empty();

      if (Array.isArray(response.data)) {
        response.data.forEach(function (item) {
          Sno++;

          pending_cmt =
            item.pending_comments !== null ? item.pending_comments : "";
          pending_reason =
            item.pending_reason !== null ? item.pending_reason : "";



    // Given values
var pre_auditdata = item.totalcasemixagency;
var post_auditdata= item.totalcasemix;

// Check if values are null or empty
if (!pre_auditdata || !post_auditdata) {
    var final_value = ''; // Set final value to empty string
} else {
    // Convert strings to numbers
    var pre_auditdata_float = parseFloat(pre_auditdata.replace(/,/g, ''));
    var post_auditdata_float = parseFloat(post_auditdata.replace(/,/g, ''));

    // Calculate the final value
    var final_value = post_auditdata_float - pre_auditdata_float;
   var truncated_value = final_value.toFixed(3);
}

// Display the final value 
 
          var std;
          if (
            [
              "ALLOTED TO QC",
              "QC COMPLETED",
              "WIP",
              "QC",
              "QA WIP",
              "ASSIGNED TO TEAM",
              "PENDING",
              "REASSIGNED TO CODER",
              "ASSIGNED TO CODER",
              "REASSIGNED TO TEAM",
            ].includes(item.status)
          ) {
            std = "WIP";
            console.log(std);
          } else if (["APPROVED"].includes(item.status)) {
            std = "Completed";
          } else {
            std = item.status;
          }

          var row =
            "<tr>" +
            "<td>" +
            Sno +
            "</td>" +
            "<td>" +
            item.agency +
            "</td>" +
            "<td>" +
            item.patient_name +
            "</td>" +
            '<td name="mrn">' +
            item.mrn +
            "</td>" +
            "<td>" +
            item.insurance_type +
            "</td>" +
            "<td>" +
            item.assesment_type +
            "</td>" +
            "<td>" +
            item.assesment_date +
            "</td>" +
            '<td class="font-weight-medium"><div class="badge badge-pill badge-success">' +
            std +
            "</div></td>" +
            "<td>" +
            pending_cmt +
            "</td>" +
            "<td>" +
            pending_reason +
            "</td>";

          if (std == "Completed") {
            row +=
              "<td>" +
              item.totalcasemixagency +
              "</td>" +
              "<td>" +
              item.totalcasemix +
              "</td>" +
              "<td>" +
              truncated_value +
              "</td>" +
              '<td><a class="flow" onclick="final_preview(' +
              item.Id +
              ')"><i class="fas fa-eye ml-2" onclick="preview(' +
              item.Id +
              ')" style="cursor: pointer;"></i></a></td>' +
              '<td><td><i class="fas fa-question-circle query-icon" style="cursor: pointer; margin-left: -96px;"></i>' +
              icon +
              "</td></td>";
          } else {
            row += "<td></td><td></td><td></td><td></td><td></td>";
          }

          row += "</tr>";

          $("#show_data").append(row);
        });
      } else {
        alert("Response data is not an array:", response);
      }
    },

    error: function (xhr, status, error) {
      alert("AJAX Error: " + status, error);
    },
  });
}

function all_report(fromdate,todate) {
  
  $.ajax({
    url: "client_data_table.php?action=all_report",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
     
    },
    // Define the success callback function to handle the response from the server
    success: function (response) {
      console.log("response",response);

      var pending_cmt = "";
      var pending_reason = "";
      var icon = "";
      var Sno = 0;

      $("#show_data").empty();

      if (Array.isArray(response.data)) {
        response.data.forEach(function (item) {
          Sno++;

          pending_cmt =
            item.pending_comments !== null ? item.pending_comments : "";
          pending_reason =
            item.pending_reason !== null ? item.pending_reason : "";



    // Given values
var pre_auditdata = item.totalcasemixagency;
var post_auditdata= item.totalcasemix;

// Check if values are null or empty
if (!pre_auditdata || !post_auditdata) {
    var final_value = ''; // Set final value to empty string
} else {
    // Convert strings to numbers
    var pre_auditdata_float = parseFloat(pre_auditdata.replace(/,/g, ''));
    var post_auditdata_float = parseFloat(post_auditdata.replace(/,/g, ''));

    // Calculate the final value
    var final_value = post_auditdata_float - pre_auditdata_float;
   var truncated_value = final_value.toFixed(3);
}

// Display the final value 
 
          var std;
          if (
            [
              "ALLOTED TO QC",
              "QC COMPLETED",
              "WIP",
              "QC",
              "QA WIP",
              "ASSIGNED TO TEAM",
              "PENDING",
              "REASSIGNED TO CODER",
              "ASSIGNED TO CODER",
              "REASSIGNED TO TEAM",
            ].includes(item.status)
          ) {
            std = "WIP";
            console.log(std);
          } else if (["APPROVED"].includes(item.status)) {
            std = "Completed";
          } else {
            std = item.status;
          }

          var row =
            "<tr>" +
            "<td>" +
            Sno +
            "</td>" +
            "<td>" +
            item.agency +
            "</td>" +
            "<td>" +
            item.patient_name +
            "</td>" +
            '<td name="mrn">' +
            item.mrn +
            "</td>" +
            "<td>" +
            item.insurance_type +
            "</td>" +
            "<td>" +
            item.assesment_type +
            "</td>" +
            "<td>" +
            item.assesment_date +
            "</td>" +
            '<td class="font-weight-medium"><div class="badge badge-pill badge-success">' +
            std +
            "</div></td>" +
            "<td>" +
            pending_cmt +
            "</td>" +
            "<td>" +
            pending_reason +
            "</td>";

          if (std == "Completed") {
            row +=
              "<td>" +
              item.totalcasemixagency +
              "</td>" +
              "<td>" +
              item.totalcasemix +
              "</td>" +
              "<td>" +
              truncated_value +
              "</td>" +
              '<td><a class="flow" onclick="final_preview(' +
              item.Id +
              ')"><i class="fas fa-eye ml-2" onclick="preview(' +
              item.Id +
              ')" style="cursor: pointer;"></i></a></td>' +
              '<td><td><i class="fas fa-question-circle query-icon" style="cursor: pointer; margin-left: -96px;"></i>' +
              icon +
              "</td></td>";
          } else {
            row += "<td></td><td></td><td></td><td></td><td></td>";
          }

          row += "</tr>";

          $("#show_data").append(row);
        });
      } else {
        alert("Response data is not an array:", response);
      }
    },

    error: function (xhr, status, error) {
      alert("AJAX Error: " + status, error);
    },
  });
}








// function show_files(data_date) {
//   var str = data_date;

//   console.log("before split  ", data_date);
//   var dateValues = str.split("-");
//   var fromdate = dateValues[0];
//   var todate = dateValues[1];
//   // console.log("SPLIT_AND_before  :", fromdate);
//   // console.log("SPILT_AND_before   todate:", todate);

//   fromdate = new Date(fromdate).toLocaleDateString("en-CA");
//   todate = new Date(todate).toLocaleDateString("en-CA");

//   // console.log("After Formatted fromdate:", fromdate);
//   //  console.log("After Formatted todate:", todate);

//   $.ajax({
//     url: "client_data_table.php",
//     type: "GET",
//     dataType: "json",
//     data: {
//       fromdate: fromdate,
//       todate: todate,
//     },
//     // Define the success callback function to handle the response from the server
//     success: function (response) {
//       console.log("response",response);

//       var pending_cmt = "";
//       var pending_reason = "";
//       var icon = "";
//       var Sno = 0;

//       $("#show_data").empty();

//       if (Array.isArray(response.data)) {
//         response.data.forEach(function (item) {
//           Sno++;

//           pending_cmt =
//             item.pending_comments !== null ? item.pending_comments : "";
//           pending_reason =
//             item.pending_reason !== null ? item.pending_reason : "";



//     // Given values
// var pre_auditdata = item.totalcasemixagency;
// var post_auditdata= item.totalcasemix;

// // Check if values are null or empty
// if (!pre_auditdata || !post_auditdata) {
//     var final_value = ''; // Set final value to empty string
// } else {
//     // Convert strings to numbers
//     var pre_auditdata_float = parseFloat(pre_auditdata.replace(/,/g, ''));
//     var post_auditdata_float = parseFloat(post_auditdata.replace(/,/g, ''));

//     // Calculate the final value
//     var final_value = post_auditdata_float - pre_auditdata_float;
//    var truncated_value = final_value.toFixed(3);
// }

// // Display the final value 




          
         



//           var std;
//           if (
//             [
//               "ALLOTED TO QC",
//               "QC COMPLETED",
//               "WIP",
//               "QC",
//               "QA WIP",
//               "ASSIGNED TO TEAM",
//               "PENDING",
//               "REASSIGNED TO CODER",
//               "ASSIGNED TO CODER",
//               "REASSIGNED TO TEAM",
//             ].includes(item.status)
//           ) {
//             std = "WIP";
//             console.log(std);
//           } else if (["APPROVED"].includes(item.status)) {
//             std = "Completed";
//           } else {
//             std = item.status;
//           }

//           var row =
//             "<tr>" +
//             "<td>" +
//             Sno +
//             "</td>" +
//             "<td>" +
//             item.agency +
//             "</td>" +
//             "<td>" +
//             item.patient_name +
//             "</td>" +
//             '<td name="mrn">' +
//             item.mrn +
//             "</td>" +
//             "<td>" +
//             item.insurance_type +
//             "</td>" +
//             "<td>" +
//             item.assesment_type +
//             "</td>" +
//             "<td>" +
//             item.assesment_date +
//             "</td>" +
//             '<td class="font-weight-medium"><div class="badge badge-pill badge-success">' +
//             std +
//             "</div></td>" +
//             "<td>" +
//             pending_cmt +
//             "</td>" +
//             "<td>" +
//             pending_reason +
//             "</td>";

//           if (std == "Completed") {
//             row +=
//               "<td>" +
//               item.totalcasemixagency +
//               "</td>" +
//               "<td>" +
//               item.totalcasemix +
//               "</td>" +
//               "<td>" +
//               truncated_value +
//               "</td>" +
//               '<td><a class="flow" onclick="final_preview(' +
//               item.Id +
//               ')"><i class="fas fa-eye ml-2" onclick="preview(' +
//               item.Id +
//               ')" style="cursor: pointer;"></i></a></td>' +
//               '<td><td><i class="fas fa-question-circle query-icon" style="cursor: pointer; margin-left: -96px;"></i>' +
//               icon +
//               "</td></td>";
//           } else {
//             row += "<td></td><td></td><td></td><td></td><td></td>";
//           }

//           row += "</tr>";

//           $("#show_data").append(row);
//         });
//       } else {
//         alert("Response data is not an array:", response);
//       }
//     },

//     error: function (xhr, status, error) {
//       alert("AJAX Error: " + status, error);
//     },
//   });
// }









function final_preview(Id) {
  document.cookie = `Id=${Id}; path=/`;

  window.open("final_preview.php", "_blank");
}

//CLIENT QUERYS UPDATING CODE START

$(document).on("click", ".query-icon", function () {
  var currentRow = $(this).closest("tr");
  var mrnCellValue = currentRow.find('td[name="mrn"]').text();
  var message = prompt(
    "Please enter your query for Selected MRN   " + mrnCellValue + ":"
  );

  if (message !== null && message !== "") {
    alert("You entered: " + message);
  } else {
    alert("No message entered.");
    return;
  }

  // Second Ajax call to update data
  $.ajax({
    url: "client_data_table.php",
    type: "GET",
    dataType: "json",
    data: {
      message: message,
      mrnCellValue: mrnCellValue,
    },
    success: function (response) {
      if (response.success) {
        alert("Message updated successfully.");
      } else {
        alert("Error: " + response.error);
      }
    },
    error: function (xhr, status, error) {
      alert("AJAX Error: " + status + ", " + error);
    },
  });

  //CLIENT QUERYS UPDATING CODE END
});
