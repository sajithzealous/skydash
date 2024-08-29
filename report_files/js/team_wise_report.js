$(document).ready(function(){

 var columnVisibility = [true, true, true, true, true, true, true, true, true, true, true, true, true];

    // Function to toggle column visibility
    function toggleColumn(column, isVisible) {
        $('#table_report th:eq(' + column + '), #table_report td:nth-child(' + (column + 1) + ')').toggle(isVisible);
    }

    // Event listener for column toggle checkboxes
    $('.column-toggle').change(function() {
        var column = parseInt($(this).data('column'));
        var isVisible = $(this).is(':checked');

        columnVisibility[column] = isVisible;
        toggleColumn(column, isVisible);
    });
    document.addEventListener("DOMContentLoaded", function() {
    const toggleColumnsBtn = document.getElementById("toggleColumnsBtn");
    const columnPanel = document.getElementById("columnSelectionPanel");

    toggleColumnsBtn.addEventListener("click", function() {
        columnPanel.classList.toggle("show");
    });

    const checkboxes = document.querySelectorAll(".column-toggle");
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {
            const column = parseInt(this.getAttribute("data-column"));
            // Implement column visibility toggle logic here
            // Example: $('#table_report th:eq(' + column + '), #work_log_data td:nth-child(' + (column + 1) + ')').toggle(this.checked);
        });
    });
});



    worklog();
    quality_reports();
    qafeedback_report();
    production_reports();
    changeDateInputIds();

    
 
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


//QUALITY-REPORT-team_select2
 $('#team_select2').on('change',function() {
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
                $('#coder_name2').html(options);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });


 //QA-FEEDBACK-REPORT-team_select3

 $('#team_select3').on('change',function() {
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
               $('#coder_name3').html(options);
           },
           error: function(xhr, status, error) {
               console.error("Error:", error);
           }
       });
   });

 



function production_reports() {
    $("#searchbtn").on('click', function () {

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

        // Call the function to change the input IDs based on the selected filter
        changeDateInputIds();

        // Fetch the values after changing the IDs
        var fromdate1 = $("#from_date1").val();
        var todate1 = $("#to_date1").val();
        var fromdate = $("#from_date").val();
        var todate = $("#to_date").val();
        var team_select = $("#team_select").val();
        var coder_name = $("#coder_name").val();
        var status = $("#status").val();
        var mrn = $("#mrn_sea").val();
        var p_name = $("#p_name").val();





        var agency = [];
    $('input[name="selectedAgencies[]"]:checked').each(function() {
        agency.push($(this).val());
    });

    console.log("agency_name", agency);

    // Check if required fields are empty
    if (fromdate === '' || todate === '') {
        alert("Select Required fields.");
        return;
    }

    if (team_select !== '') {
        if (status !== '') {
            if (coder_name !== '') {
                team_with_coder_status_report(fromdate, todate, team_select, coder_name, status,todate1,fromdate1);
            } else {
                team_with_status_report(fromdate, todate, team_select, status,todate1,fromdate1);
            }
        } else if (coder_name !== '') {
            team_with_coder_report(fromdate, todate, team_select, coder_name,todate1,fromdate1);
        } else if (agency.length > 0) {
            agency_team(fromdate, todate, team_select, agency,todate1,fromdate1);
        } else {
            team_report(fromdate, todate, team_select,todate1,fromdate1);
        }
    } else if (status !== '') {
        if (agency.length > 0) {
            agency_status(fromdate, todate, agency, status,todate1,fromdate1);
        } else {
            dastatus(fromdate, todate, status,todate1,fromdate1);
        }
    } else if (agency.length > 0) {
        if (mrn === '' && p_name === '') {
            agency_full_report(fromdate, todate, agency,todate1,fromdate1);
        } else if (status !== '') {
            agency_status(fromdate, todate, agency, status,todate1,fromdate1);
        }
    } else if (mrn !== '') {
        pro_mrn(fromdate, todate, mrn,todate1,fromdate1);
    } else if (p_name !== '') {
        pro_p_name(fromdate, todate, p_name,fromdate1,todate1);
    } else {
        All_team(fromdate, todate,fromdate1,todate1);
    }
 

      });
}

 
    //PRODUNCTION-REPORT-searchbtn
// function production_reports(){
// $("#searchbtn").on('click', function () {

//      function changeDateInputIds() {
//             var dateFilter = document.getElementById('date_filter').value;
//             var fromDate = document.getElementById('from_date');
//             var toDate = document.getElementById('to_date');

//             if (dateFilter === 'Live-Report') {
//                 fromDate.id = 'from_date1';
//                 toDate.id = 'to_date1';
//             } else if (dateFilter === 'Assign-Date'){
//                 fromDate.id = 'from_date';
//                 toDate.id = 'to_date';
//             }
//             else{

//                 fromDate.id = 'from_date';
//                 toDate.id = 'to_date';

//             }
//         }

//     var fromdate1 = $("#from_date1").val();
//     var todate1 = $("#to_date1").val();
//     var fromdate = $("#from_date").val();
//     var todate = $("#to_date").val();
//     var team_select = $("#team_select").val();
//     var coder_name = $("#coder_name").val();
//     var status = $("#status").val();
//     var mrn = $("#mrn_sea").val();
//     var p_name = $("#p_name").val();

 
    
//     var agency = [];
//     $('input[name="selectedAgencies[]"]:checked').each(function() {
//         agency.push($(this).val());
//     });

//     console.log("agency_name", agency);

//     // Check if required fields are empty
//     if (fromdate === '' || todate === '') {
//         alert("Select Required fields.");
//         return;
//     }

//     if (team_select !== '') {
//         if (status !== '') {
//             if (coder_name !== '') {
//                 team_with_coder_status_report(fromdate, todate, team_select, coder_name, status,todate1,fromdate1);
//             } else {
//                 team_with_status_report(fromdate, todate, team_select, status,todate1,fromdate1);
//             }
//         } else if (coder_name !== '') {
//             team_with_coder_report(fromdate, todate, team_select, coder_name,todate1,fromdate1);
//         } else if (agency.length > 0) {
//             agency_team(fromdate, todate, team_select, agency);
//         } else {
//             team_report(fromdate, todate, team_select);
//         }
//     } else if (status !== '') {
//         if (agency.length > 0) {
//             agency_status(fromdate, todate, agency, status);
//         } else {
//             dastatus(fromdate, todate, status);
//         }
//     } else if (agency.length > 0) {
//         if (mrn === '' && p_name === '') {
//             agency_full_report(fromdate, todate, agency);
//         } else if (status !== '') {
//             agency_status(fromdate, todate, agency, status);
//         }
//     } else if (mrn !== '') {
//         pro_mrn(fromdate, todate, mrn);
//     } else if (p_name !== '') {
//         pro_p_name(fromdate, todate, p_name,fromdate1,todate1);
//     } else {
//         All_team(fromdate, todate,fromdate1,todate1);
//     }
 



// // Additional code if needed




//  });
    

// // document.getElementById('download_excel').addEventListener('click', function () {
// //     var headers = Array.from(document.querySelectorAll("#head th")).slice(0, -3).map(function (th) {
// //         return th.textContent;
// //     });

// //     var rows = Array.from(document.querySelectorAll("#table_data tr")).map(function (row) {
// //         // Exclude last two cells in each row
// //         var cells = Array.from(row.querySelectorAll('td'));
// //         cells.splice(-3); // Remove last two cells from the array
// //         return cells.map(function (cell) {
// //             return cell.textContent;
// //         });
// //     });

// //     var data = [headers].concat(rows);

