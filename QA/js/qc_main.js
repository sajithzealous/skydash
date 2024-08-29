$(document).ready(function () {

  $("#ecommerce-dashboard-daterangepicker").on('change', function () {
        var date = $("#ecommerce-dashboard-daterangepicker").val();
        totalcount(date);

         
    });

  $("#qcfile").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    qcfile(date);
  });
  $("#qcwipfile").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    qcwipfile(date);
  });
  $("#qcappfile").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    qcappfile(date);
  });

    $("#qccompleted").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    qccompleted(date);
  });
  $("#directfile").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    directfile(date);
  });
  
});

function totalcount(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  console.log(fromdate);
    console.log(todate);

  $.ajax({
    url: "QA/qc_dash_count.php?action=qc_count",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
    },
      success: function (response) {
            console.log("qcOverall-Files_Count:", response);
            // Update HTML elements with the response values
            $("#file_count").text(response.New);
            $("#qc_wip_count").text(response.qa_wip);
            $("#qc_completed_count").text(response.qc_completed);
            $("#qc_app_count").text(response.approved);
            $("#directcount").text(response.qcdircmd);
            

            // console.log(response.approved);
        },
            error: function() {
                alert('Error occurred while counting records.');
            }
  });
}

  function qcfile(date) {
    var str = date;
    var dateValues = str.split("-");
    var fromdate = dateValues[0];
    var todate = dateValues[1];

    fromdate = new Date(fromdate).toLocaleDateString("en-CA");
    ("en-CA");   //represents the 'en'glish language in 'CA'nada
    todate = new Date(todate).toLocaleDateString("en-CA");

    $.ajax({
      url: "QA/qc_dash_count.php?action=qcfile",
      type: "GET",
     dataType: "json",
     data: {
       fromdate: fromdate,
       todate: todate,
     },
     success: function (data) {
       $("#data-table  ").empty();
       console.log(data);
       var teamDisplay = "";
       var coder = "";

       data.forEach(function (item) {
         teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
         coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
         $(".thd").html("");
         $(".thd").html(`<tr>
                        
                           <th>Alloted_Team</th>
                           <th>Agency</th>
                           <th>Patient_Name</th>
                         
                            <th>Mrn</th>
                           <th >Status</th>
                           <th >Coder</th>

                           
                           <th>Insurance_Type</th>
                            <th>AssesmentType</th>
                          <th>AssesmentDate</th>
                           <th>Previwe</th>
                         </tr>`);

       $("#data-table").append(
    "<tr><td>" +
    teamDisplay +
    "</td><td>" +
    item.agency +
    "</td><td>" +
    item.patient_name +
    "</td><td>" +
    item.mrn +
    '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' +
    item.status +
    "</div></td><td>" +
    coder +
    "</td><td>" +
    item.insurance_type +
    "</td><td>" +
    item.assesment_type +
    "</td><td>" +
    item.assesment_date +
    '</td><td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td></tr>'
);

       });
     },

     error: function (xhr, status, error) {
       console.error("AJAX Error: " + status, error);
     },
   });
 }

// function Inprogress(date) {
//   var str = date;
//   var dateValues = str.split("-");
//   var fromdate = dateValues[0];
//   var todate = dateValues[1];

//   fromdate = new Date(fromdate).toLocaleDateString("en-CA");
//   ("en-CA"); // represents the 'en'glish language in 'CA'nada
//   todate = new Date(todate).toLocaleDateString("en-CA");

//   $.ajax({
//     url: "show_files/file_9.php",
//     type: "GET",
//     dataType: "json",
//     data: {
//       fromdate: fromdate,
//       todate: todate,
//     },
//     success: function (data) {
//       $("#data-table  ").empty();
//       console.log(data);
//       var teamDisplay = "";
//       var coder = "";

//       data.forEach(function (item) {
//         teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
//         coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
//         $(".thd").html("");
//         $(".thd").html(`<tr>
                        
