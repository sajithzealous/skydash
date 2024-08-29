$(document).ready(function () {

   $("#datepicker1").on('change', function () {
    var default_date = $("#datepicker1").val();

   

    qc_coder_perform(default_date);
  });
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

   $("#assign_coder").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    assign_coder(date);
  });

 $("#dir_completed").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    dir_completed(date);
  });
 $("#approve").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    approve(date);
  });
 $("#wipqc").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    wipqc(date);
  });
  $("#qc_complete").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    qc_complete(date);
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
            $("#data-table").empty();
            console.log(data);

            // Set the table header only once
            var tableHeader = `


                <tr style="background-color: #088394; color:white;position: sticky; top: 0; z-index: 1500;">
                    <th>Alloted Team</th>

                    <th>Agency</th>
                    <th>Patient Name</th>
                    <th>MRN</th>
                    <th>Status</th>
                    <th>Alloted To Coder</th>
                    <th>Insurance Type</th>
                    <th>Assessment Type</th>
                    <th>Assessment Date</th>
                </tr>`;
            $('#data-table').html(tableHeader);

            // Populate table rows with data
            data.forEach(function (item) {
                var teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
                var coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";

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
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
        },
    });
}


function assign_coder(date) {
    var str = date;
    var dateValues = str.split("-");
    var fromdate = dateValues[0];
    var todate = dateValues[1];

    fromdate = new Date(fromdate).toLocaleDateString("en-CA");
    todate = new Date(todate).toLocaleDateString("en-CA");

    $.ajax({
        url: "qcteam_dash/qc_tl_showdata.php?action=assign_coder",
        type: "GET",
        dataType: "json",
        data: {
            fromdate: fromdate,
            todate: todate,
        },
        success: function (data) {
            $("#data-table").empty();
            console.log(data);

            // Set the table header only once
            var tableHeader = `


                <tr style="background-color: #088394; color:white;position: sticky; top: 0; z-index: 1500;">
                    <th>Alloted Team</th>
                    <th>QC TeamLeader</th>
                    <th>Agency</th>
                    <th>Patient Name</th>
                    <th>MRN</th>
                    <th>Status</th>
                    <th>Alloted To Coder</th>
                    <th>Insurance Type</th>
                    <th>Assessment Type</th>
                    <th>Assessment Date</th>
                    <th>QC_Coder</th>
                    <th>QC_Coder_Id</th>
                </tr>`;
            $('#data-table').html(tableHeader);

            // Populate table rows with data
            data.forEach(function (item) {
                var teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
                var coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";

                $("#data-table").append(
                    "<tr><td>" +
                    teamDisplay +
                    "</td><td>" +
                    item.qc_team +
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
                    "</td><td>" +
                    item.qc_person +
                    "</td><td>" +
                    item.qc_person_emp_id +
                    "</td></tr>"
                );
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
        },
    });
}

function dir_completed(date) {
    var str = date;
    var dateValues = str.split("-");
    var fromdate = dateValues[0];
    var todate = dateValues[1];

    fromdate = new Date(fromdate).toLocaleDateString("en-CA");
    todate = new Date(todate).toLocaleDateString("en-CA");

    $.ajax({
        url: "qcteam_dash/qc_tl_showdata.php?action=dir_completed",
        type: "GET",
        dataType: "json",
        data: {
            fromdate: fromdate,
            todate: todate,
        },
        success: function (data) {
            $("#data-table").empty();
            console.log(data);

            // Set the table header only once
            var tableHeader = `


                <tr style="background-color: #088394; color:white;position: sticky; top: 0; z-index: 1500;">
                    <th>Alloted Team</th>
                    
                    <th>Agency</th>
                    <th>Patient Name</th>
                    <th>MRN</th>
                    <th>Status</th>
                    <th>Alloted To Coder</th>
                    <th>Insurance Type</th>
                    <th>Assessment Type</th>
                    <th>Assessment Date</th>
                    <th>QC_Coder</th>
                    <th>QC_Coder_Id</th>
                </tr>`;
            $('#data-table').html(tableHeader);

            // Populate table rows with data
            data.forEach(function (item) {
                var teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
                var coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";

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
                    "</td><td>" +
                    item.qc_person +
                    "</td><td>" +
                    item.qc_person_emp_id +
                    "</td></tr>"
                );
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
        },
    });
}

function approve(date) {
    var str = date;
    var dateValues = str.split("-");
    var fromdate = dateValues[0];
    var todate = dateValues[1];

    fromdate = new Date(fromdate).toLocaleDateString("en-CA");
    todate = new Date(todate).toLocaleDateString("en-CA");

    $.ajax({
        url: "qcteam_dash/qc_tl_showdata.php?action=approve",
        type: "GET",
        dataType: "json",
        data: {
            fromdate: fromdate,
            todate: todate,
        },
        success: function (data) {
            $("#data-table").empty();
            console.log(data);

            // Set the table header only once
            var tableHeader = `


                <tr style="background-color: #088394; color:white;position: sticky; top: 0; z-index: 1500;">
                    <th>Alloted Team</th>
                    <th>QC TeamLeader</th>
                    <th>Agency</th>
                    <th>Patient Name</th>
                    <th>MRN</th>
                    <th>Status</th>
                    <th>Alloted To Coder</th>
                    <th>Insurance Type</th>
                    <th>Assessment Type</th>
                    <th>Assessment Date</th>
                    <th>QC_Coder</th>
                    <th>QC_Coder_Id</th>
                </tr>`;
            $('#data-table').html(tableHeader);

            // Populate table rows with data
            data.forEach(function (item) {
                var teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
                var coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";

                $("#data-table").append(
                    "<tr><td>" +
                    teamDisplay +
                    "</td><td>" +
                    item.qc_team +
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
                    "</td><td>" +
                    item.qc_person +
                    "</td><td>" +
                    item.qc_person_emp_id +
                    "</td></tr>"
                );
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
        },
    });
}

function wipqc(date) {
    var str = date;
    var dateValues = str.split("-");
    var fromdate = dateValues[0];
    var todate = dateValues[1];

    fromdate = new Date(fromdate).toLocaleDateString("en-CA");
    todate = new Date(todate).toLocaleDateString("en-CA");

    $.ajax({
        url: "qcteam_dash/qc_tl_showdata.php?action=wipqc",
        type: "GET",
        dataType: "json",
        data: {
            fromdate: fromdate,
            todate: todate,
        },
        success: function (data) {
            $("#data-table").empty();
            console.log(data);

            // Set the table header only once
            var tableHeader = `


                <tr style="background-color: #088394; color:white;position: sticky; top: 0; z-index: 1500;">
                    <th>Alloted Team</th>
                    <th>QC TeamLeader</th>
                    <th>Agency</th>
                    <th>Patient Name</th>
                    <th>MRN</th>
                    <th>Status</th>
                    <th>Alloted To Coder</th>
                    <th>Insurance Type</th>
                    <th>Assessment Type</th>
                    <th>Assessment Date</th>
                    <th>QC_Coder</th>
                    <th>QC_Coder_Id</th>
                </tr>`;
            $('#data-table').html(tableHeader);

            // Populate table rows with data
            data.forEach(function (item) {
                var teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
                var coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";

                $("#data-table").append(
                    "<tr><td>" +
                    teamDisplay +
                    "</td><td>" +
                    item.qc_team +
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
                    "</td><td>" +
                    item.qc_person +
                    "</td><td>" +
                    item.qc_person_emp_id +
                    "</td></tr>"
                );
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
        },
    });
}

function qc_complete(date) {
    var str = date;
    var dateValues = str.split("-");
    var fromdate = dateValues[0];
    var todate = dateValues[1];

    fromdate = new Date(fromdate).toLocaleDateString("en-CA");
    todate = new Date(todate).toLocaleDateString("en-CA");

    $.ajax({
        url: "qcteam_dash/qc_tl_showdata.php?action=qc_complete",
        type: "GET",
        dataType: "json",
        data: {
            fromdate: fromdate,
            todate: todate,
        },
        success: function (data) {
            $("#data-table").empty();
            console.log(data);

            // Set the table header only once
            var tableHeader = `


                <tr style="background-color: #088394; color:white;position: sticky; top: 0; z-index: 1500;">
                    <th>Alloted Team</th>
                    <th>QC TeamLeader</th>
                    <th>Agency</th>
                    <th>Patient Name</th>
                    <th>MRN</th>
                    <th>Status</th>
                    <th>Alloted To Coder</th>
                    <th>Insurance Type</th>
                    <th>Assessment Type</th>
                    <th>Assessment Date</th>
                    <th>QC_Coder</th>
                    <th>QC_Coder_Id</th>
                </tr>`;
            $('#data-table').html(tableHeader);

            // Populate table rows with data
            data.forEach(function (item) {
                var teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
                var coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";

                $("#data-table").append(
                    "<tr><td>" +
                    teamDisplay +
                    "</td><td>" +
                    item.qc_team +
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
                    "</td><td>" +
                    item.qc_person +
                    "</td><td>" +
                    item.qc_person_emp_id +
                    "</td></tr>"
                );
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
        },
    });
}
   

    function qc_coder_perform(default_date){


      var str = default_date;
     var dateValues = str.split("-");
     var fromdate = dateValues[0];
     var todate = dateValues[1];
 
  
 fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
 todate = new Date(todate).toLocaleDateString('en-CA');

 
       
    $.ajax({
        url: "qcteam_dash/qc_tl_showdata.php?action=qc_coder_perform",
        type: "GET",
        dataType: 'json',
        data: {
             fromdate: fromdate,
             todate: todate
        },
        success: function (data) {
        $('#show_data').empty();
      console.log("show_datajohn",data);
 
                         data.forEach(function (item) {
                            $('#show_data').append('<tr><center><td>' + item.Team + '</td></center><center><td>' + item.code + '</td></center><center><td>' + item.Total_Files + '</td></center><center><td>' + item.Assigned + '</td></center><center><td>' + item.QC + '</td></center><center><td>' + item.QCCOM + '</td></center><td>' + item.Approved + '</td></tr>');
                        });

 },
      error: function (xhr, status, error) {
    console.error(xhr.responseText); // Log the entire response text
    console.error("Status: " + status + ", Error: " + error); // Log additional details
}

    });

     
}
 
 