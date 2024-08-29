$(document).ready(function() {

  // total_assign();
   teamperformance_chart();
   //team_performance_filer();
  // codername();
   
   //team_performance_filter();
 

  //team_performance(fromdate1, todate1);
//! datepicker onchange event funtion
  // $("#datepicker1").on('change', function () {
  //     var date = $("#datepicker1").val();
  //     //alert(date);
  //     var val = date;
  //     var str = date;  
  //     console.log("before split date values",date);
  //     var dateValues = str.split("-");
  //      fromdate = dateValues[0];
  //      todate = dateValues[1];
  //     console.log("SPLIT_AND_before Formatted fromdate:", fromdate);
  //     console.log("SPILT_AND_before Formatted todate:", todate); 
  //     fromdate1 = new Date(fromdate).toLocaleDateString('en-CA'); 
  //     todate1 = new Date(todate).toLocaleDateString('en-CA');
  //     console.log("After Formatted fromdate:", fromdate);
  //     console.log("After Formatted todate:", todate);
  //     //total_team_count(fromdate1, todate1);
  //     team_performance_filter(fromdate1, todate1);
  // });
  // ! over all team performance  filter using 
function team_performance_filter(fromdate1, todate1){    
 // alert("sdfsdf");
  $.ajax({
      url: "coder_dash/coder_sql.php?action=team_performance_filer",
      dataType: 'json',
      type: 'POST',
      data:{ 
        fromdate1 : fromdate1,
        todate1 : todate1
      },
      success: function (data) {
      $('#show_data').empty();
      console.log("show_data",data);
      data.forEach(function (item) {
        coder=item.Total_Files;
        recoder=item.RETotal_Files;
        var num1 = parseFloat(coder);
        var num2 = parseFloat(recoder);
        total=(num1+num2);
        
        $('#show_data').append('<tr><center><td>Team</td><td>' + item.Team + '</td></center></tr><tr><center><td>Coder</td><td>' + item.code + '</td></center></tr><tr><center><td>PROGRESSION</td><td>' +  item.prg + '</td></center></tr><tr><center><td>PENDING</td><td>' +  item.pd + '</td></center></tr><tr><center><td>WIP</td><td>' + item.WIP + '</td></center></tr><tr><center><td>QC</td><td>' + item.QC + '</td></center></tr><tr><center><td>Completed</td><td>' + item.Completed + '</td></center></tr><tr><center><td>APPROVED</td><td>' + item.APPROVED + '</td></center></tr>');
        });

    },
    error: function (xhr, status, error) {
    console.error(xhr.responseText); // Log the entire response text
    console.error("Status: " + status + ", Error: " + error); // Log additional details
   }

});
}
// ! over all team performance 
function team_performance(fromdate1, todate1){    
  $.ajax({
      url: "coder_dash/coder_sql.php?action=team_performance",
      type: "POST",
      dataType: 'json',
      data: {
        fromdate1 : fromdate1,
        todate1 : todate1
      },
      success: function (data) {
      $('#show_data').empty();
       console.log("show_data",data);
       data.forEach(function (item) {
        // coder=item.Total_Files;
        // recoder=item.RETotal_Files;
        // var num1 = parseFloat(coder);
        // var num2 = parseFloat(recoder);
        // total=(num1+num2);
        
        // total=coder + recoder;
        $('#show_data').append('<tr><center><td>Team</td><td>' + item.Team + '</td></center></tr><tr><center><td>Coder</td><td>' + item.code + '</td></center></tr><tr><center><td>PROGRESSION</td><td>' +  item.prg + '</td></center></tr><tr><center><td>PENDING</td><td>' +  item.pd + '</td></center></tr><tr><center><td>WIP</td><td>' + item.WIP + '</td></center></tr><tr><center><td>QC</td><td>' + item.QC + '</td></center></tr><tr><center><td>Completed</td><td>' + item.Completed + '</td></center></tr><tr><center><td>APPROVED</td><td>' + item.APPROVED + '</td></center></tr>');
      });

    },
    error: function (xhr, status, error) {
    console.error(xhr.responseText); // Log the entire response text
    console.error("Status: " + status + ", Error: " + error); // Log additional details
   }

});
}


function  teamperformance_chart(){
$.ajax({
url: 'coder_dash/coder_sql.php?action=team_chart',
type: 'GET',
dataType: 'json',
success: function (data) {
    console.log(data);

    // Process data and create a pie chart
    var labels = data.map(function (item) {
        return item.combined_status;
    });

    var values = data.map(function (item) {
        return item.total_count;
    });

    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: getRandomColors(values.length).map(color => color + '80')
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  // Set to false to allow chart to resize 
        }
    });
},
error: function (error) {
    console.log('Error fetching data:', error);
}
});
}
// Function to generate random colors  colors.push('#204cbdd1','#8e5696');
function getRandomColors(count) {
var colors = [];
for (var i = 0; i < count; i++) {
    colors.push('#' + Math.floor(Math.random()*16777215).toString(16));
}
return colors;
}


  // ! team over all chart function 


//     $.ajax({
//       url: 'coder_dash/coder_sql.php?action=team_chart',
//       type: 'POST',
//       dataType: 'json',
//       data:{ 
//             coder_name_selectedValue : coder_name_selectedValue
//            },
//       success: function (data) {
//        // $('#myBarChart').empty();
//         console.log(data);
//           // Process data and create a bar chart
//           var labels = data.map(function (item) {
//               return item.status;
//           });

//           var values = data.map(function (item) {
//               return item.status_count;
//           });