//                           <th>Alloted_Team</th>
//                           <th>Agency</th>
//                           <th>Patient_Name</th>
                         
//                            <th>Mrn</th>
//                           <th >Status</th>
//                           <th >Coder</th>

                           
//                           <th>Insurance_Type</th>
//                         </tr>`);

//         $("#data-table").append(
//           "<tr><td>" +
//             teamDisplay +
//             "</td><td>" +
//             item.agency +
//             "</td><td>" +
//             item.patient_name +
//             "</td><td>" +
//             item.mrn +
//             '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' +
//             item.status +
//             "</div></td><td>" +
//             coder +
//             "</td><td>" +
//             item.insurance_type +
//             "</td></tr>"
//         );
//       });
//     },

//     error: function (xhr, status, error) {
//       console.error("AJAX Error: " + status, error);
//     },
//   });
// }

  function qcwipfile(date) {
   var str = date;
   var dateValues = str.split("-");
   var fromdate = dateValues[0];
   var todate = dateValues[1];

    fromdate = new Date(fromdate).toLocaleDateString("en-CA");
    ("en-CA"); // represents the 'en'glish language in 'CA'nada
   todate = new Date(todate).toLocaleDateString("en-CA");

   $.ajax({
     url: "QA/qc_dash_count.php?action=qcwipfile",
     type: "GET",
     dataType: "json",
     data: {
       fromdate: fromdate,
       todate: todate,
     },
     success: function (data) {
       $("#data-table  ").empty();
       console.log(data);
       var teamDisplay = "";
       var coder = "";

       data.forEach(function (item) {
         teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
         coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
         $(".thd").html("");
         $(".thd").html(`<tr>
                        
                           <th>Alloted_Team</th>
                           <th>Agency</th>
                           <th>Patient_Name</th>
                         
                            <th>Mrn</th>
                           <th >Status</th>
                           <th >Coder</th>
                            <th>Qc Coder</th>

                           
                           <th>Insurance_Type</th>
                           <th>Coder_Previwe</th>
                           <th>Qc_Previwe</th>
                         
                         </tr>`);

          //Constructing table row dynamically
 var tableRow = 
   "<tr>" +
     "<td>" + teamDisplay + "</td>" +
     "<td>" + item.agency + "</td>" +
     "<td>" + item.patient_name + "</td>" +
     "<td>" + item.mrn + "</td>" +
     '<td class="font-weight-medium"><div class="badge badge-pill badge-danger">' + item.status + "</div></td>" +
     "<td>" + coder + "</td>" +
     "<td>" + item.qc_person + "</td>" +
     "<td>" + item.insurance_type + "</td>" +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
     '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
   "</tr>";

  //Appending the constructed row to the data table
 $("#data-table").append(tableRow);

       });
     },

     error: function (xhr, status, error) {
       console.error("AJAX Error: " + status, error);
     },
   });
  }

// function wip_file(date) {
//   var str = date;
//   var dateValues = str.split("-");
//   var fromdate = dateValues[0];
//   var todate = dateValues[1];

//   fromdate = new Date(fromdate).toLocaleDateString("en-CA");
//   ("en-CA"); // represents the 'en'glish language in 'CA'nada
//   todate = new Date(todate).toLocaleDateString("en-CA");

//   $.ajax({
//     url: "show_files/file_3.php",
//     type: "GET",
//     dataType: "json",
//     data: {
//       fromdate: fromdate,
//       todate: todate,
//     },
//     success: function (data) {
//       $("#data-table  ").empty();
//       // console.log(data);

//       var teamDisplay = "";
//       var coder = "";

//       data.forEach(function (item) {
//         teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
//         coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
//         $(".thd").html("");
//         $(".thd").html(`<tr>
                        
//                           <th>Alloted_Team</th>
//                           <th>Agency</th>
//                           <th>Patient_Name</th>
                         
