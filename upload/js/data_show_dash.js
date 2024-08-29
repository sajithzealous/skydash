$(document).ready(function () {
  $("#new_file").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    new_data(date);
  });
  $("#ass_file").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    ass_file(date);
  });
  $("#wip_file").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    wip_file(date);
  });

    $("#noqc").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    noqc(date);
  });

   $("#dirctapp").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    dirctapp(date);
  });
  $("#cmd_file").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    cmd_file(date);
  });
  $("#qc_file").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    qc_file(date);
  });
  $("#assign_tem").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    assign_tem(date);
  });
  $("#qccmd_file").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    qccmd_file(date);
  });
  $("#aprd_file").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    aprd_file(date);
  });

  $("#Inprogress").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    Inprogress(date);
  });
  $("#Qcwip").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    Qcwip(date);
  });
  $("#Pending").on("click", function () {
    var date = $("#ecommerce-dashboard-daterangepicker").val();

    Pending(date);
  });
});

function new_data(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_1.php?action=showquery",
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
      data.forEach(function(item) {
        // Set teamDisplay and coder values
        var teamDisplay = item.alloted_team !== null ? item.alloted_team : "";
        var coder = item.alloted_to_coder !== null ? item.alloted_to_coder : "";
    
        // Clear and set table header
        $(".thd").html(`
            <tr>
                <th>Agency</th>
                <th>PatientName</th>
                <th>Mrn</th>
                <th>Status</th>
                <th>InsuranceType</th>
                <th>AssesmentType</th>
                <th>AssesmentDate</th>
                <th>Option</th>
            </tr>
        `);
    
        // Append table rows
        $("#data-table").append(`
            <tr>
                <td hidden>${teamDisplay}</td>
                <td>${item.agency}</td>
                <td>${item.patient_name}</td>
                <td>${item.mrn}</td>
                <td class="font-weight-medium">
                    <div class="badge badge-pill badge-danger">${item.status}</div>
                </td>
                <td hidden>${coder}</td>
                <td>${item.insurance_type}</td>
                <td>${item.assesment_type}</td>
                <td>${item.assesment_date}</td>
                <td>
                <button class="btn btn-primary open-prompt" data-id="${item.Id}">Client Query</button>
                </td>
            </tr>
        `);

        
    });

    $(document).on('click', '.open-prompt', function() {
      var itemId = $(this).data('id'); // Get the data-id attribute value

      // Open a prompt dialog
      var promptValue = prompt("Enter your text:");

      if (promptValue !== null) {

        $.ajax({

          type:'POST',
          url:'show_files/file_1.php?action=updatequery',
          data:{

            itemId:itemId,
            promptValue:promptValue,


          },
          success:function(response){

            console.log(response);
 


          },


        });



      } else {
          console.log('Prompt was cancelled.');
      }
  });
    },

    error: function (xhr, status, error) {
      console.error("AJAX Error: " + status, error);
    },
  });
}

function ass_file(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_2.php",
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
            "</td></tr>"
        );
      });
    },

    error: function (xhr, status, error) {
      console.error("AJAX Error: " + status, error);
    },
  });
}

function Inprogress(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_9.php",
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
            "</td></tr>"
        );
      });
    },

    error: function (xhr, status, error) {
      console.error("AJAX Error: " + status, error);
    },
  });
}

function Qcwip(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_10.php",
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
                          <th>Previwe</th>
                         
                        </tr>`);

        // Constructing table row dynamically
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
    '<td><a class="btn btn-primary flow" onclick="qc_preview(' + item.Id + ')">QC View</a></td>' +
  "</tr>";

// Appending the constructed row to the data table
$("#data-table").append(tableRow);

      });
    },

    error: function (xhr, status, error) {
      console.error("AJAX Error: " + status, error);
    },
  });
}

function wip_file(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_3.php",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
    },
    success: function (data) {
      $("#data-table  ").empty();
      // console.log(data);

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
                          <th>Previwe</th>
                        </tr>`);

       // Constructing table row dynamically
var tableRow = 
  "<tr>" +
    "<td>" + teamDisplay + "</td>" +
    "<td>" + item.agency + "</td>" +
    "<td>" + item.patient_name + "</td>" +
    "<td>" + item.mrn + "</td>" +
    '<td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' + item.status + "</div></td>" +
    "<td>" + coder + "</td>" +
    "<td>" + item.insurance_type + "</td>" +
    '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
  "</tr>";

