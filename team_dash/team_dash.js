$(document).ready(function() {
  // total_team_count();
  total_assign();
  teamperformance_chart();
  codername();
  //team_performance();
  //team_performance_filter();
  
  var fromdate1=""; var todate1="";  var fromdate2=""; var todate2="";  var coder_name_selectedValue="";
//!  coder name onchange event function
  $("#coder_name").change(function() {
    coder_name_selectedValue = $("#coder_name").val();
   // alert(coder_name_selectedValue);
    teamperformance_chart(coder_name_selectedValue);
});

var date = $("#datepicker1").val();
//alert(date);
var val = date;
var str = date;  
//console.log("before split date values",date);
var dateValues = str.split("-");
 fromdate = dateValues[0];
 todate = dateValues[1];
//console.log("SPLIT_AND_before Formatted fromdate:", fromdate);
//console.log("SPILT_AND_before Formatted todate:", todate); 
fromdate2 = new Date(fromdate).toLocaleDateString('en-CA'); 
//alert(fromdate2);
todate2 = new Date(todate).toLocaleDateString('en-CA');
//console.log("After Formatted fromdate:", fromdate);
//console.log("After Formatted todate:", todate);
team_performance(fromdate2, todate2);
//! datepicker onchange event funtion
  $("#datepicker1").on('change', function () {
      var date = $("#datepicker1").val();
      //alert(date);
      var val = date;
      var str = date;  
     // console.log("before split date values",date);
      var dateValues = str.split("-");
       fromdate = dateValues[0];
       todate = dateValues[1];
      //console.log("SPLIT_AND_before Formatted fromdate:", fromdate);
      //console.log("SPILT_AND_before Formatted todate:", todate); 
      fromdate2 = new Date(fromdate).toLocaleDateString('en-CA'); 
      //alert(fromdate2);
      todate2 = new Date(todate).toLocaleDateString('en-CA');
     // console.log("After Formatted fromdate:", fromdate);
     // console.log("After Formatted todate:", todate);
      //total_team_count(fromdate1, todate1);
    
      team_performance_filter(fromdate2, todate2);
      
  });
  // ! over all team performance  filter using 
function team_performance_filter(fromdate2, todate2){    
 // alert("sdfsdf");
   
  $.ajax({
      url: "team_dash/teamdash_sql.php?action=team_performance_filter",
      dataType: 'json',
      type: 'POST',
      data:{ 
        fromdate2 : fromdate2,
        todate2 : todate2
      },
      success: function (data) {
      $('#show_data').empty();
    console.log("indhu",data);

      data.forEach(function (item) {      
      $('#show_data').append('<tr><center><td>' + item.code + '</td></center><center><td>' + item.combined_status + '</td></center><center><td>' + item.prg + '</td></center><center><td>' + item.pd + '</td></center><center><td>' + item.WIP + '</td></center><center><td>' + item.QC + '</td></center><center><td>' + item.Completed + '</td></center><center><td>' + item.QCCOM + '</td></center><center><td>' + item.APPROVED + '</td></center></tr>');
        });

    },
    error: function (xhr, status, error) {
    console.error(xhr.responseText); // Log the entire response text
    console.error("Status: " + status + ", Error: " + error); // Log additional details
   }

});

 
}
// ! over all team performance 
function team_performance(fromdate2, todate2){ 
  //alert(fromdate2);
  $.ajax({
      url: "team_dash/teamdash_sql.php?action=team_performance",
      type: "POST",
      dataType: 'json',
      data:{ 
        fromdate2 : fromdate2,
        todate2 : todate2
      },
      success: function (data) {
      $('#show_data').empty();
      

      data.forEach(function (item) {
      $('#show_data').append('<tr><center><td>' + item.code + '</td></center><center><td>' + item.combined_status + '</td></center><center><td>' + item.prg + '</td></center><center><td>' + item.pd + '</td></center><center><td>' + item.WIP + '</td></center><center><td>' + item.QC + '</td></center><td>' + item.Completed + '</td><center><td>' + item.QCCOM + '</td></center><center><td>' + item.APPROVED + '</td></center></tr>');
        });
       
    },

    
    error: function (xhr, status, error) {
    console.error(xhr.responseText); // Log the entire response text
    console.error("Status: " + status + ", Error: " + error); // Log additional details
   }

});
}
//!  coder name added   dropdown  function
function codername(){
// alert("success");
var dropreference="";
$.ajax({
  url:'team_dash/teamdash_sql.php?action=coder_name',
  type:'post',
  success:function(data){
    console.log(data);
      var body="";
      var datasucess;
      datasucess= JSON.parse(data);
      //alert(datasucess);
      if(datasucess=='No Data Found'){
          $("#error").text("File Not Found")
          $("#error").css("color","red")
      }
      else{
          $.each(datasucess, function (index,user) {
            //console.log(user.process_name);
            dropreference +='<option value='+user.Coders+'>'+user.Coders+'</option>'                     
          })
          $("#coder_name").append(dropreference);  
        
      }
  }
})
}
  // ! team over all chart function
  var myBarChart="";
  function  teamperformance_chart(coder_name_selectedValue){
  $.ajax({
    url: 'team_dash/teamdash_sql.php?action=team_chart',
    type: 'POST',
    dataType: 'json',
    data:{ 
          coder_name_selectedValue : coder_name_selectedValue
         },
     success: function (data) {
     // $('#myBarChart').empty();
      console.log(data);
        // Process data and create a bar chart
        var labels = data.map(function (item) {
            return item.combined_status;
        });

        var values = data.map(function (item) {
            return item.total_count;
        });

        var ctx = document.getElementById('myBarChart').getContext('2d');
        if (myBarChart) {
          myBarChart.destroy();
          }
         myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Team Performance ',
                    data: values,
                    backgroundColor: getRandomColors(values.length),
                    borderColor: 'rgb(255 255 255)',
                    borderWidth: 1,
                    borderRadius: 10
                }]
            },
           
            options: {
              scales: {
                  x: {
                      grid: {
                          display: false
                      }
                  },
                  y: {
                     // min: 1,
                      beginAtZero: true,
                      grid: {
                          display: false
                      }
                  }
              },
              plugins: {
                  legend: {
                      display: false
                  }
              },
              layout: {
                  padding: {
                      top: 10,
                      right: 10,
                      bottom: 10,
                      left: 10
                  }
              },
              responsive: true,
              //maintainAspectRatio: false,  // Set to false to allow chart to resize vertically
              //aspectRatio: 2,  // Adjust the aspect ratio as needed
          }
        });
        if (window.innerWidth >= 768) {
          myBarChart.data.datasets.forEach(function (dataset) {
              dataset.barPercentage = 0.2; // Adjust the value for smaller bars
        });
      }
           // myBarChart.data.datasets[0].barPercentage = 0.1; // Adjust the value for smaller bars
            myBarChart.update(); // Update the chart to apply the changes
           
        
    },
    error: function (error) {
        console.log('Error fetching data:', error);
    }
  });
}
function getRandomColors(count) {
var colors = [];
for (var i = 0; i < count; i++) {
    colors.push('#' + Math.floor(Math.random()*16777215).toString(16));
}
return colors;
}

