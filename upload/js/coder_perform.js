$(document).ready(function(){

        $(".custom-daterangepicker").on('change', function () {
        var date = $("#datepicker1").val();
        
        
          table(date);
    });
	
     


});
 function table(date){


      var str = date;
     var dateValues = str.split("-");
     var fromdate = dateValues[0];
     var todate = dateValues[1];
 
  
 fromdate = new Date(fromdate).toLocaleDateString('en-CA');  'en-CA'// represents the 'en'glish language in 'CA'nada
 todate = new Date(todate).toLocaleDateString('en-CA');

 
       
    $.ajax({
        url: "coder_perform.php",
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
                            $('#show_data').append('<tr><center><td>' + item.Team + '</td></center><center><td>' + item.code + '</td></center><center><td>' + item.Total_Files + '</td></center><center><td>' + item.Assingned + '</td></center><center><td>' + item.inp + '</td></center><center><td>' + item.WIP + '</td></center><center><td>' + item.pnd + '</td></center><center><td>' + item.Completed + '</td></center><td>' + item.QC + '</td><td>' + item.QCCOM + '</td></center><td>' + item.approved + '</td></tr>');
                        });

 },
      error: function (xhr, status, error) {
    console.error(xhr.responseText); // Log the entire response text
    console.error("Status: " + status + ", Error: " + error); // Log additional details
}

    });

     
}