// //     var wb = XLSX.utils.book_new();
// //     var ws = XLSX.utils.aoa_to_sheet(data);
// //     XLSX.utils.book_append_sheet(wb, ws, "Sheet1"); // "Sheet1" is the sheet name
// //     XLSX.writeFile(wb, "Production-Report.xlsx");
// // });



 
// }

    //QUALITY-REPORT-searchbtn2
function quality_reports(){
$("#searchbtn2").on('click', function () {
    // Retrieve values from input fields
    var fromdate = $("#from_date2").val();
    var todate = $("#to_date2").val();
    var team_select = $("#team_select2").val();
    var coder_name = $("#coder_name2").val();

    // Retrieve selected agencies
    var agency = [];
    $('input[name="Agencies[]"]:checked').each(function() {
        agency.push($(this).val());
    });
    console.log("Selected Agencies:", agency);

    // Input validation
    if (fromdate === '' || todate === '') {
        alert("Please select required fields.");
        return;
    }

    // Determine the action based on inputs
    if (fromdate !== '' && todate !== '') {
        if (team_select !== '' && coder_name === '' && agency.length === 0) {
            team_audit_report(fromdate, todate, team_select);
        } else if (team_select !== '' && coder_name !== '' && agency.length === 0) {
            team_with_coder_audit_report(fromdate, todate, team_select, coder_name);
        } else if (team_select === '' && agency.length === 0) {
            qaAll_team(fromdate, todate);
        } else if (agency.length !== 0 && team_select === '' && coder_name === '') {
            agency_qc(fromdate, todate, agency);
        } else if (agency.length !== 0 && team_select !== '' && coder_name === '') {
            agency_team_qc(fromdate, todate, agency, team_select);
        } else if (agency.length !== 0 && team_select !== '' && coder_name !== '') {
            agency_team_coder_qc(fromdate, todate, agency, team_select, coder_name);
        } else {
            console.log("Unhandled case!");
        }
    } else {
        console.log("Unhandled case!");
    }
});


   
  }
     //    document.getElementById('download_excel1').addEventListener('click', function () {
     //     var headers = Array.from(document.querySelectorAll("#head1 th")).map(function (th) {
     //         return th.textContent;
     //     });

     //     var rows = Array.from(document.querySelectorAll("#table_data2 tr")).map(function (row) {
     //         // Exclude last two cells in each row
     //         return Array.from(row.querySelectorAll('td')).map(function (cell) {
     //             return cell.textContent;
     //         });
     //     });

     //     var data = [headers].concat(rows);

     //     var wb = XLSX.utils.book_new();
     //     var ws = XLSX.utils.aoa_to_sheet(data);
     //     XLSX.utils.book_append_sheet(wb, ws, "Sheet1");   
     //     XLSX.writeFile(wb, "Quality-Report.xlsx");
     // });

 //FEEDBACK-REPORT-searchbtn3
  function qafeedback_report(){
    $("#searchbtn3").on('click', function () {

        var fromdate = $("#from_date3").val();
        var todate = $("#to_date3").val();
        var team_select = $("#team_select3").val();
        var coder_name = $("#coder_name3").val();
        var status = $("#status3").val();
        var Segment = $("#segment").val();


       

       if ( fromdate === '' || todate === '' || Segment === '') {
  
    
    alert("Select Required fields.");
 
    return;
} 

        if(fromdate!='' && todate!='' && team_select!='' && Segment!='All' && coder_name ==='' && status ===''){

            var fromdate = fromdate;
            var todate = todate;
            var team_select = team_select;
            var Segment = Segment;
            
 

             teamfeedback(fromdate,todate,team_select,Segment);
            
        }
        else if(fromdate!='' && todate!='' && team_select!='' && Segment!='' && coder_name ==='' && status!=''){

            var fromdate = fromdate;
            var todate = todate;
            var team_select = team_select;
            var status = status;
            var Segment = Segment;
 

             team_with_status_feedback(fromdate,todate,team_select,status,Segment);
            
        }
      else if(fromdate!='' && todate!='' && team_select!='' && Segment!='' && coder_name!='' && status ===''){

              var fromdate = fromdate;
              var todate = todate;
              var team_select = team_select;
              var coder_name = coder_name;
              var Segment = Segment;
              
             
           

            coderfeedback(fromdate,todate,team_select,coder_name,Segment);
            
        }
    else if(fromdate!='' && todate!='' && team_select!='' && Segment!='' && coder_name!=''&& status!=''){

              var fromdate = fromdate;
              var todate = todate;
              var team_select = team_select;
              var coder_name = coder_name;
               var status = status;
               var Segment = Segment;
             
           

            coder_with_status_feedback(fromdate,todate,team_select,coder_name,status,Segment);
            
        }
       else if(fromdate!='' && todate!='' && team_select!='' && Segment === 'All' && coder_name==='' && status===''){
    var fromdate = fromdate;
    var todate = todate;
    var team_select = team_select;
    var coder_name = coder_name;
    var status = status;
    var Segment = Segment;
             
    // alert();

    team_all_feedback(fromdate, todate, team_select, Segment);
}

        
    });


 
  }
  
 // document.getElementById('download_excel2').addEventListener('click', function () {
 //         var headers = Array.from(document.querySelectorAll("#head2 th")).map(function (th) {
 //             return th.textContent;
 //         });

 //         var rows = Array.from(document.querySelectorAll("#table_data3 tr")).map(function (row) {
               
 //             return Array.from(row.querySelectorAll('td')).map(function (cell) {
 //                 return cell.textContent;
 //             });
 //         });

 //         var data = [headers].concat(rows);

 //         var wb = XLSX.utils.book_new();
 //         var ws = XLSX.utils.aoa_to_sheet(data);
 //         XLSX.utils.book_append_sheet(wb, ws, "Sheet1");   
 //         XLSX.writeFile(wb, "FeedBack-Report.xlsx");
 //     });

 //WORKLOG-REPORT-searchLlog 
function worklog(){

    $('#work_log').on("click",function(){
  

var fromdate = $("#from").val();
var todate = $("#to").val();
var mrn = $("#mrn_id").val();
var patient = $("#patient_id").val();
var agency = $("#agency_get").val();
var status = $("#status_get").val();
       

 if ( fromdate === '' || todate === '') {
  
    
 alert("Select Required fields.");
 
 return;
 } 

if(fromdate!='' && todate!='' && mrn!='' && patient==='' ){

    var fromdate = fromdate;
    var todate = todate;
    var mrn = mrn;
   
            
 

      mrn_check(fromdate,todate,mrn);
            
}
else if(fromdate!='' && todate!='' && mrn!='' && patient!='' ){

    var fromdate = fromdate;
    var todate = todate;
    var mrn = mrn;
    var patient = patient;
    
 

      mrn_patient(fromdate,todate,mrn,patient);
            
}
 else if(fromdate!='' && todate!='' && mrn==='' && patient!=''){

      var fromdate = fromdate;
      var todate = todate;
      var patient = patient;
     
              
             
           

     patient_check(fromdate,todate,patient);
            
}
 else if(fromdate!='' && todate!='' && mrn ==='' && patient ===''){

      var fromdate = fromdate;
      var todate = todate;
    
             
           

     all_log(fromdate,todate);
            
   }
 


    });
 }

 
 
//PRODUNCTION-REPORT-FUNCTIONS