// Appending the constructed row to the data table
$("#data-table").append(tableRow);

      });
    },

    error: function (xhr, status, error) {
      console.error("AJAX Error: " + status, error);
    },
  });
}
function cmd_file(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_4.php",
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
        //  std = item.ALLOTED TO QC !== null ? 'alloted_to_QC' : ' ';

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
                           <th>Previwe</th>
                             
                           
                         
                        </tr>`);

        // var originalNumber = item.totalcasemix;
        //  var roundedNumber = parseFloat(originalNumber.toFixed(3));
        //  console.log(roundedNumber);

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
              "</td><td>" +
              item.insurance_type +
              "</td><td>" +
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

function noqc(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_5.php",
    type: "GET",
    dataType: "json",
    data: {
      fromdate: fromdate,
      todate: todate,
    },
    success: function (data) {
      $("#data-table  ").empty();
      // console.log(data);
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
function assign_tem(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_6.php",
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
                          

                           
                          <th>Insurance_Type</th>
                         
                        </tr>`);

        $("#data-table").append(
          "<tr><td>" +
            teamDisplay +
            "</td><td>" +
            item.agency +
            "</td><td>" +
            item.patient_name +
            "</td> <td>" +
            item.mrn +
            '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' +
            item.status +
            "</div></td><<td>" +
            item.insurance_type +
            "</td>/tr>"
        );
      });
    },

    error: function (xhr, status, error) {
      console.error("AJAX Error: " + status, error);
    },
  });
}
function qccmd_file(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_7.php",
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
                           <th >QC-Coder</th>

                           
                          <th>Insurance_Type</th>
                          <th>Previwe</th>
                        </tr>`);

        $("#data-table").append(
          "<tr><td>" +
            teamDisplay +
            "</td><td>" +
            item.agency +
            "</td><td>" +
            item.patient_name +
            "</td> <td>" +
            item.mrn +
            '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' +
            item.status +
            "</div></td><td>" +
            coder +
            "</td><td>" +
            item.qc_person +
            "</td><td>" +
            item.insurance_type +
            '</td><td><a class="btn btn-primary flow" onclick="qc_preview(' +
            item.Id +
            ')">QC View</a></td></tr>'
        );
      });
    },

    error: function (xhr, status, error) {
      console.error("AJAX Error: " + status, error);
    },
  });
}
function aprd_file(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_8.php",
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
                           <th>HHRG</th>
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
        '<td><a class="btn btn-primary flow" onclick="hhrg_previwe(' + item.Id + ')">HHRG View</a></td>' +
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

function dirctapp(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_12.php",
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
                           
                           <th>final_preview</th>
                           <th>HHRG</th>
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
      
        '<td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td>' +
        '<td><a class="btn btn-primary flow" onclick="hhrg_previwe(' + item.Id + ')">HHRG View</a></td>' +
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

function hhrg_previwe(Id) {

    // alert(Id)
  //Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

  // Open the URL in a new tab/window
  window.open("hhrgpreview.php", "_blank");
}

function Pending(date) {
  var str = date;
  var dateValues = str.split("-");
  var fromdate = dateValues[0];
  var todate = dateValues[1];

  fromdate = new Date(fromdate).toLocaleDateString("en-CA");
  ("en-CA"); // represents the 'en'glish language in 'CA'nada
  todate = new Date(todate).toLocaleDateString("en-CA");

  $.ajax({
    url: "show_files/file_11.php",
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
                          <th >pending_comments</th>
                          <th >pending_date</th>
                          <th >pending_reason</th>

                           
                          <th>Insurance_Type</th>
                        </tr>`);

       
// Constructing table row dynamically
var tableRow = 
  "<tr>" +
    "<td>" + teamDisplay + "</td>" +
    "<td>" + item.agency + "</td>" +
    "<td>" + item.patient_name + "</td>" +
    "<td>" + item.mrn + "</td>" +
    '<td class="font-weight-medium"><div class="badge badge-success">' + item.status + "</div></td>" +
    "<td>" + coder + "</td>" +
    "<td>" + item.pending_comments + "</td>" +
    "<td>" + item.pending_date + "</td>" +
    "<td>" + item.pending_reason + "</td>" +
    "<td>" + item.insurance_type + "</td>" +
    '<td><a class="btn btn-primary flow" onclick="coder_preview(' + item.Id + ')">Coder View</a></td>' +
  "</tr>";

// Appending the constructed row to the data table
$("#data-table").append(tableRow);


      });
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error: " + status, error);
    },
  });
}