// function getRandomColor() {
//     var letters = '0123456789ABCDEF';
//     var color = '#';
//     for (var i = 0; i < 6; i++) {
//         color += letters[Math.floor(Math.random() * 16)];
//     }
//     return color;
// }

  //! datepicker onchange event funtion
  $("#ecommerce-dashboard-daterangepicker").on('change', function () {
      var date = $("#ecommerce-dashboard-daterangepicker").val();
      //alert(date);
      var val = date;
      var str = date;  
      console.log("before split date values",date);
      var dateValues = str.split("-");
       fromdate = dateValues[0];
       todate = dateValues[1];
     // console.log("SPLIT_AND_before Formatted fromdate:", fromdate);
     // console.log("SPILT_AND_before Formatted todate:", todate); 
      fromdate1 = new Date(fromdate).toLocaleDateString('en-CA'); 
      todate1 = new Date(todate).toLocaleDateString('en-CA');

      // alert(fromdate1);
     // console.log("After Formatted fromdate:", fromdate);
    //  console.log("After Formatted todate:", todate);
      total_team_count(fromdate1, todate1);
      total_assign_fillter_count(fromdate1, todate1);
  });
 //!  Total Team status  count function
 var assignteam="";  var Reassignteam=""
 function total_team_count(fromdate1, todate1){
      $.ajax({
        url: 'team_dash/teamdash_sql.php?action=total_team_count',
        type: 'POST',
        data:{ 
          fromdate1 : fromdate1,
          todate1 : todate1
        },
         
          success:function(data){
              //alert(data)
              console.log(data);
              var datasucess;
              var body='';
              datasucess= JSON.parse(data);
            
              $.each(datasucess,function (index,user) { 
                
                //alert(user);           
                 // if(user.status=='ASSIGNED BY TEAM' || user.status=='REASSIGNED BY TEAM' ){  
              //    if(user.assignedteam_count==null){
              //     $("#assigned_team").text("0"); 

              //    }
              //    else{
                
              //    }
              //    if(user.assignedcoder_count==null){
              //     $("#assigned_coder").text("0"); 

              //    }
              //    else{
                 
              //    }
                 $("#assigned_team").text(user.assignedteam_count); 
                // $("#assigned_coder").text(user.assignedcoder_count); 
                //}
                 //
                 // else if(user.status=='WIP'){
                    $("#processing").text(user.wip_count); 
                 // }
                
                  //else if(user.status=='COMPLETED'){
                    $("#completed").text(user.completed_count); 
                    $("#cmdcount").text(user.QC_count );
                  //}
                  
                  //else if(user.status=='QC'){
                   // $("#allot_qc").text(user.QC_count); 
                  //}
                 
                  //else if(user.status=='WIPQC'){
                    $("#qc_wip").text(user.WIPQC_count); 
                  //}
                 
                 // else if(user.status=='QCCOMPLETED'){
                    $("#qc_com").text(user.QCCOMPLETED_count); 
                 // }
       
                 // else if(user.status=='APPROVED'){
                    $("#approvedfile").text(user.APPROVED_count); 
                  //}
                 // else if(user.status=='ASSIGNED BY CODER'){
                      $("#assigned_coder").text(user.assignedcoder_count); 
                   // }
                     
              })
            
          },
            error: function() {
                alert('Error occurred while counting records.');
            }
      });
    }
 //! Team Assign count function 
    function total_assign( ){
      //alert(fromdate1)
      $.ajax({
        url: 'team_dash/teamdash_sql.php?action=total_assign_count',
        type: 'POST',
        data:{ 
         
        },
          success: function(data) {
              console.log(data);
              
              $('#total_assign_count').html('TOTAL : ' + data);
          },
          error: function() {
              alert('Error occurred while counting records.');
          }
      });
    }
       //! Team Assign count function  filerting
       function total_assign_fillter_count(fromdate1, todate1){
        //alert(fromdate1)
        $.ajax({
          url: 'team_dash/teamdash_sql.php?action=total_assign_count_filter',
          type: 'POST',
          data:{ 
            fromdate1 : fromdate1,
             todate1 : todate1
          },
            success: function(data) {
                console.log(data);
                
                $('#total_assign_count').html('TOTAL : ' + data);
            },
            error: function() {
                alert('Error occurred while counting records.');
            }
        });
      }
      //! Team Assign count function 
      function total_assign_fillter_count(fromdate1, todate1){
        //alert(fromdate1)
        $.ajax({
          url: 'team_dash/teamdash_sql.php?action=total_assign_count_filter',
          type: 'POST',
          data:{ 
            fromdate1 : fromdate1,
            todate1 : todate1
          },
            success: function(data) {
                console.log(data);
                
                $('#total_assign_count').html('TOTAL : ' + data);
            },
            error: function() {
                alert('Error occurred while counting records.');
            }
        });
      }
    
  //! Assigned to team on click event
  $("#assign_to_team").on('click', function () {
      assign_team(fromdate1,todate1); 
  });

  function  assign_team(fromdate1,todate1){
      $.ajax({
          url: "team_dash/teamdash_sql.php?action=assigned_to_team",
          type: 'POST',
          data: {
              fromdate1: fromdate1,
              todate1 : todate1
          },
        success: function (data) {
          $('#data-table  ').empty();
          console.log(data);
          var datasucess;
          var body='';
          datasucess= JSON.parse(data);

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
        <th>Preview</th>
    </tr>`;
$('#data-table').html(tableHeader);
          
          $.each(datasucess,function (index,user) { 
              $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-assignteam ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td></tr>');
          });
                        
         },
 
          error: function (xhr, status, error) {
              console.error("AJAX Error: " + status, error);
          }
      });
  }


 //! Assigned to coder on click event
$("#assign_coder").on('click', function () {
assign_coder(fromdate1,todate1); 
});
function  assign_coder(fromdate1,todate1){
$.ajax({
    url: "team_dash/teamdash_sql.php?action=assign_to_coder",
    type: 'POST',
    data: {
        fromdate1: fromdate1,
        todate1 : todate1
    },
  success: function (data) {
    $('#data-table  ').empty();
    console.log(data);
    var datasucess;
    var body='';
    datasucess= JSON.parse(data);

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
        <th>Preview</th>
    </tr>`;
$('#data-table').html(tableHeader);
    
    $.each(datasucess,function (index,user) { 

       


        $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-assigncoder ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
    });
                  
   },

    error: function (xhr, status, error) {
        console.error("AJAX Error: " + status, error);
    }
});
}

 //! Allowed QC  on click event
 $("#qc_file").on('click', function () {
    qc_file(fromdate1,todate1); 
});
function  qc_file(fromdate1,todate1){
  $.ajax({
      url: "team_dash/teamdash_sql.php?action=qc_file",
      type: 'POST',
      data: {
          fromdate1: fromdate1,
          todate1 : todate1
      },
    success: function (data) {
      $('#data-table  ').empty();
      console.log(data);
      var datasuccess;
      var body='';
      var std='';
      datasuccess= JSON.parse(data);

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
        <th>Preview</th>
    </tr>`;
$('#data-table').html(tableHeader);
      
  $.each(datasuccess, function(index, user) {
        var newRowHtml = `
            <tr>
                <td>${user.alloted_team}</td>
                <td>${user.agency}</td>
                <td>${user.patient_name}</td>
                <td>${user.mrn}</td>
                <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
                <td>${user.alloted_to_coder}</td>
                <td>${user.insurance_type}</td>
                <td>${user.assesment_type}</td>
                <td><button class="btn btn-primary flow" onclick="coder_preview(${user.Id})">Coder View</button></td>
            </tr>`;
        // Append the new row to the table
        $('#data-table').append(newRowHtml);
    });
                    
     },

      error: function (xhr, status, error) {
          console.error("AJAX Error: " + status, error);
      }
  });
}
   //! WIP QC Files  on click event
   $("#wipqc_file").on('click', function () {
    wipqc_file(fromdate1,todate1); 
  });
  function  wipqc_file(fromdate1,todate1){
    $.ajax({
        url: "team_dash/teamdash_sql.php?action=wipqc_file",
        type: 'POST',
        data: {
            fromdate1: fromdate1,
            todate1 : todate1
        },
      success: function (data) {
        $('#data-table  ').empty();
        console.log(data);
        var datasuccess;
        var body='';
        datasuccess= JSON.parse(data);

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
        <th>Preview</th>
    </tr>`;
$('#data-table').html(tableHeader);
        
  $.each(datasuccess, function(index, user) {
        var newRowHtml = `
            <tr>
                <td>${user.alloted_team}</td>
                <td>${user.agency}</td>
                <td>${user.patient_name}</td>
                <td>${user.mrn}</td>
                <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
                <td>${user.alloted_to_coder}</td>
                <td>${user.insurance_type}</td>
                <td>${user.assesment_type}</td>
                <td><button class="btn btn-primary flow" onclick="qc_preview(${user.Id})">QC View</button></td>
            </tr>`;
        // Append the new row to the table
        $('#data-table').append(newRowHtml);
    });
                      
       },
  
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
        }
    });
  }
       //!wip file  on click event
       $("#wip_file").on('click', function () {
        wip_file(fromdate1,todate1); 
      });
      function  wip_file(fromdate1,todate1){
        $.ajax({
            url: "team_dash/teamdash_sql.php?action=wip_file",
            type: 'POST',
            data: {
                fromdate1: fromdate1,
                todate1 : todate1
            },
          success: function(data) {
    $('#data-table').empty(); // Clear existing table data
    console.log(data);
    var datasuccess = JSON.parse(data);

    // Define table header only once, not inside the loop
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
        <th>Preview</th>
    </tr>`;
$('#data-table').html(tableHeader);


    // Loop through each data item and create table rows
    $.each(datasuccess, function(index, user) {
        var newRowHtml = `
            <tr>
                <td>${user.alloted_team}</td>
                <td>${user.agency}</td>
                <td>${user.patient_name}</td>
                <td>${user.mrn}</td>
                <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
                <td>${user.alloted_to_coder}</td>
                <td>${user.insurance_type}</td>
                <td>${user.assesment_type}</td>
                <td><button class="btn btn-primary flow" onclick="coder_preview(${user.Id})">Coder View</button></td>
            </tr>`;
        // Append the new row to the table
        $('#data-table').append(newRowHtml);
    });
},

      
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status, error);
            }
        });
      }
        //!Completed file  on click event
        $("#cmd_file").on('click', function () {
            cmd_file(fromdate1,todate1); 
        });
        function cmd_file(fromdate1,todate1){
         // alert("success");
          $.ajax({
              url: "team_dash/teamdash_sql.php?action=cmd_file",
              type: 'POST',
              data: {
                  fromdate1: fromdate1,
                  todate1 : todate1
              },
            success: function (data) {
              $('#data-table  ').empty();
              console.log(data);
               
              var body='';
             var datasuccess= JSON.parse(data);

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
        <th>Preview</th>
    </tr>`;
$('#data-table').html(tableHeader);
              
 $.each(datasuccess, function(index, user) {
        var newRowHtml = `
            <tr>
                <td>${user.alloted_team}</td>
                <td>${user.agency}</td>
                <td>${user.patient_name}</td>
                <td>${user.mrn}</td>
                <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
                <td>${user.alloted_to_coder}</td>
                <td>${user.insurance_type}</td>
                <td>${user.assesment_type}</td>
                <td><button class="btn btn-primary flow" onclick="coder_preview(${user.Id})">Coder View</button></td>
            </tr>`;
        // Append the new row to the table
        $('#data-table').append(newRowHtml);
    });
                            
             },
        
              error: function (xhr, status, error) {
                  console.error("AJAX Error: " + status, error);
              }
          });
        }
      //! QC completed  on click event
      $("#qccmd_file").on('click', function () {
        qccmd_file(fromdate1,todate1); 
      });
      function  qccmd_file(fromdate1,todate1){
        $.ajax({
            url: "team_dash/teamdash_sql.php?action=qccmd_file",
            type: 'POST',
            data: {
                fromdate1: fromdate1,
                todate1 : todate1
            },
          success: function (data) {
            $('#data-table  ').empty();
            console.log(data);
            var datasuccess;
            var body='';
            datasuccess= JSON.parse(data);

           var tableHeader = `
    <tr style="background-color: #088394; color:white;">
        <th>Alloted Team</th>
        <th>Agency</th>
        <th>Patient Name</th>
        <th>MRN</th>
        <th>Status</th>
        <th>Alloted To Coder</th>
        <th>Qc Coder</th>
        <th>Insurance Type</th>
        <th>Assessment Type</th>
        <th>Coder-Preview</th>
        <th>QC-Preview</th>
    </tr>`;
$('#data-table').html(tableHeader);
            
 $.each(datasuccess, function(index, user) {
        var newRowHtml = `
            <tr>
                <td>${user.alloted_team}</td>
                <td>${user.agency}</td>
                <td>${user.patient_name}</td>
                <td>${user.mrn}</td>
                <td class="font-weight-medium"><div class="badge badge-pill badge-wip">${user.status}</div></td>
                <td>${user.alloted_to_coder}</td>
                <td>${user.qc_person}</td>
                <td>${user.insurance_type}</td>
                <td>${user.assesment_type}</td>
                <td><button class="btn btn-primary flow" onclick="coder_preview(${user.Id})">Coder View</button></td>
                <td><button class="btn btn-primary flow" onclick="qc_preview(${user.Id})">Qc View</button></td>
            </tr>`;
        // Append the new row to the table
        $('#data-table').append(newRowHtml);
    });
                          
          },
      
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status, error);
            }
        });
      }

         //!  APPROVEL file  on click event
         $("#aprd_file").on('click', function () {
          aprd_file(fromdate1,todate1); 
        });
        function  aprd_file(fromdate1,todate1){
          $.ajax({
              url: "team_dash/teamdash_sql.php?action=aprd_file",
              type: 'POST',
              data: {
                  fromdate1: fromdate1,
                  todate1 : todate1
              },
            success: function (data) {
              $('#data-table  ').empty();
              console.log(data);
              var datasucess;
              var body='';
              datasucess= JSON.parse(data);

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
        <th>Preview</th>
    </tr>`;
$('#data-table').html(tableHeader);
              
              $.each(datasucess,function (index,user) { 
                  $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-approved ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td></tr>');
              });
                            
            },
        
              error: function (xhr, status, error) {
                  console.error("AJAX Error: " + status, error);
              }
          });
        }
      
}); 


function coder_preview(Id) {
    //alert(Id);
    // Set a cookie with the ID (optional, if needed in PHP)
    document.cookie = `Id=${Id}; path=/`;

    // Open the URL in a new tab/window
    window.open("generate_pdf.php", "_blank");
}

 function final_preview(Id) {
  //Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

  // Open the URL in a new tab/window
  window.open("final_preview.php", "_blank");
}


function qc_preview(Id) {

    // alert(Id)
  //Set a cookie with the ID (optional, if needed in PHP)
  document.cookie = `Id=${Id}; path=/`;

  // Open the URL in a new tab/window
  window.open("qc_single_preview.php", "_blank");
}