function team_with_status_report(fromdate, todate, team_select,status,todate1,fromdate1) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=teamstatus",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            status:status,
            fromdate1,fromdate1,
            todate1,todate1
        },
        success: function(data) {
            $('#table_data').empty();
            data.forEach(function(item) {


let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
} 


// Assuming this is inside a loop
var rowData = '<tr>' +
    '<td>' + Sno + '</td>' +
    '<td>' + (item.alloted_to_coder || '') + '</td>' +
    '<td>' + (item.coder_emp_id || '') + '</td>' +
    '<td>' + (item.alloted_team || '') + '</td>' +
    '<td>' + (item.patient_name || '') + '</td>' +
    '<td>' + (item.mrn || '') + '</td>' +
    '<td>' + (item.insurance_type || '') + '</td>' +
    '<td>' + (item.assesment_date || '') + '</td>' +
    '<td>' + (item.assesment_type || '') + '</td>' +
    '<td>' + (item.agency || '') + '</td>' +
    '<td>' + (item.status || '') + '</td>' +
    '<td>' + (item.pending_comments || '') + '</td>' +
    '<td>' + (item.pending_reason || '') + '</td>' +
    '<td>' + (item.pending_date || '') + '</td>' +
    '<td>' + (item.totalcasemixagency || '') + '</td>' +
    '<td>' + (item.totalcasemix || '') + '</td>' +
    '<td>' + (AssigndateOnly || '') + '</td>' +
    '<td>' + (qc_date_only || '') + '</td>' +
    '<td>' + (qc_completed_date_only || '') + '</td>' +
    '<td>' + (item.total_working_hours || '') + '</td>' +
    '<td>' + (CompleteddateOnly || '') + '</td>' +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
    '</tr>';

$('#table_data').append(rowData);
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}

function agency_data(fromdate,todate,team_select,status,agency) {

    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=team_status_agency_report",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            status:status,
            agency:agency
        },
        success: function(data) {
            $('#table_data').empty();
            data.forEach(function(item) {

let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
}   

// Assuming this is inside a loop
var rowData = '<tr>' +
    '<td>' + Sno + '</td>' +
    '<td>' + (item.alloted_to_coder || '') + '</td>' +
    '<td>' + (item.coder_emp_id || '') + '</td>' +
    '<td>' + (item.alloted_team || '') + '</td>' +
    '<td>' + (item.patient_name || '') + '</td>' +
    '<td>' + (item.mrn || '') + '</td>' +
    '<td>' + (item.insurance_type || '') + '</td>' +
    '<td>' + (item.assesment_date || '') + '</td>' +
    '<td>' + (item.assesment_type || '') + '</td>' +
    '<td>' + (item.agency || '') + '</td>' +
    '<td>' + (item.status || '') + '</td>' +
    '<td>' + (item.pending_comments || '') + '</td>' +
    '<td>' + (item.pending_reason || '') + '</td>' +
    '<td>' + (item.pending_date || '') + '</td>' +
    '<td>' + (item.totalcasemixagency || '') + '</td>' +
    '<td>' + (item.totalcasemix || '') + '</td>' +
    '<td>' + (AssigndateOnly || '') + '</td>' +
    '<td>' + (qc_date_only || '') + '</td>' +
    '<td>' + (qc_completed_date_only || '') + '</td>' +
    '<td>' + (item.total_working_hours || '') + '</td>' +
    '<td>' + (CompleteddateOnly || '') + '</td>' +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
    '</tr>';

$('#table_data').append(rowData);
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}

function team_report(fromdate, todate, team_select,todate1,fromdate1) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=team",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            fromdate1,fromdate1,
            todate1,todate1
            
        },
        success: function(data) {
            console.log(data);
            $('#table_data').empty();
            data.forEach(function(item) {


let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
} 


// Assuming this is inside a loop
var rowData = '<tr>' +
    '<td>' + Sno + '</td>' +
    '<td>' + (item.alloted_to_coder || '') + '</td>' +
    '<td>' + (item.coder_emp_id || '') + '</td>' +
    '<td>' + (item.alloted_team || '') + '</td>' +
    '<td>' + (item.patient_name || '') + '</td>' +
    '<td>' + (item.mrn || '') + '</td>' +
    '<td>' + (item.insurance_type || '') + '</td>' +
    '<td>' + (item.assesment_date || '') + '</td>' +
    '<td>' + (item.assesment_type || '') + '</td>' +
    '<td>' + (item.agency || '') + '</td>' +
    '<td>' + (item.status || '') + '</td>' +
    '<td>' + (item.pending_comments || '') + '</td>' +
    '<td>' + (item.pending_reason || '') + '</td>' +
    '<td>' + (item.pending_date || '') + '</td>' +
    '<td>' + (item.totalcasemixagency || '') + '</td>' +
    '<td>' + (item.totalcasemix || '') + '</td>' +
    '<td>' + (AssigndateOnly || '') + '</td>' +
     '<td>' + (qc_date_only || '') + '</td>' +
      '<td>' + (qc_completed_date_only || '') + '</td>' +
    '<td>' + (item.total_working_hours || '') + '</td>' +
    '<td>' + (CompleteddateOnly || '') + '</td>' +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
    '</tr>';

$('#table_data').append(rowData);
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}


function team_with_coder_report(fromdate, todate, team_select,coder_name,todate1,fromdate1) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];

    var parts1 = coder_name.split(" - ");
    var codername = parts1[0];
    var coderid = parts1[1];

    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=coder",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            codername: codername,
            coderid: coderid,
            fromdate1,fromdate1,
            todate1,todate1
        },
        success: function(data) {
            $('#table_data').empty();
            data.forEach(function(item) {

let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
}   
 
var rowData = '<tr>' +
    '<td>' + Sno + '</td>' +
    '<td>' + (item.alloted_to_coder || '') + '</td>' +
    '<td>' + (item.coder_emp_id || '') + '</td>' +
    '<td>' + (item.alloted_team || '') + '</td>' +
    '<td>' + (item.patient_name || '') + '</td>' +
    '<td>' + (item.mrn || '') + '</td>' +
    '<td>' + (item.insurance_type || '') + '</td>' +
    '<td>' + (item.assesment_date || '') + '</td>' +
    '<td>' + (item.assesment_type || '') + '</td>' +
    '<td>' + (item.agency || '') + '</td>' +
    '<td>' + (item.status || '') + '</td>' +
    '<td>' + (item.pending_comments || '') + '</td>' +
    '<td>' + (item.pending_reason || '') + '</td>' +
    '<td>' + (item.pending_date || '') + '</td>' +
    '<td>' + (item.totalcasemixagency || '') + '</td>' +
    '<td>' + (item.totalcasemix || '') + '</td>' +
    '<td>' + (AssigndateOnly || '') + '</td>' +
    '<td>' + (qc_date_only || '') + '</td>' +
    '<td>' + (qc_completed_date_only || '') + '</td>' +
    '<td>' + (item.total_working_hours || '') + '</td>' +
    '<td>' + (CompleteddateOnly || '') + '</td>' +
    '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
    '</tr>';

$('#table_data').append(rowData);
                Sno++;
            });
        },
        error: function(xhr, status, error) {
    console.error(xhr.responseText);
    $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
}

    });
}



