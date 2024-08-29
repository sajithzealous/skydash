$(document).ready(function () {
    $("#new_file").on('click', function () {
          var date = $("#ecommerce-dashboard-daterangepicker").val();
            
        new_data(date); 
        
    });
        $("#ass_file").on('click', function () {
          var date = $("#ecommerce-dashboard-daterangepicker").val();
            
        ass_file(date); 
    });
 $("#wip_file").on('click', function () {
  var date = $("#ecommerce-dashboard-daterangepicker").val();
            
        wip_file(date); 
    });
  $("#cmd_file").on('click', function () {
  var date = $("#ecommerce-dashboard-daterangepicker").val();
            
        cmd_file(date); 
    });
   
});

     function new_data(date) {
    
     var str = date;
     var dateValues = str.split("-");
     var fromdate = dateValues[0];
     var todate = dateValues[1];
 
  
 fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
 todate = new Date(todate).toLocaleDateString('en-CA');
 
     $.ajax({
         url: "agency_show_files/show_files.php?action=new", 
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate
         },
       success: function (data) {
        $('#data-table').empty();

         $(".thd").html("");
        $(".thd").html(`<tr>
                        
                          <th>Agency</th>
                          <th>PatientName</th>
                         
                           <th>Mrn</th>
                            <th>AssesmentType</th>
                          <th >Status</th>
                         <th>AssesmentDate</th>
                          <th>InsuranceType</th>
                      
                        </tr>`);
     
 
                         data.forEach(function (item) {
                            $('#data-table  ').append('<tr><td>' + item.agency + '</td><td>' + item.patient_name + '</td><td>' + item.mrn + '</td><td>' + item.assesment_type + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' + item.status + '</div></td><td>' + item.assesment_date + '</td><td>' + item.insurance_type + '</td></tr>');
                        });
},

         error: function (xhr, status, error) {
             console.error("AJAX Error: " + status, error);
         }
     });
 }

  function ass_file(date) {
    
     var str = date;
     var dateValues = str.split("-");
     var fromdate = dateValues[0];
     var todate = dateValues[1];
 
  
 fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
 todate = new Date(todate).toLocaleDateString('en-CA');
 
     $.ajax({
         url: "agency_show_files/show_files.php?action=assign",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate
         },
       success: function (data) {
        $('#data-table  ').empty();

         $(".thd").html("");
        $(".thd").html(`<tr>
                        
                          <th>Team</th>
                          <th>Agency</th>
                          <th>PatientName</th>
                         
                           <th>Mrn</th>
                            <th>AssesmentType</th>
                          <th >Status</th>
                         <th>AssesmentDate</th>
                          <th>InsuranceType</th>
                      
                        </tr>`);
    
 
                         data.forEach(function (item) {
                            $('#data-table  ').append('<tr><td>' + item.alloted_team + '</td><td>' + item.agency + '</td><td>' + item.patient_name + '</td><td>' + item.mrn + '</td><td>' + item.assesment_type + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-info ">' + item.status + '</div></td><td>' + item.assesment_date + '</td><td>' + item.insurance_type + '</td></tr>');
                      // console.log(item.Patient_Name);
                        });

},
                         
         error: function (xhr, status, error) {
             console.error("AJAX Error: " + status, error);
         }

     });

 }
   function wip_file(date) {
    
     var str = date;
     var dateValues = str.split("-");
     var fromdate = dateValues[0];
     var todate = dateValues[1];
 
  
 fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
 todate = new Date(todate).toLocaleDateString('en-CA');
 
     $.ajax({
         url: "agency_show_files/show_files.php?action=wip",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate
         },
       success: function (data) {

        var std='';
        $('#data-table  ').empty();
    // console.log(data);

        $(".thd").html("");
        $(".thd").html(`<tr>
                        
                          <th>Team</th>
                          <th>Coder</th>
                          <th>Agency</th>
                          <th>PatientName</th>
                         
                           <th>Mrn</th>
                            <th>AssesmentType</th>
                          <th >Status</th>
                         <th>AssesmentDate</th>
                          <th>InsuranceType</th>
                      
                        </tr>`);
 
                         data.forEach(function (item) {

                    var std = (item.status === 'ALLOTED TO QC' || item.status === 'QC COMPLETED' || item.status === 'WIP' || item.status === 'QC' || item.status === 'QA WIP' || item.status === 'PENDING' || item.status === 'Inprogression') ? 'WIP' : '';

                            $('#data-table  ').append('<tr><td>' + item.alloted_team + '</td><td>' + item.alloted_to_coder + '</td><td>' + item.agency + '</td><td>' + item.patient_name + '</td><td>' + item.mrn + '</td><td>' + item.assesment_type + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-primary ">' + std + '</div></td><td>' + item.assesment_date + '</td><td>' + item.insurance_type + '</td></tr>');
                        });
},

         error: function (xhr, status, error) {
             console.error("AJAX Error: " + status, error);
         }
     });
 }
    function cmd_file(date) {
    
     var str = date;
     var dateValues = str.split("-");
     var fromdate = dateValues[0];
     var todate = dateValues[1];
 
  
 fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
 todate = new Date(todate).toLocaleDateString('en-CA');
 
     $.ajax({
         url: "agency_show_files/show_files.php?action=approved",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate
         },
       success: function (data) {
       var std='';

        $('#data-table  ').empty();
    // console.log(data);
         $(".thd").html("");
        $(".thd").html(`<tr>
                        
                          <th>Team</th>
                          <th>Coder</th>
                          <th>Agency</th>
                          <th>PatientName</th>
                         
                           <th>Mrn</th>
                            <th>AssesmentType</th>
                          <th >Status</th>
                         <th>AssesmentDate</th>
                          <th>InsuranceType</th>
                      
                        </tr>`);
 
 
                         data.forEach(function (item) {

                                                        std = item.status === 'APPROVED' ? 'Completed' : '';

                            $('#data-table  ').append('<tr><td>' + item.alloted_team + '</td><td>' + item.alloted_to_coder + '</td><td>' + item.agency + '</td><td>' + item.patient_name + '</td><td>' + item.mrn + '</td><td>' + item.assesment_type + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-primary ">' + std + '</div></td><td>' + item.assesment_date + '</td><td>' + item.insurance_type + '</td></tr>');
                        });
},

         error: function (xhr, status, error) {
             console.error("AJAX Error: " + status, error);
         }
     });
 }
 


  function final_preview(Id) {
    // Set a cookie with the ID (optional, if needed in PHP)
    document.cookie = `Id=${Id}; path=/`;
    
    // Open the URL in a new tab/window
    window.open('final_preview.php', '_blank');
}
//  function qc_file(date) {
    
