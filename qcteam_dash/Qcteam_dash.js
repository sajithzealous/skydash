$(document).ready(function () {
    $("#ecommerce-dashboard-daterangepicker").on('change', function () {
        var date = $("#ecommerce-dashboard-daterangepicker").val();

         var val = date;
         var str = date;

    console.log("before split date values",date);
    var dateValues = str.split("-");
    var fromdate = dateValues[0];
    var todate = dateValues[1];
 
fromdate = new Date(fromdate).toLocaleDateString('en-CA');  
todate = new Date(todate).toLocaleDateString('en-CA');
 
 files_count_check(fromdate,todate);
 
  });
 });

   $("#assign_to_qc").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    assign_to_qc(date);
  });
 function files_count_check(fromdate,todate) {


     $.ajax({
         url: "qcteam_dash/qc_tl_query.php?action=files_count",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate
         },
         success: function (response) {
             console.log("Overall-Files_Count:", response);
             // Update HTML elements with the response values
             $("#alloted_qc").text(response.allot_qc);
             $("#assigned_qccoder").text(response.assign_qc);
             $("#direct_completed").text(response.qc_direct_cmd);
             $("#qc_wip").text(response.qcwip);
             $("#qc_com").text(response.qc_cmd);
             $("#approvedfile").text(response.approved);
           
              console.log(response.approved);
         },
         error: function (xhr, status, error) {
             console.error("AJAX Error: " + status, error);
         }
     });
 }



function assign_to_qc(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "qcteam_dash/qc_tl_showdata.php?action=assign_qc",
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

  // Assuming data is your JSON array
data.forEach(function (item) {
    teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
    coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";

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
        "</td></tr>"
    );
});

// Set the table header outside the loop
$(".thd").html(`<tr>
    <th>Alloted Team</th>
    <th>Agency</th>
    <th>Patient Name</th>
    <th>MRN</th>
    <th>Status</th>
    <th>Coder</th>
    <th>Insurance Type</th>
    <th>Assessment Type</th>
    <th>Assessment Date</th>
</tr>`);

    },

    error: function (xhr, status, error) {
      console.error("AJAX Error: " + status, error);
    },
  });
}
   
 
     

//   //! Assigned to team on click event


function assign_qc(fromdate, todate) {
    $.ajax({
        url: " ",
        type: 'POST',
        data: {
            fromdate: fromdate,
            todate: todate
        },
        success: function (data) {

          console.log(data);
            // Clear existing table content
            $('#data-table').empty();

            // Parse JSON response
            var responseData = JSON.parse(data);

            // Create table header
            var tableHeader = `
                <tr style="background-color: #088394; color:white;">
                    <th>Alloted Team</th>
                    <th>Agency</th>
                    <th>Patient Name</th>
                    <th>MRN</th>
                    <th>Status</th>
                    <th>Alloted To Coder</th>
                    <th>Insurance Type</th>
                    <th>Assessment Type</th>
                </tr>`;
            $('#data-table').html(tableHeader);

            // Populate table rows with data
            $.each(responseData, function (index, user) {
                var tableRow = '<tr>' +
                    '<td>' + user.alloted_team + '</td>' +
                    '<td>' + user.agency + '</td>' +
                    '<td>' + user.patient_name + '</td>' +
                    '<td>' + user.mrn + '</td>' +
                    '<td class="font-weight-medium"><div class="badge badge-pill badge-assignteam ">' + user.status + '</div></td>' +
                    '<td>' + user.alloted_to_coder + '</td>' +
                    '<td>' + user.insurance_type + '</td>' +
                    '<td>' + user.assesment_type + '</td>' +
                    '</tr>';
                $('#data-table').append(tableRow);
            });

        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
            // Display error message to the user
            $('#data-table').html('<tr><td colspan="8">Error loading data</td></tr>');
        }
    });
}



//  //! Assigned to coder on click event
// $("#assign_coder").on('click', function () {
// assign_coder(fromdate1,todate1); 
// });
// function  assign_coder(fromdate1,todate1){
// $.ajax({
//     url: "team_dash/Qcteamdash_sql.php?action=assign_to_coder",
//     type: 'POST',
//     data: {
//         fromdate1: fromdate1,
//         todate1 : todate1
//     },
//   success: function (data) {
//     $('#data-table  ').empty();
//     console.log(data);
//     var datasucess;
//     var body='';
//     datasucess= JSON.parse(data);