function team_with_coder_status_report(fromdate, todate, team_select, coder_name, status,todate1,fromdate1) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];

    var parts1 = coder_name.split(" - ");
    var codername = parts1[0];
    var coderid = parts1[1];

    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=coderstatus",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            codername: codername,
            coderid: coderid,
            status:status,
            fromdate1:fromdate1,
            todate1:todate1


        },
        success: function(data) {
            $('#table_data').empty();
            data.forEach(function(item) {

let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
}  


// Assuming this is inside a loop
var rowData = '<tr>' +
    '<td>' + Sno + '</td>' +
    '<td>' + (item.alloted_to_coder || '') + '</td>' +
    '<td>' + (item.coder_emp_id || '') + '</td>' +
    '<td>' + (item.alloted_team || '') + '</td>' +
    '<td>' + (item.patient_name || '') + '</td>' +
    '<td>' + (item.mrn || '') + '</td>' +
    '<td>' + (item.insurance_type || '') + '</td>' +
    '<td>' + (item.assesment_date || '') + '</td>' +
    '<td>' + (item.assesment_type || '') + '</td>' +
    '<td>' + (item.agency || '') + '</td>' +
    '<td>' + (item.status || '') + '</td>' +
    '<td>' + (item.pending_comments || '') + '</td>' +
    '<td>' + (item.pending_reason || '') + '</td>' +
    '<td>' + (item.pending_date || '') + '</td>' +
    '<td>' + (item.totalcasemixagency || '') + '</td>' +
    '<td>' + (item.totalcasemix || '') + '</td>' +
    '<td>' + (AssigndateOnly || '') + '</td>' +
    '<td>' + (qc_date_only || '') + '</td>' +
    '<td>' + (qc_completed_date_only || '') + '</td>' +
    '<td>' + (item.total_working_hours || '') + '</td>' +
    '<td>' + (CompleteddateOnly || '') + '</td>' +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
    '</tr>';

$('#table_data').append(rowData);
                Sno++;
            });
        },
        error: function(xhr, status, error) {
    console.error(xhr.responseText);
    $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
}

    });
}

function All_team(fromdate, todate,fromdate1,todate1) {
    

    var team = team_select;
   
     
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=All",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            fromdate1: fromdate1,
            todate: todate,
            todate1: todate1,
            
       
        },
        success: function(data) {
            $('#table_data').empty();
            data.forEach(function(item) {

let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
}  



// Assuming this is inside a loop
var rowData = '<tr>' +
    '<td>' + Sno + '</td>' +
    '<td>' + (item.alloted_to_coder || '') + '</td>' +
    '<td>' + (item.coder_emp_id || '') + '</td>' +
    '<td>' + (item.alloted_team || '') + '</td>' +
    '<td>' + (item.patient_name || '') + '</td>' +
    '<td>' + (item.mrn || '') + '</td>' +
    '<td>' + (item.insurance_type || '') + '</td>' +
    '<td>' + (item.assesment_date || '') + '</td>' +
    '<td>' + (item.assesment_type || '') + '</td>' +
    '<td>' + (item.agency || '') + '</td>' +
    '<td>' + (item.status || '') + '</td>' +
    '<td>' + (item.pending_comments || '') + '</td>' +
    '<td>' + (item.pending_reason || '') + '</td>' +
    '<td>' + (item.pending_date || '') + '</td>' +
    '<td>' + (item.totalcasemixagency || '') + '</td>' +
    '<td>' + (item.totalcasemix || '') + '</td>' +
    '<td>' + (AssigndateOnly || '') + '</td>' +
      '<td>' + (qc_date_only || '') + '</td>' +
    '<td>' + (qc_completed_date_only || '') + '</td>' +
    '<td>' + (item.total_working_hours || '') + '</td>' +
    '<td>' + (CompleteddateOnly || '') + '</td>' +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
    '</tr>';

$('#table_data').append(rowData);
                Sno++;
            });
        },
        error: function(xhr, status, error) {
    console.error(xhr.responseText);
    $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
}

    });
}


function agency_team(fromdate,todate,team_select,agency,todate1,fromdate1) {
  
  var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];    

     
   
     
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=agency_team",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            agency:agency,
            fromdate1,fromdate1,
            todate1,todate1
            
       
        },
        success: function(data) {
            $('#table_data').empty();
            data.forEach(function(item) {

let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
}  


// Assuming this is inside a loop
var rowData = '<tr>' +
    '<td>' + Sno + '</td>' +
    '<td>' + (item.alloted_to_coder || '') + '</td>' +
    '<td>' + (item.coder_emp_id || '') + '</td>' +
    '<td>' + (item.alloted_team || '') + '</td>' +
    '<td>' + (item.patient_name || '') + '</td>' +
    '<td>' + (item.mrn || '') + '</td>' +
    '<td>' + (item.insurance_type || '') + '</td>' +
    '<td>' + (item.assesment_date || '') + '</td>' +
    '<td>' + (item.assesment_type || '') + '</td>' +
    '<td>' + (item.agency || '') + '</td>' +
    '<td>' + (item.status || '') + '</td>' +
    '<td>' + (item.pending_comments || '') + '</td>' +
    '<td>' + (item.pending_reason || '') + '</td>' +
    '<td>' + (item.pending_date || '') + '</td>' +
    '<td>' + (item.totalcasemixagency || '') + '</td>' +
    '<td>' + (item.totalcasemix || '') + '</td>' +
    '<td>' + (AssigndateOnly || '') + '</td>' +
    '<td>' + (qc_date_only || '') + '</td>' +
    '<td>' + (qc_completed_date_only || '') + '</td>' +
    '<td>' + (item.total_working_hours || '') + '</td>' +
    '<td>' + (CompleteddateOnly || '') + '</td>' +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
    '</tr>';

$('#table_data').append(rowData);
                Sno++;
            });
        },
        error: function(xhr, status, error) {
    console.error(xhr.responseText);
    $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
}

    });
}