//                            <th>Mrn</th>
//                           <th >Status</th>
//                           <th >Coder</th>

                           
//                           <th>Insurance_Type</th>
//                           <th>Previwe</th>
//                         </tr>`);

//        // Constructing table row dynamically
// var tableRow = 
//   "<tr>" +
//     "<td>" + teamDisplay + "</td>" +
//     "<td>" + item.agency + "</td>" +
//     "<td>" + item.patient_name + "</td>" +
//     "<td>" + item.mrn + "</td>" +
//     '<td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' + item.status + "</div></td>" +
//     "<td>" + coder + "</td>" +
//     "<td>" + item.insurance_type + "</td>" +
//     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
//   "</tr>";

// // Appending the constructed row to the data table
// $("#data-table").append(tableRow);

//       });
//     },

//     error: function (xhr, status, error) {
//       console.error("AJAX Error: " + status, error);
//     },
//   });
// }
  function qccompleted(date) {
 var str = date;
 var dateValues = str.split("-");
 var fromdate = dateValues[0];
 var todate = dateValues[1];

 fromdate = new Date(fromdate).toLocaleDateString("en-CA");
 ("en-CA"); // represents the 'en'glish language in 'CA'nada
 todate = new Date(todate).toLocaleDateString("en-CA");

 $.ajax({
   url: "QA/qc_dash_count.php?action=qccompleted",
   type: "GET",
   dataType: "json",
   data: {
     fromdate: fromdate,
     todate: todate,
   },
   success: function (data) {
     $("#data-table").empty();
     var teamDisplay = "";
     var coder = "";
     var std = "";

     data.forEach(function (item) {
       teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
       coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
       // std = item.ALLOTED TO QC !== null ? item.ALLOTED TO QC : 'alloted_to_coder';
      // std = item.ALLOTED TO QC !== null ? 'alloted_to_QC' : ' ';

       $(".thd").html("");
       $(".thd").html(`<tr>
                        
                         <th>Alloted_Team</th>
                         <th>Agency</th>
                         <th>Patient_Name</th>
                         
                          <th>Mrn</th>
                         <th >Status</th>
                         <th >Coder</th>
                         <th >QC-Coder</th>

                           
                         <th>Insurance_Type</th>
                           <th>AssesmentType</th>
                          <th>AssesmentDate</th>
                          <th>Coder_Preview</th>
                          <th>Qc_Preview</th>
                          <th>Final_Preview</th>
                             
                           
                         
                       </tr>`);

       // var originalNumber = item.totalcasemix;
      // var roundedNumber = parseFloat(originalNumber.toFixed(3));
      // console.log(roundedNumber);

    var newRow = "<tr>" +
         "<td>" + teamDisplay + "</td>" +
         "<td>" + item.agency + "</td>" +
         "<td>" + item.patient_name + "</td>" +
         "<td>" + item.mrn + "</td>" +
         '<td class="font-weight-medium"><div class="badge badge-success">' + item.status + "</div></td>" +
         "<td>" + coder + "</td>" +
         "<td>" + item.qc_person + "</td>" +
         "<td>" + item.assesment_date + "</td>" +
         "<td>" + item.assesment_type + "</td>" +
         "<td>" + item.insurance_type + "</td>" +
         '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
         '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
         '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
         
         "</tr>";

     $("#data-table").append(newRow);

          
       });
     },

     error: function (xhr, status, error) {
       console.error("AJAX Error: " + status, error);
     },
   });
  }

  function directfile(date) {
   var str = date;
   var dateValues = str.split("-");
   var fromdate = dateValues[0];
   var todate = dateValues[1];

   fromdate = new Date(fromdate).toLocaleDateString("en-CA");
   ("en-CA");  //represents the 'en'glish language in 'CA'nada
   todate = new Date(todate).toLocaleDateString("en-CA");

   $.ajax({
     url: "QA/qc_dash_count.php?action=directfile",
     type: "GET",
     dataType: "json",
     data: {
       fromdate: fromdate,
       todate: todate,
     },
     success: function (data) {
       $("#data-table  ").empty();
        console.log(data);
       var teamDisplay = "";
       var coder = "";

       data.forEach(function (item) {
         teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
         coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
         $(".thd").html("");
         $(".thd").html(`<tr>
                        
                           <th>Alloted_Team</th>
                           <th>Agency</th>
                           <th>Patient_Name</th>
                         
                            <th>Mrn</th>
                           <th >Status</th>
                           <th >Coder</th>
                           <th >QC-Coder</th
                           <th>Insurance_Type</th>
                           <th>AssesmentType</th>
                           <th>AssesmentDate</th>
                            <th>Previwe</th>
                         </tr>`);

      
         $("#data-table").append(
             "<tr><td>" +
               teamDisplay +
               "</td><td>" +
               item.agency +
               "</td><td>" +
               item.patient_name +
               "</td><td>" +
               item.mrn +
               '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' +
               item.status +
               "</div></td><td>" +
               coder +
               "</td><td>" +
               item.qc_person +
               "</td> <td>" +
               item.assesment_type +
               "</td><td>" +
               item.assesment_date +
               '</td><td><a class="btn btn-primary flow" onclick="coder_preview(' +
               item.Id +
               ')">Coder View</a></td></tr>'
           );
       });
     },

     error: function (xhr, status, error) {
       console.error("AJAX Error: " + status, error);
     },
   });
  }