//        var tableHeader = `
//     <tr style="background-color: #088394; color:white;">
//         <th>Alloted Team</th>
//         <th>Agency</th>
//         <th>Patient Name</th>
//         <th>MRN</th>
//         <th>Status</th>
//         <th>Alloted To Coder</th>
//         <th>Insurance Type</th>
//         <th>Assessment Type</th>
      
//     </tr>`;
// $('#data-table').html(tableHeader);
    
//     $.each(datasucess,function (index,user) { 

       


//         $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-assigncoder ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
//     });
                  
//    },

//     error: function (xhr, status, error) {
//         console.error("AJAX Error: " + status, error);
//     }
// });
// }

//  //! Allowed QC  on click event
//  $("#qc_file").on('click', function () {
//     qc_file(fromdate1,todate1); 
// });
// function  qc_file(fromdate1,todate1){
//   $.ajax({
//       url: "team_dash/Qcteamdash_sql.php?action=qc_file",
//       type: 'POST',
//       data: {
//           fromdate1: fromdate1,
//           todate1 : todate1
//       },
//     success: function (data) {
//       $('#data-table  ').empty();
//       console.log(data);
//       var datasuccess;
//       var body='';
//       var std='';
//       datasuccess= JSON.parse(data);

//          var tableHeader = `
//     <tr style="background-color: #088394; color:white;">
//         <th>Alloted Team</th>
//         <th>Agency</th>
//         <th>Patient Name</th>
//         <th>MRN</th>
//         <th>Status</th>
//         <th>Alloted To Coder</th>
//         <th>Insurance Type</th>
//         <th>Assessment Type</th>
//         <th>Preview</th>
//     </tr>`;
// $('#data-table').html(tableHeader);
      
//   $.each(datasuccess, function(index, user) {
//         var newRowHtml = `
//             <tr>
//                 <td>${user.alloted_team}</td>
//                 <td>${user.agency}</td>
//                 <td>${user.patient_name}</td>
//                 <td>${user.mrn}</td>
//                 <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
//                 <td>${user.alloted_to_coder}</td>
//                 <td>${user.insurance_type}</td>
//                 <td>${user.assesment_type}</td>
//                 <td><button class="btn btn-primary flow" onclick="coder_preview(${user.Id})">Coder View</button></td>
//             </tr>`;
//         // Append the new row to the table
//         $('#data-table').append(newRowHtml);
//     });
                    
//      },

//       error: function (xhr, status, error) {
//           console.error("AJAX Error: " + status, error);
//       }
//   });
// }
//    //! WIP QC Files  on click event
//    $("#wipqc_file").on('click', function () {
//     wipqc_file(fromdate1,todate1); 
//   });
//   function  wipqc_file(fromdate1,todate1){
//     $.ajax({
//         url: "team_dash/Qcteamdash_sql.php?action=wipqc_file",
//         type: 'POST',
//         data: {
//             fromdate1: fromdate1,
//             todate1 : todate1
//         },
//       success: function (data) {
//         $('#data-table  ').empty();
//         console.log(data);
//         var datasuccess;
//         var body='';
//         datasuccess= JSON.parse(data);

//            var tableHeader = `
//     <tr style="background-color: #088394; color:white;">
//         <th>Alloted Team</th>
//         <th>Agency</th>
//         <th>Patient Name</th>
//         <th>MRN</th>
//         <th>Status</th>
//         <th>Alloted To Coder</th>
//         <th>Insurance Type</th>
//         <th>Assessment Type</th>
//         <th>Preview</th>
//     </tr>`;
// $('#data-table').html(tableHeader);
        
//   $.each(datasuccess, function(index, user) {
//         var newRowHtml = `
//             <tr>
//                 <td>${user.alloted_team}</td>
//                 <td>${user.agency}</td>
//                 <td>${user.patient_name}</td>
//                 <td>${user.mrn}</td>
//                 <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
//                 <td>${user.alloted_to_coder}</td>
//                 <td>${user.insurance_type}</td>
//                 <td>${user.assesment_type}</td>
//                 <td><button class="btn btn-primary flow" onclick="qc_preview(${user.Id})">QC View</button></td>
//             </tr>`;
//         // Append the new row to the table
//         $('#data-table').append(newRowHtml);
//     });
                      
//        },
  