function dastatus(fromdate,todate,status,todate1,fromdate1) {
   
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=dastatus",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            status: status,
            fromdate1,fromdate1,
            todate1,todate1
            
            
       
        },
        success: function(data) {
            $('#table_data').empty();
            data.forEach(function(item) {


let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
} 

// Assuming this is inside a loop
var rowData = '<tr>' +
    '<td>' + Sno + '</td>' +
    '<td>' + (item.alloted_to_coder || '') + '</td>' +
    '<td>' + (item.coder_emp_id || '') + '</td>' +
    '<td>' + (item.alloted_team || '') + '</td>' +
    '<td>' + (item.patient_name || '') + '</td>' +
    '<td>' + (item.mrn || '') + '</td>' +
    '<td>' + (item.insurance_type || '') + '</td>' +
    '<td>' + (item.assesment_date || '') + '</td>' +
    '<td>' + (item.assesment_type || '') + '</td>' +
    '<td>' + (item.agency || '') + '</td>' +
    '<td>' + (item.status || '') + '</td>' +
    '<td>' + (item.pending_comments || '') + '</td>' +
    '<td>' + (item.pending_reason || '') + '</td>' +
    '<td>' + (item.pending_date || '') + '</td>' +
    '<td>' + (item.totalcasemixagency || '') + '</td>' +
    '<td>' + (item.totalcasemix || '') + '</td>' +
    '<td>' + (AssigndateOnly || '') + '</td>' +
    '<td>' + (qc_date_only || '') + '</td>' +
    '<td>' + (qc_completed_date_only || '') + '</td>' +
    '<td>' + (item.total_working_hours || '') + '</td>' +
    '<td>' + (CompleteddateOnly || '') + '</td>' +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
    '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
    '</tr>';

$('#table_data').append(rowData);
                Sno++;
            });
        },
        error: function(xhr, status, error) {
    console.error(xhr.responseText);
    $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
}

    });
}

 function pro_mrn(fromdate,todate,mrn,todate1,fromdate1) {
   
     var Sno = 1;

     $.ajax({
         url: "report_files/teamwise_report.php?action=pro_mrn",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate,
             mrn: mrn,
             fromdate1,fromdate1,
             todate1,todate1
            
            
       
         },
         success: function(data) {
             $('#table_data').empty();
             data.forEach(function(item) {

let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
} 
   
 var rowData = '<tr>' +
     '<td>' + Sno + '</td>' +
     '<td>' + (item.alloted_to_coder || '') + '</td>' +
     '<td>' + (item.coder_emp_id || '') + '</td>' +
     '<td>' + (item.alloted_team || '') + '</td>' +
     '<td>' + (item.patient_name || '') + '</td>' +
     '<td>' + (item.mrn || '') + '</td>' +
     '<td>' + (item.insurance_type || '') + '</td>' +
     '<td>' + (item.assesment_date || '') + '</td>' +
     '<td>' + (item.assesment_type || '') + '</td>' +
     '<td>' + (item.agency || '') + '</td>' +
     '<td>' + (item.status || '') + '</td>' +
     '<td>' + (item.pending_comments || '') + '</td>' +
     '<td>' + (item.pending_reason || '') + '</td>' +
     '<td>' + (item.pending_date || '') + '</td>' +
     '<td>' + (item.totalcasemixagency || '') + '</td>' +
     '<td>' + (item.totalcasemix || '') + '</td>' +
     '<td>' + (AssigndateOnly || '') + '</td>' +
     '<td>' + (qc_date_only || '') + '</td>' +
     '<td>' + (qc_completed_date_only || '') + '</td>' +
     '<td>' + (item.total_working_hours || '') + '</td>' +
     '<td>' + (CompleteddateOnly || '') + '</td>' +
      '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
     '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
     '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
     '</tr>';

 $('#table_data').append(rowData);
                 Sno++;
             });
         },
         error: function(xhr, status, error) {
     console.error(xhr.responseText);
     $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
 }

     });
 }

 function pro_p_name(fromdate,todate,p_name,fromdate1,todate1) {
   
     var Sno = 1;

     $.ajax({
         url: "report_files/teamwise_report.php?action=p_name",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate,
             p_name: p_name,
             fromdate1,fromdate1,
             todate1,todate1
            
            
       
         },
         success: function(data) {
             $('#table_data').empty();
             data.forEach(function(item) {


let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
} 
   
 var rowData = '<tr>' +
     '<td>' + Sno + '</td>' +
     '<td>' + (item.alloted_to_coder || '') + '</td>' +
     '<td>' + (item.coder_emp_id || '') + '</td>' +
     '<td>' + (item.alloted_team || '') + '</td>' +
     '<td>' + (item.patient_name || '') + '</td>' +
     '<td>' + (item.mrn || '') + '</td>' +
     '<td>' + (item.insurance_type || '') + '</td>' +
     '<td>' + (item.assesment_date || '') + '</td>' +
     '<td>' + (item.assesment_type || '') + '</td>' +
     '<td>' + (item.agency || '') + '</td>' +
     '<td>' + (item.status || '') + '</td>' +
     '<td>' + (item.pending_comments || '') + '</td>' +
     '<td>' + (item.pending_reason || '') + '</td>' +
     '<td>' + (item.pending_date || '') + '</td>' +
     '<td>' + (item.totalcasemixagency || '') + '</td>' +
     '<td>' + (item.totalcasemix || '') + '</td>' +
     '<td>' + (AssigndateOnly || '') + '</td>' +
     '<td>' + (qc_date_only || '') + '</td>' +
     '<td>' + (qc_completed_date_only || '') + '</td>' +
     '<td>' + (item.total_working_hours || '') + '</td>' +
     '<td>' + (CompleteddateOnly || '') + '</td>' +
       '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
     '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
     '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
     '</tr>';

 $('#table_data').append(rowData);
                 Sno++;
             });
         },
         error: function(xhr, status, error) {
     console.error(xhr.responseText);
     $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
 }

     });
 }
 function agency_full_report(fromdate,todate,agency,todate1,fromdate1) {
   
     var Sno = 1;

     $.ajax({
         url: "report_files/teamwise_report.php?action=agency_full_report",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate,
             agency: agency,
             fromdate1,fromdate1,
             todate1,todate1
            
            
       
         },
         success: function(data) {
             $('#table_data').empty();
             data.forEach(function(item) {


let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
} 



 var rowData = '<tr>' +
     '<td>' + Sno + '</td>' +
     '<td>' + (item.alloted_to_coder || '') + '</td>' +
     '<td>' + (item.coder_emp_id || '') + '</td>' +
     '<td>' + (item.alloted_team || '') + '</td>' +
     '<td>' + (item.patient_name || '') + '</td>' +
     '<td>' + (item.mrn || '') + '</td>' +
     '<td>' + (item.insurance_type || '') + '</td>' +
     '<td>' + (item.assesment_date || '') + '</td>' +
     '<td>' + (item.assesment_type || '') + '</td>' +
     '<td>' + (item.agency || '') + '</td>' +
     '<td>' + (item.status || '') + '</td>' +
     '<td>' + (item.pending_comments || '') + '</td>' +
     '<td>' + (item.pending_reason || '') + '</td>' +
     '<td>' + (item.pending_date || '') + '</td>' +
     '<td>' + (item.totalcasemixagency || '') + '</td>' +
     '<td>' + (item.totalcasemix || '') + '</td>' +
     '<td>' + (AssigndateOnly || '') + '</td>' +
     '<td>' + (qc_date_only || '') + '</td>' +
     '<td>' + (qc_completed_date_only || '') + '</td>' +
     '<td>' + (item.total_working_hours || '') + '</td>' +
     '<td>' + (CompleteddateOnly || '') + '</td>' +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
     '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
     '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
     '</tr>';

 $('#table_data').append(rowData);
                 Sno++;
             });
         },
         error: function(xhr, status, error) {
     console.error(xhr.responseText);
     $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
 }

     });
 }

function agency_status(fromdate,todate,agency,status,todate1,fromdate1) {
   
     var Sno = 1;

     $.ajax({
         url: "report_files/teamwise_report.php?action=agency_status",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate,
             agency: agency,
             status:status,
             fromdate1,fromdate1,
             todate1,todate1
            
            
       
         },
         success: function(data) {
             $('#table_data').empty();
             data.forEach(function(item) {

let AssignCoder_date = item.AssignCoder_date;
let qc_date = item.qc_date;
let qc_completed_date = item.qc_completed_date;
let file_completed_date = item.file_completed_date;

if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
     var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
      var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
    
} 

// Case where AssignCoder_date is null
AssignCoder_date = null;
file_completed_date = null;
qc_date = null;
qc_completed_date = null;
if (AssignCoder_date || file_completed_date || qc_date || qc_completed_date) {
    var AssigndateOnly = AssignCoder_date ? AssignCoder_date.split(" ")[0] : null;
    var CompleteddateOnly = file_completed_date ? file_completed_date.split(" ")[0] : null;
    var qc_date_only = qc_date ? qc_date.split(" ")[0] : null;
    var qc_completed_date_only = qc_completed_date ? qc_completed_date.split(" ")[0] : null;
} 

 var rowData = '<tr>' +
     '<td>' + Sno + '</td>' +
     '<td>' + (item.alloted_to_coder || '') + '</td>' +
     '<td>' + (item.coder_emp_id || '') + '</td>' +
     '<td>' + (item.alloted_team || '') + '</td>' +
     '<td>' + (item.patient_name || '') + '</td>' +
     '<td>' + (item.mrn || '') + '</td>' +
     '<td>' + (item.insurance_type || '') + '</td>' +
     '<td>' + (item.assesment_date || '') + '</td>' +
     '<td>' + (item.assesment_type || '') + '</td>' +
     '<td>' + (item.agency || '') + '</td>' +
     '<td>' + (item.status || '') + '</td>' +
     '<td>' + (item.pending_comments || '') + '</td>' +
     '<td>' + (item.pending_reason || '') + '</td>' +
     '<td>' + (item.pending_date || '') + '</td>' +
     '<td>' + (item.totalcasemixagency || '') + '</td>' +
     '<td>' + (item.totalcasemix || '') + '</td>' +
     '<td>' + (AssigndateOnly || '') + '</td>' +
     '<td>' + (qc_date_only || '') + '</td>' +
     '<td>' + (qc_completed_date_only || '') + '</td>' +
     '<td>' + (item.total_working_hours || '') + '</td>' +
     '<td>' + (CompleteddateOnly || '') + '</td>' +
     '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
     '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
     '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
     '</tr>';

 $('#table_data').append(rowData);
                 Sno++;
             });
         },
         error: function(xhr, status, error) {
     console.error(xhr.responseText);
     $('#table_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
 }

     });
 }