//           var ctx = document.getElementById('myBarChart').getContext('2d');
//           if (myBarChart) {
//             myBarChart.destroy();
//             }
//            myBarChart = new Chart(ctx, {
//               type: 'bar',
//               data: {
//                   labels: labels,
//                   datasets: [{
//                       label: 'Team Performance ',
//                       data: values,
//                       backgroundColor: 'rgb(75, 73, 172)',
//                       borderColor: 'rgb(255 255 255)',
//                       borderWidth: 1
//                   }]
//               },
//               options: {
//                 scales: {
//                     x: {
//                         grid: {
//                             display: false
//                         }
//                     },
//                     y: {
//                         beginAtZero: true,
//                         grid: {
//                             display: false
//                         }
//                     }
//                 }
//             }
//           });
//              // Check if the device is a desktop and adjust the bar width
//              if (window.innerWidth >= 992) {
//               myBarChart.data.datasets[0].barPercentage = 0.2; // Adjust the value for smaller bars
//               myBarChart.update(); // Update the chart to apply the changes
//              }
        
//       },
//       error: function (error) {
//           console.log('Error fetching data:', error);
//       }
//   });
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
      console.log("SPLIT_AND_before Formatted fromdate:", fromdate);
      console.log("SPILT_AND_before Formatted todate:", todate); 
      fromdate1 = new Date(fromdate).toLocaleDateString('en-CA'); 
      todate1 = new Date(todate).toLocaleDateString('en-CA');
      //alert(todate1);
      console.log("After Formatted fromdate:", fromdate);
      console.log("After Formatted todate:", todate);
      total_coder_count(fromdate1, todate1);
      total_assign_fillter_count(fromdate1, todate1);
  });
 //!  Total Team status count function 
 function total_coder_count(fromdate1, todate1){
      $.ajax({
        url: 'coder_dash/coder_sql.php?action=total_coder_count',
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
                $("#processing").text(user.wip_count); 
                // }
                $("#pnd").text(user.pending);
                $("#inp").text(user.inpro);
               
                 //else if(user.status=='COMPLETED'){
                   $("#completed").text(user.completed_count); 
                 //}
                 
                 //else if(user.status=='QC'){
                   $("#allot_qc").text(user.QC_count); 
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
        url: 'coder_dash/coder_sql.php?action=total_assign_count',
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
          url: 'coder_dash/coder_sql.php?action=total_assign_count_filter',
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
          url: 'coder_dash/coder_sql.php?action=total_assign_count_filter',
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
          url: "coder_dash/coder_sql.php?action=assigned_to_team",
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
          
          $.each(datasucess,function (index,user) { 
              $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-assignteam ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
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
    url: "coder_dash/coder_sql.php?action=assign_to_coder",
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
    
    $.each(datasucess,function (index,user) { 
        $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-assigncoder ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
    });
                  
   },

    error: function (xhr, status, error) {
        console.error("AJAX Error: " + status, error);
    }
});
}

 //! Allowed InProgress  on click event
 $("#InProgress").on('click', function () {
    InProgress(fromdate1,todate1); 
});
function  InProgress(fromdate1,todate1){
  $.ajax({
      url: "coder_dash/coder_sql.php?action=InProgress",
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
      
      $.each(datasucess,function (index,user) { 
          $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-allowed ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
      });
                    
     },

      error: function (xhr, status, error) {
          console.error("AJAX Error: " + status, error);
      }
  });
}

 //! Allowed InProgress  on click event
 $("#Pending").on('click', function () {

    Pending(fromdate1,todate1); 
});
function  Pending(fromdate1,todate1){
  $.ajax({
      url: "coder_dash/coder_sql.php?action=Pending",
      type: 'POST',
      data: {
          fromdate1: fromdate1,
          todate1 : todate1
      },
    success: function (data) {
      $('#data-table  ').empty();
      console.log("ped",data);
      var datasucess;
      var body='';
      datasucess= JSON.parse(data);
      
      $.each(datasucess,function (index,user) { 
          $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-allowed ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
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
        url: "coder_dash/coder_sql.php?action=wipqc_file",
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
        
        $.each(datasucess,function (index,user) { 
            $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-wipQc ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
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
            url: "coder_dash/coder_sql.php?action=wip_file",
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
            
            $.each(datasucess,function (index,user) { 
                $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-wip ">' + user.status + '</div><td>' + user.alloted_to_coder + '</td></td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
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
              url: "coder_dash/coder_sql.php?action=cmd_file",
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
              var std='';
              datasucess= JSON.parse(data);
              
              $.each(datasucess,function (index,user) { 

                 //std = user.COMPLETED !== null ? 'alloted_to_QC' : ' ';
                  $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-completed ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
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
            url: "coder_dash/coder_sql.php?action=qccmd_file",
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
            
            $.each(datasucess,function (index,user) { 
                $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-qccompleted ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
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
              url: "coder_dash/coder_sql.php?action=aprd_file",
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
              
              $.each(datasucess,function (index,user) { 
                  $('#data-table').append('<tr><td>' + user.alloted_team + '</td><td>' + user.agency + '</td><td>' + user.patient_name + '</td><td>' + user.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-approved ">' + user.status + '</div></td><td>' + user.alloted_to_coder + '</td><td>' + user.insurance_type + '</td><td>' + user.assesment_type + '</td></tr>');
              });
                            
            },
        
              error: function (xhr, status, error) {
                  console.error("AJAX Error: " + status, error);
              }
          });
        }
      
});