// function assign_tem(date) {
//   var str = date;
//   var dateValues = str.split("-");
//   var fromdate = dateValues[0];
//   var todate = dateValues[1];

//   fromdate = new Date(fromdate).toLocaleDateString("en-CA");
//   ("en-CA"); // represents the 'en'glish language in 'CA'nada
//   todate = new Date(todate).toLocaleDateString("en-CA");

//   $.ajax({
//     url: "show_files/file_6.php",
//     type: "GET",
//     dataType: "json",
//     data: {
//       fromdate: fromdate,
//       todate: todate,
//     },
//     success: function (data) {
//       $("#data-table  ").empty();
//       var teamDisplay = "";
//       var coder = "";

//       data.forEach(function (item) {
//         teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
//         coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
//         $(".thd").html("");
//         $(".thd").html(`<tr>
                        
//                           <th>Alloted_Team</th>
//                           <th>Agency</th>
//                           <th>Patient_Name</th>
                         
//                            <th>Mrn</th>
//                           <th >Status</th>
                          

                           
//                           <th>Insurance_Type</th>
                         
//                         </tr>`);

//         $("#data-table").append(
//           "<tr><td>" +
//             teamDisplay +
//             "</td><td>" +
//             item.agency +
//             "</td><td>" +
//             item.patient_name +
//             "</td> <td>" +
//             item.mrn +
//             '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' +
//             item.status +
//             "</div></td><<td>" +
//             item.insurance_type +
//             "</td>/tr>"
//         );
//       });
//     },

//     error: function (xhr, status, error) {
//       console.error("AJAX Error: " + status, error);
//     },
//   });
// }
// function qccmd_file(date) {
//   var str = date;
//   var dateValues = str.split("-");
//   var fromdate = dateValues[0];
//   var todate = dateValues[1];

//   fromdate = new Date(fromdate).toLocaleDateString("en-CA");
//   ("en-CA"); // represents the 'en'glish language in 'CA'nada
//   todate = new Date(todate).toLocaleDateString("en-CA");

//   $.ajax({
//     url: "show_files/file_7.php",
//     type: "GET",
//     dataType: "json",
//     data: {
//       fromdate: fromdate,
//       todate: todate,
//     },
//     success: function (data) {
//       $("#data-table  ").empty();
//       var teamDisplay = "";
//       var coder = "";