//QUALITY-REPORT-FUNCTIONS


  function team_audit_report(fromdate, todate, team_select) {
     var parts = team_select.split(" - ");
     var teamname = parts[0];
     var team_id = parts[1];
     var Sno = 1;

     $.ajax({
         url: "report_files/teamwise_report.php?action=teamaudit",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate,
             teamname: teamname,
             team_id: team_id,
            
         },
         success: function(data) {
             $('#table_data2').empty();
             data.forEach(function(item) {
                $('#table_data2').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder || '') + '</td><td>' + ( item.coder_emp_id || '') + '</td><td>' + ( item.alloted_team || '' )+ '</td><td>' +( item.patient_name || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.insurance_type || '' )+ '</td><td>' + ( item.assesment_date || '' )+ '</td><td>' + ( item.assesment_type || '' )+ '</td><td>' + (item.agency || '')+ '</td><td>' + (item.status || '' ) + '</td><td>' + ( item.qc_team || '' )+ '</td><td>' + ( item.qc_team_emp_id || '' )+ '</td><td>' + ( item.qc_person || '' )+ '</td><td>' + ( item.qc_person_emp_id || '' )+ '</td><td>' + ( item.pervious_qc_person || '' )+ '</td><td>' +(item.code_segment_scroe || '') + '</td><td>' + ( item.oasis_segment_score || '' )+ '</td><td>' + (item.poc_segment_scroe || '' ) + '</td><td>' + (item.coder_avrg_score || '')+ '</td><td>' + (item.pending_comments || '' )+ '</td><td>' + (item.pending_reason || '' )+ '</td><td>' + (item.pending_date || '' )+ '</td><td>' + (item.AssignCoder_date || '' )+ '</td><td>' + (item.qc_date || '' )+ '</td><td>' + (item.qc_completed_date || '' )+ '</td><td>' + (item.file_completed_date || '' )+ '</td></tr>');
                 Sno++;
             });
         },
         error: function(xhr, status, error) {
             console.error(xhr.responseText);
             $('#table_data2').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
         }
     });
  }


 function qaAll_team(fromdate, todate) {
    
   var Sno = 1;
     $.ajax({
         url: "report_files/teamwise_report.php?action=qaAll_team",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate,
             
            
         },
         success: function(data) {
             $('#table_data2').empty();
             data.forEach(function(item) {
                $('#table_data2').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder || '') + '</td><td>' + ( item.coder_emp_id || '') + '</td><td>' + ( item.alloted_team || '' )+ '</td><td>' +( item.patient_name || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.insurance_type || '' )+ '</td><td>' + ( item.assesment_date || '' )+ '</td><td>' + ( item.assesment_type || '' )+ '</td><td>' + (item.agency || '')+ '</td><td>' + (item.status || '' ) + '</td><td>' + ( item.qc_team || '' )+ '</td><td>' + ( item.qc_team_emp_id || '' )+ '</td><td>' + ( item.qc_person || '' )+ '</td><td>' + ( item.qc_person_emp_id || '' )+ '</td><td>' + ( item.pervious_qc_person || '' )+ '</td><td>' +(item.code_segment_scroe || '') + '</td><td>' + ( item.oasis_segment_score || '' )+ '</td><td>' + (item.poc_segment_scroe || '' ) + '</td><td>' + (item.coder_avrg_score || '')+ '</td><td>' + (item.pending_comments || '' )+ '</td><td>' + (item.pending_reason || '' )+ '</td><td>' + (item.pending_date || '' )+ '</td><td>' + (item.AssignCoder_date || '' )+ '</td><td>' + (item.qc_date || '' )+ '</td><td>' + (item.qc_completed_date || '' )+ '</td><td>' + (item.file_completed_date || '' )+ '</td></tr>');
                 Sno++;
             });
         },
         error: function(xhr, status, error) {
             console.error(xhr.responseText);
             $('#table_data2').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
         }
     });
  }


 function agency_qc(fromdate, todate,agency) {
    
   var Sno = 1;
     $.ajax({
         url: "report_files/teamwise_report.php?action=agency_qc",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate,
             agency:agency
             
            
         },
         success: function(data) {
             $('#table_data2').empty();
             data.forEach(function(item) {
                $('#table_data2').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder || '') + '</td><td>' + ( item.coder_emp_id || '') + '</td><td>' + ( item.alloted_team || '' )+ '</td><td>' +( item.patient_name || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.insurance_type || '' )+ '</td><td>' + ( item.assesment_date || '' )+ '</td><td>' + ( item.assesment_type || '' )+ '</td><td>' + (item.agency || '')+ '</td><td>' + (item.status || '' ) + '</td><td>' + ( item.qc_team || '' )+ '</td><td>' + ( item.qc_team_emp_id || '' )+ '</td><td>' + ( item.qc_person || '' )+ '</td><td>' + ( item.qc_person_emp_id || '' )+ '</td><td>' + ( item.pervious_qc_person || '' )+ '</td><td>' +(item.code_segment_scroe || '') + '</td><td>' + ( item.oasis_segment_score || '' )+ '</td><td>' + (item.poc_segment_scroe || '' ) + '</td><td>' + (item.coder_avrg_score || '')+ '</td><td>' + (item.pending_comments || '' )+ '</td><td>' + (item.pending_reason || '' )+ '</td><td>' + (item.pending_date || '' )+ '</td><td>' + (item.AssignCoder_date || '' )+ '</td><td>' + (item.qc_date || '' )+ '</td><td>' + (item.qc_completed_date || '' )+ '</td><td>' + (item.file_completed_date || '' )+ '</td></tr>');
                 Sno++;
             });
         },
         error: function(xhr, status, error) {
             console.error(xhr.responseText);
             $('#table_data2').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
         }
     });
  }


   function agency_team_qc(fromdate, todate, agency, team_select){
    var parts = team_select.split(" - ");
     var teamname = parts[0];
     var team_id = parts[1];
    
   var Sno = 1;
     $.ajax({
         url: "report_files/teamwise_report.php?action=agency_team_qc",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate,
             teamname: teamname,
             team_id: team_id,
             agency:agency
             
            
         },
         success: function(data) {
             $('#table_data2').empty();
             data.forEach(function(item) {
                $('#table_data2').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder || '') + '</td><td>' + ( item.coder_emp_id || '') + '</td><td>' + ( item.alloted_team || '' )+ '</td><td>' +( item.patient_name || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.insurance_type || '' )+ '</td><td>' + ( item.assesment_date || '' )+ '</td><td>' + ( item.assesment_type || '' )+ '</td><td>' + (item.agency || '')+ '</td><td>' + (item.status || '' ) + '</td><td>' + ( item.qc_team || '' )+ '</td><td>' + ( item.qc_team_emp_id || '' )+ '</td><td>' + ( item.qc_person || '' )+ '</td><td>' + ( item.qc_person_emp_id || '' )+ '</td><td>' + ( item.pervious_qc_person || '' )+ '</td><td>' +(item.code_segment_scroe || '') + '</td><td>' + ( item.oasis_segment_score || '' )+ '</td><td>' + (item.poc_segment_scroe || '' ) + '</td><td>' + (item.coder_avrg_score || '')+ '</td><td>' + (item.pending_comments || '' )+ '</td><td>' + (item.pending_reason || '' )+ '</td><td>' + (item.pending_date || '' )+ '</td><td>' + (item.AssignCoder_date || '' )+ '</td><td>' + (item.qc_date || '' )+ '</td><td>' + (item.qc_completed_date || '' )+ '</td><td>' + (item.file_completed_date || '' )+ '</td></tr>');
                 Sno++;
             });
         },
         error: function(xhr, status, error) {
             console.error(xhr.responseText);
             $('#table_data2').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
         }
     });
  }







