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
         url: "show_files/client_datas_show.php", 
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate
         },
       success: function (data) {

       
        $('#data-table  ').empty();
     
 var teamDisplay='';
 var coder='';
                         data.forEach(function (item) {

                             teamDisplay = item.alloted_team !== null ? item.alloted_team : '';
                              coder = item.alloted_to_coder !== null ? item.alloted_to_coder : '';
                              $(".thd").html('');
                             $(".thd").html(`<tr>
                        
                          <th>Agency</th>
                          <th>PatientName</th>
                         
                           <th>Mrn</th>
                          <th >Status</th>

                           
                          <th>InsuranceType</th>
                        <th>AssesmentType</th>
                         <th>AssesmentDate</th>
                      
                        </tr>`);


                            $('#data-table').append('<tr><td>' + item.agency + '</td><td>' + item.patient_name + '</td><td>' + item.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' + item.status + '</div></td><td>' + item.insurance_type + '</td><td>' + item.assesment_type + '</td><td>' + item.assesment_date + '</td></tr>');
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
         url: "show_files/client_coder_file.php",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate
         },
       success: function (data) {
        $('#data-table  ').empty();
     console.log(data);
      var teamDisplay='';
      var coder='';
 
                         data.forEach(function (item) {

                       
                             teamDisplay = item.alloted_team !== null ? item.alloted_team : '';
                              coder = item.alloted_to_coder !== null ? item.alloted_to_coder : '';
                               $(".thd").html('');
                             $(".thd").html(`<tr>
                        
                         
                          <th>Agency</th>
                          <th>Patient_Name</th>
                         
                           <th>Mrn</th>
                          <th >Status</th>
                         

                           
                          <th>Insurance_Type</th>
                          <th>AssesmentType</th>
                         <th>AssesmentDate</th>
                        </tr>`);



                            $('#data-table').append('<tr><td>' + item.agency + '</td><td>' + item.patient_name + '</td><td>' + item.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' + item.status + '</div></td><td>' + item.insurance_type + '</td><td>' + item.assesment_type + '</td><td>' + item.assesment_date + '</td><td hidden><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td><td hidden>' + item.totalcasemix + '</td></tr>');
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
         url: "show_files/client_wip_file.php",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate
         },
       success: function (data) {
        $('#data-table  ').empty();
 console.log("SHOW_FILES-CLI",data);

           var teamDisplay='';
           var coder='';
           
                        data.forEach(function (item) {
    // Extracting values from the item object with null checks
    var teamDisplay = item.alloted_team !== null ? item.alloted_team : '';
    var coder = item.alloted_to_coder !== null ? item.alloted_to_coder : '';
    // Checking for various statuses
    var std = (item.status === 'ALLOTED TO QC' || item.status === 'QC COMPLETED' || item.status === 'WIP' || item.status === 'QC' || item.status === 'QA WIP' || item.status === 'PENDING' || item.status === 'Inprogression') ? 'WIP' : '';
    
    // Setting up table headers
    $(".thd").html('');
    $(".thd").html(`<tr>
        <th>Agency</th>
        <th>Patient Name</th>
        <th>MRN</th>
        <th>Status</th>
        <th>Insurance Type</th>
        <th>Assesment Type</th>
        <th>Assesment Date</th>
    </tr>`);

    // Appending data to the table
    $('#data-table').append('<tr><td>' + item.agency + '</td><td>' + item.patient_name + '</td><td>' + item.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' + std + '</div></td><td>' + item.insurance_type + '</td><td>' + item.assesment_type + '</td><td>' + item.assesment_date + '</td><td hidden><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td><td hidden>' + item.totalcasemix + '</td></tr>');
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
         url: "show_files/client_completed_file.php",
         type: "GET",
         dataType: 'json',
         data: {
             fromdate: fromdate,
             todate: todate
         },
       success: function (data) {
        $('#data-table').empty();
           var teamDisplay='';
           var coder='';
           var std='';
 
                         data.forEach(function (item) {

                        
                             teamDisplay = item.alloted_team !== null ? item.alloted_team : '';
                              coder = item.alloted_to_coder !== null ? item.alloted_to_coder : '';
                             // std = item.COMPLETED !== null ? item.COMPLETED : 'alloted_to_coder';
                             std = item.APPROVED !== null ? 'Completed' : ' ';




                               $(".thd").html('');
                             $(".thd").html(`<tr>
                        
                          
                          <th>Agency</th>
                          <th>Patient_Name</th>
                         
                           <th>Mrn</th>
                          <th >Status</th>
                          

                           
                          <th>Insurance_Type</th>
                          <th>AssesmentType</th>
                         <th>AssesmentDate</th>
                         <th>final_preview</th>
                         <th>PPS</th>
                         
                        </tr>`);

                        // var originalNumber = item.totalcasemix;
                        //  var roundedNumber = parseFloat(originalNumber.toFixed(3));
                        //  console.log(roundedNumber); 



                        $('#data-table').append('<tr><td>' + item.agency + '</td><td>' + item.patient_name + '</td><td>' + item.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' + std + '</div></td><td>' + item.insurance_type + '</td><td>' + item.assesment_type + '</td><td>' + item.assesment_date + '</td><td><a class="btn btn-primary flow" onclick="final_preview(' + item.Id + ')">Final View</a></td><td>' + item.totalcasemix + '</td></tr>');
                        });
},

         error: function (xhr, status, error) {
             console.error("AJAX Error: " + status, error);
         }
     });
 }


 //function of final view

 function final_preview(Id) {
    // Set a cookie with the ID (optional, if needed in PHP)
    document.cookie = `Id=${Id}; path=/`;
    
    // Open the URL in a new tab/window
    window.open('final_preview.php', '_blank');
}
 
 
//  function assign_tem(date) {
    
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
//      var teamDisplay='';
//            var coder='';
 
//                          data.forEach(function (item) {
                    
//                              teamDisplay = item.alloted_team !== null ? item.alloted_team : '';
//                               coder = item.alloted_to_coder !== null ? item.alloted_to_coder : '';
//                                $(".thd").html('');
//                              $(".thd").html(`<tr>
                        
//                           <th>Alloted_Team</th>
//                           <th>Agency</th>
//                           <th>Patient_Name</th>
                         
//                            <th>Mrn</th>
//                           <th >Status</th>
//                           <th >Coder</th>

                           
//                           <th>Insurance_Type</th>
//                           <th>QC Coder</th>
//                         </tr>`);

                              


//                             $('#data-table').append('<tr><td>' +teamDisplay + '</td><td>' + item.agency + '</td><td>' + item.patient_name + '</td> <td>' + item.mrn + '</td><td class="font-weight-medium"><div class="badge badge-pill badge-danger ">' + item.status + '</div></td><td>' +coder+ '</td><td>' + item.insurance_type + '</td><td>' + item.qc_person + '</td></tr>');
//                         });
// },

//          error: function (xhr, status, error) {
//              console.error("AJAX Error: " + status, error);
//          }
//      });
//  }



//    function Pending(date) {
    
//      var str = date;
//      var dateValues = str.split("-");
//      var fromdate = dateValues[0];
//      var todate = dateValues[1];
 
  
//  fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
//  todate = new Date(todate).toLocaleDateString('en-CA');
 
//      $.ajax({
//          url: "show_files/.php",
//          type: "GET",
//          dataType: 'json',
//          data: {
//              fromdate: fromdate,
//              todate: todate
//          },
//        success: function (data) {
//         $('#data-table  ').empty();
//     var teamDisplay='';
//            var coder='';
 
//                          data.forEach(function (item) {
//                             teamDisplay = item.alloted_team !== null ? item.alloted_team : '';
//                               coder = item.alloted_to_coder !== null ? item.alloted_to_coder : '';
//                                $(".thd").html('');
//                              $(".thd").html(`<tr>
                        
//                           <th>Alloted_Team</th>
//                           <th>Agency</th>
//                           <th>Patient_Name</th>
                         
//                            <th>Mrn</th>
//                           <th >Status</th>
//                           <th >Coder</th>

                           
//                           <th>Insurance_Type</th>
//                         </tr>`);

//                             $('#data-table').append('<tr>' +
//     '<td>' + teamDisplay + '</td>' +
//     '<td>' + item.agency + '</td>' +
//     '<td>' + item.patient_name + '</td>' +
    
//     '<td>' + item.mrn + '</td>' +
//     '<td class="font-weight-medium"><div class="badge badge-success">' + item.status + '</div></td>' +
//     '<td>' + coder + '</td>'+
//     '<td>' + item.insurance_type + '</td>' +
// '</tr>');

// });
// },
//          error: function (xhr, status, error) {
//              console.error("AJAX Error: " + status, error);
//          }
//      });
//  }