//       data.forEach(function (item) {
//         teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
//         coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
//         $(".thd").html("");
//         $(".thd").html(`<tr>
                        
//                           <th>Alloted_Team</th>
//                           <th>Agency</th>
//                           <th>Patient_Name</th>
                         
//                            <th>Mrn</th>
//                           <th >Status</th>
//                           <th >Coder</th>
//                            <th >QC-Coder</th>

                           
//                           <th>Insurance_Type</th>
//                           <th>Previwe</th>
//                         </tr>`);

//         $("#data-table").append(
//           "<tr><td>" +
//             teamDisplay +
//             "</td><td>" +
//             item.agency +
//             "</td><td>" +
//             item.patient_name +
//             "</td> <td>" +
//             item.mrn +
//             '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' +
//             item.status +
//             "</div></td><td>" +
//             coder +
//             "</td><td>" +
//             item.qc_person +
//             "</td><td>" +
//             item.insurance_type +
//             '</td><td><a class="btn btn-primary flow" onclick="qc_preview(' +
//             item.Id +
//             ')">QC View</a></td></tr>'
//         );
//       });
//     },

//     error: function (xhr, status, error) {
//       console.error("AJAX Error: " + status, error);
//     },
//   });
// }
  function qcappfile(date) {
   var str = date;
   var dateValues = str.split("-");
   var fromdate = dateValues[0];
   var todate = dateValues[1];

   fromdate = new Date(fromdate).toLocaleDateString("en-CA");
   ("en-CA"); // represents the 'en'glish language in 'CA'nada
   todate = new Date(todate).toLocaleDateString("en-CA");

   $.ajax({
     url: "QA/qc_dash_count.php?action=qcappfile",
     type: "GET",
     dataType: "json",
     data: {
       fromdate: fromdate,
       todate: todate,
     },
     success: function (data) {
       $("#data-table  ").empty();
       var teamDisplay = "";
       var coder = "";

       data.forEach(function (item) {
         teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
         coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
         $(".thd").html("");
         $(".thd").html(`<tr>
                        
                           <th>Alloted_Team</th>
                           <th>Agency</th>
                           <th>Patient_Name</th>
                         
                            <th>Mrn</th>
                           <th >Status</th>
                           <th >Coder</th>
                           <th>Qc Coder</th>
                           <th>AssesmentType</th>
                           <th>AssesmentDate</th> 
                           <th>InsuranceType</th>
                            <th>Coder_preview</th>
                            <th>Qc_preview</th>
                            <th>final_preview</th>
                              <th>PPS</th>
                         </tr>`);

       var newRow = "<tr>" +
         "<td>" + teamDisplay + "</td>" +
         "<td>" + item.agency + "</td>" +
         "<td>" + item.patient_name + "</td>" +
         "<td>" + item.mrn + "</td>" +
         '<td class="font-weight-medium"><div class="badge badge-success">' + item.status + "</div></td>" +
         "<td>" + coder + "</td>" +
         "<td>" + item.qc_person + "</td>" +
         "<td>" + item.assesment_date + "</td>" +
         "<td>" + item.assesment_type + "</td>" +
         "<td>" + item.insurance_type + "</td>" +
         '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
         '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
         '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
         "<td>" + item.totalcasemix + "</td>" +
         "</tr>";

     $("#data-table").append(newRow);
       });
     },
     error: function (xhr, status, error) {
       console.error("AJAX Error: " + status, error);
     },
   });
  }


















// <td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>
//function of final view

function final_preview(Id) {
  //Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

  // Open the URL in a new tab/window
  window.open("final_preview.php", "_blank");
}

function coder_preview(Id) {
    // alert(Id)
  //Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

  // Open the URL in a new tab/window
  window.open("generate_pdf.php", "_blank");
}

function qc_preview(Id) {

    // alert(Id)
  //Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

  // Open the URL in a new tab/window
  window.open("qc_single_preview.php", "_blank");
}

 