function team_with_coder_audit_report(fromdate, todate, team_select, coder_name) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];

    var parts1 = coder_name.split(" - ");
    var codername = parts1[0];
    var coderid = parts1[1];

    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=coderaudit",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            codername: codername,
            coderid: coderid
        },
        success: function(data) {
            $('#table_data2').empty();
            data.forEach(function(item) {
                $('#table_data2').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder || '') + '</td><td>' + ( item.coder_emp_id || '') + '</td><td>' + ( item.alloted_team || '' )+ '</td><td>' +( item.patient_name || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.insurance_type || '' )+ '</td><td>' + ( item.assesment_date || '' )+ '</td><td>' + ( item.assesment_type || '' )+ '</td><td>' + (item.agency || '')+ '</td><td>' + (item.status || '' ) + '</td><td>' + ( item.qc_team || '' )+ '</td><td>' + ( item.qc_team_emp_id || '' )+ '</td><td>' + ( item.qc_person || '' )+ '</td><td>' + ( item.qc_person_emp_id || '' )+ '</td><td>' + ( item.pervious_qc_person || '' )+ '</td><td>' +(item.code_segment_scroe || '') + '</td><td>' + ( item.oasis_segment_score || '' )+ '</td><td>' + (item.poc_segment_scroe || '' ) + '</td><td>' + (item.coder_avrg_score || '')+ '</td><td>' + (item.pending_comments || '' )+ '</td><td>' + (item.pending_reason || '' )+ '</td><td>' + (item.pending_date || '' )+ '</td><td>' + (item.AssignCoder_date || '' )+ '</td><td>' + (item.qc_date || '' )+ '</td><td>' + (item.qc_completed_date || '' )+ '</td><td>' + (item.file_completed_date || '' )+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
    console.error(xhr.responseText);
    $('#table_data2').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
}

    });
}

function agency_team_coder_qc(fromdate, todate, agency, team_select,coder_name) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];

    var parts1 = coder_name.split(" - ");
    var codername = parts1[0];
    var coderid = parts1[1];

    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=agency_team_coder_qc",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            codername: codername,
            coderid: coderid,
            agency:agency
        },
        success: function(data) {
            $('#table_data2').empty();
            data.forEach(function(item) {
                $('#table_data2').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder || '') + '</td><td>' + ( item.coder_emp_id || '') + '</td><td>' + ( item.alloted_team || '' )+ '</td><td>' +( item.patient_name || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.insurance_type || '' )+ '</td><td>' + ( item.assesment_date || '' )+ '</td><td>' + ( item.assesment_type || '' )+ '</td><td>' + (item.agency || '')+ '</td><td>' + (item.status || '' ) + '</td><td>' + ( item.qc_team || '' )+ '</td><td>' + ( item.qc_team_emp_id || '' )+ '</td><td>' + ( item.qc_person || '' )+ '</td><td>' + ( item.qc_person_emp_id || '' )+ '</td><td>' + ( item.pervious_qc_person || '' )+ '</td><td>' +(item.code_segment_scroe || '') + '</td><td>' + ( item.oasis_segment_score || '' )+ '</td><td>' + (item.poc_segment_scroe || '' ) + '</td><td>' + (item.coder_avrg_score || '')+ '</td><td>' + (item.pending_comments || '' )+ '</td><td>' + (item.pending_reason || '' )+ '</td><td>' + (item.pending_date || '' )+ '</td><td>' + (item.AssignCoder_date || '' )+ '</td><td>' + (item.qc_date || '' )+ '</td><td>' + (item.qc_completed_date || '' )+ '</td><td>' + (item.file_completed_date || '' )+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
    console.error(xhr.responseText);
    $('#table_data2').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
}

    });
}




// feedback-functions