//         error: function (xhr, status, error) {
//             console.error("AJAX Error: " + status, error);
//         }
//     });
//   }
//        //!wip file  on click event
//        $("#wip_file").on('click', function () {
//         wip_file(fromdate1,todate1); 
//       });
//       function  wip_file(fromdate1,todate1){
//         $.ajax({
//             url: "team_dash/Qcteamdash_sql.php?action=wip_file",
//             type: 'POST',
//             data: {
//                 fromdate1: fromdate1,
//                 todate1 : todate1
//             },
//           success: function(data) {
//     $('#data-table').empty(); // Clear existing table data
//     console.log(data);
//     var datasuccess = JSON.parse(data);

//     // Define table header only once, not inside the loop
//     var tableHeader = `
//     <tr style="background-color: #088394; color:white;">
//         <th>Alloted Team</th>
//         <th>Agency</th>
//         <th>Patient Name</th>
//         <th>MRN</th>
//         <th>Status</th>
//         <th>Alloted To Coder</th>
//         <th>Insurance Type</th>
//         <th>Assessment Type</th>
//         <th>Preview</th>
//     </tr>`;
// $('#data-table').html(tableHeader);


//     // Loop through each data item and create table rows
//     $.each(datasuccess, function(index, user) {
//         var newRowHtml = `
//             <tr>
//                 <td>${user.alloted_team}</td>
//                 <td>${user.agency}</td>
//                 <td>${user.patient_name}</td>
//                 <td>${user.mrn}</td>
//                 <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
//                 <td>${user.alloted_to_coder}</td>
//                 <td>${user.insurance_type}</td>
//                 <td>${user.assesment_type}</td>
//                 <td><button class="btn btn-primary flow" onclick="coder_preview(${user.Id})">Coder View</button></td>
//             </tr>`;
//         // Append the new row to the table
//         $('#data-table').append(newRowHtml);
//     });
// },

      
//             error: function (xhr, status, error) {
//                 console.error("AJAX Error: " + status, error);
//             }
//         });
//       }
//         //!Completed file  on click event
//         $("#cmd_file").on('click', function () {
//             cmd_file(fromdate1,todate1); 
//         });
//         function cmd_file(fromdate1,todate1){
//          // alert("success");
//           $.ajax({
//               url: "team_dash/Qcteamdash_sql.php?action=cmd_file",
//               type: 'POST',
//               data: {
//                   fromdate1: fromdate1,
//                   todate1 : todate1
//               },
//             success: function (data) {
//               $('#data-table  ').empty();
//               console.log(data);
               
//               var body='';
//              var datasuccess= JSON.parse(data);

//  var tableHeader = `
//     <tr style="background-color: #088394; color:white;">
//         <th>Alloted Team</th>
//         <th>Agency</th>
//         <th>Patient Name</th>
//         <th>MRN</th>
//         <th>Status</th>
//         <th>Alloted To Coder</th>
//         <th>Insurance Type</th>
//         <th>Assessment Type</th>
//         <th>Preview</th>
//     </tr>`;
// $('#data-table').html(tableHeader);
              
//  $.each(datasuccess, function(index, user) {
//         var newRowHtml = `
//             <tr>
//                 <td>${user.alloted_team}</td>
//                 <td>${user.agency}</td>
//                 <td>${user.patient_name}</td>
//                 <td>${user.mrn}</td>
//                 <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
//                 <td>${user.alloted_to_coder}</td>
//                 <td>${user.insurance_type}</td>
//                 <td>${user.assesment_type}</td>
//                 <td><button class="btn btn-primary flow" onclick="coder_preview(${user.Id})">Coder View</button></td>
//             </tr>`;
//         // Append the new row to the table
//         $('#data-table').append(newRowHtml);
//     });
                            
//              },
        
//               error: function (xhr, status, error) {
//                   console.error("AJAX Error: " + status, error);
//               }
//           });
//         }
//       //! QC completed  on click event
//       $("#qccmd_file").on('click', function () {
//         qccmd_file(fromdate1,todate1); 
//       });
//       function  qccmd_file(fromdate1,todate1){
//         $.ajax({
//             url: "team_dash/Qcteamdash_sql.php?action=qccmd_file",
//             type: 'POST',
//             data: {
//                 fromdate1: fromdate1,
//                 todate1 : todate1
//             },
//           success: function (data) {
//             $('#data-table  ').empty();
//             console.log(data);
//             var datasuccess;
//             var body='';
//             datasuccess= JSON.parse(data);