//      var str = date;
//      var dateValues = str.split("-");
//      var fromdate = dateValues[0];
//      var todate = dateValues[1];
 
  
//  fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
//  todate = new Date(todate).toLocaleDateString('en-CA');
 
//      $.ajax({
//          url: "show_files/file_5.php",
//          type: "GET",
//          dataType: 'json',
//          data: {
//              fromdate: fromdate,
//              todate: todate
//          },
//        success: function (data) {
//         $('#data-table  ').empty();
//     // console.log(data);
 
//                          data.forEach(function (item) {
//                             $('#data-table  ').append('<tr><td>' + item.Team + '</td><td>' + item.Agency + '</td><td>' + item.Patient_Name + '</td><td>' + item.Phone_Number + '</td><td>' + item.Mrn + '</td><td class="font-weight-medium"><div class="badge badge-warning">' + item.Status + '</div></td><td>' + item.coder + '</td><td>' + item.Insurance_Type + '</td></tr>');
//                         });
// },

//          error: function (xhr, status, error) {
//              console.error("AJAX Error: " + status, error);
//          }
//      });
//  }
//  function wipqc_file(date) {
    
//      var str = date;
//      var dateValues = str.split("-");
//      var fromdate = dateValues[0];
//      var todate = dateValues[1];
 
  
//  fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
//  todate = new Date(todate).toLocaleDateString('en-CA');
 
//      $.ajax({
//          url: "show_files/file_6.php",
//          type: "GET",
//          dataType: 'json',
//          data: {
//              fromdate: fromdate,
//              todate: todate
//          },
//        success: function (data) {
//         $('#data-table  ').empty();
//     // console.log(data);
 
//                          data.forEach(function (item) {
//                             $('#data-table  ').append('<tr><td>' + item.Team + '</td><td>' + item.Agency + '</td><td>' + item.Patient_Name + '</td><td>' + item.Phone_Number + '</td><td>' + item.Mrn + '</td><td class="font-weight-medium"><div class="badge badge-primary">' + item.Status + '</div></td><td>' + item.coder + '</td><td>' + item.Insurance_Type + '</td></tr>');
//                         });
// },

//          error: function (xhr, status, error) {
//              console.error("AJAX Error: " + status, error);
//          }
//      });
//  }
//   function qccmd_file(date) {
    
//      var str = date;
//      var dateValues = str.split("-");
//      var fromdate = dateValues[0];
//      var todate = dateValues[1];
 
  
//  fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
//  todate = new Date(todate).toLocaleDateString('en-CA');
 
//      $.ajax({
//          url: "show_files/file_7.php",
//          type: "GET",
//          dataType: 'json',
//          data: {
//              fromdate: fromdate,
//              todate: todate
//          },
//        success: function (data) {
//         $('#data-table  ').empty();
//     // console.log(data);
 
//                          data.forEach(function (item) {
//                             $('#data-table  ').append('<tr><td>' + item.Team + '</td><td>' + item.Agency + '</td><td>' + item.Patient_Name + '</td><td>' + item.Phone_Number + '</td><td>' + item.Mrn + '</td><td class="font-weight-medium"><div class="badge badge-info">' + item.Status + '</div></td><td>' + item.coder + '</td><td>' + item.Insurance_Type + '</td></tr>');
//                         });
// },

//          error: function (xhr, status, error) {
//              console.error("AJAX Error: " + status, error);
//          }
//      });
//  }
//    function aprd_file(date) {
    
//      var str = date;
//      var dateValues = str.split("-");
//      var fromdate = dateValues[0];
//      var todate = dateValues[1];
 
  
//  fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
//  todate = new Date(todate).toLocaleDateString('en-CA');
 
//      $.ajax({
//          url: "show_files/file_8.php",
//          type: "GET",
//          dataType: 'json',
//          data: {
//              fromdate: fromdate,
//              todate: todate
//          },
//        success: function (data) {
//         $('#data-table  ').empty();
//     // console.log(data);
 
//                          data.forEach(function (item) {
//                             $('#data-table').append('<tr>' +
//     '<td>' + item.Team + '</td>' +
//     '<td>' + item.Agency + '</td>' +
//     '<td>' + item.Patient_Name + '</td>' +
//     '<td>' + item.Phone_Number + '</td>' +
//     '<td>' + item.Mrn + '</td>' +
//     '<td class="font-weight-medium"><div class="badge badge-success">' + item.Status + '</div></td>' +
//     '<td>' + item.coder + '</td>'+
//     '<td>' + item.Insurance_Type + '</td>' +
// '</tr>');

// });
// },
//          error: function (xhr, status, error) {
//              console.error("AJAX Error: " + status, error);
//          }
//      });
//  }