function teamfeedback(fromdate, todate, team_select,Segment) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=teamfeedback",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            Segment:Segment,
            
        },
        success: function(data) {
            $('#table_data3').empty();
            data.forEach(function(item) {


                $('#table_data3').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder ||'')+ '</td><td>' + (item.coder_emp_id ||'')+ '</td><td>' + (item.patient_name ||'')+ '</td><td>' + (item.mrn ||'')+ '</td><td>' + (item.status ||'')+ '</td><td>' + (item.insurance_type ||'')+ '</td><td>' + (item.assesment_date ||'')+ '</td><td>' + (item.assesment_type || '')+ '</td><td>' + ( item.agency || '')+ '</td><td>' + (item.AssignCoder_date ||'')+ '</td><td>' + (item.qc_person || '')+ '</td><td>' + (item.qc_date || '')+ '</td><td>' + (item.M_item || '')+ '</td><td>' + (item.Coder_response ||'')+ '</td><td>' + (item.Qc_response ||'')+ '</td><td>' + (item.Error_reason ||'')+ '</td><td>' + (item.Error_type ||'')+ '</td><td>' + (item.Qc_rationali ||'')+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#table_data3').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}




function team_with_status_feedback(fromdate,todate,team_select,status,Segment) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=team_with_status_feedback",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            status:status,
            Segment:Segment
            
        },
        success: function(data) {
            $('#table_data3').empty();
            data.forEach(function(item) {
                $('#table_data3').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder ||'')+ '</td><td>' + (item.coder_emp_id ||'')+ '</td><td>' + (item.patient_name ||'')+ '</td><td>' + (item.mrn ||'')+ '</td><td>' +(item.status ||'')+ '</td><td>' + (item.insurance_type ||'')+ '</td><td>' + (item.assesment_date ||'')+ '</td><td>' + (item.assesment_type ||'')+ '</td><td>' + (item.agency ||'')+ '</td><td>' + (item.AssignCoder_date ||'') + '</td><td>' + (item.qc_person ||'')+ '</td><td>' + (item.qc_date ||'')+ '</td><td>' + (item.Coder_response ||'')+ '</td><td>' + (item.Qc_response ||'')+ '</td><td>' + (item.Error_reason ||'')+ '</td><td>' + (item.Error_type ||'')+ '</td><td>' + (item.Qc_rationali ||'')+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#table_data3').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}


function coderfeedback(fromdate,todate,team_select,coder_name,Segment) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];
    var parts1 = coder_name.split(" - ");
    var codername = parts1[0];
    var coderid = parts1[1];
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=coderfeedback",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            codername:codername,
            coderid:coderid,
            Segment:Segment
             
            
        },
        success: function(data) {
            $('#table_data3').empty();
            data.forEach(function(item) {
                $('#table_data3').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder || '') + '</td><td>' + (item.coder_emp_id ||'')+ '</td><td>' + (item.patient_name || '')+ '</td><td>' + (item.mrn ||'')+ '</td><td>' + (item.status ||'')+ '</td><td>' + (item.insurance_type ||'')+ '</td><td>' + (item.assesment_date ||'')+ '</td><td>' + (item.assesment_type ||'')+ '</td><td>' + (item.agency ||'')+ '</td><td>' + (item.AssignCoder_date ||'')+ '</td><td>' + (item.qc_person ||'')+ '</td><td>' + (item.qc_date ||'')+ '</td><td>' + (item.Coder_response || '' )+ '</td><td>' + (item.Qc_response ||'')+ '</td><td>' + (item.Error_reason ||'')+ '</td><td>' + (item.Error_type ||'')+ '</td><td>' + (item.Qc_rationali ||'')+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#table_data3').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}


function coder_with_status_feedback(fromdate,todate,team_select,coder_name,status,Segment) {
    var parts = team_select.split(" - ");
    var teamname = parts[0];
    var team_id = parts[1];
    var parts1 = coder_name.split(" - ");
    var codername = parts1[0];
    var coderid = parts1[1];
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=coder_with_status_feedback",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            teamname: teamname,
            team_id: team_id,
            codername:codername,
            coderid:coderid,
            status:status,
            Segment:Segment
             
            
        },
        success: function(data) {
            $('#table_data3').empty();
            data.forEach(function(item) {
                $('#table_data3').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder || '' )+ '</td><td>' + (item.coder_emp_id || '' )+ '</td><td>' + (item.patient_name ||'')+ '</td><td>' + (item.mrn ||'')+ '</td><td>' + (item.status ||'')+ '</td><td>' + (item.insurance_type || '')+ '</td><td>' + (item.assesment_date ||'')+ '</td><td>' + (item.assesment_type ||'')+ '</td><td>' + (item.agency ||'')+ '</td><td>' + (item.AssignCoder_date ||'')+ '</td><td>' + (item.qc_person ||'')+ '</td><td>' + (item.qc_date ||'')+ '</td><td>' + (item.Coder_response || '') + '</td><td>' + (item.Qc_response ||'')+ '</td><td>' + (item.Error_reason ||'')+ '</td><td>' + (item.Error_type ||'')+ '</td><td>' + (item.Qc_rationali ||'')+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#table_data3').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}


 function team_all_feedback(fromdate, todate, team_select, Segment) {
     var parts = team_select.split(" - ");
     var teamname = parts[0];
     var team_id = parts[1];

     $.ajax({
         url: "report_files/teamwise_report.php?action=team_all_feedback",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate,
             teamname: teamname,
             team_id: team_id,
             Segment:Segment
             
         },
         success: function(data) {
             $('#table_data3').empty();
             if (data && data.length > 0) {
                 var Sno = 1;
                 data.forEach(function(item) {
                     $('#table_data3').append('<tr><td>' + Sno + '</td><td>' + (item.alloted_to_coder || '') + '</td><td>' + (item.coder_emp_id || '') + '</td><td>' + (item.patient_name || '') + '</td><td>' + (item.mrn || '') + '</td><td>' + (item.status || '') + '</td><td>' + (item.insurance_type || '') + '</td><td>' + (item.assesment_date || '') + '</td><td>' + (item.assesment_type || '') + '</td><td>' + (item.agency || '') + '</td><td>' + (item.AssignCoder_date || '') + '</td><td>' + (item.qc_person || '') + '</td><td>' + (item.qc_date || '') + '</td><td>' + (item.Coder_response || '') + '</td><td>' + (item.Qc_response || '') + '</td><td>' + (item.Error_reason || '') + '</td><td>' + (item.Error_type || '') + '</td><td>' + (item.Qc_rationali || '') + '</td></tr>');
                     Sno++;
                 });
             } else {
                 $('#table_data3').append('<tr><td colspan="17"><center>No records found</center></td></tr>');
             }
         },
         error: function(xhr, status, error) {
             console.error(xhr.responseText);
             $('#table_data3').empty().append('<tr><td colspan="17"><center>Error retrieving data</center></td></tr>');
         }
     });
 }




//WORKLOG-FUNCTION'S
function mrn_check(fromdate,todate,mrn) {
  
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=mrn_check",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            mrn: mrn
           
             
            
        },
        success: function(data) {
            $('#work_log_data').empty();
            data.forEach(function(item) {
                $('#work_log_data').append('<tr><td>' + Sno + '</td><td>' + (item.entry_id || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.patient_name ||'')+ '</td><td>' + (item.status ||'')+ '</td><td>' + (item.assesment_date ||'')+ '</td><td>' + (item.assesment_type || '')+ '</td><<td>' + (item.agency ||'')+ '</td><td>' + (item.Team ||'')+ '</td><td>' + (item.team_emp_id ||'')+ '</td><td>' + (item.Coder ||'')+ '</td><td>' + (item.coder_emp_id || '') + '</td><td>' + (item.logtime ||'')+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#work_log_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}

function mrn_patient(fromdate,todate,mrn,patient) {
  
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=mrn_patient",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            mrn: mrn,
            patient:patient
           
             
            
        },
        success: function(data) {
            $('#work_log_data').empty();
            data.forEach(function(item) {
                $('#work_log_data').append('<tr><td>' + Sno + '</td><td>' + (item.entry_id || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.patient_name ||'')+ '</td><td>' + (item.status ||'')+ '</td><td>' + (item.assesment_date ||'')+ '</td><td>' + (item.assesment_type || '')+ '</td><<td>' + (item.agency ||'')+ '</td><td>' + (item.Team ||'')+ '</td><td>' + (item.team_emp_id ||'')+ '</td><td>' + (item.Coder ||'')+ '</td><td>' + (item.coder_emp_id || '') + '</td><td>' + (item.logtime ||'')+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#work_log_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}

function patient_check(fromdate,todate,patient) {
  
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=patient_check",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate,
            patient:patient
           
             
            
        },
        success: function(data) {
            $('#work_log_data').empty();
            data.forEach(function(item) {
                $('#work_log_data').append('<tr><td>' + Sno + '</td><td>' + (item.entry_id || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.patient_name ||'')+ '</td><td>' + (item.status ||'')+ '</td><td>' + (item.assesment_date ||'')+ '</td><td>' + (item.assesment_type || '')+ '</td><<td>' + (item.agency ||'')+ '</td><td>' + (item.Team ||'')+ '</td><td>' + (item.team_emp_id ||'')+ '</td><td>' + (item.Coder ||'')+ '</td><td>' + (item.coder_emp_id || '') + '</td><td>' + (item.logtime ||'')+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#work_log_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
}

function all_log(fromdate,todate) {
  
    var Sno = 1;

    $.ajax({
        url: "report_files/teamwise_report.php?action=all_log",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate
   
        },
        success: function(data) {
            $('#work_log_data').empty();
            data.forEach(function(item) {
                $('#work_log_data').append('<tr><td>' + Sno + '</td><td>' + (item.entry_id || '' )+ '</td><td>' + (item.mrn || '' )+ '</td><td>' + (item.patient_name ||'')+ '</td><td>' + (item.status ||'')+ '</td><td>' + (item.assesment_date ||'')+ '</td><td>' + (item.assesment_type || '')+ '</td><<td>' + (item.agency ||'')+ '</td><td>' + (item.Team ||'')+ '</td><td>' + (item.team_emp_id ||'')+ '</td><td>' + (item.Coder ||'')+ '</td><td>' + (item.coder_emp_id || '') + '</td><td>' + (item.logtime ||'')+ '</td></tr>');
                Sno++;
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#work_log_data').empty().append('<tr><td colspan="15"><center>No records found</center></td></tr>');
        }
    });
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