//            var tableHeader = `
//     <tr style="background-color: #088394; color:white;">
//         <th>Alloted Team</th>
//         <th>Agency</th>
//         <th>Patient Name</th>
//         <th>MRN</th>
//         <th>Status</th>
//         <th>Alloted To Coder</th>
//         <th>Qc Coder</th>
//         <th>Insurance Type</th>
//         <th>Assessment Type</th>
//         <th>Coder-Preview</th>
//         <th>QC-Preview</th>
//     </tr>`;
// $('#data-table').html(tableHeader);
            
//  $.each(datasuccess, function(index, user) {
//         var newRowHtml = `
//             <tr>
//                 <td>${user.alloted_team}</td>
//                 <td>${user.agency}</td>
//                 <td>${user.patient_name}</td>
//                 <td>${user.mrn}</td>
//                 <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
//                 <td>${user.alloted_to_coder}</td>
//                 <td>${user.qc_person}</td>
//                 <td>${user.insurance_type}</td>
//                 <td>${user.assesment_type}</td>
//                 <td><button class="btn btn-primary flow" onclick="coder_preview(${user.Id})">Coder View</button></td>
//                 <td><button class="btn btn-primary flow" onclick="qc_preview(${user.Id})">Qc View</button></td>
//             </tr>`;
//         // Append the new row to the table
//         $('#data-table').append(newRowHtml);
//     });
                          
//           },
      
//             error: function (xhr, status, error) {
//                 console.error("AJAX Error: " + status, error);
//             }
//         });
//       }

//          //!  APPROVEL file  on click event
//          $("#aprd_file").on('click', function () {
//           aprd_file(fromdate1,todate1); 
//         });
//         function  aprd_file(fromdate1,todate1){
//           $.ajax({
//               url: "team_dash/Qcteamdash_sql.php?action=aprd_file",
//               type: 'POST',
//               data: {
//                   fromdate1: fromdate1,
//                   todate1 : todate1
//               },
//             success: function (data) {
//               $('#data-table  ').empty();
//               console.log(data);
//               var datasuccess;
//               var body='';
//               datasuccess= JSON.parse(data);

//   var tableHeader = `
//     <tr style="background-color: #088394; color:white;">
//         <th>Alloted Team</th>
//         <th>Agency</th>
//         <th>Patient Name</th>
//         <th>MRN</th>
//         <th>Status</th>
//         <th>Alloted To Coder</th>
//         <th>Qc Coder</th>
//         <th>Insurance Type</th>
//         <th>Assessment Type</th>
//         <th>Coder-Preview</th>
//         <th>Qc-Preview</th>
//         <th>Final-Preview</th>
//     </tr>`;
// $('#data-table').html(tableHeader);
              
// $.each(datasuccess, function(index, user) {
//         var newRowHtml = `
//             <tr>
//                 <td>${user.alloted_team}</td>
//                 <td>${user.agency}</td>
//                 <td>${user.patient_name}</td>
//                 <td>${user.mrn}</td>
//                 <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
//                 <td>${user.alloted_to_coder}</td>
//                 <td>${user.qc_person}</td>
//                 <td>${user.insurance_type}</td>
//                 <td>${user.assesment_type}</td>
//                 <td><button class="btn btn-primary flow" onclick="coder_preview(${user.Id})">Coder View</button></td>
//                 <td><button class="btn btn-primary flow" onclick="qc_preview(${user.Id})">Qc View</button></td>
//                 <td><button class="btn btn-primary flow" onclick="final_preview(${user.Id})">Final View</button></td>
//             </tr>`;
//         // Append the new row to the table
//         $('#data-table').append(newRowHtml);
//     });
                            
//             },
        
//               error: function (xhr, status, error) {
//                   console.error("AJAX Error: " + status, error);
//               }
//           });
//         }
      
// }); 


// function coder_preview(Id) {
//     //alert(Id);
//     // Set a cookie with the ID (optional, if needed in PHP)
//     document.cookie = `Id=${Id}; path=/`;

//     // Open the URL in a new tab/window
//     window.open("generate_pdf.php", "_blank");
// }

//  function final_preview(Id) {
//   //Set a cookie with the ID (optional, if needed in PHP)
//   document.cookie = `Id=${Id}; path=/`;

//   // Open the URL in a new tab/window
//   window.open("final_preview.php", "_blank");
// }


// function qc_preview(Id) {

//     // alert(Id)
//   //Set a cookie with the ID (optional, if needed in PHP)
//   document.cookie = `Id=${Id}; path=/`;

//   // Open the URL in a new tab/window
//   window.open("qc_single_preview.php", "_blank");
// }